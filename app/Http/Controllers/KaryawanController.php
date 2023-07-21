<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Services\ApiResponseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KaryawanController extends Controller
{
    public function getAllKaryawan()
    {
        try {
            $karyawan = Karyawan::all();
            return ApiResponseService::success($karyawan, "Sukses mengambil data karyawan");
        } catch (Exception $e) {
            return ApiResponseService::error($e->getMessage(), 500);
        }
    }

    public function createKaryawan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:50',
            'alamat' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'tanggal_bergabung' => 'required|date'
        ]);

        if ($validator->fails()) {
            return ApiResponseService::error($validator->errors(), 400);
        }

        try {
            $newNomorInduk = Karyawan::generateNomorInduk();

            $newKaryawan = Karyawan::create([
                'nomor_induk' => $newNomorInduk,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'tanggal_lahir' => $request->tanggal_lahir,
                'tanggal_bergabung' => $request->tanggal_bergabung,
            ]);

            return ApiResponseService::success($newKaryawan, "Sukses menambah karyawan", 201);
        } catch (Exception $e) {
            return ApiResponseService::error($e->getMessage(), 500);
        }
    }

    public function updateKaryawan(Request $request, $nomorInduk)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:50',
            'alamat' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'tanggal_bergabung' => 'required|date'
        ]);

        if ($validator->fails()) {
            return ApiResponseService::error($validator->errors(), 400);
        }

        $karyawan = Karyawan::where('nomor_induk', $nomorInduk)->first();

        if (!$karyawan) {
            return ApiResponseService::error("Karyawan dengan nomor induk $nomorInduk tidak ditemukan", 404);
        }

        try {
            $karyawan->nama = $request->nama;
            $karyawan->tanggal_lahir = $request->tanggal_lahir;
            $karyawan->tanggal_bergabung = $request->tanggal_bergabung;

            return ApiResponseService::success($karyawan, "Sukses mengupdate karyawan", 201);
        } catch (Exception $e) {
            return ApiResponseService::error($e->getMessage(), 500);
        }
    }

    public function deleteKaryawan($nomorInduk)
    {
        try {
            $karyawan = Karyawan::where('nomor_induk', $nomorInduk);
            $karyawan->delete();
            return ApiResponseService::success(null, null, 204);
        } catch (Exception $e) {
            return ApiResponseService::error($e->getMessage(), 500);
        }
    }

    public function getKaryawanTerbaru()
    {
        try {
            $karyawanTerbaru = Karyawan::orderBy('tanggal_bergabung', 'DESC')->take(3)->get();
            return ApiResponseService::success($karyawanTerbaru, "Sukses mendapatkan data karyawan terbaru");
        } catch (Exception $e) {
            return ApiResponseService::error($e->getMessage(), 500);
        }
    }

    public function getKaryawanTerambilCuti()
    {
        try {
            $karyawanTerambilCuti = Karyawan::has('cuti')->get();
            return ApiResponseService::success($karyawanTerambilCuti, "Sukses mendapatkan data karyawan terambil cuti");
        } catch (Exception $e) {
            return ApiResponseService::error($e->getMessage(), 500);
        }
    }

    public function getKaryawanWithSisaCuti()
    {
        try {
            $karyawanWithSisaCuti = Karyawan::select('karyawan.nomor_induk', 'karyawan.nama')
                ->leftJoin('cuti', 'karyawan.nomor_induk', '=', 'cuti.nomor_induk')
                ->selectRaw('karyawan.nomor_induk, karyawan.nama, (12 - COALESCE(SUM(cuti.lama_cuti), 0)) as sisa_cuti')
                ->groupBy('karyawan.nomor_induk', 'karyawan.nama')
                ->get()->map(function ($karyawan) {
                    $karyawan->sisa_cuti = (int) $karyawan->sisa_cuti;
                    return $karyawan;
                });

            return ApiResponseService::success($karyawanWithSisaCuti, "Sukses mendapatkan data karyawan dengan sisa cuti");
        } catch (Exception $e) {
            return ApiResponseService::error($e->getMessage(), 500);
        }
    }
}
