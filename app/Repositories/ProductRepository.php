<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository
{
    public function getProducts()
    {
        return Product::all();
    }

    public function find(int $id)
    {
        return Product::with('user')->findOrFail($id);
    }
}
