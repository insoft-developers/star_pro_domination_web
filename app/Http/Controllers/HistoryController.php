<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\QuizHeader;
use App\Quiz;
use App\QuizSession;
use App\QuizAnswer;
use App\User;
use App\Kelas;
use App\TryOut;
use App\TryoutDetail;
use App\TryoutSession;
use App\TryoutAnswer;
use App\BankSoal;
use App\BankSoalDetail;
use App\BankSoalAnswer;
use App\BankSoalSession;
use App\TryoutReport;

use App\Tkp;
use App\TkpDetail;
use App\TkpSession;
use App\TkpAnswer;

class HistoryController extends Controller
{
    public function quiz($id) {
        $session = QuizSession::where('user_id', $id)->get();
        
        $rows = [];
        foreach($session as $s) {
            $user = User::findorFail($id);
            $header = QuizHeader::findorFail($s->id_quiz);
            $kelas = Kelas::findorFail($user->id_kelas);
            
            $row['sesi'] = $s->id;
            $row['tanggal'] = date('d-m-Y', strtotime($s->created_at));
            $row['siswa'] = $user->name;
            $row['kelas'] = $kelas->nama_kelas;
            $row['judul'] = $header->judul;
            $row['waktu_kuis'] = $header->waktu_kuis;
            
            array_push($rows,$row);
        }
        
        return response()->json([
           "success" => true,
           "data" => $rows
        ]);
        
    }
    
    
    public function tkp($id) {
        $session = TkpSession::where('id_user', $id)->get();
        
        $rows = [];
        foreach($session as $s) {
            $user = User::findorFail($id);
            $header = Tkp::findorFail($s->id_tkp);
            $kelas = Kelas::findorFail($user->id_kelas);
            
            $row['sesi'] = $s->id;
            $row['tanggal'] = date('d-m-Y', strtotime($s->created_at));
            $row['siswa'] = $user->name;
            $row['kelas'] = $kelas->nama_kelas;
            $row['judul'] = $header->judul;
            $row['waktu_kuis'] = $header->time_limit;
            
            array_push($rows,$row);
        }
        
        return response()->json([
           "success" => true,
           "data" => $rows
        ]);
    }
    
    
    
    public function tryout($id) {
        $session = TryoutSession::where('id_user', $id)->get();
        
        $rows = [];
        foreach($session as $s) {
            $user = User::findorFail($id);
            $header = TryOut::findorFail($s->id_tryout);
            $kelas = Kelas::findorFail($user->id_kelas);
            
            $row['sesi'] = $s->id;
            $row['tanggal'] = date('d-m-Y', strtotime($s->created_at));
            $row['siswa'] = $user->name;
            $row['kelas'] = $kelas->nama_kelas;
            $row['judul'] = $header->judul;
            $row['waktu_kuis'] = $header->time_limit;
            
            array_push($rows,$row);
        }
        
        return response()->json([
           "success" => true,
           "data" => $rows
        ]);
    }
    
    
    public function banksoal($id) {
        $session = BankSoalSession::where('id_user', $id)->get();
        
        $rows = [];
        foreach($session as $s) {
            $user = User::findorFail($id);
            $header = BankSoal::findorFail($s->id_bank_soal);
            $kelas = Kelas::findorFail($user->id_kelas);
            
            $row['sesi'] = $s->id;
            $row['tanggal'] = date('d-m-Y', strtotime($s->created_at));
            $row['siswa'] = $user->name;
            $row['kelas'] = $kelas->nama_kelas;
            $row['judul'] = $header->judul;
            array_push($rows,$row);
        }
        
        return response()->json([
           "success" => true,
           "data" => $rows
        ]);
    }
    
    
    
    public function lapor($id) {
        $lapor = TryoutReport::where('id_user', $id)->get();
      
        $rows = [];
        foreach($lapor as $s) {
            $user = User::findorFail($id);
            $kelas = Kelas::findorFail($user->id_kelas);
            if($s->kategori == 'tryout') {
                $soal = TryoutDetail::findorFail($s->id_soal);
                $header = TryOut::findorFail($soal->id_tryout);
                $judul = "TRY OUT";
            } else {
                $soal = BankSoalDetail::findorFail($s->id_soal);
                $header = BankSoal::findorFail($soal->id_bank_soal);
                $judul = "BANK SOAL";
            }
            
            if($s->status == 0) {
                $status = "Outstanding";
                $selesai = "";
            } else if($s->status == 1) {
                $status = "Finished";
                $selesai = date('d-m-Y', strtotime($s->finish_date));
            }
            
            $row['keterangan'] = strtoupper($judul.' - '.$header->judul.' - Soal No '.$soal->no_soal);
            $row['nama'] = $user->name;
            $row['kelas'] = $kelas->nama_kelas;
            $row['laporan'] = $s->isi_laporan;
            $row['tanggal'] = date('d-m-Y', strtotime($s->created_at));
            $row['status'] = $status;
            $row['selesai'] = $selesai;
            
            
            array_push($rows,$row);
        }
        
        return response()->json([
           "success" => true,
           "data" => $rows
        ]);
    }
}
