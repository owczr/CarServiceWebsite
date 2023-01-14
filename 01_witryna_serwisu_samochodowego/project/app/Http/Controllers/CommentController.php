<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\View\View;

class CommentController extends Controller
{
    public function index(): View
    {
        return view('gallery.index')->with('gallery', Comment::all());
    }

    public function show(Comment $comment): View
    {
        return view('gallery.show')->with('comment', $comment);
    }
}
