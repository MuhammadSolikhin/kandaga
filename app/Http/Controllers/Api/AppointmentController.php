<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Appointment;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::orderBy('consultation_date', 'asc')->get();

        return response()->json([
            'message' => 'Daftar konsultasi berhasil diambil.',
            'data' => $appointments,
        ]);
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'address' => 'required|string',
            'consultation_date' => 'required|date|after_or_equal:today',
            'message' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();

        $appointment = Appointment::create($validated);

        return response()->json([
            'message' => 'Konsultasi berhasil dijadwalkan.',
            'data' => $appointment,
        ], 201);
    }
}
