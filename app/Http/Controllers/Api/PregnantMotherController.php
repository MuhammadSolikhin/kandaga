<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PregnantMother;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PregnantMotherController extends Controller
{
    // GET: List semua data
    public function index()
    {
        return response()->json(PregnantMother::all());
    }

    // POST: Simpan data baru
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bpjs_number' => 'nullable|string',
            'nik' => 'required|string|unique:pregnant_mothers',
            'phone_number' => 'nullable|string',
            'address' => 'nullable|string',
            'kelurahan' => 'nullable|string',
            'pre_pregnancy_weight' => 'nullable|numeric',
            'current_weight' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'age' => 'nullable|integer',
            'hemoglobin' => 'nullable|numeric',
            'lila' => 'nullable|numeric',
            'blood_pressure' => 'nullable|string',
            'gestational_age' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        // Hitung BMI jika tinggi dan berat tersedia
        $bmi = null;
        $noteParts = [];

        if (!empty($validated['current_weight']) && !empty($validated['height'])) {
            $height_m = $validated['height'] / 100;
            $bmi = round($validated['current_weight'] / ($height_m ** 2), 1);
            $validated['bmi'] = $bmi;

            // Interpretasi BMI
            if ($bmi < 18.5) {
                $bmiStatus = "Berat badan kurang, perhatikan asupan gizi.";
            } elseif ($bmi < 25) {
                $bmiStatus = "Berat badan normal.";
            } elseif ($bmi < 30) {
                $bmiStatus = "Berat badan berlebih, perhatikan asupan makanan.";
            } else {
                $bmiStatus = "Obesitas, segera konsultasikan dengan tenaga medis.";
            }

            $noteParts[] = "BMI Anda: $bmi - $bmiStatus";
        }

        // Interpretasi HB
        if (!empty($validated['hemoglobin'])) {
            $hb = $validated['hemoglobin'];
            if ($hb < 11) {
                $hbStatus = "Rendah (Anemia), perhatikan asupan zat besi.";
            } else {
                $hbStatus = "Normal.";
            }
            $noteParts[] = "HB: $hb g/dL - $hbStatus";
        }

        // Catatan usia
        if (!empty($validated['age'])) {
            $noteParts[] = "Usia: {$validated['age']} tahun - Pastikan asupan nutrisi sesuai kebutuhan.";
        }

        // Gabungkan catatan
        $validated['note'] = implode("\n", $noteParts);

        $ibuHamil = PregnantMother::create($validated);
        return response()->json($ibuHamil, 201);
    }
}
