<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use App\BankSoal;
use App\BankSoalSession;
use App\BankSoalAnswer;
use App\BankSoalDetail;
use App\Kelas;
use App\User;
use Session;
use DB;

class WebBankSessionController extends Controller
{
    public function index() 
    {
        if(! Session::has('id')) {
            return Redirect(route('login'));
        }
        $view = 'banksoal-session';
        return view('banksoal.session', compact('view'));
    }
    
    public function ikutBankSoal($id)
    {
        $view = 'banksoal-exam';
        $banksoal = BankSoal::findorFail($id);
        return view('banksoal.exam', compact('view','banksoal'));    
    }
    
    public function bankSoalSessionTable()
    {
        $banksoal = BankSoal::all();
        return Datatables::of($banksoal)
             ->addColumn('id_kelas', function($banksoal){
               $kelasString = $banksoal->id_kelas;
               $kelasArray = explode(",", $kelasString);
               
               $html = "";
               $html .= "<ul>";
               for($i=0; $i < count($kelasArray); $i++) 
               {
                   $id = (int)$kelasArray[$i]; 
                   $kelas = Kelas::findorFail($id);
                   $html .= '<li>'.$kelas->nama_kelas.'</li>';
               }
               $html .= "</ul>";
               
               return '<div>'.$html.'</div>';
           })
            ->addColumn('freq', function($banksoal){
                $fr = BankSoalSession::where('id_bank_soal', $banksoal->id);
                return '<div style="text-align:right;">'.$fr->count().'</div>';
            })
            ->addColumn('is_active', function($banksoal){
               if($banksoal->is_active == 1) {
                   return '<center><span class="label label-success">Active</span></center>';
               }
               else {
                   return '<center><span class="label label-danger">Inactive</span></center>';
               }
            })
            ->addColumn('target_score', function($banksoal){
                return '<div style="text-align:right;">'.$banksoal->target_score.'</div>';
            })
            ->addColumn('created_at', function($banksoal) {
               return '<center>'.date('d-m-Y', strtotime($banksoal->created_at)).'</center>';
            })
            ->addColumn('action', function($banksoal){
                return '<center><a onclick="listData('. $banksoal->id.')" style="width:25px;margin-right:5px;" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-list"></i></a></center>';
        })->rawColumns(['created_at','target_score','freq','id_kelas','is_active','action'])
        ->make(true);
    }
    
    
    public function bankSoalExamTable($id)
    {
        
        $exam = BankSoalSession::where('id_bank_soal', $id)->get();
        return Datatables::of($exam)
         ->addColumn('judul', function($exam){
                $tr = BankSoal::findorFail($exam->id_bank_soal);
                return '<div>'.$tr->judul.'</div>';  
         })
         
         ->addColumn('id_user', function($exam){
             $user = User::findorFail($exam->id_user);
             return '<div>'.$user->name.'</div>';
         })
          ->addColumn('nis', function($exam){
             $user = User::findorFail($exam->id_user);
             return '<div>'.$user->nis.'</div>';
         })
          ->addColumn('phone', function($exam){
             $user = User::findorFail($exam->id_user);
             return '<div>'.$user->phone.'</div>';
         })
          ->addColumn('school_id', function($exam){
             $user = DB::table('users')
                    ->select('users.id', 'schools.school_name')
                    ->where('users.id', $exam->id_user)
                    ->join('schools', 'schools.id', '=', 'users.school_id')
                    ->first();
             
             
             return '<div>'.$user->school_name.'</div>';
         })
         ->addColumn('id_kelas', function($exam){
             $user = User::findorFail($exam->id_user);
             $kelas = Kelas::findorFail($user->id_kelas);
             return '<div>'.$kelas->nama_kelas.'</div>';
         })
         ->addColumn('score', function($exam){
             $sc = BankSoalAnswer::where('id_session', $exam->id)->sum('score');
             return '<div style="text-align:right;">'.$sc.'</div>';
         })
         ->addColumn('target', function($exam){
             $tr = BankSoal::findorFail($exam->id_bank_soal);
             return '<div style="text-align:right;">'.$tr->target_score.'</div>';
         })
         ->addColumn('resume', function($exam){
             $tg = BankSoalAnswer::where('id_session', $exam->id)->sum('score');
             $tr = BankSOal::findorFail($exam->id_bank_soal);
             $sc = $tr->target_score;
             if($tg >= $sc) {
                 return '<div>LULUS</div>'; 
             } else {
                 return '<div>TIDAK LULUS</div>';
             }
             
             
         })
         ->addColumn('created_at', function($exam){
            return '<center>'.date('d-m-Y', strtotime($exam->created_at)).'</center>';    
         })
         ->addColumn('detail', function($exam){
                return '<center><a onclick="listData('. $exam->id.')" style="width:25px;margin-right:5px;" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-list"></i></a></center>';
        })->rawColumns(['created_at','target','resume','score','id_kelas','id_user','judul','detail','nis','phone', 'school_id'])
        ->make(true);
    }
    
    public function detailExam($id) 
    {
        $answer = BankSoalAnswer::where('id_session', $id)->orderBy('id')->get();
        $ht ='';
        $ht .= '<table class="table table-bordered table-striped">';
        $ht .= '<thead>';
        $ht .= '<tr><th>No Soal</th><th>Jawaban Siswa</th><th>Kunci Jawaban</th><th>Hasil</th><th>Score</th></tr>';
        $ht .= '</thead>';
        foreach($answer as $index => $key) {
            
            $detail = \App\BankSoalDetail::findorFail($key->id_soal);   
            
            $ht .= '<tr><td>'.$key->no_soal.'</td><td>'.strtoupper($key->jawaban_user).'</td><td>'.strtoupper($detail->kunci_jawaban).'</td><td><center>'.strtoupper($key->hasil_jawaban).'</center></td><td style="text-align:right;">'.$key->score.'</td></tr>';
        }
        $ht .= '</table>';
        return $ht;
    }
}
