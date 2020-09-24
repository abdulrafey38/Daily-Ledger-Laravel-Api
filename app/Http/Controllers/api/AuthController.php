<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{

    public static function login(Request $request)
    {


        $request->validate([
            'email' => ['required'],
            'password' => ['required'],

        ]);
        $user = User::where('email', $request->email)->first();

        if (Auth::attempt($request->only('email', 'password'))) {
            $token = $user->createToken($request->email)->plainTextToken;
            $response = [
                'user' => $user,
                'token' => $token
            ];
            return response($response, 200);
        }

        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    //==============================================================================
    public function update(Request $request)
    {
        if ($request->password) {
            $request->validate([
                'name' => ['required'],
                'email' => ['required'],
                'password' => ['min:8']
            ]);
        } else {
            $request->validate([
                'name' => ['required'],
                'email' => ['required'],

            ]);
        }
        $user = Auth::user();
        $password = $user->password;

        if ($request->password) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password =  \bcrypt($request->password);
            $user->update();
        } else {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password =  $password;
            $user->update();
        }
        return response()->json([
            'user' => $user
        ], 200);
    }

    //================================================
    public function logout(Request $request)
    {

        $request->user()->currentAccessToken()->delete();
        return response()->json(200);
    }
    //=======================================================
    public function token(Request $request)
    {
        if ($request->user()->currentAccessToken()) {
            return response()->json(200);
        } else {
            return response()->json(500);
        }
    }

    //=======================================================
    public function tokenbahir(Request $request)
    {
       return \response()->json(200);
    }


    //========================================================
    public function register(Request $request)
    {


        $request->validate([
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8', 'confirmed']
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        return response()->json([
            'info' => self::login($request)
        ], 201);
    }
}

//     public function authenticate(Request $request)
//     {
//             return $request;
//         $credentials = $request->only('email', 'password');

//         try {
//             if (! $token = JWTAuth::attempt($credentials)) {
//                 return response()->json(['error' => 'invalid_credentials'], 400);
//             }
//         } catch (JWTException $e) {
//             return response()->json(['error' => 'could_not_create_token'], 500);
//         }
//         $user = User::where('email', $request->email)->first();

//         return response()->json([
//                 'token'=>$token,
//                 'user'=>$user
//         ],201);
//     }

//     public function register(Request $request)
//     {
//             $validator = Validator::make($request->all(), [
//             'name' => 'required|string|max:255',
//             'email' => 'required|string|email|max:255|unique:users',
//             'password' => 'required|string|min:6|confirmed',
        
//         ]);

//         if($validator->fails()){
//                 return response()->json($validator->errors()->toJson(), 400);
//         }

//         $user = User::create([
//             'name' => $request->get('name'),
//             'email' => $request->get('email'),
//             'password' => Hash::make($request->get('password')),
//         ]);

//         $token = JWTAuth::fromUser($user);

//         return response()->json(compact('user','token'),201);
//     }

//     public function getAuthenticatedUser()
//         {
//                 try {

//                         if (! $user = JWTAuth::parseToken()->authenticate()) {
//                                 return response()->json(['user_not_found'], 404);
//                         }

//                 } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

//                         return response()->json(['token_expired'], $e->getStatusCode());

//                 } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

//                         return response()->json(['token_invalid'], $e->getStatusCode());

//                 } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

//                         return response()->json(['token_absent'], $e->getStatusCode());

//                 }

//                 return response()->json(compact('user'));
//         }


//         public function logout(Request $request)

//         {
       
//                 $token = $request->header("Authorization");
                
//                 try {
//                 JWTAuth::invalidate(JWTAuth::getToken());
//                 return response()->json([
//                 "status" => "success",
//                 "message"=> "User successfully logged out."
//                 ]);
//                 } catch (JWTException $e) {

//                 return response()->json([
//                 "status" => "error",
//                 "message" => "Failed to logout, please try again."
//                 ], 500);
//                 }

//         }
// }
