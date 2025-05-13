<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\Models\User;
use App\Models\UserDetails;

class UserDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('user.details', [
            'user' => Auth::user(),
            'user_details' => UserDetails::where('user_id', Auth::user()->id)->first()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        $request->validate([
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female'
        ]);

        $user_details = UserDetails::where('user_id', $id)->first();

        if (!$user_details) {
            return response()->json(['error' => 'User details not found'], 404);
        }

        try {
            $user_details->update($request->only([
                'address',
                'phone_number',
                'date_of_birth',
                'gender',
            ]));
        } catch (\Exception $e) {
            Log::error('Error updating user detail:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to update user detail'], 500);
        }

        Log::info('User Detail updated successfully', ['user_id' => $id]);
        return response()->json(['message' => 'User Detail updated successfully'], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user_details = UserDetails::where('user_id', $id)->first();

        if (!$user_details) {
            return response()->json(['error' => 'User details not found'], 404);
        }

        try {
            $user_details->delete();
        } catch (\Exception $e) {
            Log::error('Error deleting user detail:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to delete user detail'], 500);
        }

        Log::info('User Detail deleted successfully', ['user_id' => $id]);
        return response()->json(['message' => 'User Detail deleted successfully'], 200);
    }
}
