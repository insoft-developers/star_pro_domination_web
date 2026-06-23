<?php

namespace App\Http\Controllers;

use App\Tka;
use App\TkaAnswer;
use App\TkaSession;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TkaSessionController extends Controller
{


    public function table()
    {
        $row = Tka::query();
        return DataTables::of($row)
            ->addColumn('judul', function ($row) {
                return '<div style="width:160px;">' . $row->judul . '</div>';
            })
            ->addColumn('kelas', function ($row) {
                $html = '';
                if ($row->tkaKelas && $row->tkaKelas->count() > 0) {
                    $html .= '<ul>';
                    foreach ($row->tkaKelas as $rt) {
                        $html .= '<li>' . $rt->kelas->nama_kelas ?? '' . '</li>';
                    }
                    $html .= '</ul>';
                }
                return '<div style="white-space:normal;width:130px;">' . $html . '</div>';
            })

            ->addColumn('active', function ($row) {
                return $row->is_active == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Not Active</span>';
            })

            ->addColumn('target_score', function ($row) {
                return  $row->target_score ?? '0';
            })

            ->addColumn('frequency', function ($row) {
                return $row->session->count() ?? 0;
            })

            ->addColumn('date', function ($row) {
                return  date('d-m-Y H:i:s', strtotime($row->created_at));
            })



            ->addColumn('action', function ($row) {
                return '<center><a href="' . url('/tka_session/' . $row->id) . '" style="width:25px;margin-bottom:5px;" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-list"></i></a></center>';
            })->rawColumns(['action', 'kelas', 'active', 'judul'])
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $view = 'tka-session';
        return view('tka.tka_session_page', compact('view'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $view = 'tka-session-detail';
        $tka = Tka::find($id);
        return view('tka.tka_session_detail_page', compact('view', 'tka'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function detailTable(Request $request)
    {
        $row = TkaSession::where('tka_id', $request->filter_id);
        return DataTables::of($row)
            ->addColumn('judul', function ($row) {
                return optional($row->tka)->judul ?? '';
            })
            ->addColumn('siswa', function ($row) {

                return optional($row->user)->name ?? '';
            })
            ->addColumn('nis', function ($row) {
                return optional($row->user)->nis ?? '';
            })
            ->addColumn('sekolah', function ($row) {
                return optional($row->user)->sekolah->school_name ?? '';
            })
            ->addColumn('telp', function ($row) {
                return optional($row->user)->phone ?? '';
            })
            ->addColumn('kelas', function ($row) {
                return optional($row->user)->kelas->nama_kelas ?? '';
            })

            ->addColumn('score', function ($row) {
                return optional($row->answer)->sum('score');
            })
            ->addColumn('target', function ($row) {
                return optional($row->tka)->target_score ?? 0;
            })
            ->addColumn('resume', function ($row) {
                $score_siswa = optional($row->answer)->sum('score') ?? 0;
                $target_score =  optional($row->tka)->target_score ?? 0;
                if ($score_siswa >= $target_score) {
                    return 'LULUS';
                } else {
                    return 'TIDAK LULUS';
                }
            })
            ->addColumn('date', function ($row) {
                return date('d-m-Y H:i', strtotime($row->created_at));
            })


            ->addColumn('detail', function ($row) {
                $button = '';
                $button .= '<center>';
                $button .= '<a onclick="listData(' . $row->id . ')" style="width:25px;" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-list"></i></a>';
                $button .= '<br>';
                $button .= '<a onclick="deleteDataSession(' . $row->id . ')" style="width:25px;margin-top:5px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a>';
                $button .= '</center>';
                return $button;
            })->rawColumns(['detail'])
            ->make(true);
    }

    public function showDetail(Request $request)
    {
        $input = $request->all();
        $id = $input['id'];

        $answer = TkaAnswer::with('details')->where('session_id', $id)->orderBy('id')->get();
        $ht = '';
        $ht .= '<table class="table table-bordered table-striped">';
        $ht .= '<thead>';
        $ht .= '<tr><th>No Soal</th><th>Jawaban Siswa</th><th>Kunci Jawaban</th><th>Waktu</th><th>Hasil</th><th>Score</th></tr>';
        $ht .= '</thead>';
        foreach ($answer as $index => $key) {

            if ($index == 0) {
                $selisih = $key->init_time - $answer[$index]->waktu_selesai;
            } else {
                $selisih = $answer[$index - 1]->waktu_selesai - $answer[$index]->waktu_selesai;
            }

            $ht .= '<tr><td>' . $key->no_soal . '</td><td>' . strtoupper($key->jawaban_user) . '</td><td><center>' . strtoupper(optional($key->details)->kunci_jawaban) . '</center></td><td style="text-align:right";>' . $selisih . ' detik</td><td><center>' . strtoupper($key->hasil_jawaban) . '</center></td><td style="text-align:right;">' . $key->score . '</td></tr>';
        }
        $ht .= '</table>';
        return $ht;
    }

    public function sessionDelete(String $id)
    {
        TkaAnswer::where('session_id', $id)->delete();
        return TkaSession::destroy($id);

        
    }
}
