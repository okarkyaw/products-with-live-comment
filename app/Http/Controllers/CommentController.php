<?php

namespace App\Http\Controllers;

use App\Events\CommentPosted;
use App\Models\Comment;
use App\Services\CommentService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    protected CommentService $commentService;

    public function __construct(CommentService $commentService)
    {
        $this->commentService = $commentService;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $comment = $this->commentService->store($data);
        $user = $comment->user;
        CommentPosted::dispatch($comment);
        
        return response()->json([
            'data'    => $comment,
            'message' => 'Successfully create comment.',
            'status'  => 'success',
        ]);
    }
}
