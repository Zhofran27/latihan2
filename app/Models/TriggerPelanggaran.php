<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TriggerPelanggaran extends Model
{
    use HasFactory;
    protected $table = 'inp_pelanggaran';
    public $timestamps = false;
}
