<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function create(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
            ]);
        } catch (\Exception $e) {
            return response([
                'message' => ['Invalid or missing fields']
            ], 400);
        }

        $todolist = $request->get('todolist');

        $product = Product::create([
            'name' => $request->name,
            'todolist_id' => $todolist->id
        ]);
        return response($product, 200);
    }

    public function delete(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required',
            ]);
        } catch (\Exception $e) {
            return response([
                'message' => ['Invalid or missing fields']
            ], 400);
        }

        $product = Product::find($request->id);
        $product->delete();
        return response([
            'message' => 'Product deleted'
        ], 200);
    }
}
