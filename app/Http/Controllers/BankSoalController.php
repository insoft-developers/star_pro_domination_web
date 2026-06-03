<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\BankSoal;
use App\BankSoalDetail;
use App\BankSoalSession;
use App\BankSoalAnswer;
use App\User;

class BankSoalController extends Controller
{
    public function bankSoalAnswerList(Request $request) {
       $input = $request->all();
       $session = BankSoalSession::findorFail($input['id_session']);
       
       $details = BankSoalDetail::where('id_bank_soal', $session->id_bank_soal)->get();
       
       $rows = [];
       
       foreach($details as $index => $detail) {
           $row['index'] = $index;
           $row['id'] = $detail->id;
           $row['no_soal'] = $detail->no_soal;
           
           $jawaban = BankSoalAnswer::where('id_session', $input['id_session'])->where('id_soal', $detail->id);
           if($jawaban->count() > 0) {
               $row['status'] = 1;
           } else {
               $row['status'] = 0;
           }
           
           array_push($rows, $row);
       }
       
       return response()->json([
            "success" => true,
            "data" => $rows
       ]);
   }
    
    public function bankSoalHasil(Request $request) {
       $input = $request->all();
       $query = BankSoalAnswer::where('id_session', $input['id_session'])
                ->orderBy('id', 'asc')
                ->get();
       
       $session = BankSoalSession::findorFail($input['id_session']);
       $id_tryout = $session->id_bank_soal;
       $id_user = $session->id_user;
       $tanggal_tryout = date('d-m-Y H:i:s', strtotime($session->created_at));
       
       $user = User::findorFail($id_user);
       
       $total_soal = BankSoalDetail::where('id_bank_soal', $id_tryout)
                ->get()->count();
       
       
       $tryout = BankSoal::findorFail($id_tryout);
       $waktu = 120;
       $judul = $tryout->judul;
       $target = $tryout->target_score;
       
       $rows = [];
       $totalscore = 0;
       $dijawab = 0;
       $benar = 0;
       $salah = 0;
       $waktu_selesai = 0;
       
       foreach($query  as $index => $d) {
           $totalscore = $totalscore + $d->score;
           
           
           if($index == 0) {
               $lama = $d->waktu_selesai;
           } else {
               $lama = $d->waktu_selesai - $query[$index - 1]->waktu_selesai;
           }
           
           if($d->status_jawaban == 1) {
               $dijawab++;
           }
           
           if($d->hasil_jawaban == 'benar') {
               $benar++;
           } else {
               $salah++;
           }
           
           $waktu_selesai = $waktu_selesai + $lama;
           
           $row['id'] = $d->id;
           $row['id_session'] = $d->id_session;
           $row['id_user'] = $d->id_user;
           $row['id_soal'] = $d->id_soal;
           $row['no_soal'] = $d->no_soal;
           $row['jawaban_user'] = $d->jawaban_user;
           $row['waktu_selesai'] = $d->waktu_selesai;
           $row['status_jawaban'] = $d->status_jawaban;
           $row['hasil_jawaban'] = $d->hasil_jawaban;
           $row['score'] = $d->score;
           $row['created_at'] = $d->created_at;
           $row['updated_at'] = $d->updated_at;
           $row['lama_pengerjaan'] = $lama;
           
           array_push($rows, $row);
       }
       
       if($totalscore >= $target) {
           $kesimpulan = 'Lulus';
       } else {
           $kesimpulan = 'Tidak Lulus';
       }
       
       if($query) {
           return response()->json([
               "success" => true,
               "answer" =>$rows,
               "user" => $user->name,
               "judul" => $judul,
               "hasil" => $kesimpulan,
               "tanggal" => $tanggal_tryout,
               "benar" => $benar,
               "salah" => $salah,
               "score" => $totalscore,
               "target" => $target,
               "soal" => $total_soal,
               "lewat" => $total_soal - $benar - $salah,
               "dijawab" => $dijawab,
               "lama" => $waktu_selesai
           ]);
       }
      
    }
   
   
    public function bankSoalAnswer(Request $request) {
        $input = $request->all();
       
       
        $bank_soal_id = $input['id_soal'] ; 
        $soal = BankSoalDetail::findorFail($input['id_soal']);
        if($soal->kunci_jawaban == $input['jawaban_user']) {
            $hasil_jawaban = 'benar';
            $score = $soal->score;
        } else {
            $hasil_jawaban = 'salah';
            $score = 0;
        }

        $jwb = BankSoalAnswer::where('id_user', $input['id_user'])
        ->where('id_session', $input['id_session'])
        ->min('waktu_selesai');
        
        $sesi = BankSoalSession::findorFail($input['id_session']);
        $id_bank_soal = $sesi->id_bank_soal;
        
        $bank_soal = BankSoal::findorFail($id_bank_soal);
        $waktu = 120;
        
        if(empty($jwb)) {
            $lama = $waktu - $input['waktu_selesai'];
        } else {
            $lama = $jwb - $input['waktu_selesai'];
        }
       
       
       $jawaban = BankSoalAnswer::where('id_session', $input['id_session'])
                    ->where('id_soal', $input['id_soal']);
       $jawaban_list = $jawaban->get();
       if($jawaban_list->count() > 0){
           $jawaban->delete();
       }
       
       $answer = new BankSoalAnswer;
       $answer->id_session = $input['id_session'];
       $answer->id_user = $input['id_user'];
       $answer->id_soal = $input['id_soal'];
       $answer->no_soal = $input['no_soal'];
       $answer->jawaban_user = $input['jawaban_user'];
       $answer->waktu_selesai = $input['waktu_selesai'];
       $answer->status_jawaban = 1;
       $answer->hasil_jawaban = $hasil_jawaban;
       $answer->score = $score;
       $query = $answer->save();
       if($query) {
           return response()->json([
               "success" => true,
               "message" => 'success'
               ]);
       }
       else{
           return response()->json([
               "success" => false,
               "message" => 'failed'
               ]);
       }
    }
    
    
    
    public function checkAnswer(Request $request) {
       $input = $request->all();
       $id_soal = $input['id_soal'];
       $id_session = $input['id_session'];
       
       $jawaban = BankSoalAnswer::where('id_soal', $id_soal)
                    ->where('id_session', $id_session)
                    ->first();
       if($jawaban) {
            return response()->json([
               "success" => true,
               "message" => $jawaban->jawaban_user
            ]);
       } else {
            return response()->json([
               "success" => true,
               "message" => 'no-answer'
            ]);
       }                   
    }
    
       
    public function detail($id) {
       
           
       $rows = [];
       $query = BankSoalDetail::where('id_bank_soal', $id)->get();
       foreach($query as $key) {
           
           $row['id'] = $key->id;
           $row['id_tryout'] = $key->id_tryout;
           $row['no_soal'] = $key->no_soal;
           $row['soal'] = $key->soal;
           $row['gambar_soal'] = $key->gambar_soal;
           $row['soal_bawah'] = $key->soal_bawah;
           $row['jawaban_a'] = $key->jawaban_a;
           $row['gambar_a'] = $key->gambar_a;
           $row['jawaban_b'] = $key->jawaban_b;
           $row['gambar_b'] = $key->gambar_b;
           $row['jawaban_c'] = $key->jawaban_c;
           $row['gambar_c'] = $key->gambar_c;
           $row['jawaban_d'] = $key->jawaban_d;
           $row['gambar_d'] = $key->gambar_d;
           $row['jawaban_e'] = $key->jawaban_e;
           $row['gambar_e'] = $key->gambar_e;
           $row['kunci_jawaban'] = $key->kunci_jawaban;
           $row['score'] = $key->score;
           $row['is_active'] = $key->is_active;
           $row['created_at'] = $key->created_at;
           $row['updated_at'] = $key->updated_at;
           
           array_push($rows, $row);
       }
       
       
       return response()->json([
           "success" => true,
           "data" => $rows
       ]);
   }
   
    
    public function addSession(Request $request) {
        $input = $request->all();
        $query = BankSoalSession::create([
                "id_bank_soal" => $input['id_bank_soal'],
                "id_user" => $input['id_user']
            ]);
            
        if($query) {
            return response()->json([
                "success" => true,
                "data" => $query->id
                
            ]);
        }    
    }   
    
    
    public function index(Request $request) {
        $input = $request->all();
        $rows = [];
        $query = BankSoal::where('id_kategori', $input['id_kategori'])->where('is_active', 1)->get();
        foreach($query as $key)  {
            
            $detail = BankSoalDetail::where('id_bank_soal', $key->id)->get();
            
            $row['id'] = $key->id;
            $row['judul'] = $key->judul;
            $row['id_kelas'] = $key->id_kelas;
            $row['id_kategori'] = $key->id_kategori;
            $row['is_active'] = $key->is_active;
            $row['is_skipped'] = $key->is_skipped;
            $row['is_repeted'] = $key->is_repeated;
            $row['target_score'] = $key->target_score;
            $row['created_at'] = $key->created_at;
            $row['updated_at'] = $key->update_at;
            $row['jumlah_soal'] = $detail->count();
            $row['time_limit'] = 'No time limit';
            $row['warna_soal'] = $key->warna_soal;
            $row['warna_tulisan'] = $key->warna_tulisan;
            $row['warna_jawaban'] = $key->warna_jawaban;
            $row['warna_tulisan_jawaban'] = $key->warna_tulisan_jawaban;
            
            array_push($rows, $row);
            
        }
        
        
        if($query) {
            return response()->json([
               "success" => true,
               "data" => $rows
            ]);
        } else {
            return response()->json([
               "success" => false,
               "data" => []
            ]);
        }
        
    } 
    
    
    
}
