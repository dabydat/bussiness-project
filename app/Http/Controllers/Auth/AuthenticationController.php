<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Notifications\ChangeRoleNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\JsonResponseHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SignInRequest;
use App\Http\Requests\Auth\SignUpRequest;

class AuthenticationController extends Controller
{
    /**
     * Sign up a new user and sign in the user and return a token.
     */
    public function signUp(SignUpRequest $request)
    {
        DB::beginTransaction();
        try {
            $userExists = User::userExistsByEmail($request->email);
            if ($userExists) {
                return JsonResponseHelper::notFound('User with that email already exists');
            }

            $user = User::createUser($request->all());
            if ($user) {
                $token = $user->createToken($user->id)->accessToken;
                $data = [
                    'token' => $token,
                    'user' => ['name' => $user->name, 'email' => $user->email],
                ];
                User::where('id', $user->id)->update(['api_token' => $token]);
                DB::commit();
                $user->api_token = $token;
                $administrator = User::where('role_id', 1)->first();
                $administrator->notify(new ChangeRoleNotification($user));
                return JsonResponseHelper::success('User created successfully', $data);
            }
            return JsonResponseHelper::error('User not found');
        } catch (\Throwable $th) {
            DB::rollBack();
            return JsonResponseHelper::error('Something went wrong', $th->getMessage());
        }
    }

    /**
     * Sign in a user.
     */
    public function signIn(SignInRequest $request)
    {
        try {
            $userExists = User::userExistsByEmail($request->email);
            if (!$userExists) {
                return JsonResponseHelper::notFound('User not found');
            }

            $user = User::where('email', $request->email)->first();
            if (!Hash::check($request->password, $user->password)) {
                return JsonResponseHelper::error('Wrong password');
            }
            $token = $user->createToken($user->id)->accessToken;
            $data = [
                'token' => $token,
                'user' => ['name' => $user->name, 'email' => $user->email],
            ];
            User::where('id', $user->id)->update(['api_token' => $token]);

            return JsonResponseHelper::success('User logged in successfully', $data);
        } catch (\Throwable $th) {
            return JsonResponseHelper::error('Something went wrong', $th->getMessage());
        }
    }

    /**
     * Sign out a user.
     */
    public function signOut(Request $request)
    {
        $user = Auth::guard('api')->user();
        $user->token()->revoke();
        return JsonResponseHelper::success('User logged out successfully');
    }
}
