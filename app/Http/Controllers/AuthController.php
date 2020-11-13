<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Helper\ResponseJson;
use App\Http\Requests\AuthRequest;
use App\Jobs\SmsJob;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @var UserService
     */
    private $user_service;

    public function __construct(UserService $user_service)
    {
        $this->user_service = $user_service;
        $this->middleware('auth:api', ['except' => ['login','otpTokenRequest','otpLogin']]);

    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validated = $this->validate($request,AuthRequest::login());

        $user = $this->user_service->getUserByPhoneNumber($validated['phone_number']);

        if (!$user) {
            return ResponseJson::failure() ;
        } else if (!Hash::check($request->password, $user->password)) {
            return ResponseJson::failure();
        }

        return ResponseJson::success('login successful',$this->respondWithToken(auth('api')->login($user)));
    }

    public function otpTokenRequest(Request $request)
    {
        $validated =  $this->validate($request, AuthRequest::otpTokenRequest());


        // 0. get User
        $user = $this->user_service->getUserByPhoneNumber($validated['phone_number']);

        // 1. generate token
        $token = random_int(1000,9999);

        // 2. save to user record
        $this->user_service->updateUser(['otp'=>$token]);

        // 3. send sms to user
        $message = "سلام کد ورود شما  $token";
        $this->dispatch(new SmsJob($user->phone_number,$message));


        return ResponseJson::success('Token sent to your cell phone');


    }

    public function otpLogin(Request $request)
    {

        $validated = $this->validate($request, AuthRequest::otpLogin());

        // 1. get User
        $user = $this->user_service->getUserByPhoneNumber($validated['phone_number']);

        // 2. check if token valid
        if($validated['token'] == $user->otp){
            //2.1 flush db otp field
            $this->user_service->updateUser($user,['otp' => null]);
            // 3. if yes send jwt token
            return ResponseJson::success($this->respondWithToken(auth('api')->login($user)));
        } else {
            // 4. else send unrelated info
            return ResponseJson::failure( 'login not successful');
        }


    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return ResponseJson::success('user_info',auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return ResponseJson::success( 'Successfully logged out');
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return ResponseJson::success('refresh token',$this->respondWithToken(auth()->refresh()));
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }



}
