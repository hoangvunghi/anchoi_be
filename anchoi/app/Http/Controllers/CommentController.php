<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // list ra comment của 1 id bài viết truyền vào
    public function index($id)
    {
        $comments = Comment::where('entertainment_spot_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($comments);
    }

    public function store(Request $request)
{
    $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255',
        'body' => 'required|string',
        'parent_id' => 'nullable|integer',
    ];

    // Thêm điều kiện yêu cầu number_of_star nếu không có parent_id
    if (is_null($request->parent_id)) {
        $rules['number_of_star'] = 'required|integer|min:1|max:5';
    } else {
        $rules['number_of_star'] = 'nullable|integer|min:1|max:5';
    }

    $request->validate($rules);

    Comment::create($request->all());

    return response()->json(['message' => 'Comment created'], 201);
}


    public function showWithReplies($id)
    {
        $comments = Comment::where('entertainment_spot_id', $id)
            ->whereNull('parent_id')
            ->with('replies')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($comments);
    }
}