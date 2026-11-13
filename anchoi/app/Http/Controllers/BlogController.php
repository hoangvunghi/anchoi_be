<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\EntertainmentSpot;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;

class BlogController extends Controller
{

    public function index()
    {
        // Trang danh sách không hiển thị body (HTML nặng) -> không select để nhẹ query
        $blogs = Blog::with('category:id,name,slug')
            ->select(['id', 'title', 'slug', 'banner_image', 'category_id', 'created_at', 'updated_at'])
            ->orderBy('id', 'desc')->get();
        // return response()->json($this->transformBlogs($blogs));
        return response()->json([
            'blogs' => $this->transformBlogs($blogs),
        ]);
    }
    public function indexRender(){
        $response=$this->index();
        $blogs=$response->getData()->blogs;
        return view('homeBlog',compact('blogs'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'body' => 'required|string',
            'banner_image' => 'required|string',
            'category_id' => 'required|integer|exists:category,id',
        ]);

        if ($request->has('banner_image')) {
            $imagePath = $this->processImage($request->input('banner_image'));
            $request->merge(['banner_image' => $imagePath]);
        }

        $markdownContent = $request->input('body');

        $markdownContent = preg_replace_callback('/!\[.*?\]\((data:image\/\w+;base64,.*?)\)/', function ($matches) {
            $imageData = $matches[1];
            return $this->processImage($imageData);
        }, $markdownContent);

        $request->merge(['body' => $markdownContent]);

        $blog = Blog::create($request->all());
        return response()->json($this->transformBlog($blog), Response::HTTP_CREATED);
    }

    public function show($id)
    {
        $blog = Blog::with('category')->find($id);

        if (!$blog) {
            return response()->json(['message' => 'Blog not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($this->transformBlog($blog));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255',
            'body' => 'nullable|string',
            'banner_image' => 'nullable|string',
            'category_id' => 'nullable|integer|exists:category,id',
        ]);

        $blog = Blog::find($id);

        if (!$blog) {
            return response()->json(['message' => 'Blog not found'], Response::HTTP_NOT_FOUND);
        }

        if ($request->has('banner_image')) {
            $imagePath = $this->processImage($request->input('banner_image'));
            $request->merge(['banner_image' => $imagePath]);

            if ($blog->banner_image && Storage::exists($blog->banner_image)) {
                Storage::delete($blog->banner_image);
            }
        }

        if ($request->has('body')) {
            $markdownContent = $request->input('body');

            $markdownContent = preg_replace_callback('/!\[.*?\]\((data:image\/\w+;base64,.*?)\)/', function ($matches) {
                $imageData = $matches[1];
                return $this->processImage($imageData);
            }, $markdownContent);

            $request->merge(['body' => $markdownContent]);
        }

        $blog->update($request->all());
        return response()->json($this->transformBlog($blog));
    }

    public function destroy($id)
    {
        $blog = Blog::find($id);

        if (!$blog) {
            return response()->json(['message' => 'Blog not found'], Response::HTTP_NOT_FOUND);
        }

        if ($blog->banner_image) {
            Storage::delete($blog->banner_image);
        }

        $blog->delete();
        return response()->json(['message' => 'Blog deleted']);
    }

    private function processImage($imageData)
    {
        $imageExtension = explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
        $imageName = time() . '.' . $imageExtension;
        $imagePath = 'images/' . $imageName;

        $decodedImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));

        $manager = new ImageManager(new Driver());

        $image = $manager->read($decodedImage);

        $image->save(storage_path('app/public/' . $imagePath));

        return $imagePath;
    }

    public function getBlogBySlug($slug)
    {
        $blog = Blog::with('category')->where('slug', $slug)->orderBy('id', 'desc')->first();
        if (!$blog) {
            return response()->json(['message' => 'Blog not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json([
            'blog' => $this->transformBlog($blog),
        ]);
    }

    public function getBlogBySlugRender($slug)
    {
        $current = Blog::with('category')->where('slug', $slug)->first();
        if (!$current) {
            return response()->view('404', ['pageTitle' => 'Không tìm thấy bài viết', 'title' => 'Bài viết không tồn tại'], 404);
        }
        $blog = json_decode(json_encode($this->transformBlog($current)));

        // Bài liên quan: cùng danh mục, trừ bài hiện tại
        $related = Blog::with('category:id,name,slug')
            ->select(['id', 'title', 'slug', 'banner_image', 'category_id', 'created_at'])
            ->where('category_id', $current->category_id)
            ->where('id', '!=', $current->id)
            ->latest('id')->take(4)->get();
        $related = json_decode(json_encode($this->transformBlogs($related)));

        // Internal link: gợi ý địa điểm (blog -> trang địa điểm / money page)
        $suggestedSpots = EntertainmentSpot::with(['ward:id,name,slug', 'entertainmentType:id,name,slug'])
            ->where('status', 'approved')->whereHas('ward')->whereHas('entertainmentType')
            ->inRandomOrder()->take(4)->get()
            ->map(fn ($s) => (object) [
                'name' => $s->name,
                'type' => $s->entertainmentType->name,
                'ward' => $s->ward->name,
                'url' => $s->entertainmentType->slug . '-' . $s->ward->slug . '/' . $s->slug,
            ]);

        return view('blogDetail', compact('blog', 'related', 'suggestedSpots'));
    }

    private function transformBlog($blog)
    {
        return [
            'id' => $blog->id,
            'title' => $blog->title,
            'slug' => $blog->slug,
            'body' => $blog->body,
            'url' => url('blog/' . $blog->slug),
            'banner_image' =>"storage/". $blog->banner_image,
            'category_id' => $blog->category_id,
            'category_slug' => $blog->category->slug ?? null,
            'created_at' => $blog->created_at,
            'category_name' => $blog->category->name ?? null,
            'updated_at' => $blog->updated_at,
        ];
    }

    private function transformBlogs($blogs)
    {
        return $blogs->map(function ($blog) {
            return $this->transformBlog($blog);
        });
    }
}
