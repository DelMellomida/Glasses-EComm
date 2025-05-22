<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::where('user_id', Auth::id())->get();
        return view('appointments.index', compact('appointments'));
    }

    // public function show($id)
    // {
    //     return Appointment::findOrFail($id);
    // }

    // API endpoint for calendar (returns JSON)
    public function appointments(Request $request)
    {
        $query = Appointment::query();
        $user = Auth::user();
        // If not admin, only show this user's appointments
        if (!$user || ($user->type !== 'admin')) {
            $query->where('user_id', Auth::id());
        }
        $appointments = $query->get();

        $events = $appointments->map(function ($appointment) {
            return [
                'id' => $appointment->id,
                'title' => $appointment->type,
                'start' => $appointment->appointment_date . 'T' . $appointment->appointment_time,
            ];
        });

        return response()->json($events);
    }

    public function create()
    {
        return view('appointments.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'type' => 'required|string',
        ]);

        Appointment::create([
            'user_id' => Auth::id(),
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'type' => $request->type,
        ]);

        return redirect()->route('appointments.index')->with('success', 'Appointment booked!');
    }

    // Show the edit form
    public function edit($id)
    {
        $appointment = Appointment::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('appointments.edit', compact('appointment'));
    }

    // Handle the update
    public function update(Request $request, $id)
    {
        $request->validate([
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'type' => 'required|string',
        ]);

        $appointment = Appointment::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $appointment->update([
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'type' => $request->type,
        ]);

        return redirect()->route('appointments.index')->with('success', 'Appointment updated!');
    }

    // (Optional) Delete an appointment
    public function destroy($id)
    {
        try {
            $appointment = Appointment::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
            $appointment->delete();

            // For AJAX requests, you might want to return JSON:
            // if (request()->wantsJson()) {
            //     return response()->json(['success' => true, 'message' => 'Appointment deleted!']);
            // }

            return redirect()->route('appointments.index')->with('success', 'Appointment deleted!');
        } catch (\Exception $e) {
            if (request()->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Failed to delete appointment.'], 500);
            }

            return redirect()->route('appointments.index')->with('error', 'Failed to delete appointment.');
        }
    }
}