<?php

namespace App\Http\Controllers;

use App\Kelas;
use App\Tka;
use App\TkaKelasId;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TkaController extends Controller
{


    public function table()
    {
        $row = Tka::query();
        return DataTables::of($row)
            ->addColumn('judul', function ($row) {
                return '<div style="width:160px;">'.$row->judul.'</div>';
            })
            ->addColumn('id_kelas', function ($row) {
                $html = '';
                if($row->tkaKelas && $row->tkaKelas->count() > 0) {
                    $html .= '<ul>';
                    foreach($row->tkaKelas as $rt) {
                        $html .= '<li>'.$rt->kelas->nama_kelas ?? ''.'</li>';
                    }
                    $html .= '</ul>';
                }
                return '<div style="white-space:normal;width:130px;">'.$html.'</div>';
            })

            ->addColumn('is_active', function ($row) {
                return $row->is_active == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Not Active</span>';
            })

            ->addColumn('is_repeated', function ($row) {
                 return $row->is_repeated == 1 ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-danger">No</span>';
            })

            ->addColumn('is_skipped', function ($row) {
                return  $row->is_skipped == 1 ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-danger">No</span>';
            })

            ->addColumn('time_limit', function ($row) {
                $html =  $row->time_limit  ? $row->time_limit.' menit' : 'tidak ada';
                return '<div style="white-space:wrap;width:100px;">'.$html.'</div>';
            })

            ->addColumn('target_score', function ($row) {
                return $row->target_score ?? '';
            })

            ->addColumn('jumlah_soal', function ($row) {
                return '';
            })

            ->addColumn('warna', function($row){
                $html = '';
                $html .= '<div style="padding:5px;border-radius:4px;background-color:'.$row->warna_soal.';color:'.$row->warna_tulisan.'"><center>Warna Soal</center></div>';

                return '<div style="white-space:normal;width:100px;">'.$html.'</div>';
            })

            ->addColumn('warna_jawaban', function($row){
                $html = '';
                $html .= '<div style="padding:5px;border-radius:4px;background-color:'.$row->warna_jawaban.';color:'.$row->warna_tulisan_jawaban.'"><center>Warna Jawaban</center></div>';

                return '<div style="white-space:normal;width:110px;">'.$html.'</div>';
            })


            ->addColumn('action', function ($row) {
                return '<center><a href="'.url('/tka_detail/'.$row->id).'" style="width:25px;margin-bottom:5px;" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-list"></i></a>' .
                    '<br><a onclick="copyData(' . $row->id . ')" style="margin-bottom:4px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-copy"></i></a>' .
                    '<br><a onclick="editData(' . $row->id . ')" style="width:25px;margin-bottom:5px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i></a>' .
                    '<br><a onclick="deleteData(' . $row->id . ')" style="width:25px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a></center>';
            })->rawColumns(['action','id_kelas', 'is_active', 'is_repeated', 'is_skipped', 'warna', 'warna_jawaban','judul','time_limit'])
            ->make(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $view = 'tka';
        $kelas = Kelas::all();
        return view('tka.tka_page', compact('view', 'kelas'));
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
        $input = $request->all();
        $request->validate([
            "judul" => "required",
            "id_kelas" => "required",
            "target_score" => "required",
            "is_active" => "required",
            "is_repeated" => "required",
            "is_skipped" => "required",
            "warna_soal" => "required",
            "warna_tulisan" => "required",
            "warna_jawaban" => "required",
            "warna_tulisan_jawaban" => "required"

        ]);

        try {

            $kelas = $input['id_kelas'] ?? [];

            unset($input['id_kelas']);

            $tkaId = Tka::create($input)->id;

            foreach ($kelas as $k) {
                TkaKelasId::create([
                    'tka_id' => $tkaId,
                    'id_kelas' => $k
                ]);
            }
            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Tka::with('tkaKelas')->find($id);
        return $data;
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
        $input = $request->all();
        $request->validate([
            "judul" => "required",
            "id_kelas" => "required",
            "target_score" => "required",
            "is_active" => "required",
            "is_repeated" => "required",
            "is_skipped" => "required",
            "warna_soal" => "required",
            "warna_tulisan" => "required",
            "warna_jawaban" => "required",
            "warna_tulisan_jawaban" => "required"

        ]);

        try {

            $data = Tka::find($id);
            $kelas = $input['id_kelas'] ?? [];
            unset($input['id_kelas']);
            $data->update($input);

            TkaKelasId::where('tka_id', $id)->delete();
            
            foreach ($kelas as $k) {
                TkaKelasId::create([
                    'tka_id' => $id,
                    'id_kelas' => $k
                ]);
            }
            return response()->json([
                'success' => true
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "message" => $e->getMessage()
            ]);
        }
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
}
