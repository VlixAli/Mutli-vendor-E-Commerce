<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AccessToken\StoreRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Laravel\Sanctum\PersonalAccessToken;

class AccessTokensController extends Controller
{
    public function store(StoreRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!($user && Hash::check($request->password, $user->password))) {

            return Response::json([
                'code' => 0,
                'message' => 'Invalid credentials',
            ], 401);
        }
        $device_name = $request->post('device_name', $request->userAgent());
        $token = $user->createToken($device_name, $request->post('abilities'));

        return Response::json([
            'code' => 1,
            'token' => $token->plainTextToken,
            'user' => $user,
        ], 201);
    }

    public function destroy($token = null)
    {
        $user = Auth::guard('sanctum')->user();

        if(null === $token){
            $user->currentAccessToken()->delete();
            return;
        }

        $personalAccessToken = PersonalAccessToken::findToken($token);
        if ($user->id == $personalAccessToken->tokenable_id &&
            get_class($user) == $personalAccessToken->tokenable_type) {
            $personalAccessToken->delete();
        }
    }

    public function destroyAll()
    {
        $user = Auth::user();
        $user->tokens()->delete();
    }
}
