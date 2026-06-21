<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use App\Tkp;
use App\Kelas;
use App\TkpDetail;
use DB;
use File;
use App\TkpSession;
use App\TkptAnswer;
use Session;

class TkpController extends Controller
{
   
    public function index()
    {
        if(! Session::has('id')) {
            return Redirect(route('login'));
        }
        $view = 'tkp';
        $kelas = Kelas::all();
        $tkp = Tkp::all();
        return view('tkp.tkp', compact('view', 'kelas', 'tkp'));
    }
  
  
    public function store(Request $request)
    {
        $input = $request->all();
        $kelas = $input['id_kelas'];
        $id_kelas = implode(",", $kelas);
        $input['id_kelas'] = $id_kelas;
        
        
        Tkp::create($input);

        return response()->json([
            'success'=>true
        ]);
    }


    public function tkpDetail($id)
    {
        if(! Session::has('id')) {
            return Redirect(route('login'));
        }
        $view = 'tkp-detail';
        $ids = $id;
        $tkp = Tkp::findorFail($id);
        return view('tkp.detail', compact('view', 'ids', 'tkp'));
    }
    
    
    public function detailAdd(Request $request) 
    {
        $input = $request->all();
        
        $input['gambar_soal'] = null;
        $unique = uniqid();
        $nm = 'soal-'.$unique;
        if($request->hasFile('gambar_soal')){
            $input['gambar_soal'] = str_slug($nm, '-').'.'.$request->gambar_soal->getClientOriginalExtension();
            $request->gambar_soal->move(public_path('/images/tkp'), $input['gambar_soal']);
        }
        
        
        $input['gambar_a'] = null;
        $nma = 'a-'.$unique;
        if($request->hasFile('gambar_a')){
            $input['gambar_a'] = str_slug($nma, '-').'.'.$request->gambar_a->getClientOriginalExtension();
            $request->gambar_a->move(public_path('/images/tkp'), $input['gambar_a']);
        }
        
        $input['gambar_b'] = null;
        $nmb = 'b-'.$unique;
        if($request->hasFile('gambar_b')){
            $input['gambar_b'] = str_slug($nmb, '-').'.'.$request->gambar_b->getClientOriginalExtension();
            $request->gambar_b->move(public_path('/images/tkp'), $input['gambar_b']);
        }
        
        
        $input['gambar_c'] = null;
        $nmc = 'c-'.$unique;
        if($request->hasFile('gambar_c')){
            $input['gambar_c'] = str_slug($nmc, '-').'.'.$request->gambar_c->getClientOriginalExtension();
            $request->gambar_c->move(public_path('/images/tkp'), $input['gambar_c']);
        }
        
        $input['gambar_d'] = null;
        $nmd = 'd-'.$unique;
        if($request->hasFile('gambar_d')){
            $input['gambar_d'] = str_slug($nmd, '-').'.'.$request->gambar_d->getClientOriginalExtension();
            $request->gambar_d->move(public_path('/images/tkp'), $input['gambar_d']);
        }
        
        $input['gambar_e'] = null;
        $nme = 'e-'.$unique;
        if($request->hasFile('gambar_e')){
            $input['gambar_e'] = str_slug($nme, '-').'.'.$request->gambar_e->getClientOriginalExtension();
            $request->gambar_e->move(public_path('/images/tkp'), $input['gambar_e']);
        }

        
        TkpDetail::create($input);

        return response()->json([
            'success'=>true
        ]);
    }
    
    
    public function detailEdit($id) 
    {
        $detail = TkpDetail::findorFail($id);
        return $detail;
    }
    
    
     public function detailUpdate(Request $request, $id)
    {
        $input = $request->all();
        $detail = TkpDetail::findorFail($id);
        
        $unique = uniqid();
        $uni = 'soal-'.$unique;
        $una = 'a-'.$unique;
        $unb = 'b-'.$unique;
        $unc = 'c-'.$unique;
        $und = 'd-'.$unique;
        $une = 'e-'.$unique;
        
        $input['gambar_soal'] = $detail->gambar_soal;
        if($request->hasFile('gambar_soal')){
            if($detail->gambar_soal != NULL && file_exists(public_path('/images/tkp/'.$detail->gambar_soal))){
                unlink(public_path('/images/tkp/'.$detail->gambar_soal));
            }
            
            $input['gambar_soal'] = str_slug($uni, '-').'.'.$request->gambar_soal->getClientOriginalExtension();
            $request->gambar_soal->move(public_path('/images/tkp'), $input['gambar_soal']);
        }
        
        $input['gambar_a'] = $detail->gambar_a;
        if($request->hasFile('gambar_a')){
            if($detail->gambar_a != NULL && file_exists(public_path('/images/tkp/'.$detail->gambar_a))){
                unlink(public_path('/images/tkp/'.$detail->gambar_a));
            }
            
            $input['gambar_a'] = str_slug($una, '-').'.'.$request->gambar_a->getClientOriginalExtension();
            $request->gambar_a->move(public_path('/images/tkp'), $input['gambar_a']);
        }
        
        
        $input['gambar_b'] = $detail->gambar_b;
        if($request->hasFile('gambar_b')){
            if($detail->gambar_b != NULL && file_exists(public_path('/images/tkp/'.$detail->gambar_b))){
                unlink(public_path('/images/tkp/'.$detail->gambar_b));
            }
            
            $input['gambar_b'] = str_slug($unb, '-').'.'.$request->gambar_b->getClientOriginalExtension();
            $request->gambar_b->move(public_path('/images/tkp'), $input['gambar_b']);
        }
        
        
        $input['gambar_c'] = $detail->gambar_c;
        if($request->hasFile('gambar_c')){
            if($detail->gambar_c != NULL && file_exists(public_path('/images/tkp/'.$detail->gambar_c))){
                unlink(public_path('/images/tkp/'.$detail->gambar_c));
            }
            
            $input['gambar_c'] = str_slug($unc, '-').'.'.$request->gambar_c->getClientOriginalExtension();
            $request->gambar_c->move(public_path('/images/tkp'), $input['gambar_c']);
        }
        
        
        $input['gambar_d'] = $detail->gambar_d;
        if($request->hasFile('gambar_d')){
            if($detail->gambar_d != NULL && file_exists(public_path('/images/tkp/'.$detail->gambar_d))){
                unlink(public_path('/images/tkp/'.$detail->gambar_d));
            }
            
            $input['gambar_d'] = str_slug($und, '-').'.'.$request->gambar_d->getClientOriginalExtension();
            $request->gambar_d->move(public_path('/images/tkp'), $input['gambar_d']);
        }
        
        
        $input['gambar_e'] = $detail->gambar_e;
        if($request->hasFile('gambar_e')){
            if($detail->gambar_e != NULL && file_exists(public_path('/images/tkp/'.$detail->gambar_e))){
                unlink(public_path('/images/tkp/'.$detail->gambar_e));
            }
            
            $input['gambar_e'] = str_slug($une, '-').'.'.$request->gambar_e->getClientOriginalExtension();
            $request->gambar_e->move(public_path('/images/tkp'), $input['gambar_e']);
        }
        
        
        $detail->update($input);
        
        return response()->json([
            'success'=>true
        ]);
    }
    
    
    public function deleteImage(Request $request) 
    {
        $input = $request->all();
        $detail = TkpDetail::findorFail($input['id']);
        $type = $input['type'];
        if($type == 0) {
            unlink(public_path('/images/tkp/'.$detail->gambar_soal));
            $detail->update(['gambar_soal'=> NULL]);
        }
        
        
        if($type == 1) {
            unlink(public_path('/images/tkp/'.$detail->gambar_a));
            $detail->update(['gambar_a'=> NULL]);
        }
        
        if($type == 2) {
            unlink(public_path('/images/tkp/'.$detail->gambar_b));
            $detail->update(['gambar_b'=> NULL]);
        }
        
        
        if($type == 3) {
            unlink(public_path('/images/tkp/'.$detail->gambar_c));
            $detail->update(['gambar_c'=> NULL]);
        }
        
        
        if($type == 4) {
            unlink(public_path('/images/tkp/'.$detail->gambar_d));
            $detail->update(['gambar_d'=> NULL]);
        }
        
        if($type == 5) {
            unlink(public_path('/images/tkp/'.$detail->gambar_e));
            $detail->update(['gambar_e'=> NULL]);
        }
        
        return response()->json([
            'success'=>true
        ]);
        
    }
    
    
    public function detailTkpDelete(Request $request) 
    {
        
        $input = $request->all();
        $detail = TkpDetail::findorFail($input['id']);
        if($detail->gambar_soal != NULL && file_exists(public_path('/images/tkp/'.$detail->gambar_soal))){
            unlink(public_path('/images/tkp/'.$detail->gambar_soal));
        }
        
        if($detail->gambar_a != NULL && file_exists(public_path('/images/tkp/'.$detail->gambar_a))){
            unlink(public_path('/images/tkp/'.$detail->gambar_a));
        }
        
        if($detail->gambar_b != NULL && file_exists(public_path('/images/tkp/'.$detail->gambar_b))){
            unlink(public_path('/images/tkp/'.$detail->gambar_b));
        }
        
        if($detail->gambar_c != NULL && file_exists(public_path('/images/tkp/'.$detail->gambar_c))){
            unlink(public_path('/images/tkp/'.$detail->gambar_c));
        }
        
        if($detail->gambar_d != NULL && file_exists(public_path('/images/tkp/'.$detail->gambar_d))){
            unlink(public_path('/images/tkp/'.$detail->gambar_d));
        }
        
        if($detail->gambar_e != NULL && file_exists(public_path('/images/tkp/'.$detail->gambar_e))){
            unlink(public_path('/images/tkp/'.$detail->gambar_e));
        }

        TkpDetail::destroy($input['id']);
        
        return response()->json([
            'success'=>true

        ]);
    }
    
    
    public function detailTkpDeleteAll(Request $request)
    {
        $input = $request->all();
        
        $data = TkpDetail::findorFail($input['id']);
        // foreach($data as $key) {
        //     \App\TryoutReport::where('id_soal', $key->id)->where('kategori', 'tryout')->delete();
        // }
        
        TkpDetail::where('id_tkp', $input['id'])->delete();

        return response()->json([
            'success'=>true

        ]);
    }
  
  
  
    public function edit($id)
    {
        $data = Tkp::findorFail($id);
        return $data;
    }

  
    public function update(Request $request, $id)
    {
        
        
        $input = $request->all();
        $data = Tkp::findorFail($id);
        $kelas_array = implode(",", $input['id_kelas']);
        $input['id_kelas'] = $kelas_array;
        $data->update($input);
        
        return response()->json([
            'success'=>true
        ]);
    }


    public function destroy($id)
    {
        Tkp::destroy($id);

        return response()->json([
            'success'=>true

        ]);
    }
    
    
    
    public function tkpTable()
    {
        $data = Tkp::all();
       
        return Datatables::of($data)
           
           ->addColumn('jumlah_soal', function($data){
               $d = TkpDetail::where('id_tkp', $data->id);
               return '<div style="text-align:right;padding:4px;border-radius:3px;background-color:'.$data->warna_soal.'"><strong><span style="color:'.$data->warna_tulisan.';">'.$d->count().'</span></strong></div><br><div style="text-align:right;padding:4px;border-radius:3px;background-color:'.$data->warna_jawaban.'"><strong><span style="color:'.$data->warna_tulisan_jawaban.';">jawaban</span></strong></div>';
           })
           
           ->addColumn('time_limit', function($data){
               return '<div style="text-align:right;">'.$data->time_limit.'</div>';
           })
           ->addColumn('target_score', function($data){
               return '<div style="text-align:right;">'.$data->target_score.'</div>';
           })
           ->addColumn('is_active', function($data){
               if($data->is_active == 1) {
                   return '<center><span class="label label-success">Active</span></center>';
               }
               else {
                   return '<center><span class="label label-danger">Inactive</span></center>';
               }
           })
           
           ->addColumn('id_kelas', function($data) {
               $data_kelas = $data->id_kelas;
               $data_array = explode(",", $data_kelas);
               $html = "";
               $html .= '<ul>';
               foreach($data_array as $d) {
                   $query_kelas = Kelas::findorFail($d);
                   $html .= '<li>'.$query_kelas->nama_kelas.'</li>';
               }
               
               $html .= '</ul>';
               
               return $html;
               
           })
           
           ->addColumn('is_repeated', function($data){
               if($data->is_repeated == 1) {
                   return '<center><span class="label label-success">Yes</span></center>';
               }
               else {
                   return '<center><span class="label label-danger">No</span></center>';
               }
           })
           
           ->addColumn('is_skipped', function($data){
               if($data->is_skipped == 1) {
                   return '<center><span class="label label-success">Yes</span></center>';
               }
               else {
                   return '<center><span class="label label-danger">No</span></center>';
               }
           })
            ->addColumn('judul', function($data){
               return '<div style="text-align:left;">'.$data->judul.'<br> ( '.$data->short_name.' )</div>';
           })
           
           ->addColumn('action', function($data){
                return '<center><a onclick="listData('. $data->id.')" style="width:25px;margin-bottom:5px;" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-list"></i></a>'.
                 '<br><a onclick="copyData('. $data->id.')" style="margin-bottom:4px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-copy"></i></a>'.
                '<br><a onclick="editData('. $data->id.')" style="width:25px;margin-bottom:5px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a>'.
                '<br><a onclick="deleteData('. $data->id.')" style="width:25px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a></center>';
        })->rawColumns(['id_kelas','judul','jumlah_soal','is_repeated', 'is_skipped','time_limit','target_score','is_active','action'])
        ->make(true);
    }
    
    
    public function tkpDetailTable($id) 
    {
        $detail = TkpDetail::where('id_tkp', $id)->get();
        return Datatables::of($detail)
           
           
           ->addColumn('is_active', function($detail){
               if($detail->is_active == 1) {
                   return '<center><span class="label label-success">Active</span></center>';
               }
               else {
                   return '<center><span class="label label-danger">Inactive</span></center>';
               }
           })
           
           ->addColumn('soal', function($detail){
               if(! empty($detail->gambar_soal)) {
                   return '<div><a href="'.asset('images/tkp/').'/'.$detail->gambar_soal.'" target="_blank"><img style="width:90px;" class="img-responsive" src="'.asset('images/tkp/').'/'.$detail->gambar_soal.'"></a><small onclick="deleteImage('.$detail->id.', 0)" style="color:red;cursor:pointer;"><i class="fa fa-trash"></i> Delete</small><br>'.$detail->soal.'</div>';
               } else {
                   return '<div>'.$detail->soal.'</div>';
               }
               
           })
           
           ->addColumn('jawaban_a', function($detail){
               $html = '';
               $html = '<div>';
               $html .= '<b>A</b>. '.$detail->jawaban_a.'';
               if(! empty($detail->gambar_a)) {
                   $html .= '<a href="'.asset('images/tkp/').'/'.$detail->gambar_a.'" target="_blank"><img style="width:50px;" class="img-responsive" src="'.asset('images/tkp/').'/'.$detail->gambar_a.'"></a><small onclick="deleteImage('.$detail->id.', 1)" style="color:red;cursor:pointer;"><i class="fa fa-trash"></i> Delete</small>'; 
               }
               $html .= '<br><b>B</b>. '.$detail->jawaban_b.'';
               if(! empty($detail->gambar_b)) {
                   $html .= '<a href="'.asset('images/tkp/').'/'.$detail->gambar_b.'" target="_blank"><img style="width:50px;" class="img-responsive" src="'.asset('images/tkp/').'/'.$detail->gambar_b.'"></a><small onclick="deleteImage('.$detail->id.', 2)" style="color:red;cursor:pointer;"><i class="fa fa-trash"></i> Delete</small>'; 
               }
               $html .= '<br><b>C</b>. '.$detail->jawaban_c.'';
               if(! empty($detail->gambar_c)) {
                   $html .= '<a href="'.asset('images/tkp/').'/'.$detail->gambar_c.'" target="_blank"><img style="width:50px;" class="img-responsive" src="'.asset('images/tkp/').'/'.$detail->gambar_c.'"></a><small onclick="deleteImage('.$detail->id.', 3)" style="color:red;cursor:pointer;"><i class="fa fa-trash"></i> Delete</small>'; 
               }
               $html .= '<br><b>D</b>. '.$detail->jawaban_d.'';
               if(! empty($detail->gambar_d)) {
                   $html .= '<a href="'.asset('images/tkp/').'/'.$detail->gambar_d.'" target="_blank"><img style="width:50px;" class="img-responsive" src="'.asset('images/tkp/').'/'.$detail->gambar_d.'"></a><small onclick="deleteImage('.$detail->id.', 4)" style="color:red;cursor:pointer;"><i class="fa fa-trash"></i> Delete</small>'; 
               }
               $html .= '<br><b>E</b>. '.$detail->jawaban_e.'';
               if(! empty($detail->gambar_e)) {
                   $html .= '<a href="'.asset('images/tkp/').'/'.$detail->gambar_e.'" target="_blank"><img style="width:50px;" class="img-responsive" src="'.asset('images/tkp/').'/'.$detail->gambar_e.'"></a><small onclick="deleteImage('.$detail->id.', 5)" style="color:red;cursor:pointer;"><i class="fa fa-trash"></i> Delete</small>'; 
               }
               $html .= '</div>';
               return $html;
           })
           
           ->addColumn('score', function($detail){
               $var = '';
               $var .= '<ul>';
               $var .= '<li><strong>A</strong> = '.$detail->score_a.'</li>';
               $var .= '<li><strong>B</strong> = '.$detail->score_b.'</li>';
               $var .= '<li><strong>C</strong> = '.$detail->score_c.'</li>';
               $var .= '<li><strong>D</strong> = '.$detail->score_d.'</li>';
               $var .= '<li><strong>E</strong> = '.$detail->score_e.'</li>';
               $var .= '</ul>';
               return $var;
           })
           ->addColumn('action', function($detail){
                return '<center><a onclick="editData('. $detail->id.')" style="width:25px;margin-bottom:5px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a>'.
                '<br><a onclick="deleteData('. $detail->id.')" style="width:25px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a></center>';
        })->rawColumns(['soal','jawaban_a','score', 'is_active','action'])
        ->make(true);
    }
    
    
    public function copyTkp(Request $request)
    {
        $input = $request->all();
        $soalAsal = TkpDetail::where('id_tkp', $input['dari'])->get();
       
            
        $no = TkpDetail::where('id_tkp', $input['tujuan'])
            ->select('no_soal')
            ->orderBy('id', 'desc');
        $nos = $no->first();    
        
        $noSoal = 1;
        if($no->count() > 0) {
            $noSoal = $nos->no_soal + 1;    
        }
        
        foreach($soalAsal as $s) {
            $td = new TkpDetail;
            $td->id_tkp = $input['tujuan'];
            $td->no_soal = $noSoal;
            $td->soal = $s->soal;
            $td->gambar_soal = $s->gambar_soal;
            $td->jawaban_a = $s->jawaban_a;
            $td->jawaban_b = $s->jawaban_b;
            $td->jawaban_c = $s->jawaban_c;
            $td->jawaban_d = $s->jawaban_d;
            $td->jawaban_e = $s->jawaban_e;
            $td->gambar_a = $s->gambar_a;
            $td->gambar_b = $s->gambar_b;
            $td->gambar_c = $s->gambar_c;
            $td->gambar_d = $s->gambar_d;
            $td->gambar_e = $s->gambar_e;
            $td->score_a = $s->score_a;
            $td->score_b = $s->score_b;
            $td->score_c = $s->score_c;
            $td->score_d = $s->score_d;
            $td->score_e = $s->score_e;
            $td->is_active = $s->is_active;
            $td->created_at = date('Y-m-d h:i:s');
            $td->updated_at = date('Y-m-d h:i:s');
            $td->save();
            $noSoal++;
        }
        return response()->json([
            "success" => true
            ]);
    }
    
    
    public function laporan() {
        // if(! Session::has('id')) {
        //     return Redirect(route('login'));
        // }
        // $kelas = \App\Kelas::all();
        // $view = 'laporan-tryout';
        // return view('tryout.laporan', compact('view', 'kelas'));
    }
    
    
    public function export() {
        // $utama = \App\User::all();
        // $tryout = TryOut::where('is_active', 1)->get();
        // return \Excel::download(new TryoutReportExport($utama, $tryout), 'laporan_tryout.xlsx');
    }
    
    
    public function displayReport(Request $request) 
    {
        // $input = $request->all();
        // $id = $input['id'];
        
        // if(! empty($id))  {
        //     $utama = \App\User::where('id_kelas', $id)->get();
        //     $tryout = TryOut::where('is_active', 1)->where('id_kelas', $id)->get();
        // } else {
        //     $utama = \App\User::all();
        //     $tryout = TryOut::where('is_active', 1)->get();
        // }
        
        
        
        
        // $html = "";

        // $html .= '<table style="font-size:13px;width:400%;" id="tryout_laporan_table" class="table table-bordered table-striped">';
        // $html .= '<thead>';
        // $html .= '<tr>';
        // $html .= '<th style="vertical-align:middle" rowspan="2" width="5%">ID</th>';
        // $html .= '<th style="vertical-align:middle" rowspan="2" width="50">Username</th>';
        // $html .= '<th style="vertical-align:middle" rowspan="2"><span style="white-space:nowrap;">Nama_Peserta</span></th>';
        // foreach($tryout as $t) {
        //     $detail = \App\TryoutDetail::where('id_tryout', $t->id)->get(); 
        //     foreach($detail as $d) {
        //     $html .= '<th width="1%">'.$d->no_soal.'</th>';
            
        //     }
        // }
        
        // $html .= '</tr>';
        // $html .= '<tr>';
        
        // foreach($tryout as $t){
        
        // $detail = \App\TryoutDetail::where('id_tryout', $t->id)->get();
        // foreach($detail as $d)  { 
        // $html .= '<th width="1%">'.$t->short_name.'</th>';
        // }
        // }
        // $html .= '</tr>';
        
        // $html .= '</thead>';
        // $html .= '<tbody>';
        // foreach($utama as $key){
        // $html .= '<tr>';
        // $html .= '<td>'.$key->id.'</td>';
        // $html .= '<td>'.$key->email.'</td>';
        // $html .= '<td>'.$key->name.'</td>';
        // foreach($tryout as $t){
        
        // $detail = \App\TryoutDetail::where('id_tryout', $t->id)->get();
        // foreach($detail as $d)  { 
        // $ans = \App\TryoutAnswer::where('id_soal', $d->id)->where('id_user', $key->id)->get();
        // if($ans->count() > 0) { 
        // if($ans[0]->hasil_jawaban == 'benar') {
        // $html .= '<td style="background-color:green;color:white;" width="1%"><center>1</center></td>';
        // } else {
        // $html .= '<td width="1%"><center>0</center></td>';
        // } 
        
        // } else  { 
        // $html .='<td width="1%"><center>0</center></td>';
        // }    
        // }
        // }
        // $html .= '</tr>';
        // }
        // $html .= '</tbody>';
        
        // $html .= '</table>';
        
        // return $html;
    }
    
    
    public function kelasByTkp($id) {
        $data = Tkp::findorFail($id);
        $kelas = $data->id_kelas;
        return explode(",", $kelas);
    } 
    
    public function generateNomor(Request $request)
    {
        $input = $request->all();
        $query = TkpDetail::where('id_tkp', $input['idtkp'])->max('no_soal');
        return $query + 1;
    }
    
    
    
}
