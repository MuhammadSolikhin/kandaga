<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ChildHealthRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChildHealthRecordController extends Controller
{
    private function getZScoreBBUByGender($gender, $ageMonth)
    {
        $zScoreBoys = [
            0 => [2.1, 2.5, 2.9, 3.3, 3.9, 4.4, 5.0],
            1 => [2.9, 3.4, 3.9, 4.5, 5.1, 5.8, 6.6],
            2 => [3.8, 4.4, 4.9, 5.6, 6.3, 7.0, 8.0],
            3 => [4.4, 5.0, 5.7, 6.4, 7.2, 8.1, 9.0],
            4 => [4.9, 5.6, 6.2, 7.0, 7.8, 8.7, 9.7],
            5 => [5.3, 6.0, 6.7, 7.5, 8.4, 9.3, 10.4],
            6 => [5.7, 6.4, 7.1, 7.9, 8.9, 9.8, 10.9],
            7 => [5.9, 6.7, 7.4, 8.3, 9.3, 10.3, 11.3],
            8 => [6.2, 6.9, 7.7, 8.6, 9.6, 10.7, 11.8],
            9 => [6.4, 7.1, 8.0, 8.9, 10.0, 11.1, 12.3],
            10 => [6.6, 7.4, 8.2, 9.2, 10.2, 11.4, 12.7],
            11 => [6.8, 7.6, 8.4, 9.4, 10.5, 11.7, 13.0],
            12 => [6.9, 7.7, 8.6, 9.6, 10.8, 12.0, 13.3],
            13 => [7.1, 7.9, 8.8, 9.9, 11.0, 12.3, 13.7],
            14 => [7.2, 8.1, 9.0, 10.1, 11.3, 12.6, 14.0],
            15 => [7.4, 8.3, 9.2, 10.3, 11.5, 12.9, 14.3],
            16 => [7.5, 8.4, 9.4, 10.5, 11.7, 13.1, 14.6],
            17 => [7.7, 8.6, 9.6, 10.7, 12.0, 13.4, 14.9],
            18 => [7.8, 8.8, 9.8, 10.9, 12.2, 13.7, 15.3],
            19 => [8.0, 9.0, 10.0, 11.1, 12.5, 13.9, 15.6],
            20 => [8.1, 9.1, 10.1, 11.3, 12.7, 14.2, 15.9],
            21 => [8.2, 9.2, 10.3, 11.5, 12.9, 14.5, 16.2],
            22 => [8.4, 9.4, 10.5, 11.8, 13.2, 14.8, 16.5],
            23 => [8.5, 9.5, 10.7, 12.0, 13.4, 15.0, 16.8],
            24 => [8.6, 9.6, 10.8, 12.2, 13.6, 15.3, 17.1],
            25 => [8.8, 9.8, 11.0, 12.4, 13.9, 15.5, 17.5],
            26 => [8.9, 10.0, 11.2, 12.5, 14.1, 15.8, 17.8],
            27 => [9.0, 10.1, 11.3, 12.7, 14.3, 16.1, 18.1],
            28 => [9.1, 10.2, 11.5, 12.9, 14.5, 16.3, 18.4],
        ];


        $zScoreGirls = [
            0 => [2.0, 2.4, 2.8, 3.2, 3.7, 4.2, 4.8],
            1 => [2.8, 3.2, 3.7, 4.2, 4.8, 5.4, 6.1],
            2 => [3.6, 4.2, 4.7, 5.3, 6.0, 6.7, 7.5],
            3 => [4.2, 4.8, 5.4, 6.1, 6.8, 7.6, 8.5],
            4 => [4.7, 5.4, 6.0, 6.7, 7.5, 8.3, 9.3],
            5 => [5.1, 5.8, 6.4, 7.2, 8.0, 8.9, 9.9],
            6 => [5.4, 6.2, 6.8, 7.6, 8.4, 9.4, 10.5],
            7 => [5.7, 6.5, 7.1, 7.9, 8.8, 9.8, 10.9],
            8 => [5.9, 6.7, 7.4, 8.2, 9.1, 10.2, 11.3],
            9 => [6.1, 6.9, 7.6, 8.5, 9.4, 10.5, 11.6],
            10 => [6.3, 7.1, 7.8, 8.7, 9.6, 10.7, 11.9],
            11 => [6.5, 7.3, 8.0, 8.9, 9.9, 11.0, 12.2],
            12 => [6.6, 7.4, 8.2, 9.1, 10.1, 11.3, 12.5],
            13 => [6.8, 7.6, 8.4, 9.3, 10.3, 11.5, 12.7],
            14 => [6.9, 7.7, 8.5, 9.5, 10.5, 11.7, 13.0],
            15 => [7.1, 7.9, 8.7, 9.6, 10.7, 11.9, 13.2],
            16 => [7.2, 8.0, 8.8, 9.8, 10.9, 12.1, 13.4],
            17 => [7.3, 8.1, 9.0, 9.9, 11.0, 12.3, 13.6],
            18 => [7.4, 8.2, 9.1, 10.1, 11.2, 12.5, 13.8],
            19 => [7.6, 8.4, 9.3, 10.2, 11.4, 12.7, 14.0],
            20 => [7.7, 8.5, 9.4, 10.4, 11.5, 12.9, 14.2],
            21 => [7.8, 8.6, 9.6, 10.5, 11.7, 13.1, 14.4],
            22 => [7.9, 8.7, 9.7, 10.6, 11.9, 13.3, 14.6],
            23 => [8.0, 8.8, 9.8, 10.8, 12.0, 13.4, 14.8],
            24 => [8.1, 8.9, 10.0, 10.9, 12.2, 13.6, 15.0],
            25 => [8.2, 9.0, 10.1, 11.0, 12.3, 13.8, 15.2],
            26 => [8.3, 9.1, 10.2, 11.2, 12.5, 13.9, 15.4],
            27 => [8.4, 9.2, 10.4, 11.3, 12.6, 14.1, 15.6],
            28 => [8.5, 9.3, 10.5, 11.4, 12.8, 14.3, 15.8],
        ];

        $table = $gender === 'Laki-laki' ? $zScoreBoys : $zScoreGirls;
        return $table[$ageMonth] ?? null;
    }


    private function evaluateNutritionStatus($gender, $age, $weight)
    {
        $z = $this->getZScoreBBUByGender($gender, $age);
        
        if (!$z) {
            return 'Data referensi tidak tersedia untuk usia ini.';
        }

        [$minus3, $minus2, $minus1, $median, $plus1, $plus2, $plus3] = $z;

        if ($weight < $minus3) {
            return "Gizi buruk (sangat kurus)";
        } elseif ($weight < $minus2) {
            return "Gizi kurang (kurus)";
        } elseif ($weight <= $plus1) {
            return "Gizi baik (normal)";
        } elseif ($weight <= $plus2) {
            return "Risiko gizi lebih";
        } elseif ($weight <= $plus3) {
            return "Gizi lebih";
        } else {
            return "Obesitas";
        }
    }


    // GET: Ambil semua data
    public function index()
    {
        return response()->json(ChildHealthRecord::all());
    }

    // POST: Simpan data baru
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bpjs_number' => 'required|string',
            'nik' => 'required|string|unique:child_health_records',
            'phone_number' => 'required|string',
            'address' => 'required|string',
            'kelurahan' => 'required|string',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'weight' => 'required|numeric',
            'height' => 'required|numeric',
            'age_months' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();

        // Format note hasil berdasarkan input
        $gender = $validated['gender'];
        $bb = $validated['weight'];
        $tb = $validated['height'];
        $usia = $validated['age_months'];

        $statusGizi = $this->evaluateNutritionStatus(
            $validated['gender'],
            $validated['age_months'],
            $validated['weight']
        );

        $note = "Hasil untuk balita $gender: Berat Badan = {$bb} kg, Tinggi Badan = {$tb} cm, Usia = {$usia} bln.";
        $note .= " Perhatikan rentang pertumbuhan $gender.";
        $note .= "\nStatus Gizi: $statusGizi.";
        $note .= "\nCatatan: Data ini bersifat informatif, konsultasikan dengan dokter untuk evaluasi lebih lanjut.";

        $validated['note'] = $note;

        $record = ChildHealthRecord::create($validated);

        return response()->json($record, 201);
    }


}
