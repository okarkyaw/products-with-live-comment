<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Repositories\CommentRepository;
use App\Repositories\ProductRepository;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    protected ProductRepository $productRepository;
    protected ProductService $productService;
    protected CommentRepository $commentRepository;

    public function __construct(ProductRepository $productRepository, ProductService $productService, CommentRepository $commentRepository)
    {
        $this->productRepository = $productRepository;
        $this->productService    = $productService;
        $this->commentRepository = $commentRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = $this->productRepository->getProducts();

        return Inertia::render('Product/List', [
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Product/CreateEdit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $product = $this->productService->store($request);
        return response()->json([
            'data'    => $product,
            'message' => 'Successfully create product.',
            'status'  => 'success',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = $this->productRepository->find($id);
        $comments= $this->commentRepository->getByProductId($id);
        return Inertia::render('Product/Detail', [
            'product' => $product,
            'comments'=> $comments
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
