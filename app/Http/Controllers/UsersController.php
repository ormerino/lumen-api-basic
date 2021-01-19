<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UsersController extends Controller

{

  public function __construct(){

//        $this->middleware('auth', ['only' =>
//  ['authenticate']]);

  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
  */
  public function authenticate(Request $request)
  {
    
    $this->validate($request, [
      'email' => 'required',
      'password' => 'required'
    ]);

    $user = User::where('email', $request->email)->first();
    if(!$user)
      return response()->json(['status' => 'fail'],401);
//dd($request->input('password'));
    if(Hash::check($request->input('password'), $user->password)){
      $apikey = base64_encode(Str::random(40));+
      User::where('email', $request->input('email'))->update(['api_key' => "$apikey","expiration_key"=>Carbon::now()->addHour(2)]);
      return response()->json(['status' => 'success','api_key' => $apikey]);
    }else{
      return response()->json(['status' => 'fail'],401);
    }

  }

  public function getUsers(Request $request){
    return response()->json(['status'=>200,'data'=>User::all(),'message'=>'Ok'],200);
  }

}