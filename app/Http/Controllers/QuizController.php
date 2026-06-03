<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Quiz;
use App\QuizSession;
use App\QuizAnswer;
use App\Setting;
use App\QuizHeader;
use App\User;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
    public function list($id) {

        $list = Quiz::where('id_quiz', $id)->get();
        
        return response()->json([
            'success' => true,
            'message' => 'List Quiz',
            'data' => $list
        ]);

    }
    
    
    public function quizList(Request $request)
    {
        $input = $request->all();
        $kuis = QuizHeader::where('is_active', 1)
                ->orderBy('urutan', 'asc')
                ->get();
        
        $rows = [];
        foreach($kuis as $k) {
            $kelas = explode(",", $k->id_kelas);
            $cek = array_search((string)$input['id_kelas'], $kelas, true);
            
            if($cek !== false) {
                $row['id'] = $k->id;
                $row['judul'] = $k->judul;
                $row['id_kelas'] = $k->id_kelas;
                $row['waktu_kuis'] = $k->waktu_kuis;
                $row['target_score'] = $k->target_score;
                $row['created_at'] = $k->created_at;
                $row['updated_at'] = $k->updated_at;
                $row['is_active'] = $k->is_active;
                $row['short_name'] = $k->short_name;
                $row['warna_soal'] = $k->warna_soal;
                $row['warna_tulisan_soal'] = $k->warna_tulisan_soal;
                $row['warna_jawaban'] = $k->warna_jawaban;
                $row['warna_tulisan_jawaban'] = $k->warna_tulisan_jawaban;
                array_push($rows, $row);
            }
            
        }
        
        
        return response()->json([
            "success" => true,
            "data" => $rows
            
            ]);
    }

    
    public function detail($id) {
        $detail = QuizAnswer::where('id_quiz', $id)
        ->orderBy('id_soal')->get();
        return response()->json([
                "success" => true,
                "data" => $detail,
                "message" => 'List Answer'
            
            ]);
    }
    
    
    public function add_session(Request $request) {
        $input = $request->all();

        $quiz = new QuizSession;
        $quiz->user_id = $input['user_id'];
        $quiz->id_quiz = $input['id_quiz'];
        $quiz->save();
        return response()->json([
           'success' => true,
           'session_quiz' => $quiz->id,
       ]);

    }


    public function quiz_answer(Request $request) {
        $input = $request->all();

        $quiz_id = $input['id_quiz'] ; 
        $soal = Quiz::findorFail($input['id_soal']);
        $no_kuis = $soal->no_kuis;
        
        $session = QuizSession::findorFail($quiz_id);
        $idkuis = $session->id_quiz;
        if($soal->kunci_jawaban == $input['jawaban_user']) {
            $hasil_jawaban = 'benar';
            $score = $soal->score;
        } else {
            $hasil_jawaban = 'salah';
            $score = 0;
        }

        $jwb = QuizAnswer::where('id_user', $input['id_user'])
        ->where('id_quiz', $quiz_id)
        ->min('waktu_selesai');
        
        $setting = QuizHeader::where('id', $idkuis)->first();
        
        $waktu = $setting->waktu_kuis;
        
        
        
        if(empty($jwb)) {
            $lama = $waktu - $input['waktu_selesai'];
        } else {
            $lama = $jwb - $input['waktu_selesai'];
        }
        
        

        $quiz = new QuizAnswer;
        $quiz->id_quiz = $quiz_id;
        $quiz->no_kuis = $no_kuis;
        $quiz->id_user = $input['id_user'];
        $quiz->id_soal = $input['id_soal'];
        $quiz->jawaban_user = $input['jawaban_user'];
        $quiz->waktu_selesai = $input['waktu_selesai'];
        $quiz->status_soal = $input['status_soal'];
        $quiz->hasil_jawaban = $hasil_jawaban;
        $quiz->lama_pengerjaan = $lama;
        $quiz->score = $score;
        $quiz->save();
        if($quiz) {
            return response()->json([
                'success' => true,
                'message' => 'sukses'
            ]);    
        } else {
            return response()->json([
                'success' => false,
                'message' => 'failed'
            ]);
        }
        
    }

    public function quiz_hasil(Request $request) {

        $input = $request->all();
       
        $idquiz = $input['id_quiz'];
        
        $sesi = QuizSession::findorFail($idquiz);        
        $idkuis = $sesi->id_quiz;
        $iduser = $sesi->user_id;
        
        $user = User::findorFail($iduser);
        
        $header = QuizHeader::where('id', $idkuis)->first();
        
        $soal = Quiz::where('id_quiz', $idkuis)->count();

        $data = DB::table('quiz_answers')
        ->where('id_quiz', $idquiz)
        
        ->get();

        $lama = DB::table('quiz_answers')
        ->where('id_quiz', $idquiz)
        
        ->sum('lama_pengerjaan');
        
        $score = DB::table('quiz_answers')
        ->where('id_quiz', $idquiz)
        
        ->sum('score');

        $benar = DB::table('quiz_answers')
        ->where('id_quiz', $idquiz)
        
        ->where('hasil_jawaban', 'benar')
        ->get(); 

        $salah = DB::table('quiz_answers')
        ->where('id_quiz', $idquiz)
        
        ->where('hasil_jawaban', 'salah')
        ->get();
        
        if($score < $header->target_score) {
            $grade = 'TIDAK LULUS';
        }
        else {
            $grade = 'LULUS';    
        }
        
        $list['judul'] = $header->judul;
        $list['benar'] = $benar->count();
        $list['salah'] = $salah->count();
        $list['lewat'] = $soal - $benar->count() - $salah->count();
        $list['total'] = $soal;
        $list['tanggal'] = date('d-m-Y H:i:s', strtotime($sesi->created_at));
        $list['lama']  = $lama;
        $list['target'] = $header->target_score;
        $list['score'] = $score;
        $list['grade'] = $grade;
        $list['nama'] = $user->name;

        if($data) {
            return response()->json([
                "success"=> true,
                "data"=> $list

            ]);
        }    
    
    }
    
    
    
    
}
