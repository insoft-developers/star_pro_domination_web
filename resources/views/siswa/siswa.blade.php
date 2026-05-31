 
 @extends('master')
 @section('content')
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Siswa Management
        
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{ route('default') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="#">Siswa Management</a></li>
        <li class="active">Data Siswa</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
         
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Data Siswa</h3>
              <button onclick="addData()" style="float:right;" class="btn btn-success btn-xs"><i class="fa fa-plus"></i> Add</button>
            </div>
            <!-- /.box-header -->
            <div class="box-body" style="margin-top:10px">
              <div class="table-responsive">
              <table style="font-size:13px;" id="siswa_table" class="table table-bordered table-striped nowrap">
                <thead>
                <tr>
                  <th width="10%">Action</th>
                  <th width="5%">ID</th>
                  <th width="5%">VERSI</th>
                  <th width="15%">Foto</th>
                  <th width="10%">Status</th>
                  <th width="13%">Date</th>
                  <th width="*">Nama Siswa</th>
                  <th width="8%">L.A</th>
                  <th width="8%">NIS</th>
                  <th width="10%">Kelas</th>
                  <th width="10%">Sekolah</th>
                  <th width="10%">Email</th>
                  <th width="10%">Telepon</th>
                  
                  
                  
                </tr>
                </thead>
                <tbody></tbody>
                
              </table>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
    @include('modal.modal_add_siswa')
    @include('modal.modal_hapus')
  </div>
  @endsection