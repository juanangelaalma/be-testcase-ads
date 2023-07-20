<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = "karyawan";

    protected $timestamps = false;

    public function cuti() {
        return $this->hasOne(Cuti::class, "nomor_induk", "nomor_induk");
    }
}
