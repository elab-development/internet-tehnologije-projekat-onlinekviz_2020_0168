<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    public function register(request $request) {

        $validator=Validator::make($request->all(),[
            'name'=>'required|string|max:255',
            'email'=>'required|string|email|max:255|unique:users',
            'password'=>'required|string|min:8'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors());
        }
        $user=User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password)
        ]);
        $token=$user->createToken('auth_token')->plainTextToken;
        return response()
            ->json(['data'=>$user,'access_token'=>$token,'token_type'=>'Bearer',]);   
    }

    public function login (request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['Greska:', $validator->errors()]);
        }

        if(!Auth::attempt($request->only('email','password'))){
            return response()->json(['message'=>'Unauthorized'], 401);
        }
        $user = User::where('email', $request['email']) -> firstOrFail();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }

    public function forgotPassword(Request $request)
    {   
        $request->validate([
            'email' => 'required',
            'new_password' => 'required|string|min:6'
        ]);
    
        $user = User::where('email', $request->email)->first();
    
        if ($user) {
            $user->password = Hash::make($request->new_password);
            $user->save();
            
            return response()->json(['message' => 'Sifra je uspesno azurirana!']);
        }
    
        return response()->json(['message' => 'User nije pronadjen'], 404);
    }

    public function logout(Request $request)
    {
       $request->user()->tokens()->delete();
       return response()->json(['message'=> 'Uspesno ste se izlogovali!']);
    }
}
