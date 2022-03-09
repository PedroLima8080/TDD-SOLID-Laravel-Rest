<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'title' => 'required|unique:products',
            'price' => 'required|integer|min:0'
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
}
