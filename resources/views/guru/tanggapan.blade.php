<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Aplikasi siswa</title>
	<link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet"> </head>

<body> 
	{{-- @include('sweetalert::alert') --}}
	@include('layouts.headguru')
	<div class="container">
		<h3 class="mt-4">Data Siswa
			<a class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambah">Tambah</a>
		</h3>
		<form class="col-12 col-lg-auto mb-2 mb-lg-0 me-lg-auto" role="search" method="get" action="/guru/siswa"> Cari data &nbsp;
			<input type="text" name="search" class="form-control w-75 d-inline" id="search" placeholder="Masukkan Nama Siswa"> </form>
		<br> @if ($data->isNotEmpty())
		<table class="table table-striped table-bordered">
			<tr>
				<th>No</th>
                <th>id_tanggapan</th>
                <th>id_pelanggaran</th>
                <th>id_petugas</th>
                <th>Tanggal</th>
                <th>Isi Tanggapan</th>
                <th>Proses Data</th>
			</tr>
			</thead>
			<tbody>
				<?php $no=1;?> @foreach ($data as $dt)
					<tr>
						<td>{{ $no++ }}</td>
                        <td>{{$dt->id_tanggapan}}</td>
                        <td>{{$dt->id_pelanggaran}}</td>
                        <td>{{$dt->id_petugas}}</td>
                        <td>{{$dt->tgl_tanggapan}}</td>
                        <td>{{$dt->isi_tanggapan}}</td>
                        <td>
                        <a class="btn btn-warning btn-sm" href="/admin/siswa/edit/{{$dt->id}}"> Ubah
                        </a>
                        <a class="btn btn-danger btn-sm" href="/admin/siswa/delete/{{$dt->id}}"> Hapus</a>
                        </td>
					</tr> @endforeach </tbody>
		</table>
	</div> {{--
	<div class="d-flex justify-content-right"> {{!! $dt->links() !!}} </div> --}} @else
	<p>Tidak ada Data</p> @endif @include('layouts.footer')