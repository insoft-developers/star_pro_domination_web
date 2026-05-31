<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use App\Quiz;
use App\Kelas;
use App\QuizHeader;
use App\QuizSession;
use App\User;
use App\QuizAnswer;
use Session;
use DB;


class ExquizController extends Controller
{
    
    public function index()
    {
        if(! Session::has('id')) {
            return Redirect(route('login'));
        }
        
        $view = 'exquiz';
        $ids = '';
        return view('quiz.exquiz', compact('view','ids'));
    }
    
    
    public function sess_quizes($id, $awal, $akhir) {
        $ids = '';
        $view = 'exquiz';
       
        $sekarang = date('Y-m-d');
        $date = strtotime($sekarang.' -1 day');
        $tanggal = date('Y-m-d 00:00:01', $date);
        
        if($awal == "0" || $akhir == "0") {
            $periode_akhir = date('Y-m-d 23:59:59');
            $periode_awal = $tanggal;
        } else {
            $periode_akhir = $akhir." 23:59:59";
            $periode_awal = $awal." 00:00:01";
        }
        $kuis = QuizSession::where('id_quiz', $id)->whereBetween('created_at', [$periode_awal, $periode_akhir])->orderBy('created_at', 'desc')->get();
        return view('quiz.session_fix', compact('view','ids', 'kuis'));
    } 

    
    public function store(Request $request)
    {
        $input = $request->all();
        Quiz::create($input);

        return response()->json([
            'success'=>true
        ]);
    }

   
    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        $quiz = Quiz::findorFail($id);
        return $quiz;
    }

  
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $kuis = Quiz::findorFail($id);
        $kuis->update($input);
        
        return response()->json([
            'success'=>true
        ]);
    }

   
    public function destroy($id)
    {
        Quiz::destroy($id);

        return response()->json([
            'success'=>true

        ]);
    }
    
    
    
    public function exquizTable()
    {
        $quiz = QuizHeader::all();
        return Datatables::of($quiz)
           ->addColumn('created_at', function($quiz){
               return '<center>'.date('d-m-Y', strtotime($quiz->created_at)).'</center>';
           })
           
           ->addColumn('id_kelas', function($quiz){
               $kelasString = $quiz->id_kelas;
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
           ->addColumn('jumlah', function($quiz){
               $i = QuizSession::where('id_quiz', $quiz->id)->get();
               return '<div style="text-align:right;">'.$i->count().'</div>';
           })
           
           ->addColumn('action', function($quiz){
                return '<center><a onclick="sessData('. $quiz->id.')" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-list"></i></a></center>';
        })->rawColumns(['jumlah','id_kelas','created_at','action'])
        ->make(true);
    
    }
    
    
    public function sess_quiz($id)
    {
        if(! Session::has('id')) {
            return Redirect(route('login'));
        }
        $view = 'exquiz';
        $ids = $id;
        return view('quiz.session', compact('view', 'ids'));
    }
    
    public function quiz_result(Request $request) 
    {
        $input = $request->all();
        $answer = QuizAnswer::where('id_quiz', $input['id'])->orderBy('id')->get();
        $ht ='';
        $ht .= '<table class="table table-bordered table-striped">';
        $ht .= '<thead>';
        $ht .= '<tr><th>No Soal</th><th>Jawaban Siswa</th><th>Kunci Jawaban</th><th>Waktu</th><th>Hasil</th><th>Score</th></tr>';
        $ht .= '</thead>';
        foreach($answer as $index => $key) {
            $detail = \App\Quiz::findorFail($key->id_soal);  
            $ht .= '<tr><td>'.$key->no_kuis.'</td><td>'.strtoupper($key->jawaban_user).'</td><td>'.strtoupper($detail->kunci_jawaban).'</td><td style="text-align:right";>'.$key->lama_pengerjaan.' detik</td><td><center>'.strtoupper($key->hasil_jawaban).'</center></td><td style="text-align:right;">'.$key->score.'</td></tr>';
        }
        $ht .= '</table>';
        return $ht;
    }
    
    
    public function countRecord(Request $request) {
        $input = $request->all();
        $id = $input['id'];
        $awal = $input['awal'];
        $akhir = $input['akhir'];
        // $tanggal_awal = strtotime($awal.' -1 day');
        $periode_awal = $awal." 00:00:01";
        $periode_akhir = $akhir." 23:59:59";
        
        $quiz = QuizSession::where('id_quiz', $id)->whereBetween('created_at', [$periode_awal, $periode_akhir])->orderBy('created_at', 'desc')->count('id');
        
        return $quiz;
    }
    
    public function sessquizTable($id, $awal, $akhir, $offset, $limit)
    {
        $sekarang = date('Y-m-d');
        $date = strtotime($sekarang.' -1 day');
        $tanggal = date('Y-m-d 00:00:01', $date);
        
        
        
        
        if($awal == "0" || $akhir == "0") {
            $periode_akhir = date('Y-m-d 23:59:59');
            $periode_awal = $tanggal;
            
        } else {
            $periode_akhir = $akhir." 23:59:59";
            $periode_awal = $awal." 00:00:01";
            
        } 
        
        
        $quiz = QuizSession::where('id_quiz', $id)->whereBetween('created_at', [$periode_awal, $periode_akhir])->orderBy('id', 'desc')->skip($offset)->take($limit)->get();
        return Datatables::of($quiz)
           ->addColumn('created_at', function($quiz){
               return '<center>'.date('d-m-Y', strtotime($quiz->created_at)).'</center>';
           })
           
           ->addColumn('judul', function($quiz){
               $judul = QuizHeader::findorFail($quiz->id_quiz);
               return '<div>'.$judul->judul.'</div>';
           })
           
           ->addColumn('siswa', function($quiz){
               $siswa = User::findorFail($quiz->user_id);
               return '<div>'.$siswa->name.'</div>';
           })
           
           ->addColumn('nis', function($quiz){
             $user = User::findorFail($quiz->user_id);
             return '<div>'.$user->nis.'</div>';
         })
          ->addColumn('phone', function($quiz){
             $user = User::findorFail($quiz->user_id);
             return '<div>'.$user->phone.'</div>';
         })
          ->addColumn('school_id', function($quiz){
             $user = DB::table('users')
                    ->select('users.id', 'schools.school_name')
                    ->where('users.id', $quiz->user_id)
                    ->join('schools', 'schools.id', '=', 'users.school_id')
                    ->first();
             
             
             return '<div>'.$user->school_name.'</div>';
         })
           
           ->addColumn('id_kelas', function($quiz){
               $siswa = User::findorFail($quiz->user_id);
               $kelas = Kelas::findorFail($siswa->id_kelas);
               return '<div>'.$kelas->nama_kelas.'</div>';
           })
           
           ->addColumn('target_score', function($quiz){
               $header = QuizHeader::findorFail($quiz->id_quiz);
               return '<div style="text-align:right;">'.$header->target_score.'</div>';
           })
           
            ->addColumn('score', function($quiz){
               $answer = QuizAnswer::where('id_quiz', $quiz->id)->sum('score');
               return '<div style="text-align:right;">'.$answer.'</div>';
           })
           
           ->addColumn('time', function($quiz){
               $answer = QuizAnswer::where('id_quiz', $quiz->id)->sum('lama_pengerjaan');
               return '<div style="text-align:right;">'.$answer.' detik</div>';
           })
           
            ->addColumn('resume', function($quiz){
              $header = QuizHeader::findorFail($quiz->id_quiz);
              $answer = QuizAnswer::where('id_quiz', $quiz->id)->sum('score');
              if($answer >= $header->target_score) {
                  return '<div>LULUS</div>';
              } else {
                  return '<div>TIDAK LULUS</div>';
              }
              
               
           })
           ->addColumn('action', function($quiz){
                return '<center><a onclick="detailData('. $quiz->id.')" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-list"></i></a></center>';
                
        })->rawColumns(['time','id_kelas','target_score','score','resume','siswa', 'judul', 'created_at','action','nis','school_id', 'phone'])
        ->make(true);
    
    }
    
    
    public function deleteSession(Request $request) {
        $input = $request->all();
        dd($input);
    }
    
    
    
    
}
