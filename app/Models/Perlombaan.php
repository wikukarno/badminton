<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Perlombaan extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama_perlombaan',
        'deskripsi_perlombaan',
        'tanggal_pendaftaran_dibuka',
        'tanggal_pendaftaran_ditutup',
        'tempat_pelaksanaan',
        'kategori_perlombaan',
    ];
}
