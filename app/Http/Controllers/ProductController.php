<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'title' => 'required|unique:products',
            'price' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id'
        ]);

        $data = $request->all();
        DB::beginTransaction();
        try {
            $product = Product::create($data);
            DB::commit();
            return redirect()->route('app.product.index');
        } catch (\PDOException $e) {
            echo $e->getMessage();
            DB::rollBack();
            exit;
        }
    }

    public function index(){
        $products = Product::orderBy('title', 'ASC')->get();
        return view('product.index', compact('products'));
    }

    public function create(){
        $categories = Category::orderBy('title', 'ASC')->get();
        return view('product.create', compact('categories'));
    }

    public function update($id, Request $request){
        $request->validate([
            'title' => "required|unique:products,title,$id",
            'price' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id'
        ]);

        $product = Product::findOrFail($id);
        
        DB::beginTransaction();
        try {
            $product->update($request->all());
            DB::commit();
            return redirect()->route('app.product.index');
        } catch (\PDOException $e) {
            echo $e->getMessage();
            DB::rollBack();
            exit;
        }
    }

    public function edit($id){
        $product = Product::findOrFail($id);
        $categories = Category::orderBy('title', 'ASC')->get();
        
        return view('product.edit', compact('categories', 'product'));
    }
    
    public function destroy($id){
        $product = Product::findOrFail($id);

        DB::beginTransaction();
        try {
            $product->delete();
            DB::commit();
            return redirect()->route('app.product.index');
        } catch (\PDOException $e) {
            echo $e->getMessage();
            DB::rollBack();
            exit;
        }
    }
}
