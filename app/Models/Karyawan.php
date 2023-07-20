<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = "karyawan";

    public $timestamps = false;

    protected $fillable = ['nama', 'nomor_induk', 'alamat', 'tanggal_lahir', 'tanggal_bergabung'];

    public static function generateNomorInduk() {
        $lastKaryawan = self::orderBy('id', 'desc')->first();
        if($lastKaryawan) {
            $lastNumber = (int)substr($lastKaryawan->nomor_induk, 2);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 0000;
        }

        return 'IP' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }

    public function cuti() {
        return $this->hasOne(Cuti::class, "nomor_induk", "nomor_induk");
    }
}
