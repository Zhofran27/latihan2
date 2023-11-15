<?php

namespace App\Http\Controllers;

use App\Models\TriggerPelanggaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
    $this->middleware('auth');
    }

    function index(){
        $data =TriggerPelanggaran::paginate(10);
        return view('admin.index',compact('data'));
    }
}
