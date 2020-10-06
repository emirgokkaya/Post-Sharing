<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        $comments = Comment::where('user_id', '!=', auth()->user()->id)->with('news')->with('user')->orderBy('created_at', 'DESC')->get();
        return view('admin.pages.comment.index')->with('comments', $comments);
    }

    public function update($id)
    {
        $comment = Comment::where('id', $id)->firstOrFail();

        $comment->state = !$comment->state;

        $comment->update();

        return response()->json($comment);
        /*return redirect()->route('comments');*/
    }

    public function delete($id)
    {
        $comment = Comment::where('id', $id)->with('user')->firstOrFail();
        $comment->delete();

        return response()->json($comment);
    }

    public function delete_all_comments()
    {
        Comment::whereNotNull('id')->delete();

        return response()->json('Tüm yorumlar başarıyla silindi');
    }
}
