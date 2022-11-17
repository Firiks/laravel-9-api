<?php

namespace App\Http\Controllers\API\V1;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
  
  public function register(Request $request) {
    // validate data
    $fields = $request->validate([
      'name' => 'required|string',
      'email' => 'required|string|unique:users,email',
      'password' => 'required|string'
    ]);

    // create new user
    $user = User::create([
      'name' => $fields['name'],
      'email' => $fields['email'],
      'password' => bcrypt($fields['password']) // secure hash helper function
    ]);

    // create secure token and return as plaitext
    $updateToken = $user->createToken('update-token', ['create', 'update']);
    $basicToken = $user->createToken('basic-token', ['none']);

    // return user data + token to access protected routes
    $response = [
      'user' => $user,
      'update-token' => $updateToken,
      'basic-token' => $basicToken
    ];

    return response($response, 201);
  }

}
