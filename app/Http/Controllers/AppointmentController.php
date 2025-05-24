<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Appointment;
use App\Models\Branch;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::where('user_id', Auth::id())->get();
        $branches = Branch::all();
        return view('appointments.index', compact('appointments', 'branches'));
    }

    public function appointments(Request $request)
    {
        $query = Appointment::query();
        $user = Auth::user();

        if (!$user || ($user->type !== 'admin')) {
            $query->where('user_id', Auth::id());
        }
        $appointments = $query->get();

        $events = $appointments->map(function ($appointment) {
            return [
                'id' => $appointment->id,
                'title' => $appointment->type,
                'start' => $appointment->appointment_date . 'T' . $appointment->appointment_time,
                'branch_id' => $appointment->branch_id,
                'branch_name' => $appointment->branch->branch_name ?? '',
                'type' => $appointment->type,
                // add other fields as needed
            ];
        });

        return response()->json($events);
    }

    public function availableTimes(Request $request)
    {
        $date = $request->query('date');
        $branchId = $request->query('branch_id');
        $exclude = $request->query('exclude'); // for edit

        $startHour = 8;
        $endHour = 18;

        // Get all appointments for this branch and date (excluding the one being edited)
        $query = Appointment::where('branch_id', $branchId)
            ->where('appointment_date', $date);

        if ($exclude) {
            $query->where('id', '!=', $exclude);
        }

        $appointments = $query->get();

        $slots = [];
        for ($h = $startHour; $h < $endHour; $h++) {
            $slotStart = sprintf('%02d:00', $h);
            $slotEnd = date('H:i', strtotime($slotStart) + 3600);

            // Check if this slot overlaps with any existing appointment
            $conflict = $appointments->contains(function ($appt) use ($slotStart, $slotEnd) {
                $apptStart = $appt->appointment_time;
                $apptEnd = date('H:i', strtotime($apptStart) + 3600);
                // Overlap if slotStart < apptEnd and slotEnd > apptStart
                return ($slotStart < $apptEnd) && ($slotEnd > $apptStart);
            });

            if (!$conflict) {
                $slots[] = $slotStart;
            }
        }

        return response()->json($slots);
    }

    public function create()
    {
        $branches = Branch::all();
        return view('appointments.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'type' => 'required|string',
            'branch_id' => 'required|exists:branch,id',
        ]);

        // Calculate the start and end time for the 1-hour slot
        $startTime = $request->appointment_time;
        $endTime = date('H:i', strtotime($startTime) + 3600);

        // Check for conflicts in the same branch and date
        $conflict = Appointment::where('branch_id', $request->branch_id)
            ->where('appointment_date', $request->appointment_date)
            ->where(function($query) use ($startTime, $endTime) {
                $query->whereBetween('appointment_time', [$startTime, $endTime])
                    ->orWhereRaw('? BETWEEN appointment_time AND ADDTIME(appointment_time, "01:00:00")', [$startTime]);
            })
            ->exists();

        if ($conflict) {
            return back()->withErrors(['appointment_time' => 'This time slot is already booked for this branch. Please choose another time.'])->withInput();
        }

        Appointment::create([
            'user_id' => Auth::id(),
            'appointment_date' => $request->appointment_date,
            'appointment_time' => $request->appointment_time,
            'type' => $request->type,
            'branch_id' => $request->branch_id,
        ]);

        return redirect()->route('appointments.index')->with('success', 'Appointment booked!');
    }

    // Show the edit form
    public function edit($id)
    {
        $appointment = Appointment::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('appointments.edit', compact('appointment'));
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'appointment_date' => 'required|date',
                'appointment_time' => 'required',
                'type' => 'required|string',
                'branch_id' => 'required|exists:branch,id',
            ]);

            $startTime = $request->appointment_time;
            $endTime = date('H:i', strtotime($startTime) + 3600);

            $conflict = Appointment::where('branch_id', $request->branch_id)
                ->where('appointment_date', $request->appointment_date)
                ->where('id', '!=', $id)
                ->where(function($query) use ($startTime, $endTime) {
                    $query->whereBetween('appointment_time', [$startTime, $endTime])
                        ->orWhereRaw('? BETWEEN appointment_time AND ADDTIME(appointment_time, "01:00:00")', [$startTime]);
                })
                ->exists();

            if ($conflict) {
                if ($request->wantsJson()) {
                    return response()->json(['success' => false, 'message' => 'This time slot is already booked for this branch.'], 409);
                }
                return back()->withErrors(['appointment_time' => 'This time slot is already booked for this branch. Please choose another time.'])->withInput();
            }

            $appointment = Appointment::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
            $appointment->update([
                'appointment_date' => $request->appointment_date,
                'appointment_time' => $request->appointment_time,
                'type' => $request->type,
                'branch_id' => $request->branch_id,
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => true]);
            }
            return redirect()->route('appointments.index')->with('success', 'Appointment updated!');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'An error occurred while updating the appointment.'], 500);
            }
            Log::info("Taenang error: ". $e);
            return back()->withErrors(['error' => 'An error occurred while updating the appointment.'])->withInput();
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $appointment = Appointment::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
            $appointment->delete();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => true, 'message' => 'Appointment deleted!']);
            }

            return redirect()->route('appointments.index')->with('success', 'Appointment deleted!');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['error' => true]);
            }
        }
        return redirect()->route('appointments.index')->with('success', 'Appointment deleted!');
    }
}