<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {		
		// Return all data
		$posts = Post::get();

		if(!$posts->toArray()){
			return response()->json([
				'_S' 	=> 0,
				'_M' 	=> 'No posts found',
				'_F' 	=> 'NOTY',
				'data'	=> []
			]);
		}

		return response()->json([
			'_S' 	=> 1,
			'_M' 	=> 'Posts found',
			'_F' 	=> 'NOTY',
			'data'	=> $posts
		]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
		$postData = $request->validate([
			'title'		=> 'required|string',
			'content'	=> 'required|string'
		]);

		// Create record
		Post::create([
			'title'		=> $postData['title'],
			'content'	=> $postData['content'],
			'user_id'	=> Auth::user()->id
		]);

		// Send response
		return response()->json([
			'_S' 	=> 1,
			'_M' 	=> 'Posted successfully again',
			'_F' 	=> 'NOTY',
			'data'	=> []
		]);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Get single post
		$post = Post::find($id);

		if(!$post->toArray()){
			return response()->json([
				'_S' 	=> 0,
				'_M' 	=> 'Post not found',
				'_F' 	=> 'NOTY',
				'data'	=> []
			]);
		}
		
		return response()->json([
			'_S' 	=> 1,
			'_M' 	=> 'Post found',
			'_F' 	=> 'NOTY',
			'data'	=> Post::find($id)
		]);

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

		// Validate data
		$updateData = $request->validate([
			'title'		=> 'required|string',
			'content'	=> 'required|string'
		]);

		$post = Post::find($id);

		if($post->user_id != Auth::user()->id){
			return response()->json([
				'_S' 	=> 0,
				'_M' 	=> 'Only the owner can update this post',
				'_F' 	=> 'NOTY',
				'data'	=> []
			]);
		}

		// update record
		$post->update([
			'title'		=> $updateData['title'],
			'content'	=> $updateData['content'],
		]);

		// Send response
		return response()->json([
			'_S' 	=> 1,
			'_M' 	=> 'Post updated successfully',
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

		$post = Post::find($id);

		if($post->user_id != Auth::user()->id){
			return response()->json([
				'_S' 	=> 0,
				'_M' 	=> 'Only the owner can delete this post',
				'_F' 	=> 'NOTY',
				'data'	=> []
			]);
		}

		// update record
		$post->delete();

		// Send response
		return response()->json([
			'_S' 	=> 1,
			'_M' 	=> 'Post deleted successfully',
			'_F' 	=> 'NOTY',
			'data'	=> []
		]);
    }

    public function search(string $query)
    {
        // Return all data
		$posts = Post::where('title', 'like', '%'. $query .'%')->orWhere('content', 'like', '%'. $query .'%')->get();

		if(!$posts->toArray()){
			return response()->json([
				'_S' 	=> 0,
				'_M' 	=> 'No posts found',
				'_F' 	=> 'NOTY',
				'data'	=> []
			]);
		}

		return response()->json([
			'_S' 	=> 1,
			'_M' 	=> 'Posts found',
			'_F' 	=> 'NOTY',
			'data'	=> $posts
		]);
    }

    public function filter(string $id)
    {
        // Return all data
		$posts = Post::where('user_id','=', $id)->get();

		if(!$posts->toArray()){
			return response()->json([
				'_S' 	=> 0,
				'_M' 	=> 'No posts found',
				'_F' 	=> 'NOTY',
				'data'	=> []
			]);
		}

		return response()->json([
			'_S' 	=> 1,
			'_M' 	=> 'Posts found',
			'_F' 	=> 'NOTY',
			'data'	=> $posts
		]);
    }

}
