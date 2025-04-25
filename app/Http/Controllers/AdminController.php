<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\Models\User;


class AdminController extends Controller
{
    public function index()
    {
        return view('admin.home', [
            'users' => User::all(),
        ]);
    }

    public function listUsers()
    {
        $userModel = new User();
        $users = $userModel->getUsers();

        dd($users->toArray()); 

        // return view('admin.users', [
        //     'users' => $users->toArray(),
        // ]);
    }

    public function listAdmins()
    {
        $userModel = new User();
        $users = $userModel->getAdmins();

        dd($users->toArray());

        // return view('admin.admins', [
        //     'users' => $users->toArray(),
        // ]);
    }

    public function changeUserRole(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|in:user,admin'
        ]);

        $user = User::findOrFail($id);
        if ($user) {
            $user->type = $request->input('type');
            $user->save();
            Log::info('User role updated', [
                'id' => $user->id,
                'type' => $request->input('type'),
            ]);

            return response()->json(['message' => 'User role updated successfully'], 200);
        }
        return response()->json(['message' => 'User not found'], 404);
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        if ($user) {
            $user->delete();
            return response()->json(['message' => 'User deleted successfully'], 200);
        }
        return response()->json(['message' => 'User not found'], 404);
    }
}
