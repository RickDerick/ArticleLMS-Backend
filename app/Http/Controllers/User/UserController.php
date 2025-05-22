<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        try {
            $users = User::select('id','name','email', 'role')->get();
            return response()->json([
                'data'=>$users,
                'message'=> 'Users Retrieved Successfully',
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message'=> 'Error fetching users'.$e->getMessage()], 500);
        }
    }

    public function show($id){
        try {
            $user = User::select('id', 'name', 'email', 'role')->findOrFail($id);
            return response()->json([
                'data'=> $user,
                'meessage'=> 'User retrieved successful'
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'message'=> 'User Not Found',
            ], 404);
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $validated = $request->validate([
                'name' => 'sometimes|string|max:255',
                'email' => 'sometimes|string|email|max:255|unique:users,email,' . $id,
                'role' => 'sometimes|string|in:user,admin',
                'password' => 'sometimes|string|min:8|confirmed',
            ]);

            $user->update(array_filter([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
            ]));

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
                $user->save();
            }

            return response()->json([
                'data' => $user->only('id', 'name', 'email', 'role'),
                'message' => 'User updated successfully',
            ], 200);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error updating user: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id){
        try {
            if(auth()->id()===$id){
                return response()->json([
                    'message'=> 'Cannot delete yourself',
                ], 403);

            }
            $user =User::findOrFail($id);
            $user->delete();
            return response()->json([
                'message' => 'User deleted successfully',
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error deleting user: ' . $e->getMessage(),
            ], 500);
        }
    }
}
