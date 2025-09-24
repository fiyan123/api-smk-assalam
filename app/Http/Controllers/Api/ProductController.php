<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Products berhasil diambil',
            'data' => $products,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'stock' => 'nullable|integer|min:0',
        ]);

        $products = new Product();
        $products->name = $request->name;
        $products->price = $request->price;
        $products->description = $request->description;
        $products->stock = $request->stock ?? 0;
        $products->save();

        return response()->json([
            'status' => 201,
            'success' => true,
            'message' => 'Product berhasil ditambahkan',
            'data' => $products,
        ], 201);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status' => 404,
                'success' => false,
                'message' => 'Product not found',
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Product berhasil diambil',
            'data' => $product,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'price' => 'sometimes|required|numeric|min:0',
            'description' => 'nullable|string',
            'stock' => 'nullable|integer|min:0',
        ]);

        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status' => 404,
                'success' => false,
                'message' => 'Product not found',
            ], 404);
        }

        if ($request->has('name')) {
            $product->name = $request->name;
        }
        if ($request->has('price')) {
            $product->price = $request->price;
        }
        if ($request->has('description')) {
            $product->description = $request->description;
        }
        if ($request->has('stock')) {
            $product->stock = $request->stock;
        }

        $product->save();

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Product berhasil diupdate',
            'data' => $product,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status' => 404,
                'success' => false,
                'message' => 'Product not found',
            ], 404);
        }

        $product->delete();

        return response()->json([
            'status' => 200,
            'success' => true,
            'message' => 'Product berhasil dihapus',
        ]);
    }
}
