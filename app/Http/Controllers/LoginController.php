<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    // Register
	public function register(Request $request){

		// Data validation
		$userData = $request->validate([
			'first_name'	=> 'required|string',
			'last_name'		=> 'required|string',
			'phone'			=> 'required|string|digits:10',
			'email'			=> 'required|string|email|unique:users',
			'password'		=> 'required|min:8'
		]);

		// Create record
		User::create([
			'first_name'	=> $userData['first_name'],
			'last_name'		=> $userData['last_name'],
			'phone'			=> $userData['phone'],
			'email'			=> $userData['email'],
			'password'		=> Hash::make($userData['password'])
		]);

		// Send response
		return response()->json([
			'_S' 	=> 1,
			'_M' 	=> 'User registration was successfull',
			'_F' 	=> 'NOTY',
			'data'	=> [],
		]);

	}

	// Login
	public function login(Request $request){

		// Validate data
		$userData = $request->validate([
			'email'		=> 'required|string|email',
			'password'	=> 'required|min:8'
		]);

		// Authenticate user
		if(!Auth::attempt($userData)){
			return response()->json([
				'_S'	=> 0,
				'_M'	=> 'Invalid credentials',
				'_F'	=> 'NOTY',
				'data'	=> $userData
			]);
		}

		// Get user token
		$user	= Auth::user();
		$token	= $user->createToken('API Token')->plainTextToken;

		// Send response
		return response()->json([
			'_S' 	=> 1,
			'_M' 	=> 'Login was successfull',
			'_F' 	=> 'NOTY',
			'data'	=> [
				'token' => $token,
			],
		]);

	}

	// Logout
	public function logout(Request $request){

		// Terminate current session
		$request->user()->currentAccessToken()->delete();

		// Send response
		return response()->json([
			'_S' 	=> 1,
			'_M' 	=> 'Logout was successfull',
			'_F' 	=> 'NOTY',
			'data'	=> [],
		]);

	}

}
