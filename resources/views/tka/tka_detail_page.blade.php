 @extends('master')
 @section('content')
     <div class="content-wrapper">
         <!-- Content Header (Page header) -->
         <section class="content-header">
             <h1>
                 TKA Details Management

             </h1>
             <ol class="breadcrumb">
                 <li><a href="{{ route('default') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                 <li><a href="#">TKA</a></li>
                 <li><a href="{{ url('/tka') }}">TKA (Test Kompetisi Akademik)</a></li>
                 <li class="active">TKA Details</li>
             </ol>
         </section>

         <!-- Main content -->
         <section class="content">
             <div class="row">
                 <div class="col-xs-12">

                     <div class="box">
                         <div class="box-header">
                             <h3 class="box-title">{{ $data->judul ?? '' }}</h3>
                             <button onclick="addData()" style="float:right;" class="btn btn-success btn-xs"><i
                                     class="fa fa-plus"></i> Add</button>
                         </div>
                         <!-- /.box-header -->
                         <div class="box-body" style="margin-top:10px">
                             <div class="table-responsive">
                                 <table style="font-size:13px;" id="list-table"
                                     class="table table-bordered table-striped nowrap">
                                     <thead>
                                         <tr>
                                             <th>ID</th>
                                             <th>Action</th>
                                             <th>No Soal</th>
                                             <th>Soal</th>
                                             <th>Gambar Soal</th>
                                             <th>Soal Bawah</th>
                                             <th>Jawaban A</th>
                                             <th>Jawaban B</th>
                                             <th>Jawaban C</th>
                                             <th>Jawaban D</th>
                                             <th>Jawaban E</th>
                                             <th>Tipe Soal</th>
                                             <th>Kunci Jawaban</th>
                                             <th>Score</th>
                                             <th>Active</th>


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
         @include('modal.modal_add_tka_detail')
         @include('modal.modal_lihat_soal_tka')
         @include('modal.modal_hapus')
     </div>
 @endsection
