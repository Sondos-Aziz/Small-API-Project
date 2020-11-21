<?php

namespace App\Http\Controllers\Api\Admin;

use Exception;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use GeneralTrait;

    public function login( Request $request){
        //validation
       try{
        $rules =[
            'email' => "required |exists:admins,email", // exist in table admins in field email
            'password' => "required"
        ];

        $validator = Validator::make($request->all() , $rules);
        if($validator->fails()){
            $code = $this->returnCodeAccordingToInput($validator);
           return $this->returnValidationError($code , $validator);
        }
    
        //login
        $credentials = $request -> only(['email','password']);
        $token = Auth::guard('admin-api')-> attempt($credentials);  // Generate a token for the admin if the credentials are valid

        if(!$token)
            return $this->returnError('E001','the data of inputs does not true');

            $admin =Auth::guard('admin-api')->user(); //return the admin without the token
            $admin->api_token = $token; // the key api_token and the value token
        //return token
        // return $this->returnData('adminToken',$token);
        return $this->returnData('admin',$admin);
   
        }catch(\Exception $ex){
            return $this->returnError($ex->getCode(),$ex->getMessage());

        }
    }
}
