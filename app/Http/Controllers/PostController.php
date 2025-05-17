<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\TransCategory;
use App\Models\PostImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    private $post;
    private $category;
    private $trans_category;

    public function __construct(Post $post, Category $category, TransCategory $trans_category, PostImage $postImage)
    {
        $this->post           = $post;
        $this->category       = $category;
        $this->trans_category = $trans_category;
        $this->postImage = $postImage;
    }

    public function store(Request $request)
    {
        $commonRules = [ //other
            'description' => 'required|min:1|max:1000',
            'images.*' => 'image|mimes:jpeg,jpg,png,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
        ];

        // カテゴリIDごとに追加のバリデーションを分ける
        $categoryId = $request->input('category_id');

        if ($categoryId == 1 || $categoryId == 3) { // event,item
            $extraRules = [
                'max'       => 'required|numeric|min:1',
                'startdate' => 'required|date|after_or_equal:today',
                'enddate'   => 'date|after_or_equal:startdate',
            ];
            $modalId = 'post-form-' . $categoryId;
        } elseif ($categoryId == 2 || $categoryId == 4) { // food,travel
            $extraRules = [
                'location'  => 'required|string|max:50',
                'latitude'  => 'required|numeric',
                'longitude' => 'required|numeric',
            ];
            $modalId = 'post-form-' . $categoryId;
        } elseif ($categoryId == 5) { // transportation
            $extraRules = [
                'departure'      => 'required|string|max:50',
                'destination'    => 'required|string|max:50',
                'fee'            => 'required|numeric|min:1',
                'trans_category' => 'required|exists:trans_categories,id',
            ];
            $modalId = 'post-form-' . $categoryId;
        } elseif ($categoryId == 6) { // question
            $extraRules = [
                'title' => 'required|min:1|max:50',
            ];
            $modalId = 'post-form-' . $categoryId;
        } elseif ($categoryId == 7) { // item
            $extraRules = $commonRules;
            $modalId = 'post-form-' . $categoryId;
        }

        $validator = Validator::make($request->all(), array_merge($commonRules, $extraRules));

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('open_modal', $modalId);  // モーダルIDをセッションに保存
        }

        $this->post->user_id     = Auth::user()->id;
        $this->post->title       = $request->title;
        $this->post->description = $request->description;

        // if ($request->hasFile('image')) {
        //     $this->post->image = 'data:image/' . $request->image->extension() .
        //         ';base64,' . base64_encode(file_get_contents($request->image));
        // }

        $this->post->location          = $request->location;
        $this->post->latitude          = $request->latitude;
        $this->post->longitude         = $request->longitude;
        $this->post->departure         = $request->departure;
        $this->post->destination       = $request->destination;
        $this->post->fee               = $request->fee;
        $this->post->max               = $request->max;
        $this->post->startdatetime     = $request->startdate;
        $this->post->enddatetime       = $request->enddate;
        $this->post->category_id       = $request->category_id;
        $this->post->trans_category_id = $request->trans_category;
        $this->post->save();

        // base64形式で画像を保存
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageBase64 = 'data:image/' . $image->extension() . ';base64,' . base64_encode(file_get_contents($image));
                $this->post->images()->create([
                    'path' => $imageBase64, // DBにbase64文字列を保存
                ]);
            }
        }

        return redirect()->back();
    }


    public function edit($id)
    {
        // $post = $this->post->findOrFail($id);

        // // 画像データがBase64形式で保存されている場合、そのまま返す
        // if ($post->image && strpos($post->image, 'data:image') === false) {
        //     // 画像ファイルのパスが保存されている場合
        //     $imagePath = storage_path('app/public/' . $post->image);

        //     // 画像が存在する場合、Base64に変換して返す
        //     if (file_exists($imagePath)) {
        //         $imageData = base64_encode(file_get_contents($imagePath));
        //         $mimeType = mime_content_type($imagePath); // MIMEタイプを取得
        //         $post->image = 'data:' . $mimeType . ';base64,' . $imageData;
        //     } else {
        //         // 画像が存在しない場合、nullを設定
        //         $post->image = null;
        //     }
        // }

        // return response()->json($post);

        $post = Post::with('images')->findOrFail($id);

        $images = [];
        foreach ($post->images as $image) {
            // 既にBase64ならそのまま使う
            if (strpos($image->path, 'data:image') === 0) {
                $images[] = $image->path;
            } else {
                // 万が一Base64でない場合の対応（不要なら削除可）
                $images[] = null; // または適宜処理
            }
        }

        return response()->json([
            'post' => [
                'id' => $post->id,
                'title' => $post->title,
                'description' => $post->description,
                'location' => $post->location,
                'latitude' => $post->latitude,
                'longitude' => $post->longitude,
                'departure' => $post->departure,
                'destination' => $post->destination,
                'fee' => $post->fee,
                'max' => $post->max,
                'startdatetime' => $post->startdatetime,
                'enddatetime' => $post->enddatetime,
            ],
            'images' => $images,
        ]);
    }

    public function update($id, Request $request)
    {
        $commonRules = [ //other
            'description' => 'required|min:1|max:1000',
            'images.*' => 'image|mimes:jpeg,jpg,png,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
        ];

        // カテゴリIDごとに追加のバリデーションを分ける
        $categoryId = $request->input('category_id');

        if ($categoryId == 1 || $categoryId == 3) { // event,item
            $extraRules = [
                'max'       => 'required|numeric|min:1',
                'startdate' => 'required|date|after_or_equal:today',
                'enddate'   => 'date|after_or_equal:startdate',
            ];
            $modalId = 'edit-form-' . $categoryId;
        } elseif ($categoryId == 2 || $categoryId == 4) { // food,travel
            $extraRules = [
                'location'  => 'required|string|max:50',
                'latitude'  => 'required|numeric',
                'longitude' => 'required|numeric',
            ];
            $modalId = 'edit-form-' . $categoryId;
        } elseif ($categoryId == 5) { // transportation
            $extraRules = [
                'departure'      => 'required|string|max:50',
                'destination'    => 'required|string|max:50',
                'fee'            => 'required|numeric|min:1',
                'trans_category' => 'required|exists:trans_categories,id',
            ];
            $modalId = 'edit-form-' . $categoryId;
        } elseif ($categoryId == 6) { // question
            $extraRules = [
                'title' => 'required|min:1|max:50',
            ];
            $modalId = 'edit-form-' . $categoryId;
        } elseif ($categoryId == 7) { // item
            $extraRules = $commonRules;
            $modalId = 'edit-form-' . $categoryId;
        }

        $validator = Validator::make($request->all(), array_merge($commonRules, $extraRules));

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('open_modal', $modalId);  // モーダルIDをセッションに保存
        }

        $post = $this->post->findOrFail($id);

        $post->user_id     = Auth::user()->id;
        $post->title       = $request->title;
        $post->description = $request->description;
        // if ($request->hasFile('image')) {

        //     $post->image = 'data:image/' . $request->image->extension() .
        //                          ';base64,' . base64_encode(file_get_contents($request->image));
        // } else {
        //     $post->image = null;
        // }
        $post->location          = $request->location;
        $post->latitude          = $request->latitude;
        $post->longitude         = $request->longitude;
        $post->departure         = $request->departure;
        $post->destination       = $request->destination;
        $post->fee               = $request->fee;
        $post->max               = $request->max;
        $post->startdatetime     = $request->startdate;
        $post->enddatetime       = $request->enddate;
        $post->category_id       = $request->category_id;
        $post->trans_category_id = $request->trans_category;
        $post->save();

        // 3. 画像がアップロードされていれば
        if ($request->hasFile('images')) {
            // 既存画像を削除（物理ファイルを扱っていないならDBのみ）
            $post->images()->delete();

            // 画像の保存
            foreach ($request->file('images') as $image) {
                $imageBase64 = 'data:image/' . $image->extension() . ';base64,' . base64_encode(file_get_contents($image));
                $post->images()->create([
                    'path' => $imageBase64, // DBにbase64文字列を保存
                ]);
            }
        } else {
            $post->images()->delete();
        }

        return redirect()->back();
    }

    public function delete($id)
    {
        $post = $this->post->findOrFail($id);

        $post->forceDelete(); // ← これで完全に削除される
        return redirect()->back();
    }
    public function loadMore(Request $request)
    {
        if ($request->ajax()) {
            $page = $request->input('page', 1);
            $perPage = 5;
            $all_posts = Post::latest()->paginate($perPage, ['*'], 'page', $page);

            if ($all_posts->isEmpty()) {
                // 投稿がもうない場合は空レスポンスを返す
                return response('', 204);
            }

            return view('posts.components.post-cards', compact('all_posts'))->render();
        }

        $perPage = 5;
        $all_posts = Post::latest()->paginate($perPage);
        return view('home', compact('all_posts'));
    }
}
