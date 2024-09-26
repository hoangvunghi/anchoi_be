<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EntertainmentSpot;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;
use App\Models\EntertainmentType;
use App\Models\Province;
use App\Models\District;
use App\Models\Ward;
use App\Models\Comment;

class EntertainmentSpotController extends Controller
{
    function findMatchInList($params, $searchList)
    {
        foreach ($searchList as $item) {
            if (strpos($params, $item) !== false) {
                return $item;
            }
        }
        return null;
    }
    public function index_nr()
    {
        $entertainmentSpots = EntertainmentSpot::with(['ward', 'entertainmentType'])->where('status', 'approved')->orderBy('id', 'desc')->get();
        return response()->json([
            'entertainmentSpots' => $this->transformEntertainmentSpots($entertainmentSpots),
        ]);
    }
    public function index()
    {
        // $entertainmentSpots = EntertainmentSpot::with(['ward', 'entertainmentType'])->where('status', 'approved')->orderBy('id', 'desc')->get();
        $response = $this->index_nr();
        $entertainmentSpots = $response->getData()->entertainmentSpots;
        return view("home", compact('entertainmentSpots'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'entertainment_type_id' => 'required|integer|exists:loai_hinh,id',
            'ward_id' => 'required|integer|exists:xa_phuong,id',
            'full_address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'description' => 'nullable|string',
            'banner_image' => 'nullable|string',
            'price' => 'nullable|numeric',
            'name_of_owner' => 'nullable|string|max:255',
            'status' => 'nullable|string|in:pending,approved,rejected',
            'prefix' => 'nullable|string|max:255',
            'have_menu' => 'nullable|boolean',
        ]);

        if ($request->has('banner_image')) {
            $imagePath = $this->processImage($request->input('banner_image'));
            $request->merge(['banner_image' => $imagePath]);
        }

        $entertainmentSpot = EntertainmentSpot::create($request->all());

        return response()->json($this->transformEntertainmentSpot($entertainmentSpot), Response::HTTP_CREATED);
    }

    public function show($id)
    {
        $entertainmentSpot = EntertainmentSpot::with(['ward', 'entertainmentType'])->find($id);

        if (!$entertainmentSpot) {
            return response()->json(['message' => 'Entertainment Spot not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($this->transformEntertainmentSpot($entertainmentSpot));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'entertainment_type_id' => 'nullable|integer|exists:loai_hinh,id',
            'ward_id' => 'nullable|integer|exists:quan_huyen,id',
            'full_address' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'banner_image' => 'nullable|string',
            'price' => 'nullable|numeric',
            'name_of_owner' => 'nullable|string|max:255',
            'status' => 'nullable|string|in:pending,approved,rejected',
            'prefix' => 'nullable|string|max:255',
            'have_menu' => 'nullable|boolean',
        ]);

        $entertainmentSpot = EntertainmentSpot::find($id);

        if (!$entertainmentSpot) {
            return response()->json(['message' => 'Entertainment Spot not found'], Response::HTTP_NOT_FOUND);
        }

        if ($request->has('banner_image')) {
            $imagePath = $this->processImage($request->input('banner_image'));
            $request->merge(['banner_image' => $imagePath]);

            if ($entertainmentSpot->banner_image) {
                Storage::delete($entertainmentSpot->banner_image);
            }
        }

        $entertainmentSpot->update($request->all());
        return response()->json($this->transformEntertainmentSpot($entertainmentSpot));
    }

    public function destroy($id)
    {
        $entertainmentSpot = EntertainmentSpot::find($id);

        if (!$entertainmentSpot) {
            return response()->json(['message' => 'Entertainment Spot not found'], Response::HTTP_NOT_FOUND);
        }

        if ($entertainmentSpot->banner_image) {
            Storage::delete($entertainmentSpot->banner_image);
        }

        $entertainmentSpot->delete();
        return response()->json(['message' => 'Entertainment Spot deleted']);
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

    public function search_menu(Request $request)
    {
        $filter_criteria = [
            'an' => ['type' => 'ăn', 'title' => 'Địa điểm ăn uống tại Việt Nam', 'pageTitle' => 'Ăn uống'],
            'choi' => ['type' => 'chơi', 'title' => 'Địa điểm vui chơi giải trí tại Việt Nam', 'pageTitle' => 'Vui chơi giải trí'],
            'club' => ['slug' => 'club', 'title' => 'Club tại Việt Nam', 'pageTitle' => 'Club'],
            'massage' => ['slug' => 'massage', 'title' => 'Massage tại Việt Nam', 'pageTitle' => 'Massage'],
        ];

        $criteria = $filter_criteria[$request->id] ?? null;

        if ($criteria) {
            $query = EntertainmentSpot::query();

            foreach ($criteria as $field => $value) {
                if ($field !== 'title' && $field !== 'pageTitle') {
                    $query->whereHas('entertainmentType', function ($q) use ($field, $value) {
                        $q->where($field, $value);
                    });
                }
            }

            $entertainmentSpots = $query->with(['ward', 'entertainmentType'])->where('status', 'approved')->orderBy('id', 'desc')->get();

            return response()->json([
                'entertainmentSpots' => $this->transformEntertainmentSpots($entertainmentSpots),
                'title' => $criteria['title'],
                'pageTitle' => $criteria['pageTitle'],
            ]);
        } else {
            $entertainmentSpots = EntertainmentSpot::with(['ward', 'entertainmentType'])->where('status', 'approved')->orderBy('id', 'desc')->get();
            return response()->json($this->transformEntertainmentSpots($entertainmentSpots));
        }
    }

    public function search_entertainment_spot(Request $request)
    {
        $query = EntertainmentSpot::query();

        $loaiHinhFilter = $request->get('loai-hinh', null);
        $xaPhuongFilter = $request->get('xa-phuong', null);
        $quanHuyenFilter = $request->get('quan-huyen', null);
        $tinhThanhPhoFilter = $request->get('tinh-thanh-pho', null);

        if ($loaiHinhFilter) {
            $loaiHinhValues = explode(',', $loaiHinhFilter);
            $query->whereHas('entertainmentType', function ($q) use ($loaiHinhValues) {
                $q->whereIn('slug', $loaiHinhValues);
            });
        }

        if ($xaPhuongFilter) {
            $xaPhuongValues = explode(',', $xaPhuongFilter);
            $query->whereHas('ward', function ($q) use ($xaPhuongValues) {
                $q->whereIn('slug', $xaPhuongValues);
            });
        }

        if ($quanHuyenFilter) {
            $quanHuyenValues = explode(',', $quanHuyenFilter);
            $query->whereHas('ward.district', function ($q) use ($quanHuyenValues) {
                $q->whereIn('slug', $quanHuyenValues);
            });
        }

        if ($tinhThanhPhoFilter) {
            $tinhThanhPhoValues = explode(',', $tinhThanhPhoFilter);
            $query->whereHas('ward.district.province', function ($q) use ($tinhThanhPhoValues) {
                $q->whereIn('slug', $tinhThanhPhoValues);
            });
        }

        $entertainmentSpots = $query->with(['ward', 'entertainmentType'])->where('status', 'approved')->orderBy('id', 'desc')->get();

        if ($entertainmentSpots->isEmpty()) {
            return response()->json(['message' => 'Entertainment Spot not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($this->transformEntertainmentSpots($entertainmentSpots));
    }

    public function urlApiSearch(Request $request, $params)
    {
        $params = urldecode($params);
        $loaiHinhList = EntertainmentType::pluck('slug')->toArray();
        $foundLoaiHinhSlug = $this->findMatchInList($params, $loaiHinhList);
        if (!$foundLoaiHinhSlug) {
            return response()->json(['message' => 'Không tìm thấy địa điểm nào phù hợp.', 'status' => 404, 'entertainmentSpots' => ""], Response::HTTP_NOT_FOUND);
        }
        $loaiHinhName = EntertainmentType::where('slug', $foundLoaiHinhSlug)->first()->name;
        $position = strpos($params, $foundLoaiHinhSlug) - 1;
        $params = trim(substr($params, $position + 1 + strlen($foundLoaiHinhSlug)));

        $query = EntertainmentSpot::query();
        $query->whereHas('entertainmentType', function ($q) use ($foundLoaiHinhSlug) {
            $q->where('slug', $foundLoaiHinhSlug);
        });

        $tinhName = $huyenName = $xaPhuongName = null;

        if ($params) {
            $tenTinhList = Province::pluck('slug')->toArray();
            $foundTinhSlug = $this->findMatchInList($params, $tenTinhList);
            if ($foundTinhSlug) {
                $tinhName = Province::where('slug', $foundTinhSlug)->first()->name;
                $query->whereHas('ward.district.province', function ($q) use ($foundTinhSlug) {
                    $q->where('slug', $foundTinhSlug);
                });
                $position = strpos($params, $foundTinhSlug) - 1;
                $params = trim(substr($params, $position + 1 + strlen($foundTinhSlug)));
            }

            if ($params) {
                $tenHuyenList = District::whereHas('province', function ($query) use ($foundTinhSlug) {
                    $query->where('slug', $foundTinhSlug);
                })->pluck('slug')->toArray();
                $foundHuyenSlug = $this->findMatchInList($params, $tenHuyenList);
                if ($foundHuyenSlug) {
                    $huyenName = District::where('slug', $foundHuyenSlug)->first()->name;
                    $query->whereHas('ward.district', function ($q) use ($foundHuyenSlug) {
                        $q->where('slug', $foundHuyenSlug);
                    });
                    $position = strpos($params, $foundHuyenSlug) - 1;
                    $params = trim(substr($params, $position + 1 + strlen($foundHuyenSlug)));
                }

                if ($params) {
                    $tenXaPhuongList = Ward::whereHas('district.province', function ($query) use ($foundTinhSlug) {
                        $query->where('slug', $foundTinhSlug);
                    })->whereHas('district', function ($query) use ($foundHuyenSlug) {
                        $query->where('slug', $foundHuyenSlug);
                    })->pluck('slug')->toArray();
                    $foundXaPhuongSlug = $this->findMatchInList($params, $tenXaPhuongList);
                    if ($foundXaPhuongSlug) {
                        $xaPhuongName = Ward::where('slug', $foundXaPhuongSlug)->first()->name;
                        $query->whereHas('ward', function ($q) use ($foundXaPhuongSlug) {
                            $q->where('slug', $foundXaPhuongSlug);
                        });
                    }
                }
            }
        }

        $entertainmentSpots = $query->with(['ward', 'entertainmentType'])->where('status', 'approved')->orderBy('id', 'desc')->get();
        if ($entertainmentSpots->isEmpty()) {
            return response()->json(['message' => 'Entertainment Spot not found', 'entertainmentSpots' => ""], Response::HTTP_NOT_FOUND);
        }

        $pageTitle = "Các địa điểm " . $loaiHinhName . " tại " . $tinhName;
        $title = "Các địa điểm " . $loaiHinhName . " tại " . ($xaPhuongName ? $xaPhuongName . ", " : "") . ($huyenName ? $huyenName . ", " : "") . $tinhName;

        return response()->json([
            'entertainmentSpots' => $this->transformEntertainmentSpots($entertainmentSpots),
            'pageTitle' => $pageTitle,
            'title' => $title
        ]);
    }

    public function urlApiSearchRender(Request $request, $params)
    {
        $response = $this->urlApiSearch($request, $params);
        if ($response->getData()->entertainmentSpots == "") {
            return view("404");
        }
        $entertainmentSpotss = $response->getData()->entertainmentSpots;
        $pageTitle = $response->getData()->pageTitle;
        $title = $response->getData()->title;
        return view("searchResult", compact("entertainmentSpotss", "pageTitle", "title"));
    }

    public function getLastId()
    {
        $lastId = EntertainmentSpot::latest()->where('status', 'approved')->first()->id;
        return response()->json($lastId);
    }

    public function urlApiSearchDetail(Request $request, $params, $id)
    {
        $params = urldecode($params);
        $loaiHinhList = EntertainmentType::pluck('slug')->toArray();
        $foundLoaiHinhSlug = $this->findMatchInList($params, $loaiHinhList);
        if (!$foundLoaiHinhSlug) {
            return response()->json(['message' => 'Không tìm thấy địa điểm nào phù hợp.', 'status' => 404], Response::HTTP_NOT_FOUND);
        }
        $loaiHinhName = EntertainmentType::where('slug', $foundLoaiHinhSlug)->first()->name;
        $position = strpos($params, $foundLoaiHinhSlug) - 1;
        $params = trim(substr($params, $position + 1 + strlen($foundLoaiHinhSlug)));

        $query = EntertainmentSpot::query();
        $query->whereHas('entertainmentType', function ($q) use ($foundLoaiHinhSlug) {
            $q->where('slug', $foundLoaiHinhSlug);
        });

        $xaPhuongName = null;

        if ($params) {
            $tenXaPhuongList = Ward::pluck('slug')->toArray();
            $foundXaPhuongSlug = $this->findMatchInList($params, $tenXaPhuongList);
            if ($foundXaPhuongSlug) {
                $xaPhuongName = Ward::where('slug', $foundXaPhuongSlug)->first()->name;
                $query->whereHas('ward', function ($q) use ($foundXaPhuongSlug) {
                    $q->where('slug', $foundXaPhuongSlug);
                });
            }
        }

        $entertainmentSpot = $query->with(['ward', 'entertainmentType'])->where('slug', $id)->where('status', 'approved')->orderBy('id', 'desc')->first();

        if (!$entertainmentSpot) {
            return response()->json(['message' => 'Entertainment Spot not found'], Response::HTTP_NOT_FOUND);
        }

        $titlePage = $entertainmentSpot->name . " " . $this->clearString($entertainmentSpot->full_address);
        return response()->json([
            'entertainmentSpot' => $this->transformEntertainmentSpot($entertainmentSpot),
            'titlePage' => $titlePage
        ]);
    }
    public function urlApiSearchDetailRender(Request $request, $params, $id)
    {
        $response = $this->urlApiSearchDetail($request, $params, $id);

        $entertainmentSpot = $response->getData()->entertainmentSpot;
        $titlePage = $response->getData()->titlePage;
        $realtedEntertainmentSpots = $this->relatedEntertainmentSpots($entertainmentSpot->id)->getData();
        return view("detail", compact("entertainmentSpot", "titlePage", "realtedEntertainmentSpots"));
    }
    public function entertainment_spot_type_list(Request $request, $type)
    {
        $query = EntertainmentSpot::query();
        if ($type == 'an') {
            $query->whereHas('entertainmentType', function ($q) {
                $q->where('type', 'ăn');
            });
        }
        if ($type == 'choi') {
            $query->whereHas('entertainmentType', function ($q) {
                $q->where('type', 'chơi');
            });
        }
        $entertainmentSpots = $query->with(['ward', 'entertainmentType'])->where('status', 'approved')->orderBy('id', 'desc')->get();

        return response()->json($this->transformEntertainmentSpots($entertainmentSpots));
    }

    public function entertainment_spot_type_list_newest(Request $request, $type)
    {
        $query = EntertainmentSpot::query();

        switch ($type) {
            case 'all':
                break;
            case 'an':
                $query->whereHas('entertainmentType', function ($q) {
                    $q->where('type', 'ăn');
                });
                break;
            case 'choi':
                $query->whereHas('entertainmentType', function ($q) {
                    $q->where('type', 'chơi');
                });
                break;
            default:
                return response()->json([]);
        }

        $entertainmentSpots = $query->with(['ward', 'entertainmentType'])->where('status', 'approved')->latest()->take(16)->orderBy('id', 'desc')->get();

        return response()->json($this->transformEntertainmentSpots($entertainmentSpots));
    }

    public function detail_entertainment_spot(Request $request, $slug)
    {
        $entertainmentSpot = EntertainmentSpot::with(['ward', 'entertainmentType'])->where('slug', $slug)->where('status', 'approved')->orderBy('id', 'desc')->first();

        if (!$entertainmentSpot) {
            return response()->json(['message' => 'Entertainment Spot not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($this->transformEntertainmentSpot($entertainmentSpot));
    }
    private function transformEntertainmentSpot($entertainmentSpot)
    {
        $openingHoursSpecification = $this->generateOpeningHoursSpecification($entertainmentSpot->opening_hours);
        $comments = Comment::where('entertainment_spot_id', $entertainmentSpot->id)->get();
        $reviews = $comments->map(function ($comment) {
            return [
                "@type" => "Review",
                "reviewRating" => [
                    "@type" => "Rating",
                    "ratingValue" => $comment->number_of_star,
                ],
                "author" => [
                    "@type" => "Person",
                    "name" => $comment->name,
                ],
            ];
        })->toArray();

        $totalRating = $comments->where('number_of_star', '>', 0)->sum('number_of_star');
        $ratingCount = $comments->whereNull('parent_id')->count();
        $bestRating = $ratingCount > 0 ? max($comments->pluck('number_of_star')->toArray()) : 5;
        $averageRating = $ratingCount > 0 ? $totalRating / $ratingCount : 0;

        $aggregateRating = [
            "@type" => "AggregateRating",
            "ratingValue" => round($averageRating, 2),
            "bestRating" => $bestRating,
            "ratingCount" => $ratingCount,
        ];
        $header = [
            "@context" => "https://schema.org",
            "@type" => $entertainmentSpot->entertainmentType->name,
            "image" => [
                url('/storage/' . $entertainmentSpot->banner_image),
            ],
            "name" => $entertainmentSpot->name,
            "address" => [
                "@type" => "PostalAddress",
                "streetAddress" => $entertainmentSpot->full_address,
                "addressLocality" => $entertainmentSpot->ward->name,
                "addressRegion" => $entertainmentSpot->district->name,
                "addressCountry" => "VN",
            ],
            "geo" => [
                "@type" => "GeoCoordinates",
                "latitude" => $entertainmentSpot->latitude,
                "longitude" => $entertainmentSpot->longitude,
            ],
            "url" => url('/' . $entertainmentSpot->entertainmentType->slug . '-' . $entertainmentSpot->ward->slug . '/'  . $entertainmentSpot->slug),
            "telephone" => $entertainmentSpot->phone_number,
            "review" => $reviews,
            "aggregateRating" => $aggregateRating,
            // "servesCuisine" => "American", 
            "priceRange" => "VND",
            "openingHoursSpecification" => $openingHoursSpecification,
        ];
        // "url" => url('/' . $entertainmentSpot->entertainmentType->slug . '-' . $entertainmentSpot->ward->slug . '/'  . $entertainmentSpot->slug),
        $url = $entertainmentSpot->entertainmentType->slug . '-' . $entertainmentSpot->ward->slug . '/'  . $entertainmentSpot->slug;

        return [
            'id' => $entertainmentSpot->id,
            'name' => $entertainmentSpot->name,
            'entertainment_type_id' => $entertainmentSpot->entertainment_type_id,
            'entertainment_type_slug' => $entertainmentSpot->entertainmentType->slug,
            "loai_hinh" => $entertainmentSpot->entertainmentType->type,
            'ward_id' => $entertainmentSpot->ward_id,
            "url" => $url,
            "url_tinh" => $entertainmentSpot->entertainmentType->slug . "-" . $entertainmentSpot->ward->district->province->slug,
            "url_huyen" => $entertainmentSpot->entertainmentType->slug . "-" . $entertainmentSpot->ward->district->province->slug . "-" . $entertainmentSpot->ward->district->slug,
            "url_xa" => $entertainmentSpot->entertainmentType->slug . "-" . $entertainmentSpot->ward->district->province->slug . "-" . $entertainmentSpot->ward->district->slug . "-" . $entertainmentSpot->ward->slug,
            'ward_slug' => $entertainmentSpot->ward->slug,
            'ward_name' => $entertainmentSpot->ward->name,
            'full_address' => $entertainmentSpot->full_address,
            'phone_number' => $entertainmentSpot->phone_number,
            'description' => $entertainmentSpot->description,
            'banner_image' => "storage/" . $entertainmentSpot->banner_image,
            'price' => $entertainmentSpot->price,
            'name_of_owner' => $entertainmentSpot->name_of_owner,
            'status' => $entertainmentSpot->status,
            'prefix' => $entertainmentSpot->prefix,
            'have_menu' => $entertainmentSpot->have_menu,
            "slug" => $entertainmentSpot->slug,
            "entertainment_type_name" => $entertainmentSpot->entertainmentType->name,
            "additional_info" => $entertainmentSpot->additional_info,
            "opening_hours" => $entertainmentSpot->opening_hours,
            "province_name" => $entertainmentSpot->ward->district->province->name,
            "district_name" => $entertainmentSpot->ward->district->name,
            "provin_slug" => $entertainmentSpot->ward->district->province->slug,
            "district_slug" => $entertainmentSpot->ward->district->slug,
            "average_rating" => $entertainmentSpot->average_rating,
            "latitude" => $entertainmentSpot->latitude,
            "longitude" => $entertainmentSpot->longitude,
            "distance" => $entertainmentSpot->distance,
            "detailHeader" => $entertainmentSpot->name . '-' . $this->clearString($entertainmentSpot->full_address),
            'header' => $header,
        ];
    }
    // bỏ hết dấu ,
    private function clearString($string)
    {
        $string = str_replace(',', '', $string);
        $string = str_replace('-', '', $string);
        $string = str_replace('  ', ' ', $string);
        return $string;
    }
    private function transformEntertainmentSpots($entertainmentSpots)
    {
        return $entertainmentSpots->map(function ($entertainmentSpot) {
            return $this->transformEntertainmentSpot($entertainmentSpot);
        });
    }
    private function transformEntertainmentSpotsNear($entertainmentSpots)
    {
        return $entertainmentSpots->map(function ($entertainmentSpot) {
            return $this->transformEntertainmentSpot($entertainmentSpot);
        });
    }
    private function generateOpeningHoursSpecification($openingHours)
    {

        $openingHoursSpecification = [];
        if ($openingHours) {
            $times = explode('-', $openingHours);
            if (count($times) === 2) {
                $openingHoursSpecification[] = [
                    "@type" => "OpeningHoursSpecification",
                    "dayOfWeek" => [
                        "Monday",
                        "Tuesday",
                        "Wednesday",
                        "Thursday",
                        "Friday",
                        "Saturday",
                        "Sunday"
                    ],
                    "opens" => $this->convertTimeTo24HourFormat($times[0]),
                    "closes" => $this->convertTimeTo24HourFormat($times[1]),
                ];
            }
        }
        return $openingHoursSpecification;
    }

    private function convertTimeTo24HourFormat($time)
    {
        $time = trim($time);

        preg_match('/(\d{1,2})(:(\d{2}))?\s*(am|pm)?/i', $time, $matches);
        $hours = (int)$matches[1];
        $minutes = isset($matches[3]) ? (int)$matches[3] : 0;
        $ampm = isset($matches[4]) ? strtolower($matches[4]) : null;

        if ($ampm === 'pm' && $hours < 12) {
            $hours += 12;
        } elseif ($ampm === 'am' && $hours == 12) {
            $hours = 0;
        }

        return sprintf('%02d:%02d', $hours, $minutes);
    }
    public function relatedEntertainmentSpots($id)
    {

        define('RELATED_SPOTS_LIMIT', 8);

        $entertainmentSpot = EntertainmentSpot::with(['ward.district.province', 'entertainmentType'])->find($id);

        if (!$entertainmentSpot) {
            return response()->json(['message' => 'Entertainment Spot not found'], Response::HTTP_NOT_FOUND);
        }

        $relatedSpots = collect();

        // 1. Cùng thể loại trong xã, phường
        $relatedSpots = $relatedSpots->merge(
            EntertainmentSpot::query()
                ->where('entertainment_type_id', $entertainmentSpot->entertainment_type_id)
                ->where('status', 'approved')
                ->where('id', '!=', $id)
                ->where('ward_id', $entertainmentSpot->ward_id)
                ->orderBy('id', 'desc')
                ->get()
        );

        // Kiểm tra xem đã đạt giới hạn 8 kết quả chưa
        if ($relatedSpots->count() < RELATED_SPOTS_LIMIT) {

            // 2. Cùng thể loại trong huyện
            $relatedSpots = $relatedSpots->merge(
                EntertainmentSpot::query()
                    ->where('entertainment_type_id', $entertainmentSpot->entertainment_type_id)
                    ->where('status', 'approved')
                    ->where('id', '!=', $id)
                    ->whereHas('ward.district', function ($query) use ($entertainmentSpot) {
                        $query->where('id', $entertainmentSpot->ward->district->id);
                    })
                    ->whereNotIn('id', $relatedSpots->pluck('id'))
                    ->orderBy('id', 'desc')
                    ->get()
            );

            // Kiểm tra xem đã đạt giới hạn 8 kết quả chưa
            if ($relatedSpots->count() < RELATED_SPOTS_LIMIT) {

                // 3. Cùng thể loại trong tỉnh
                $relatedSpots = $relatedSpots->merge(
                    EntertainmentSpot::query()
                        ->where('entertainment_type_id', $entertainmentSpot->entertainment_type_id)
                        ->where('status', 'approved')
                        ->where('id', '!=', $id)
                        ->whereHas('ward.district.province', function ($query) use ($entertainmentSpot) {
                            $query->where('id', $entertainmentSpot->ward->district->province->id);
                        })
                        ->whereNotIn('id', $relatedSpots->pluck('id'))
                        ->orderBy('id', 'desc')
                        ->get()
                );

                // Kiểm tra xem đã đạt giới hạn 8 kết quả chưa
                if ($relatedSpots->count() < RELATED_SPOTS_LIMIT) {

                    // 4. Khác thể loại trong xã, phường
                    $relatedSpots = $relatedSpots->merge(
                        EntertainmentSpot::query()
                            ->where('entertainment_type_id', '!=', $entertainmentSpot->entertainment_type_id)
                            ->where('status', 'approved')
                            ->where('id', '!=', $id)
                            ->where('ward_id', $entertainmentSpot->ward_id)
                            ->whereNotIn('id', $relatedSpots->pluck('id'))
                            ->orderBy('id', 'desc')
                            ->get()
                    );

                    // Kiểm tra xem đã đạt giới hạn 8 kết quả chưa
                    if ($relatedSpots->count() < RELATED_SPOTS_LIMIT) {

                        // 5. Khác thể loại trong huyện
                        $relatedSpots = $relatedSpots->merge(
                            EntertainmentSpot::query()
                                ->where('entertainment_type_id', '!=', $entertainmentSpot->entertainment_type_id)
                                ->where('status', 'approved')
                                ->where('id', '!=', $id)
                                ->whereHas('ward.district', function ($query) use ($entertainmentSpot) {
                                    $query->where('id', $entertainmentSpot->ward->district->id);
                                })
                                ->whereNotIn('id', $relatedSpots->pluck('id'))
                                ->orderBy('id', 'desc')
                                ->get()
                        );

                        // Kiểm tra xem đã đạt giới hạn 8 kết quả chưa
                        if ($relatedSpots->count() < RELATED_SPOTS_LIMIT) {

                            // 6. Khác thể loại trong tỉnh
                            $relatedSpots = $relatedSpots->merge(
                                EntertainmentSpot::query()
                                    ->where('entertainment_type_id', '!=', $entertainmentSpot->entertainment_type_id)
                                    ->where('status', 'approved')
                                    ->where('id', '!=', $id)
                                    ->whereHas('ward.district.province', function ($query) use ($entertainmentSpot) {
                                        $query->where('id', $entertainmentSpot->ward->district->province->id);
                                    })
                                    ->whereNotIn('id', $relatedSpots->pluck('id'))
                                    ->orderBy('id', 'desc')
                                    ->get()
                            );

                            // Kiểm tra xem đã đạt giới hạn 8 kết quả chưa
                            if ($relatedSpots->count() < RELATED_SPOTS_LIMIT) {

                                // 7. Khác thể loại ở nơi khác
                                $relatedSpots = $relatedSpots->merge(
                                    EntertainmentSpot::query()
                                        ->where('entertainment_type_id', '!=', $entertainmentSpot->entertainment_type_id)
                                        ->where('status', 'approved')
                                        ->where('id', '!=', $id)
                                        ->whereNotIn('id', $relatedSpots->pluck('id'))
                                        ->orderBy('id', 'desc')
                                        ->limit(RELATED_SPOTS_LIMIT - $relatedSpots->count())
                                        ->get()
                                );
                            }
                        }
                    }
                }
            }
        }

        $relatedSpots = $relatedSpots->take(RELATED_SPOTS_LIMIT);

        return response()->json($this->transformEntertainmentSpots($relatedSpots));
    }

    private function calculateHaversineDistance($lat1, $lon1, $lat2, $lon2)
    {
        // Chuyển đổi tọa độ từ độ sang radian
        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        // Tính toán hiệu giữa hai tọa độ
        $dLat = $lat2 - $lat1;
        $dLon = $lon2 - $lon1;

        // Áp dụng công thức Haversine
        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos($lat1) * cos($lat2) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        // Bán kính Trái Đất theo km
        $R = 6371;

        // Tính toán khoảng cách theo km
        $distance = $R * $c;

        return $distance;
    }
    // tìm 5 địa điểm ở gần nhất
    public function findNearestEntertainmentSpots(Request $request, $lat, $lon)
    {
        // Lấy danh sách địa điểm đã được duyệt (status = 'approved') và có kinh độ, vĩ độ
        $entertainmentSpots = EntertainmentSpot::with(['ward', 'entertainmentType'])
            ->where('status', 'approved')
            // ->whereNotNull('latitude')
            // ->whereNotNull('longitude')
            ->get();

        // Tính toán khoảng cách và thêm vào mỗi địa điểm
        $entertainmentSpots = $entertainmentSpots->map(function ($entertainmentSpot) use ($lat, $lon) {
            $entertainmentSpot->distance = $this->calculateHaversineDistance($lat, $lon, $entertainmentSpot->latitude, $entertainmentSpot->longitude);
            return $entertainmentSpot;
        });

        $nearestSpots = $entertainmentSpots->sortBy('distance')->take(15)->values();
        $title = "Các địa điểm ăn chơi tốt và gần bạn nhất";
        $titlePage = "Các địa điểm ăn chơi tốt và gần bạn nhất";
        return response()->json([
            'entertainmentSpots' => $this->transformEntertainmentSpots($nearestSpots),
            'title' => $title,
            'titlePage' => $titlePage,
        ]);
    }

    // tìm 15 địa điểm gần nhất theo thể loại và kinh độ, vĩ độ
    public function findNearestEntertainmentSpotsByType(Request $request, $lat, $lon, $type)
    {
        if (!is_array($type)) {
            $type = [$type];
        }
        // Lấy danh sách địa điểm đã được duyệt (status = 'approved') và có kinh độ, vĩ độ
        $entertainmentSpots = EntertainmentSpot::with(['ward', 'entertainmentType'])
            ->where('status', 'approved')
            // ->whereNotNull('latitude')
            // ->whereNotNull('longitude')
            ->whereHas('entertainmentType', function ($query) use ($type) {
                $query->whereIn('slug', $type); // Now $type is always an array
            })
            ->get();

        // Tính toán khoảng cách và thêm vào mỗi địa điểm
        $entertainmentSpots = $entertainmentSpots->map(function ($entertainmentSpot) use ($lat, $lon) {
            $entertainmentSpot->distance = $this->calculateHaversineDistance($lat, $lon, $entertainmentSpot->latitude, $entertainmentSpot->longitude);
            return $entertainmentSpot;
        });

        // Get unique entertainment type names
        $titles = $entertainmentSpots->map(function ($spot) {
            return $spot->entertainmentType->name;
        })->unique();

        // Create titles
        $title = "Các địa điểm " . $titles->implode(', ') . " tốt và gần nhất";
        $titlePage = "Các địa điểm " . $titles->implode(', ') . " tốt và gần bạn nhất";

        // Sắp xếp theo khoảng cách và lấy 15 địa điểm gần nhất (or adjust as needed)
        $nearestSpots = $entertainmentSpots->sortBy('distance')->take(15)->values();

        return response()->json([
            'entertainmentSpots' => $this->transformEntertainmentSpots($nearestSpots),
            'title' => $title,
            'titlePage' => $titlePage,
        ]);
    }
    public function findNearestEntertainmentSpotsByTypeRender(Request $request, $type)
    {
        // Lấy tọa độ từ request; nếu không có thì sử dụng lat = 0, lon = 0
        $lat = $request->input('lat', 0);
        $lon = $request->input('lon', 0);
        // Gọi hàm findNearestEntertainmentSpotsByType
        $response = $this->findNearestEntertainmentSpotsByType($request, $lat, $lon, $type);

        // Lấy dữ liệu từ response
        $entertainmentSpots = $response->getData()->entertainmentSpots; // Nếu response là JSON
        $title = $response->getData()->title;
        $titlePage = $response->getData()->titlePage;

        // Trả về view với dữ liệu đã lấy
        return view('near', compact('entertainmentSpots', 'title', 'titlePage'));
    }
}
