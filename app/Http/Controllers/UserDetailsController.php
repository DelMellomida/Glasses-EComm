<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\UserDetails;

class UserDetailsController extends Controller
{
    /**
     * Display the user's details.
     */
    public function index()
    {
        $user = Auth::user();

        return view('user.user_details', [
            'user' => $user,
            'user_details' => UserDetails::where('user_id', $user->id)->first()
        ]);
    }

    /**
     * Show the form to create user details.
     */
    public function create()
    {
        $user = Auth::user();

        return view('user.user_details_create', [
            'user_id' => $user->id,
        ]);
    }

    /**
     * Store the user details.
     */
    public function store(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female',
        ]);

        try {
            UserDetails::create([
                'address' => $request->address,
                'phone_number' => $request->phone_number,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'user_id' => Auth::id(),
            ]);

            return redirect()->route('user-details.index')->with('success', 'User details created successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating user detail:', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors('Failed to create user details.');
        }
    }

    /**
     * Show the form for editing user details.
     */
    public function edit()
    {
        $user = Auth::user();
        $user_details = UserDetails::where('user_id', $user->id)->first();

        if (!$user_details) {
            return redirect()->route('user-details.index')->withErrors('User details not found.');
        }

        return view('user.user_details_edit', [
            'user_details' => $user_details,
        ]);
    }

    /**
     * Update the user details.
     */
    public function update(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female'
        ]);

        $user = Auth::user();
        $user_details = UserDetails::where('user_id', $user->id)->first();

        if (!$user_details) {
            return redirect()->route('user-details.index')->withErrors('User details not found.');
        }

        try {
            $user_details->update($request->only([
                'address',
                'phone_number',
                'date_of_birth',
                'gender',
            ]));

            return redirect()->route('user-details.index')->with('success', 'User details updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating user detail:', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors('Failed to update user details.');
        }
    }

    /**
     * Delete the user details.
     */
    public function destroy()
    {
        $user = Auth::user();
        $user_details = UserDetails::where('user_id', $user->id)->first();

        if (!$user_details) {
            return redirect()->route('user-details.index')->withErrors('User details not found.');
        }

        try {
            $user_details->delete();
            return redirect()->route('user-details.index')->with('success', 'User details deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting user detail:', ['error' => $e->getMessage()]);
            return redirect()->route('user-details.index')->withErrors('Failed to delete user details.');
        }
    }
}
