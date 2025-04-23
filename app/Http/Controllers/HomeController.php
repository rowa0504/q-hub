<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\TransCategory;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $category;
    private $trans_category;

    public function __construct(Category $category, TransCategory $trans_category)
    {
        $this->category = $category;
        $this->trans_category = $trans_category;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $all_categories = $this->category->all();
        $all_trans_categories = $this->trans_category->all();

        return view('home')
            ->with('all_categories',$all_categories)
            ->with('all_trans_categories',$all_trans_categories);
    }
}
