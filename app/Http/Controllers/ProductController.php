<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Repositories\ProductRepository;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{
    private $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = $this->repository->paginate(16);
        $products = ProductResource::collection($products);
        return $products;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'name' => 'required',
            'tag' => 'required',
            'count' => 'required',
            'rating' => 'required',
            'price' => 'required',
            'description' => 'required',
            'title' => 'required',
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->tag = $request->tag;
        $product->count = $request->count;
        $product->rating = $request->rating;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->title = $request->title;
        $product->save();

        return response()->json(['data' => $product], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(string $id)
    {
        $product = $this->repository->with(['colors','sizes'], $id);
        return response()->json(['data' => $product], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        //
        $product=Product::findOrFail($id);
        $product->name = $request->name;
        $product->tag = $request->tag;
        $product->count = $request->count;
        $product->rating = $request->rating;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->title = $request->title;
        $product->save();

        return response()->json(['data' => $product], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product=Product::findOrFail($id);
        $product->delete();
        return response()->json([], 200);
    }

    public function featured()
    {
        $featuredProducts = $this->repository->featured();
        return response()->json($featuredProducts, Response::HTTP_OK);
    }
}
