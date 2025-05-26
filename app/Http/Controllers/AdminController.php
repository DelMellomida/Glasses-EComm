<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

use App\Models\User;
use App\Helpers\EventLogger;


class AdminController extends Controller
{
    public function index()
    {
        return view('admin.home', [
            'users' => User::all(),
        ]);
    }

    public function userIndex()
    {
        return view('admin.users.list');
    }

    public function adminIndex()
    {
        return view('admin.users.list-admin');
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email',
                'password' => 'required|string|min:8|confirmed',
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
                'type' => 'user',
            ]);

            EventLogger::log('User Creation', 'User created successfully', [
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]);

            return redirect()->route('user.index')->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            EventLogger::log('User Creation Failed', 'Failed to create user', [
                'error_message' => $e->getMessage(),
                'input_data' => $request->except('password', 'password_confirmation'), // avoid logging sensitive data
            ]);

            return redirect()->back()->withInput()->withErrors(['error' => 'Failed to create user. Please try again.']);
        }
    }

    public function listUsers()
    {
        return DataTables::of(
        User::where('type', 'user')
        )
        ->addColumn('action', function ($user) {
            return '
                <div class="flex space-x-2 justify-center">
                    <form action="' . route('admin.user.destroy', $user->id) . '" method="POST" style="display:inline;">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button type="submit" title="Delete"
                            class="p-2 bg-transparent hover:bg-red-100 rounded transition group"
                            onclick="event.stopPropagation(); return confirm(\'Are you sure you want to delete this user?\')">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600 group-hover:text-red-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </form>
                    <form action="' . route('admin.change-user-role', $user->id) . '" method="POST" style="display:inline;">
                        ' . csrf_field() . '
                        <input type="hidden" name="type" value="admin">
                        <button type="submit" title="Promote to Admin"
                            class="p-2 bg-transparent hover:bg-green-100 rounded transition group"
                            onclick="event.stopPropagation();">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600 group-hover:text-green-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.485 0 4.797.657 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </button>
                    </form>
                </div>
            ';
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function listAdmins()
    {
        return DataTables::of(
        User::where('type', 'admin')
        )
        ->addColumn('action', function ($user) {
            return '
                <div class="flex space-x-2 justify-center">
                    <form action="' . route('admin.user.destroy', $user->id) . '" method="POST" style="display:inline;">
                        ' . csrf_field() . method_field('DELETE') . '
                        <button type="submit" title="Delete"
                            class="p-2 bg-transparent hover:bg-red-100 rounded transition group"
                            onclick="event.stopPropagation(); return confirm(\'Are you sure you want to delete this user?\')">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600 group-hover:text-red-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </form>
                </div>
            ';
        })
        ->rawColumns(['action'])
        ->make(true);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $user_details = $user->userDetail;

        if ($user) {
            return view('admin.users.edit', [
                'user' => $user,
                'user_details' => $user_details,
            ]);
        }
        return response()->json(['message' => 'User not found'], 404);
    }

    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users,email,' . $user->id,
                'address' => 'nullable|string|max:255',
                'phone_number' => 'nullable|string|max:20',
                'date_of_birth' => 'nullable|date',
                'gender' => 'nullable|in:male,female',
            ]);

            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            $user->userDetail()->updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'address' => $validated['address'] ?? null,
                        'phone_number' => $validated['phone_number'] ?? null,
                        'date_of_birth' => $validated['date_of_birth'] ?? null,
                        'gender' => $validated['gender'] ?? 'male', // Default to 'male' if not set
                    ]
            );

            EventLogger::log('User Update', 'User updated successfully', [
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]);

            return redirect(
                request('back') ??
                ($user->type === 'admin'
                    ? route('admin.adminIndex')
                    : route('user.index'))
            )->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            Log::info('Error updating user', [
                'id' => $id,
                'error' => $e->getMessage(),
            ]);

            EventLogger::log('User Update Failed', 'Failed to update user', [
                'user_id' => $id,
                'error_message' => $e->getMessage(),
                'input_data' => $request->except('password', 'password_confirmation'), // avoid logging sensitive data
            ]);

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'An error occurred while updating the user.');
        }
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

            EventLogger::log('User Role Change', 'User role updated successfully', [
                'user_id' => $user->id,
                'new_role' => $user->type,
            ]);

            return $this->userIndex();
            // return response()->json(['message' => 'User role updated successfully'], 200);
        }

        return response()->json(['message' => 'User not found'], 404);
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if ($user) {
            EventLogger::log('User Deletion', 'User deleted successfully', [
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]);

            $user->delete();

            return redirect()->route('user.index')->with('success', 'User deleted successfully.');
        }
        return redirect()->route('user.index')->with('error', 'User not found.');
    }
}
