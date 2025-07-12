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
            'bpjs_number' => 'required|string',
            'nik' => 'required|string|unique:pregnant_mothers',
            'phone_number' => 'required|string',
            'address' => 'required|string',
            'kelurahan' => 'required|string',
            'pre_pregnancy_weight' => 'required|numeric',
            'current_weight' => 'required|numeric',
            'height' => 'required|numeric',
            'age' => 'required|integer',
            'hemoglobin' => 'required|numeric',
            'lila' => 'required|numeric',
            'blood_pressure' => 'required|string',
            'gestational_age' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        $validated = $validator->validated();

        // Hitung BMI dari berat badan saat ini (current_weight)
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

        // Hitung IMT jika usia kandungan ≤ 12 minggu
        if (
            !empty($validated['pre_pregnancy_weight']) &&
            !empty($validated['height']) &&
            (!isset($validated['gestational_age']) || $validated['gestational_age'] <= 12)
        ) {
            $height_m = $validated['height'] / 100;
            $imt = round($validated['pre_pregnancy_weight'] / ($height_m ** 2), 2);

            // Kategori & Rekomendasi kenaikan berat badan
            if ($imt < 18.5) {
                $imtStatus = "Underweight. Rekomendasi kenaikan berat badan 13-18 kg.";
            } elseif ($imt < 25) {
                $imtStatus = "Normal. Rekomendasi kenaikan berat badan 11-16 kg.";
            } elseif ($imt < 30) {
                $imtStatus = "Overweight. Rekomendasi kenaikan berat badan 7-11 kg.";
            } else {
                $imtStatus = "Obesitas. Rekomendasi kenaikan berat badan 5-9 kg.";
            }

            $noteParts[] = "IMT Anda: $imt - $imtStatus";
        }

        // Interpretasi HB
        if (!empty($validated['hemoglobin'])) {
            $hb = $validated['hemoglobin'];
            $hbStatus = $hb < 11
                ? "Rendah (Anemia), perhatikan asupan zat besi."
                : "Normal.";
            $noteParts[] = "HB: $hb g/dL - $hbStatus";
        }

        // Catatan usia
        if (!empty($validated['age'])) {
            $noteParts[] = "Usia: {$validated['age']} tahun - Pastikan asupan nutrisi sesuai kebutuhan.";
        }

        // Gabungkan semua catatan
        $validated['note'] = implode("\n", $noteParts);

        $ibuHamil = PregnantMother::create($validated);
        return response()->json($ibuHamil, 201);
    }
}
