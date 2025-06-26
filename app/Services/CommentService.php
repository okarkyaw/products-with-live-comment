<?php

namespace App\Services;

use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentService
{
    public function store(array $data): Comment
    {
        $data['user_id'] = Auth::user()->id;
        return Comment::create($data);
    }
}
