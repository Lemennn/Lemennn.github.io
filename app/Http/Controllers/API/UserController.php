<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Rules\Password;


class UserController extends Controller
{
    public function fetch(Request $request)
    {
        return response()->json([
            ['status' => 200, 'message' => 'Success get data', $request->user()],
            200,
        ]);
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'email|required',
                'password' => 'required'
            ]);

            $credential = request(['email', 'password']);

            if (!Auth::attempt($credential)) {
                return 'Authenticate Failed';
            }

            $user = User::where('email', $request->email)->first();

            if (!Hash::check($request->password, $user->password)) {
                throw new Exception('Invalid Credentials');
            }

            $token = $user->createToken('authtoken')->plainTextToken;

            return response()->json(
                [
                    'code' => 200,
                    'message' => 'Authenticate Success',
                    'type_token' => 'Bearer',
                    'access_token' => $token,
                    'data' => $user
                ],
            );
        } catch (Exception $err) {
            throw response()->json(
                ['status' => 500, 'message' => $err,],
            );
        }
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'email', 'max:255', 'string', 'unique:users'],
                'username' => ['required', 'unique:users', 'max:255', 'string'],
                'password' => ['required', 'string', new password],
                'phone' => ['required', 'string']
            ]);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
            ]);

            $user = User::where('email', $request->email)->first();

            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json(
                ['message' => 'User Registered', 'type_token' => 'Bearer', 'access_token' => $token, 'user' => $user,],
                200,
            );
        } catch (Exception $err) {
            throw $err;
        }
    }

    public function logout(Request $request)
    {
        $token = $request->user()->currentAccesstoken()->delete();

        return response()->json(
            [
                'message' => 'Token Revoked',
                'access_token' => $token,
                'code' => 200
            ],
            200,
        );
    }

    public function updateProfile(Request $request)
    {
        $data = $request->all();

        $user = Auth::user();
        $user->update($data);

        return response()->json(
            ['code' => 200, 'message' => 'Data Updated', 'data' => $user],
            200,
        );
    }
}
