<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pertandingan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pertandingans';
    protected $primaryKey = 'id';

    protected $guarded = [
        'id'
    ];

    protected $fillable = [
        'perlombaans_id',
        'pesertas_id_1',
        'pesertas_id_2',
        'tanggal_jadwal'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
}
