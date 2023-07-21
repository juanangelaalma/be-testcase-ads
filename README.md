# API Routes Documentation

This document provides an overview of the available API routes for the application. The routes are grouped based on the "karyawan" prefix and are all assigned to the "api" middleware group.

## Karyawan Routes

| Method | URI                         | Controller Method                          | Description                                          |
| ------ | --------------------------- | ------------------------------------------ | ---------------------------------------------------- |
| GET    | /api/karyawan/terlama       | KaryawanController@getKaryawanTerlama      | Mendapatkan 3 data karyawan yang pertama kali gabung |
| GET    | /api/karyawan/sisa-cuti     | KaryawanController@getKaryawanWithSisaCuti | Mendapatkan data karyawan beserta sisa cuti          |
| GET    | /api/karyawan/terambil-cuti | KaryawanController@getKaryawanTerambilCuti | Mendapatkan data karyawan yang pernah melakukan cuti |
| GET    | /api/karyawan               | KaryawanController@getAllKaryawan          | Mendapatkan semua data karyawan                      |
| POST   | /api/karyawan               | KaryawanController@createKaryawan          | Menambah data karyawan                               |
| PUT    | /api/karyawan/{nomorInduk}  | KaryawanController@updateKaryawan          | Menguah data karyawan                                |
| DELETE | /api/karyawan/{nomorInduk}  | KaryawanController@deleteKaryawan          | Menghapus data karyawan                              |

## Description

-   **GET /api/karyawan/terlama:** Mendapatkan 3 data karyawan yang pertama kali gabung
-   **GET /api/karyawan/sisa-cuti:** Mendapatkan data karyawan beserta sisa cuti
-   **GET /api/karyawan/terambil-cuti:** Mendapatkan data karyawan yang pernah melakukan cuti
-   **GET /api/karyawan/:** Mendapatkan semua data karyawan
-   **POST /api/karyawan/:** Menambah data karyawan
-   **PUT /api/karyawan/{nomorInduk}:** Mengubah data karyawan berdasarkan nomor induk
-   **DELETE /api/karyawan/{nomorInduk}:** menghapus data karyawan berdasarkan nomor induk

