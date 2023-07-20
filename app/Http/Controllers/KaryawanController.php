<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Services\ApiResponseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KaryawanController extends Controller
{
    public function getAllKaryawan() {
        try {
            $karyawan = Karyawan::all();
            return ApiResponseService::success($karyawan, "Sukses mengambil data karyawan");
        } catch (Exception $e) {
            return ApiResponseService::error($e->getMessage(), 500);
        }
    }

    public function createKaryawan(Request $request) {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:50',
            'alamat' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'tanggal_bergabung' => 'required|date'
        ]);

        if($validator->fails()) {
            return ApiResponseService::error($validator->errors(), 400);
        }

        $newNomorInduk = Karyawan::generateNomorInduk();

        $newKaryawan = Karyawan::create([
            'nomor_induk' => $newNomorInduk,
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'tanggal_lahir' => $request->tanggal_lahir,
            'tanggal_bergabung' => $request->tanggal_bergabung,
        ]);

        return ApiResponseService::success($newKaryawan, "Sukses menambah karyawan", 201);
    }

    public function updateKaryawan(Request $request, $nomorInduk) {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:50',
            'alamat' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'tanggal_bergabung' => 'required|date'
        ]);

        if($validator->fails()) {
            return ApiResponseService::error($validator->errors(), 400);
        }

        $karyawan = Karyawan::where('nomor_induk', $nomorInduk)->first();

        if(!$karyawan) {
            return ApiResponseService::error("Karyawan dengan nomor induk $nomorInduk tidak ditemukan", 404);
        }

        $karyawan->nama = $request->nama;
        $karyawan->tanggal_lahir = $request->tanggal_lahir;
        $karyawan->tanggal_bergabung = $request->tanggal_bergabung;

        return ApiResponseService::success($karyawan, "Sukses mengupdate karyawan", 201);
    }

    public function deleteKaryawan($nomorInduk) {
        $karyawan = Karyawan::where('nomor_induk', $nomorInduk);
        $karyawan->delete();
        return ApiResponseService::success(null, null, 204);
    }

    public function getKaryawanTerbaru() {
        $karyawanTerbaru = Karyawan::orderBy('tanggal_bergabung', 'DESC')->take(3)->get();
        return ApiResponseService::success($karyawanTerbaru, "Sukses mendapatkan data karyawan terbaru");
    }
}
