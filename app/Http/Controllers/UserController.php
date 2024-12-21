<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $users = $request->input('users');

        // Log the incoming request for debugging
        Log::info('Received user data:', ['data' => $users]);

        if (is_array($users)) {
            foreach ($users as $user) {
                // Log each user's data
                Log::info('Processing user:', ['user' => $user]);

                if (isset($user['phone_number']) && isset($user['first_name']) && isset($user['last_name']) && isset($user['email'])) {
                    User::updateOrCreate(
                        ['phone_number' => $user['phone_number']],
                        [
                            'first_name' => $user['first_name'],
                            'last_name' => $user['last_name'],
                            'email' => $user['email'],
                            'image' => null // Ensure image is set to null
                        ]
                    );
                } else {
                    Log::error('Missing required fields for user:', ['user' => $user]);
                    return response()->json(['message' => 'Missing required user fields'], 400);
                }
            }
            return response()->json(['message' => 'User data saved successfully'], 201);
        }

        Log::error('Received data is not an array.');
        return response()->json(['message' => 'Missing required user fields'], 400);
    }
}
