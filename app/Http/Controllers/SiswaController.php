<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaController extends Controller
{
    public function __construct()
    {
    $this->middleware('auth');
    }

    public function index()
    {
    $data =Siswa::paginate(10);
    $user =Auth::user();
        if ($user->level == 'admin') {
        return view('admin.siswa',compact('data'));
        } elseif ($user->level == 'gurubk') {
        return view('guru.siswa',compact('data'));
        }
   }
}
