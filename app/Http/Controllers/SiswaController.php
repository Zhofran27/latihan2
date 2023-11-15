<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

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

   public function store(Request $request)
    {
            //
        $validator =Validator::make($request->all(), [
            'ns' => 'required',
            'nm' => 'required',
            'kls' => 'required',
        ]);

            //check if validation fails
        if ($validator->fails()) {
         return response()->json($validator->errors(), 422);
        }
            //create post
        $simpan = Siswa::create([
            'nis' => $request->ns,
            'nama' => $request->nm,
            'kelas' => $request->kls,
         ]);

        if($simpan){
            //redirect dengan pesan sukses
        Alert::success('Simpan Data', 'data siswa berhasil disimpan');
        return redirect('/admin/siswa');
        }else{
            //redirect dengan pesan error
            Alert::error('Simpan Data', 'data siswa gagal disimpan');
        return redirect('/admin/siswa');
        }
    }

    public function edit($id)
    {
    //
    $data=Siswa::find($id);
    //ubah adalah pengambilan data dari variabel $ubah, namanya harus sama
    return view('admin.siswa.index',compact(['data']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $upd = Siswa::find($id);
        
            $upd->update([
                'id' => $request->id,
                'nis' => $request->nis,
                'nama' => $request->nama,
                'kelas' => $request->kelas,
            ]);

        
        if($upd){
        Alert::success('Ubah Data', 'data siswa berhasil diubah');
        return redirect('/admin/siswa');
        }else{
        Alert::success('Ubah Data', 'data siswa berhasil diubah');
        return redirect('/admin/siswa');
        }
    }

    public function destroy($id)
    {
            //return dd($id);
            $del=Siswa::find($id);
            $del->delete(); //perintah untuk hapus
            if($del){
            Alert::success('Hapus Data', 'data siswa berhasil dihapus');
            return redirect('/admin/siswa');
            }else{
            //redirect dengan pesan error
            Alert::error('Hapus Data', 'data siswa gagal dihapus');
            return redirect('/admin/siswa');
            }
    }
}
