<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Aplikasi siswa</title>
	<link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet"> </head>

<body> 
	@include('layouts.headguru')
	@include('sweetalert::alert')
	<div class="container">
		<h3 class="mt-4">Data Siswa
			<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#inppelanggaran">Tambah</button>
			<a class="btn btn-primary btn-sm" href="{{ url('guru/pelanggaran-pdf') }}" target="_blank">Download PDF</a>
		</h3>
		<form class="col-12 col-lg-auto mb-2 mb-lg-0 me-lg-auto" role="search" method="get" action="/guru/siswa"> Cari data &nbsp;
			<input type="text" name="search" class="form-control w-75 d-inline" id="search" placeholder="Masukkan Nama Siswa"> </form>
		<br> @if ($data->isNotEmpty())
		<table class="table table-striped table-bordered">
          <thead>
			<tr>
				<th>No</th>
				<th>Foto</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Tanggal</th>
                <th>Pelanggaran</th>
                <th>Proses Data</th>
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
                        <td>
						<a class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#ubah{{$dt->id}}"> Ubah </a> 
                        <a class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapus{{$dt->id}}"> Hapus</a> 
                        </td>
					</tr> 

					<!-- Modal Hapus -->
				<div class="modal fade" id="hapus{{$dt->id}}" role="dialog" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content">
						<div class="modal-header bg-danger text-white">
						<h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Pelanggaran</h1>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
						<h4 class="text-center">Apakah anda yakin menghapus pelanggaran <span>
							<font color="blue">{{$dt->siswa->nama}} : {{$dt->isi_pelanggaran}}</font>
							</span>
						</h4>
						</div>
						<div class="modal-footer">
						<form action="/guru/pelanggaran/{{$dt->id}}" method="POST"> @csrf @method('delete') <button type="button" class="btn btn-secondary" data-bs- dismiss="modal">Tidak Jadi</button>
							<button type="submit" class="btn btn-danger">Hapus!</button>
						</form>
						</div>
					</div>
					</div>
               </div>

			   <!-- Modal Ubah -->
				<div class="modal fade" id="ubah{{$dt->id}}" role="dialog" tabindex="-1" aria- labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered">
					<div class="modal-content">
						<div class="modal-header bg-success text-white">
						<h1 class="modal-title fs-5" id="exampleModalLabel">Ubah Data Pelanggaran</h1>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
						</div>
						<form id="create-depot-form" action="/guru/pelanggaran/{{$dt->id}}" method="POST" enctype="multipart/form-data"> @csrf @method('PUT') <div class="modal-body">
							<div class="row g-2">
							<div class="col-md"> Foto Preview: <br>
								<img id="prevImg" src="{{asset('foto/'.$dt->foto)}}" class="rounded" style="width: 150px">
								<input type="file" class="form-control" name="foto" id="ubahImg">
							</div>
							<div class="col-md">
								<div class="form-floating">
								<div class="row g-1">
									<div class="col-md">
									<div class="form-floating">
										<input type="text" class="form-control" name="idpel" value="{{$dt->id_pelanggaran}}">
										<label for="floatingInputGrid">Id Pelanggaran:</label>
									</div>
									</div>
								</div>
								<br>
								<div class="row g-2">
									<div class="col-md">
									<div class="form-floating">
										<select class="form-control" name="nis">
										<option value="{{ $dt->nis }}">
											{{ $dt->nis }} {{$dt->siswa->nama}} {{$dt->siswa->kelas}}
										</option> @foreach ($dataSiswa as $nis) <option value="{{ $nis->nis }}" name="id">
											{{ $nis->nis }} => {{$nis->nama}}
											{{$nis->kelas}}
										</option> @endforeach
										</select>
										<label for="floatingInputGrid">Nis:</label>
									</div>
									</div>
								</div>
								<br>
								<div class="row g-1">
									<div class="col-md">
									<div class="form-floating">
										<input type="date" class="form-control" name="tgl" value="{{$dt->tgl_pelanggaran}}">
										<label for="floatingInputGrid">Tanggal Pelanggaran:</label>
									</div>
									</div>
								</div>
								</div>
							</div>
							<div class="row g-1">
								<div class="col-md">
								<label>Isi Pelanggaran:</label> @isset($dt) <textarea class="form-control scrollable" name="isi" rows="5" required>{{$dt->isi_pelanggaran}}</textarea> @else <textarea class="form-control scrollable" name="isi" rows="5" required></textarea> @endIf
								</div>
							</div>
							<br>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
								<button type="submit" class="btn btn-success">Ubah</button>
							</div>
							</div>
						</div>
						</form>
					</div>
					</div>
				</div>
				</div>
					@endforeach 
				</tbody>
		</table>
	</div> 
	{{--<div class="d-flex justify-content-right"> {{!! $dt->links() !!}} </div> --}} @else
	<p>Tidak ada Data</p> 
	@endif 

	<!-- Modal input Pelanggaran -->
<div class="modal fade" id="inppelanggaran" tabindex="-1" data-bs- backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
	  <div class="modal-content">
		<div class="modal-header bg-primary text-white">
		  <h5 class="modal-title" id="exampleModalLabel">Tambah Data Pelanggaran</h5>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<form id="create-depot-form" action="/guru/pelanggaran" method="POST" enctype="multipart/form-data">
		   @csrf 
		<div class="modal-body">
			 <div class="row g-2">
			  <div class="col-md"> Foto Preview: <br>
				<img id="prevFoto" src="{{ asset('avatar.png')}}" class="rounded" style="width: 150px">
				<input type="file" class="form-control" name="foto" id="image">
			  </div>
			  <div class="col-md">
				<div class="form-floating">
				  <div class="row g-1">
					<div class="col-md">
					  <div class="form-floating">
						<input type="text" class="form-control" name="idpel" placeholder="id pelanggaran">
						<label for="floatingInputGrid">Id Pelanggaran:</label>
					  </div>
					</div>
				  </div>
				  <br>
				  <div class="row g-2">
					<div class="col-md">
					  <div class="form-floating">
						<select class="form-control" name="nis">
						  <option> -- pilih nis --</option> @foreach ($dataSiswa as $nis) <option value="{{ $nis->nis }}" name=" id">
							{{ $nis->nis }} => {{$nis->nama}} {{$nis->kelas}}
						  </option> @endforeach
						</select>
						<label for="floatingInputGrid">Nis:</label>
					  </div>
					</div>
				  </div>
				  <br>
				  <div class="row g-1">
					<div class="col-md">
					  <div class="form-floating">
						<input min="2021-01-01" type="date" class="form-control" name="tgl" placeholder="tanggal pelanggaran">
						<label for="floatingInputGrid">Tanggal Pelanggaran:</label>
					  </div>
					</div>
				  </div>
				</div>
			  </div>
			  <div class="row g-1">
				<div class="col-md">
				  <label>Isi Pelanggaran:</label>
				  <textarea class="form-control scrollable" rows="5" name="isi"></textarea>
				</div>
			  </div>
			  <br>
			</div>
		</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs- dismiss="modal">Tutup</button>
				<button type="submit" class="btn btn-primary">Simpan</button>
			</div>
		</form>
	  </div>
	</div>
</div>

{{-- <div class="modal fade" id="inppelanggaran" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog">
	  <div class="modal-content">
		<div class="modal-header bg-primary text-white">
			<h5 class="modal-title" id="exampleModalLabel">Tambah Data Pelanggaran</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body">
		  ...
		</div>
		<div class="modal-footer">
		  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
		  <button type="button" class="btn btn-primary">Understood</button>
		</div>
	  </div>
	</div>
  </div> --}}

  <!-- Modal input Pelanggaran -->
{{-- <div class="modal fade" id="inppelanggaran" tabindex="-1" data-bs- backdrop="static" data-bs-keyboard="false" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
	  <div class="modal-content">
		<div class="modal-header bg-primary text-white">
		  <h5 class="modal-title" id="exampleModalLabel">Tambah Data Pelanggaran</h5>
		  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body">
		  <form id="create-depot-form" action="/guru/pelanggaran" method="POST" enctype="multipart/form-data">
			 @csrf 
			 <div class="row g-2">
			  <div class="col-md"> Foto Preview: <br>
				<img id="prevFoto" src="{{ asset('avatar.png')}}" class="rounded" style="width: 150px">
				<input type="file" class="form-control" name="foto" id="image">
			  </div>
			  <div class="col-md">
				<div class="form-floating">
				  <div class="row g-1">
					<div class="col-md">
					  <div class="form-floating">
						<input type="text" class="form-control" name="idpel" placeholder="id pelanggaran">
						<label for="floatingInputGrid">Id Pelanggaran:</label>
					  </div>
					</div>
				  </div>
				  <br>
				  <div class="row g-2">
					<div class="col-md">
					  <div class="form-floating">
						<select class="form-control" name="nis">
						  <option> -- pilih nis --</option> @foreach ($dataSiswa as $nis) <option value="{{ $nis->nis }}" name=" id">
							{{ $nis->nis }} => {{$nis->nama}} {{$nis->kelas}}
						  </option> @endforeach
						</select>
						<label for="floatingInputGrid">Nis:</label>
					  </div>
					</div>
				  </div>
				  <br>
				  <div class="row g-1">
					<div class="col-md">
					  <div class="form-floating">
						<input min="2021-01-01" type="date" class="form-control" name="tgl" placeholder="tanggal pelanggaran">
						<label for="floatingInputGrid">Tanggal Pelanggaran:</label>
					  </div>
					</div>
				  </div>
				</div>
			  </div>
			  <div class="row g-1">
				<div class="col-md">
				  <label>Isi Pelanggaran:</label>
				  <textarea class="form-control scrollable" rows="5" name="isi"></textarea>
				</div>
			  </div>
			  <br>
			  <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
				<button type="submit" class="btn btn-primary">Simpan</button>
			  </div>
		  </form>
		</div>
	  </div>
	</div>
  </div> --}}
	@include('layouts.footer')