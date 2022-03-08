<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'title' => 'required|unique:categories'
        ]);

        DB::beginTransaction();
        try {
            $category = Category::create($request->all());
            DB::commit();
            return redirect()->route('app.category.index');
        } catch (\PDOException $e) {
            echo $e->getMessage();
            DB::rollBack();
            exit;
        }

    }

    public function index(){
        $categories = Category::orderBy('title', 'ASC')->get();
        return view('category.index', compact('categories'));
    }

    public function create(){
        return view('category.create');
    }
}
