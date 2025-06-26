<?php

namespace App\Repositories;

use App\Models\Comment;

class CommentRepository
{
    public function getByProductId(int $productId)
    {
        return Comment::with('user')->where('product_id', $productId)->get();
    }
}
