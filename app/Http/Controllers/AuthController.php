<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Mail\PasswordResetCodeMail;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;


class AuthController extends Controller
{
    public function register(request $request) {

        $validator=Validator::make($request->all(),[
            'name'=>'required|string|max:255',
            'email'=>'required|string|email|max:255|unique:users',
            'password'=>'required|string|min:8'
        ]);
        if($validator->fails()){
            return response()->json($validator->errors(),400);
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
            'user' => [
                'name' => $user->name,
                'role' => $user->role, 
            ],
        ]);
    }

    public function forgotPassword(Request $request)
    {   
        $request->validate([
            'email' => 'required|email',
        ]);
    
        $user = User::where('email', $request->email)->first();
    
        if ($user) {
            $code = mt_rand(100000, 999999); 
            Cache::put('password_reset_code_' . $user->id, $code, now()->addMinutes(10));
    
            
            $this->sendVerificationCode($user->email, $code);
    
            return response()->json(['message' => 'Kod je poslat na vašu email adresu.'], 200);

        }
    
        return response()->json(['message' => 'Korisnik nije pronađen.'], 404);
    }

    private function sendVerificationCode($email, $code)
    {
        Mail::to($email)->send(new PasswordResetCodeMail($code));
    }
 
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|numeric',
            'new_password' => 'required|string|min:8',
        ]);
    
        $user = User::where('email', $request->email)->first();
    
        if ($user) {
            $storedCode = Cache::get('password_reset_code_' . $user->id);
    
            if ($storedCode && $storedCode == $request->code) {
                $user->password = Hash::make($request->new_password);
                $user->save();
    
                Cache::forget('password_reset_code_' . $user->id);
    
                return response()->json(['message' => 'Šifra je uspešno ažurirana.']);
            }
    
            return response()->json(['message' => 'Pogrešan kod za resetovanje šifre.'], 400);
        }
    
        return response()->json(['message' => 'Korisnik nije pronađen.'], 404);
    }


    public function logout(Request $request)
    {
       $request->user()->tokens()->delete();
       return response()->json(['message'=> 'Uspesno ste se izlogovali!']);
    }
}
