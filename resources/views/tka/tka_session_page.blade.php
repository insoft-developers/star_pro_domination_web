 @extends('master')
 @section('content')
     <div class="content-wrapper">
         <!-- Content Header (Page header) -->
         <section class="content-header">
             <h1>
                 TKA Session Management

             </h1>
             <ol class="breadcrumb">
                 <li><a href="{{ route('default') }}"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                 <li><a href="#">TKA</a></li>
                 <li class="active">TKA Session</li>
             </ol>
         </section>

         <!-- Main content -->
         <section class="content">
             <div class="row">
                 <div class="col-xs-12">

                     <div class="box">
                         <div class="box-header">
                             <h3 class="box-title">TKA Session</h3>
                             
                         </div>
                         <!-- /.box-header -->
                         <div class="box-body" style="margin-top:10px">
                             <div class="table-responsive">
                                 <table style="font-size:13px;" id="tka_session_table" class="table table-bordered table-striped nowrap">
                                     <thead>
                                         <tr>
                                             <th width="5%">ID</th>
                                             <th width="7%">Action</th>
                                             <th width="*">Judul</th>
                                             <th width="10%">Kelas</th>
                                             <th width="10%">Active</th>
                                             <th width="10%">Target Score</th>
                                             <th width="10%">Frequency</th>
                                             <th width="10%">Date</th>
                                             
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
       
     </div>
 @endsection
