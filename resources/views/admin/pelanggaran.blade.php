<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Aplikasi siswa</title>
	<link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet"> </head>

<body> 
	@include('layouts.headadmin')
	{{-- @include('sweetalert::alert') --}}
	<div class="container">
		<h3 class="mt-4">Data Pelanggaran Siswa
</h3> @if ($data->isNotEmpty()) 
		<table class="table table-striped table-bordered">
			<tr>
				<th>No</th>
				<th>Foto</th>
				<th>NIS</th>
				<th>Nama</th>
				<th>Kelas</th>
				<th>Tanggal</th>
				<th>Pelanggaran</th>
			</tr>
			</thead>
			<tbody>
				<?php $no=1;?> @foreach ($data as $dt)
					<tr>
						<td>{{ $no++ }}</td>
						<td>
							@if ($dt->foto && file_exists(public_path('foto/'.$dt->foto)))
							<img src="{{asset('foto/'.$dt->foto)}}" class="rounded" style="width: 100px">
							@else
							<img src="{{asset('avatar.png')}}" class="rounded" style="width: 100px">
							@endif
						</td>
						<td>{{$dt->nis}}</td>
						<td>{{$dt->siswa->nama}}</td>
						<td>{{$dt->siswa->kelas}}</td>
						<td>{{$dt->tgl_pelanggaran}}</td>
						<td>{{$dt->isi_pelanggaran}}</td>
					</tr>
					@endforeach 
				</tbody>
		</table>
	</div> {{--
	<div class="d-flex justify-content-right"> {{!! $dt->links() !!}} </div> --}} @else
	<p>Tidak ada Data</p> 
	@endif 
  

	@include('layouts.footer')