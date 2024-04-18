<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use App\Http\Requests\Auth\SignInRequest;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\JsonResponseHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\SignUpRequest;

class AuthenticationController extends Controller
{
    /**
     * Sign up a new user and sign in the user and return a token.
     */
    public function signUp(SignUpRequest $request)
    {
        try {
            $userExists = User::userExistsByEmail($request->email);
            if ($userExists) {
                return JsonResponseHelper::notFound('User with that email already exists');
            }
            $user = User::createUser($request->all());
            if ($user) {
                $data = [
                    'token' => $user->createToken($user->id)->accessToken,
                    'user' => ['name' => $user->name,'email' => $user->email]
                ];
                return JsonResponseHelper::success('User created successfully', $data);
            }
            return JsonResponseHelper::error('User not found');
        } catch (\Throwable $th) {
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
            $data = [
                'token' => $user->createToken($user->id)->accessToken,
                'user' => ['name' => $user->name,'email' => $user->email]
            ];
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

    /**
     * Display the specified resource.
     */
    public function show()
    {
        # code...
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
