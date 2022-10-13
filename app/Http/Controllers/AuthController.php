<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\LoginRequest;

use Exception;

use App\Models\User;

class AuthController extends Controller
{

    public function login()
    {
    	if(Session::get('email') && Session::get('token')){
        	return redirect()->route('articles');
    	}else{
    		return view('admin.auth.login');
    	}
    }
    
    public function onLogin(LoginRequest $request)
    {

        try{

            $user = User::where('email', $request->email)->first();

            if(!$user){
                return response()->json([
                    'message' => "Email yang Anda masukkan belum terdaftar."
                ], 404);
            }

                
            if(Hash::check($request->password, $user->password)){
                if(!$user->token){
                    $user->token = _generateToken();
                    $user->save();
                }

                return response()->json([
                    'message' => 'Login berhasil.',
                    'user'    => $user,
                    'token'   => $user->token
                ], 200);

            }else{

                return response()->json([
                    'message' => 'Password yang Anda masukkan salah.'
                ], 401);

            }


        }catch(Exception $e){

            return response()->json([
                'message' => 'Terdapat kesalahan pada sistem internal.',
                'error'   => $e->getMessage()
            ], 500);

        }
    }
	
	private function getToken($email, $token)
    {
        try{

            $token = User::where(['email' => $email, 'token' => $token])
                        ->first();

            if(!$token){
                return response()->json([
                    'message' => 'Invalid token.'
                ], 401);
            }

            return response()->json([
                'status'=> true,
                'message'   => 'Get data berhasil.',
                'user'      => $token,
            ], 200);

        }catch(Exception $e){


            return response()->json([
                'status' => false,
                'message' => 'Terdapat kesalahan pada sistem internal.',
                'error'   => '[Middleware] ' . $e->getMessage()
            ], 500);

        }
    }


    public function verifyToken($token)
    {
    	$token = explode('||', $token);
        
    	if(empty($token[1])){

            return $this->onLogout()->with(['error' => 'Invalid token.']);

        }

        Session::put('email', $token[0]);
        Session::put('token', $token[1]);

    	$data = $this->getToken($token[0], $token[1]);
        $data = $data->getData();
        
		if($data == null){

    		return $this->onLogout()->with(['error' => 'Invalid token.']);

    	}else{

    		Session::put('user', $data->user);
    		return redirect()->route('articles');
    	}
    }

    public function onLogout()
    {
    	Session::flush();

    	return redirect()->route('login');
    }

}
