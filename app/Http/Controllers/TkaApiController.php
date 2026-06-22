<?php

namespace App\Http\Controllers;

use App\Tka;
use App\TkaAnswer;
use App\TkaDetail;
use App\TkaSession;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TkaApiController extends Controller
{
    public function tkaList(Request $request)
    {
        $input = $request->all();

        $user = User::find($input['userid']);

        $data = Tka::with(['tkaKelas', 'details'])->where('is_active', 1)
            ->whereHas('tkaKelas', function ($query) use ($user) {
                $query->where('id_kelas', $user->id_kelas);
            })->get();

        return response()->json([
            "success" => true,
            "data" => $data
        ]);
    }


    public function tkaDetailList(Request $request)
    {
        $input = $request->all();

        $data = TkaDetail::where('is_active', 1)->where('tka_id', $input['id'])->get();
        return response()->json([
            "success" => true,
            "data" => $data
        ]);
    }

    public function createSession(Request $request)
    {
        $input = $request->all();
        $query = TkaSession::create([
            "tka_id" => $input['tka_id'],
            "user_id" => $input['user_id']
        ]);

        if ($query) {
            return response()->json([
                "success" => true,
                "data" => $query->id

            ]);
        }
    }


    public function makeAnswer(Request $request)
    {
        $input = $request->all();

        $soal = TkaDetail::find($input['id']);
        if ($soal->kunci_jawaban == $input['jawaban_user']) {
            $hasil_jawaban = 'benar';
            $score = $soal->score;
        } else {
            $hasil_jawaban = 'salah';
            $score = 0;
        }

        $jwb = TkaAnswer::where('user_id', $input['user_id'])
            ->where('session_id', $input['session_id'])
            ->min('waktu_selesai');

        $sesi = TkaSession::find($input['session_id']);

        $tka = Tka::find($sesi->tka_id);
        $waktu = $tka->time_limit;

        if (empty($jwb)) {
            $lama = $waktu - $input['waktu_selesai'];
        } else {
            $lama = $jwb - $input['waktu_selesai'];
        }


        $jawaban = TkaAnswer::where('session_id', $input['session_id'])
            ->where('soal_id', $input['soal_id']);
        $jawaban_list = $jawaban->get();
        if ($jawaban_list->count() > 0) {
            $jawaban->delete();
        }

        $answer = new TkaAnswer();
        $answer->session_id = $input['session_id'];
        $answer->user_id = $input['user_id'];
        $answer->soal_id = $input['soal_id'];
        $answer->no_soal = $input['no_soal'];
        $answer->jawaban_user = $input['jawaban_user'];
        $answer->waktu_selesai = $input['waktu_selesai'];
        $answer->status_jawaban = 1;
        $answer->hasil_jawaban = $hasil_jawaban;
        $answer->score = $score;
        $query = $answer->save();
        if ($query) {
            return response()->json([
                "success" => true,
                "message" => 'success'
            ]);
        } else {
            return response()->json([
                "success" => false,
                "message" => 'failed'
            ]);
        }
    }

    public function hasil(Request $request)
    {
        $input = $request->all();
        $query = TkaAnswer::where('session_id', $input['session_id'])
            ->orderBy('id', 'asc')
            ->get();

        $session = TkaSession::find($input['session_id']);
        $tka_id = $session->tka_id;
        $user_id = $session->user_id;
        $tanggal_tka = date('d-m-Y H:i:s', strtotime($session->created_at));

        $user = User::find($user_id);

        $total_soal = TkaDetail::where('tka_id', $tka_id)->where('is_active', 1)
            ->get()->count();


        $tka = Tka::find($tka_id);
        $waktu = $tka->time_limit;
        $judul = $tka->judul;
        $target = $tka->target_score;

        $rows = [];
        $totalscore = 0;
        $dijawab = 0;
        $benar = 0;
        $salah = 0;
        $waktu_selesai = 0;

        foreach ($query  as $index => $d) {
            $totalscore = $totalscore + $d->score;


            if ($index == 0) {
                $lama = $waktu - $d->waktu_selesai;
            } else {
                $lama = $query[$index - 1]->waktu_selesai - $d->waktu_selesai;
            }

            if ($d->status_jawaban == 1) {
                $dijawab++;
            }

            if ($d->hasil_jawaban == 'benar') {
                $benar++;
            } else {
                $salah++;
            }

            $waktu_selesai = $waktu_selesai + $lama;

            $row['id'] = $d->id;
            $row['session_id'] = $d->id_session;
            $row['user_id'] = $d->user_id;
            $row['soal_id'] = $d->soal_id;
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

        if ($totalscore >= $target) {
            $kesimpulan = 'Lulus';
        } else {
            $kesimpulan = 'Tidak Lulus';
        }

        if ($query) {
            return response()->json([
                "success" => true,
                "answer" => $rows,
                "user" => $user->name,
                "judul" => $judul,
                "hasil" => $kesimpulan,
                "tanggal" => $tanggal_tka,
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


    public function checkAnswer(Request $request)
    {
        $input = $request->all();
        $soal_id = $input['soal_id'];
        $session_id = $input['session_id'];

        $jawaban = TkaAnswer::where('soal_id', $soal_id)
            ->where('session_id', $session_id)
            ->first();
        if ($jawaban) {
            return response()->json([
                "success" => true,
                "message" => $jawaban->jawaban_user
            ]);
        } else {
            return response()->json([
                "success" => true,
                "message" => 'no answer'
            ]);
        }
    }


    public function answerList(Request $request)
    {
        $input = $request->all();
        $session = TkaSession::findorFail($input['session_id']);

        $details = TkaDetail::where('tka_id', $session->tka_id)->get();

        $rows = [];

        foreach ($details as $index => $detail) {
            $row['index'] = $index;
            $row['id'] = $detail->id;
            $row['no_soal'] = $detail->no_soal;

            $jawaban = TkaAnswer::where('session_id', $input['session_id'])->where('soal_id', $detail->id);
            if ($jawaban->count() > 0) {
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
}
