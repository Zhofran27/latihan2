<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Petugas extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $guarded = ['id'];
    protected $table = 'petugas'; //agar nama tabel tetap
    public $timestamps = false; //agar tidak menambahkan created_at updated_at
    protected $fillable = [
    'id_petugas',
    'nama',
    'username',
    'password',
    'telp',
    'level',
    ];

    protected $hidden = [
    'password',
    'remember_token',
    ];
    protected $enums = [
    'level' => ['admin', 'gurubk'],
    ];
    protected $casts = [
    'username_verified_at' => 'datetime',
    'password' => 'hashed',
    ];

    public function tanggapan():HasMany
    {
        return $this->hasMany(Tanggapan::class,'id_petugas','id_petugas');
    }
}
