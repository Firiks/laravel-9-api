<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SetupController extends Controller
{
  public function setup(Request $request) {
    $credentials = [
      'email' => 'tst@tst.com',
      'password' => 'password'
    ];

   if( !Auth::attempt($credentials) ) {
      $user = new User();

      $user->name = 'Admin';
      $user->email = $credentials['email'];
      $user->password = Hash::make($credentials['password']);

      $user->save();

      if( Auth::attempt($credentials) ) {
        $user = Auth::user();
        $adminToken = $user->createToken('admin-token', ['create', 'update', 'delete']);
        $updateToken = $user->createToken('update-token', ['create', 'update']);
        $basicToken = $user->createToken('basic-token', ['none']);
        
        return [
          'admin' => $adminToken->plainTextToken,
          'update' => $updateToken->plainTextToken,
          'basic' => $basicToken->plainTextToken,
        ];
      }
   }
  }
}
