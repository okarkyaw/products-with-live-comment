<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductService
{
    public function store($request): Product
    {
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('products', 'public');
            $data['image'] = $image;
        }
        return Product::create($data);
    }
}
