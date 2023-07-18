<?php

namespace App\Http\Controllers;

use App\Helper\JWTToken;
use App\Mail\OTPMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;

class userController extends Controller
{


    function signupPage(Request $req){
        return view('pages.auth.registration');
    }
    function userRegistration(Request $req){
        //single kore

            try{
                User::create([
                    'firstName' => $req->input('firstName'),
                    'lastName' => $req->input('lastName'),
                    'email' => $req->input('email'),
                    'phone' => $req->input('phone'),
                    'password' => $req->input('password')
                
                ]);
                 //Or Once
                //User::create($req->input());

                return response()->json([
                    'status' => 'Success',
                    'message' => 'User Registration successful'
                 ]);

            }catch(Exception $e){

                return response()->json([
                    'status' => 'failed',
                    'message' => 'Registration failed'

                ]);

            }
       
    }



    function userLogin(Request $req){
       $count =  User::where('email', '=', $req->input('email'))
            ->where('password', '=', $req->input('password'))->count();

            if($count ===1){

            $token = JWTToken::createToken($req->input('email'));

            return response()->json([
                'status' => 'success',
                'message' => 'user log in successful',
                'token' => $token
            ]);
                    
            }else {
            return response()->json([
                'status' => 'failed',
                'message' => 'unauthorize'
            ]);
            }
    }

    function sendOtpCode(Request $req){

        $email = $req->input('email');
        $otp = rand(1000, 9999);

      $count =   User::where('email', '=', $email)->count();

      if($count===1){

            Mail::to($email)->send(new OTPMail($otp));
            User::where('email', '=', $email)->update(['otp' => $otp]);
              return response()->json([
                'status' => 'success',
                'message' => 'code sent to your email'
            ]);
      }else{
         return response()->json([
                'status' => 'failed',
                'message' => 'unauthorize'
            ]);
      }


    }





    function verifyOtp(Request $req){
        $email = $req->input('email');
        $otp = $req->input('otp');
        $count = User::where('email', '=', $email)->where('otp', '=', $otp)->count();
        if($count ===1){

            User::where('email', '=', $email)->update(['otp' => '0']);


            $token = JWTToken::createTokenForSetPassword($req->input('email'));
            return response()->json([
                'status' => 'success',
                'message' => 'otp verification successfull',
                'token' => $token
            ]);
            
        }else{
             return response()->json([
                'status' => 'failed',
                'message' => 'unauthorize'
            ]);
        }
    }

    function resetPassword(Request $req){

      try{
          $email = $req->header('email');
        $password = $req->input('password');
        User::where('email', '=', $email)->update(['password' => $password]);

        return response()->json([
            'status' => 'success',
            'message' => 'password reset successfull'
        ]);
      }
      catch(Exception $e){
         return response()->json([
            'status' => 'failed',
            'message' => 'Something went wrong'
        ]);
      }
    }
}
