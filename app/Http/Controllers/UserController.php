<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\Store;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function profile()
    {
        return response()->json(auth()->user());
    }

    public function updateProfile(UpdateProfileRequest $request): JsonResponse
    {
        $user = User::find(auth()->id())->with('storeInfo')->first();
        if ($request->has('store_info') && $user->role !== 'user') {
            $info = $request->validated()['store_info'];
            $info['user_id'] = $user->id;
            Store::create($info);
        }
        $data = $request->validated();
        // remove store_info from data
        unset($data['store_info']);
        $user->update([
            'name' => isset($data['name']) ? $data['name'] : $user->name,
            'email' => isset($data['email']) ? $data['email'] : $user->email,
            'phone' => isset($data['phone']) ? $data['phone'] : $user->phone,
            'address' => isset($data['address']) ? $data['address'] : $user->address,
            'role' => isset($data['role']) ? $data['role'] : $user->role,
            'city' => isset($data['city']) ? $data['city'] : $user->city,
            // 'postal_code' => $data['postal_code'] ? $data['postal_code'] : $user->postal_code,
        ]);
        $user->refresh();
        return response()->json($user);
    }

    public function updateAccountStatus(Request $request): JsonResponse
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:pending,active,suspended'
        ]);

        $user = User::find($request->user_id);
        $user->update(['status' => $request->status]);
        return response()->json($user);
    }
}
