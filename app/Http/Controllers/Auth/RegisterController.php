<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class RegisterController extends Controller
{
    public function __invoke(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role_id' => ['required', Rule::in(Role::ROLE_OWNER, Role::ROLE_USER)],
        ]);
        
       if ($validator->fails()) {
            $response = [
                'code' => 200,
                'status' => false,
                'message' => $validator->errors()->first(),
            ];
            return response()->json($response, 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
        ]);

        return response()->json([
            'access_token' => $user->createToken('client')->plainTextToken,
        ]);

        
        // some laravel error work on this later   

        // $request->validate([
        //     'name' => ['required', 'string', 'max:255'],
        //     'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        //     'password' => ['required', 'confirmed', Password::defaults()],
        //     'role_id' => ['required', Rule::in(Role::ROLE_OWNER, Role::ROLE_USER)],
        // ]);

    }


}
