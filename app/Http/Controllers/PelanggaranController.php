<?php

namespace App\Http\Controllers;

use App\Models\Pelanggaran;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Barryvdh\DomPDF\Facade\Pdf;

class PelanggaranController extends Controller
{
    public function __construct()
    {
    $this->middleware('auth');
    }

    public function index()
    {
    $data =Pelanggaran::paginate(10);
    $dataSiswa = Siswa::all();
    $user =Auth::user();
        if ($user->level == 'admin') {
        return view('admin.pelanggaran',compact(['data', 'dataSiswa']));
        } elseif ($user->level == 'gurubk') {
        return view('guru.pelanggaran',compact(['data', 'dataSiswa']));
        }
   }

   function view_pdf()
   {
    $data=Pelanggaran::limit(10)->get();
    $pdf=PDF::loadview('guru.pelanggaran-pdf',compact(['data']));
    $pdf->setPaper('A4','portrait');
    return $pdf->stream('pelanggaran.pdf'); //stream untuk lihat dahulu
   }

   public function store(Request $request)
    {
            //
        $this->validate($request, [
            'idpel' => 'required',
            'nis' => 'required',
            'tgl' => 'required',
            'isi' => 'required',
            'foto' => 'mimes:jpg,jpeg,png|max:2048'
            ]);
                //proses upload gambar
        if($request->hasFile('foto')) {
        $image = $request->file('foto');
        $image->move(public_path('foto'),$image->getClientOriginalName());
        $simpan = Pelanggaran::create([
            'id_pelanggaran' => $request->idpel,
            'nis' => $request->nis,
            'tgl_pelanggaran' => $request->tgl,
            'isi_pelanggaran' => $request->isi,
            'foto' => $image->getClientOriginalName()
        ]);
        }elseif($request->file('foto') == "") {
        Alert::error('ERROR Simpan Data','Foto pelanggaran wajib dilampirkan');
            return redirect('/guru/pelanggaran');
        }
                
        if($simpan){
                //redirect dengan pesan sukses
            Alert::success('Simpan Data', 'data pelanggaran sukses di simpan');
            return redirect('/guru/pelanggaran');
            }else{
                //redirect dengan pesan error
            Alert::error('Simpan Data', 'data pelanggaran gagal di simpan');
            return redirect('/guru/pelanggaran');
            }
    }

    public function edit($id)
    {
    //
    $data=Pelanggaran::find($id);
    //ubah adalah pengambilan data dari variabel $ubah, namanya harus sama
    return view('guru.pelanggaran.index',compact(['data']));
    }

    public function update(Request $request, string $id)
    {

        $this->validate($request, [
            'idpel' => 'required',
            'nis' => 'required',
            'tgl' => 'required',
            'isi' => 'required',
            'foto' => 'mimes:jpg,jpeg,png|max:2048'
        ]);
            //proses upload gambar
        $upd = Pelanggaran::find($id);
        if($request->hasFile('foto')) {
        $image = $request->file('foto');
        $image->move(public_path('foto'),$image->getClientOriginalName());
        $upd ->update([
            'id_pelanggaran' => $request->idpel,
            'nis' => $request->nis,
            'tgl_pelanggaran' => $request->tgl,
            'isi_pelanggaran' => $request->isi,
            'foto' => $image->getClientOriginalName()
        ]);
        }elseif($request->file('foto') == "") {
        $upd ->update([
            'id_pelanggaran' => $request->idpel,
            'nis' => $request->nis,
            'tgl_pelanggaran' => $request->tgl,
            'isi_pelanggaran' => $request->isi
        ]);
        }
        if($upd){
            //redirect dengan pesan sukses
        Alert::success('Ubah Data', 'data pelanggaran sukses di ubah');
            return redirect('/guru/pelanggaran');
        }else{
            //redirect dengan pesan error
            
        Alert::error('Ubah Data', 'data pelanggaran gagal di ubah');
            return redirect('/guru/pelanggaran');
        }
    }

    public function destroy($id)
    {
        $del=Pelanggaran::find($id);
        $del->delete(); //perintah untuk hapus
        if($del){
        Alert::success('Hapus Data', 'data pelanggaran sukses di hapus');
        return redirect('/guru/pelanggaran');
        }else{
        Alert::error('Hapus Data', 'data pelanggaran gagal di hapus');
        return redirect('/guru/pelanggaran');
        }
    }

}
