<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Wrong Credentials'],
            ]);
        }

        $token = $user->createToken($request->email)->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token,
        ];

        return new JsonResponse(['data' => $response], Response::HTTP_OK);
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name'      => 'required|max:50',
            'email'     => 'required|email|max:50',
            'password'  => 'required|min:6'
        ]);
        $users = User::where('email', $validatedData['email'])->get();
        if (count($users) > 0)
            return new JsonResponse(['data' => $users], Response::HTTP_OK);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = password_hash($request->password, PASSWORD_BCRYPT);
        unset($user->_token);
        $user->save();

        return new JsonResponse(['data' => $user], Response::HTTP_OK);
    }
}
