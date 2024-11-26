<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Comment;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $id)
    {
        // Return all data
		$comments = Comment::where('post_id', $id)->get();

		if(!$comments->toArray()){
			return response()->json([
				'_S' 	=> 0,
				'_M' 	=> 'No comments found',
				'_F' 	=> 'NOTY',
				'data'	=> []
			]);
		}

		return response()->json([
			'_S' 	=> 1,
			'_M' 	=> 'Comments found',
			'_F' 	=> 'NOTY',
			'data'	=> $comments
		]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $id)
    {
        // Test if user is logged in
		if(!Auth::check()){
			return response()->json([
				'_S' 	=> 0,
				'_M' 	=> 'Please login',
				'_F' 	=> 'NOTY',
				'data'	=> []
			]);
		}

		// Validate data
		$commentData = $request->validate([
			'content'	=> 'required|string'
		]);

		$post = Post::find($id);

		if(!$post->toArray()){
			return response()->json([
				'_S' 	=> 0,
				'_M' 	=> 'Post not found',
				'_F' 	=> 'NOTY',
				'data'	=> []
			]);
		}

		// Create record
		Comment::create([
			'post_id'	=> $id,
			'user_id'	=> Auth::user()->id,
			'content'	=> $commentData['content'],
		]);

		// Send response
		return response()->json([
			'_S' 	=> 1,
			'_M' 	=> 'Comment posted successfully',
			'_F' 	=> 'NOTY',
			'data'	=> []
		]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Test if user is logged in
		if(!Auth::check()){
			return response()->json([
				'_S' 	=> 0,
				'_M' 	=> 'Please login',
				'_F' 	=> 'NOTY',
				'data'	=> []
			]);
		}

		// Validate
		$commentData = $request->validate([
			'content'	=> 'required|string'
		]);

		$comment = Comment::find($id);

		if(!$comment->toArray()){
			return response()->json([
				'_S' 	=> 0,
				'_M' 	=> 'Comment not found',
				'_F' 	=> 'NOTY',
				'data'	=> []
			]);
		}

		if($comment->user_id != Auth::user()->id){
			return response()->json([
				'_S' 	=> 0,
				'_M' 	=> 'Only the owner can update this comment',
				'_F' 	=> 'NOTY',
				'data'	=> []
			]);
		}

		// Update record
		$comment->update([
			'content'	=> $commentData['content'],
		]);

		// Send response
		return response()->json([
			'_S' 	=> 1,
			'_M' 	=> 'Comment updated successfully',
			'_F' 	=> 'NOTY',
			'data'	=> []
		]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Test if user is logged in
		if(!Auth::check()){
			return response()->json([
				'_S' 	=> 0,
				'_M' 	=> 'Please login',
				'_F' 	=> 'NOTY',
				'data'	=> []
			]);
		}

		// Validate
		$comment = Comment::find($id);

		if(!$comment->toArray()){
			return response()->json([
				'_S' 	=> 0,
				'_M' 	=> 'Comment not found',
				'_F' 	=> 'NOTY',
				'data'	=> []
			]);
		}

		if($comment->user_id != Auth::user()->id){
			return response()->json([
				'_S' 	=> 0,
				'_M' 	=> 'Only the owner can delete this comment',
				'_F' 	=> 'NOTY',
				'data'	=> []
			]);
		}

		// Delete record
		$comment->delete();

		// Send response
		return response()->json([
			'_S' 	=> 1,
			'_M' 	=> 'Comment deleted successfully',
			'_F' 	=> 'NOTY',
			'data'	=> []
		]);
    }
}
