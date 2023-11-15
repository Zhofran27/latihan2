<?php

namespace App\Http\Controllers;

use App\Models\Tanggapan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TanggapanController extends Controller
{
    public function __construct()
    {
    $this->middleware('auth');
    }

    public function index()
    {
    $data =Tanggapan::paginate(10);
    $user =Auth::user();
        if ($user->level == 'admin') {
        return view('admin.tanggapan',compact('data'));
        } elseif ($user->level == 'gurubk') {
        return view('guru.tanggapan',compact('data'));
        }
   }
}
