<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\TransCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    private $post;
    private $category;
    private $trans_category;

    public function __construct(Post $post, Category $category, TransCategory $trans_category)
    {
        $this->post = $post;
        $this->category = $category;
        $this->trans_category = $trans_category;
    }

    public function store(Request $request){
        $commonRules = [//other,question
            'title' => 'required|min:1|max:50',
            'description' => 'required|min:1|max:1000',
            'image' => 'nullable|mimes:jpeg,jpg,png,gif|max:1048',
            'category_id' => 'required|exists:categories,id',
        ];

        // カテゴリIDごとに追加のバリデーションを分ける
        $categoryId = $request->input('category_id');

        if ($categoryId == 1 || $categoryId == 3) { // event,item
            $extraRules = [
                'max' => 'required|numeric|min:1',
                'startdate' => 'required|date',
                'enddate'   => 'date|after_or_equal:startdate',
            ];
            $modalId = 'post-form-' . $categoryId;
        } elseif ($categoryId == 2 || $categoryId == 4) { // food,travel
            $extraRules = [
                'location'  => 'required|string|max:50',
            ];
            $modalId = 'post-form-' . $categoryId;
        } elseif ($categoryId == 5) { // item
            $extraRules = [
                'departure' => 'required|string|max:50',
                'destination' => 'required|string|max:50',
                'fee' => 'required|numeric|min:1',
                'trans_category' => 'required|exists:trans_categories,id',
            ];
            $modalId = 'post-form-' . $categoryId;
        }elseif ($categoryId == 6 || $categoryId == 7) { // item
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

        $this->post->user_id = Auth::id();
        $this->post->title = $request->title;
        $this->post->description = $request->description;

        if ($request->hasFile('image')) {
            $this->post->image = 'data:image/' . $request->image->extension() .
                ';base64,' . base64_encode(file_get_contents($request->image));
        }

        $this->post->location = $request->location;
        $this->post->departure = $request->departure;
        $this->post->destination = $request->destination;
        $this->post->fee = $request->fee;
        $this->post->max = $request->max;
        $this->post->startdatetime = $request->startdate;
        $this->post->enddatetime = $request->enddate;
        $this->post->category_id = $request->category_id;
        $this->post->trans_category_id = $request->trans_category;
        $this->post->save();

        return redirect()->back();
    }


    public function edit($id){
        $commonRules = [//other,question
            'title' => 'required|min:1|max:50',
            'description' => 'required|min:1|max:1000',
            'image' => 'nullable|mimes:jpeg,jpg,png,gif|max:1048',
            'category_id' => 'required|exists:categories,id',
        ];

        // カテゴリIDごとに追加のバリデーションを分ける
        $categoryId = $request->input('category_id');

        if ($categoryId == 1 || $categoryId == 3) { // event,item
            $extraRules = [
                'max' => 'required|numeric|min:1',
                'startdate' => 'required|date',
                'enddate'   => 'date|after_or_equal:startdate',
            ];
            $modalId = 'post-form-' . $categoryId;
        } elseif ($categoryId == 2 || $categoryId == 4) { // food,travel
            $extraRules = [
                'location'  => 'required|string|max:50',
            ];
            $modalId = 'post-form-' . $categoryId;
        } elseif ($categoryId == 5) { // item
            $extraRules = [
                'departure' => 'required|string|max:50',
                'destination' => 'required|string|max:50',
                'fee' => 'required|numeric|min:1',
                'trans_category' => 'required|exists:trans_categories,id',
            ];
            $modalId = 'post-form-' . $categoryId;
        }elseif ($categoryId == 6 || $categoryId == 7) { // item
            $extraRules = $commonRules;
            $modalId = 'post-form-' . $categoryId;
        }

        $validator = Validator::make($request->all(), array_merge($commonRules, $extraRules));

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('open_modal', $modalId);
        }
        $post = $this->post->findOrFail($id);

        // 画像データがBase64形式で保存されている場合、そのまま返す
        if ($post->image && strpos($post->image, 'data:image') === false) {
            // 画像ファイルのパスが保存されている場合
            $imagePath = storage_path('app/public/' . $post->image);

            // 画像が存在する場合、Base64に変換して返す
            if (file_exists($imagePath)) {
                $imageData = base64_encode(file_get_contents($imagePath));
                $mimeType = mime_content_type($imagePath); // MIMEタイプを取得
                $post->image = 'data:' . $mimeType . ';base64,' . $imageData;
            } else {
                // 画像が存在しない場合、nullを設定
                $post->image = null;
            }
        }

        return response()->json($post);
    }

    public function update($id, Request $request){
        $commonRules = [//other,question
            'title' => 'required|min:1|max:50',
            'description' => 'required|min:1|max:1000',
            'image' => 'nullable|mimes:jpeg,jpg,png,gif|max:1048',
            'category_id' => 'required|exists:categories,id',
        ];

        // カテゴリIDごとに追加のバリデーションを分ける
        $categoryId = $request->input('category_id');

        if ($categoryId == 1 || $categoryId == 3) { // event,item
            $extraRules = [
                'max' => 'required|numeric|min:1',
                'startdate' => 'required|date',
                'enddate'   => 'date|after_or_equal:startdate',
            ];
            $modalId = 'post-form-' . $categoryId;
        } elseif ($categoryId == 2 || $categoryId == 4) { // food,travel
            $extraRules = [
                'location'  => 'required|string|max:50',
            ];
            $modalId = 'post-form-' . $categoryId;
        } elseif ($categoryId == 5) { // item
            $extraRules = [
                'departure' => 'required|string|max:50',
                'destination' => 'required|string|max:50',
                'fee' => 'required|numeric|min:1',
                'trans_category' => 'required|exists:trans_categories,id',
            ];
            $modalId = 'post-form-5';
        }

        // バリデーション処理
        $validator = Validator::make($request->all(), array_merge($commonRules, $extraRules));
        // $request->validate(array_merge($commonRules, $extraRules));

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('open_modal', $modalId); // モーダル再表示用
        }

        $post = $this->post->findOrFail($id);
        $post->user_id     = Auth::user()->id;
        $post->title = $request->title;
        $post->description = $request->description;
        if ($request->hasFile('image')) {

            $post->image = 'data:image/' . $request->image->extension() .
                                 ';base64,' . base64_encode(file_get_contents($request->image));
        } else {
            $post->image = null;
        }

        $post->location = $request->location;
        $post->departure = $request->departure;
        $post->destination = $request->destination;
        $post->fee = $request->fee;
        $post->max = $request->max;
        $post->startdatetime = $request->startdate;
        $post->enddatetime = $request->enddate;
        $post->category_id = $request->category_id;
        $post->trans_category_id = $request->trans_category;
        $post->save();

        return redirect()->back();
    }

    public function delete($id){
        $post = $this->post->findOrFail($id);

        $post->delete();
        return redirect()->back();
    }

    public function index()
    {
        // 自分（ログインしてる人）の投稿だけ取得する
        $all_posts = $this->post->where('user_id', Auth::id())
                                ->latest()
                                ->get();

        return view('users.profile.index', compact('all_posts'));
    }


}
