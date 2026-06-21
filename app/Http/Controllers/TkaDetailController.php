<?php

namespace App\Http\Controllers;

use App\Tka;
use App\TkaDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class TkaDetailController extends Controller
{


    public function table(Request $request)
    {
        $row = TkaDetail::where('tka_id', $request->filter_id);
        return DataTables::of($row)
            ->addColumn('no_soal', function ($row) {
                return $row->no_soal ?? '';
            })
            ->addColumn('model', function ($row) {
                $model = '';
                if ($row->question_model == '1') {
                    $model = 'Pilihan Ganda Biasa';
                } else if ($row->question_model == '2') {
                    $model = 'Multiple Pilihan Jawaban';
                } else if ($row->question_model == '3') {
                    $model = 'Pilihan Benar Salah';
                } else if ($row->question_model == '4') {
                    $model = 'Isian Singkat';
                }
                return $model;
            })
            ->addColumn('soal', function ($row) {
                $html = '';
                $html .= $row->soal;
                return '<div style="white-space:normal;width:200px;">' . $html . '</div>';
            })
            ->addColumn('gambar_soal', function ($row) {
                $html = '';
                if ($row->gambar_soal) {
                    $html .=  '<a href="' . asset('images/question/') . '/' . $row->gambar_soal . '" target="_blank"><img style="width:60px;" class="img-responsive" src="' . asset('images/question/') . '/' . $row->gambar_soal . '"></a><small onclick="deleteImage(' . $row->id . ', 0)" style="color:red;cursor:pointer;"><i class="fa fa-trash"></i> Delete</small>';
                }
                return $html;
            })
            ->addColumn('soal_bawah', function ($row) {
                $html = '';
                $html .= $row->soal_bawah;
                return '<div style="white-space:normal;width:200px;">' . $html . '</div>';
            })
            ->addColumn('jawaban_a', function ($row) {
                $html = '';
                $html .= $row->jawaban_a;
                if (! empty($row->gambar_a)) {
                    $html .= '<a href="' . asset('images/question/') . '/' . $row->gambar_a . '" target="_blank"><img style="width:50px;" class="img-responsive" src="' . asset('images/question/') . '/' . $row->gambar_a . '"></a><small onclick="deleteImage(' . $row->id . ', 1)" style="color:red;cursor:pointer;"><i class="fa fa-trash"></i> Delete</small>';
                }
                return '<div style="white-space:normal;width:200px;">' . $html . '</div>';
            })
            ->addColumn('jawaban_b', function ($row) {
                $html = '';
                $html .= $row->jawaban_b;
                if (! empty($row->gambar_b)) {
                    $html .= '<a href="' . asset('images/question/') . '/' . $row->gambar_b . '" target="_blank"><img style="width:50px;" class="img-responsive" src="' . asset('images/question/') . '/' . $row->gambar_b . '"></a><small onclick="deleteImage(' . $row->id . ', 2)" style="color:red;cursor:pointer;"><i class="fa fa-trash"></i> Delete</small>';
                }
                return '<div style="white-space:normal;width:200px;">' . $html . '</div>';
            })
            ->addColumn('jawaban_c', function ($row) {
                $html = '';
                $html .= $row->jawaban_c;
                if (! empty($row->gambar_c)) {
                    $html .= '<a href="' . asset('images/question/') . '/' . $row->gambar_c . '" target="_blank"><img style="width:50px;" class="img-responsive" src="' . asset('images/question/') . '/' . $row->gambar_c . '"></a><small onclick="deleteImage(' . $row->id . ', 3)" style="color:red;cursor:pointer;"><i class="fa fa-trash"></i> Delete</small>';
                }
                return '<div style="white-space:normal;width:200px;">' . $html . '</div>';
            })
            ->addColumn('jawaban_d', function ($row) {
                $html = '';
                $html .= $row->jawaban_d;
                if (! empty($row->gambar_d)) {
                    $html .= '<a href="' . asset('images/question/') . '/' . $row->gambar_d . '" target="_blank"><img style="width:50px;" class="img-responsive" src="' . asset('images/question/') . '/' . $row->gambar_d . '"></a><small onclick="deleteImage(' . $row->id . ', 4)" style="color:red;cursor:pointer;"><i class="fa fa-trash"></i> Delete</small>';
                }
                return '<div style="white-space:normal;width:200px;">' . $html . '</div>';
            })
            ->addColumn('jawaban_e', function ($row) {
                $html = '';
                $html .= $row->jawaban_e;
                if (! empty($row->gambar_e)) {
                    $html .= '<a href="' . asset('images/question/') . '/' . $row->gambar_e . '" target="_blank"><img style="width:50px;" class="img-responsive" src="' . asset('images/question/') . '/' . $row->gambar_e . '"></a><small onclick="deleteImage(' . $row->id . ', 5)" style="color:red;cursor:pointer;"><i class="fa fa-trash"></i> Delete</small>';
                }
                return '<div style="white-space:normal;width:200px;">' . $html . '</div>';
            })
            ->addColumn('kunci_jawaban', function ($row) {
                $html = '';
                if ($row->question_model == '1') {
                    $html .= strtoupper($row->kunci_jawaban);
                } else if ($row->question_model == '2' || $row->question_model == '4') {
                    if (! empty($row->kunci_jawaban)) {
                        $kunci = explode("|", $row->kunci_jawaban);
                        $html .= '<ul>';
                        foreach ($kunci as $k) {
                            $html .= '<li>' . strtoupper($k) . '</li>';
                        }
                        $html .= '</ul>';
                    }
                } else if ($row->question_model == '3') {
                    if (! empty($row->kunci_jawaban)) {
                        $kunci = explode("|", $row->kunci_jawaban);
                        $html .= '<ul>';
                        foreach ($kunci as $k) {
                            $ks = explode("_", $k);
                            $status = '';
                            if ($ks[1] == '1') {
                                $status = 'Benar';
                            } else {
                                $status = 'Salah';
                            }
                            $html .= '<li>' . strtoupper($ks[0]) . ' - ' . strtoupper($status) . '</li>';
                        }
                        $html .= '</ul>';
                    }
                }

                return $html;
            })
            ->addColumn('score', function ($row) {
                return $row->score;
            })

            ->addColumn('is_active', function ($row) {
                return $row->is_active == 1 ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">Not Active</span>';
            })



            ->addColumn('action', function ($detail) {

                $button = '';
                $button .= '<center>';
                $button .= '<a title="Lihat Soal" onclick="lihatData(' . $detail->id . ')" style="width:25px;margin-bottom:5px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-file"></i></a>';
                $button .= '<br>';
                $button .= '<a title="Edit" onclick="editData(' . $detail->id . ')" style="width:25px;margin-bottom:5px;" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-edit"></i></a>';
                $button .= '<br>';

                $button .= '<a title="Hapus" onclick="deleteData(' . $detail->id . ')" style="width:25px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i></a>';

                $button .= '</center>';

                return $button;
                   
            })->rawColumns(['action', 'is_active', 'soal', 'gambar_soal', 'soal_bawah', 'jawaban_a', 'jawaban_b', 'jawaban_c', 'jawaban_d', 'jawaban_e', 'kunci_jawaban'])
            ->make(true);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();


        $rules = [
            'question_model' => 'required',
            'soal' => 'required'
        ];

        if ($request->question_model == '1') {
            $rules['jawaban_a'] = 'required';
            $rules['jawaban_b'] = 'required';
            $rules['jawaban_c'] = 'required';
            $rules['jawaban_d'] = 'required';
            $rules['jawaban_e'] = 'required';
        }

        if ($request->question_model == '2') {
            $rules['jawaban_a'] = 'required';
            $rules['jawaban_b'] = 'required';
            $rules['jawaban_c'] = 'required';
            $rules['jawaban_d'] = 'required';
           
        }

        if ($request->question_model == '3') {
            $rules['jawaban_a'] = 'required';
            $rules['jawaban_b'] = 'required';
        }



        $validator = Validator::make($request->all(), $rules, [
            'jawaban_a.required' => 'Jawaban A wajib diisi',
            'jawaban_b.required' => 'Jawaban B wajib diisi',
            'jawaban_c.required' => 'Jawaban C wajib diisi',
            'jawaban_d.required' => 'Jawaban D wajib diisi',
            'jawaban_e.required' => 'Jawaban E wajib diisi',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ]);
        }

        $input['gambar_soal'] = null;
        $unique = uniqid();
        $nm = 'soal-' . $unique;
        if ($request->hasFile('gambar_soal')) {
            $input['gambar_soal'] = str_slug($nm, '-') . '.' . $request->gambar_soal->getClientOriginalExtension();
            $request->gambar_soal->move(public_path('/images/question'), $input['gambar_soal']);
        }


        $input['gambar_a'] = null;
        $nma = 'a-' . $unique;
        if ($request->hasFile('gambar_a')) {
            $input['gambar_a'] = str_slug($nma, '-') . '.' . $request->gambar_a->getClientOriginalExtension();
            $request->gambar_a->move(public_path('/images/question'), $input['gambar_a']);
        }

        $input['gambar_b'] = null;
        $nmb = 'b-' . $unique;
        if ($request->hasFile('gambar_b')) {
            $input['gambar_b'] = str_slug($nmb, '-') . '.' . $request->gambar_b->getClientOriginalExtension();
            $request->gambar_b->move(public_path('/images/question'), $input['gambar_b']);
        }


        $input['gambar_c'] = null;
        $nmc = 'c-' . $unique;
        if ($request->hasFile('gambar_c')) {
            $input['gambar_c'] = str_slug($nmc, '-') . '.' . $request->gambar_c->getClientOriginalExtension();
            $request->gambar_c->move(public_path('/images/question'), $input['gambar_c']);
        }

        $input['gambar_d'] = null;
        $nmd = 'd-' . $unique;
        if ($request->hasFile('gambar_d')) {
            $input['gambar_d'] = str_slug($nmd, '-') . '.' . $request->gambar_d->getClientOriginalExtension();
            $request->gambar_d->move(public_path('/images/question'), $input['gambar_d']);
        }

        $input['gambar_e'] = null;
        $nme = 'e-' . $unique;
        if ($request->hasFile('gambar_e')) {
            $input['gambar_e'] = str_slug($nme, '-') . '.' . $request->gambar_e->getClientOriginalExtension();
            $request->gambar_e->move(public_path('/images/question'), $input['gambar_e']);
        }


        if ($request->question_model == '1') {
            $input['kunci_jawaban'] = $request->kunci_jawaban;
        } else if ($request->question_model == '2') {
            $kunci = $request->kunci_jawaban;
            if (! empty($kunci)) {
                $kunciJawaban = implode("|", $kunci);
                $input['kunci_jawaban'] = $kunciJawaban;
            } else {
                $input['kunci_jawaban'] = '';
            }
        } else if ($request->question_model == '3') {
            $kunci = $request->kunci_jawaban;
            if (! empty($kunci)) {
                $kunciJawaban = implode("|", $kunci);
                $input['kunci_jawaban'] = $kunciJawaban;
            } else {
                $input['kunci_jawaban'] = '';
            }
        } else if ($request->question_model == '4') {
            $input['kunci_jawaban'] = $request->kunci_jawaban;
        }

        TkaDetail::create($input);

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $view = 'tka-detail';
        $data = Tka::find($id);
        return view('tka.tka_detail_page', compact('view', 'data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = TkaDetail::find($id);
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
        $detail = TkaDetail::find($id);

        $rules = [
            'question_model' => 'required',
            'soal' => 'required'
        ];

        if ($request->question_model == '1') {
            $rules['jawaban_a'] = 'required';
            $rules['jawaban_b'] = 'required';
            $rules['jawaban_c'] = 'required';
            $rules['jawaban_d'] = 'required';
            $rules['jawaban_e'] = 'required';
        }

        if ($request->question_model == '2') {
            $rules['jawaban_a'] = 'required';
            $rules['jawaban_b'] = 'required';
            $rules['jawaban_c'] = 'required';
            $rules['jawaban_d'] = 'required';
           
        }

        if ($request->question_model == '3') {
            $rules['jawaban_a'] = 'required';
            $rules['jawaban_b'] = 'required';
        }



        $validator = Validator::make($request->all(), $rules, [
            'jawaban_a.required' => 'Jawaban A wajib diisi',
            'jawaban_b.required' => 'Jawaban B wajib diisi',
            'jawaban_c.required' => 'Jawaban C wajib diisi',
            'jawaban_d.required' => 'Jawaban D wajib diisi',
            'jawaban_e.required' => 'Jawaban E wajib diisi',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ]);
        }

        $unique = uniqid();
        $uni = 'soal-' . $unique;
        $una = 'a-' . $unique;
        $unb = 'b-' . $unique;
        $unc = 'c-' . $unique;
        $und = 'd-' . $unique;
        $une = 'e-' . $unique;

        $input['gambar_soal'] = $detail->gambar_soal;
        if ($request->hasFile('gambar_soal')) {
            if ($detail->gambar_soal != NULL && file_exists(public_path('/images/question/' . $detail->gambar_soal))) {
                unlink(public_path('/images/question/' . $detail->gambar_soal));
            }

            $input['gambar_soal'] = str_slug($uni, '-') . '.' . $request->gambar_soal->getClientOriginalExtension();
            $request->gambar_soal->move(public_path('/images/question'), $input['gambar_soal']);
        }

        $input['gambar_a'] = $detail->gambar_a;
        if ($request->hasFile('gambar_a')) {
            if ($detail->gambar_a != NULL && file_exists(public_path('/images/question/' . $detail->gambar_a))) {
                unlink(public_path('/images/question/' . $detail->gambar_a));
            }

            $input['gambar_a'] = str_slug($una, '-') . '.' . $request->gambar_a->getClientOriginalExtension();
            $request->gambar_a->move(public_path('/images/question'), $input['gambar_a']);
        }


        $input['gambar_b'] = $detail->gambar_b;
        if ($request->hasFile('gambar_b')) {
            if ($detail->gambar_b != NULL && file_exists(public_path('/images/question/' . $detail->gambar_b))) {
                unlink(public_path('/images/question/' . $detail->gambar_b));
            }

            $input['gambar_b'] = str_slug($unb, '-') . '.' . $request->gambar_b->getClientOriginalExtension();
            $request->gambar_b->move(public_path('/images/question'), $input['gambar_b']);
        }


        $input['gambar_c'] = $detail->gambar_c;
        if ($request->hasFile('gambar_c')) {
            if ($detail->gambar_c != NULL && file_exists(public_path('/images/question/' . $detail->gambar_c))) {
                unlink(public_path('/images/question/' . $detail->gambar_c));
            }

            $input['gambar_c'] = str_slug($unc, '-') . '.' . $request->gambar_c->getClientOriginalExtension();
            $request->gambar_c->move(public_path('/images/question'), $input['gambar_c']);
        }


        $input['gambar_d'] = $detail->gambar_d;
        if ($request->hasFile('gambar_d')) {
            if ($detail->gambar_d != NULL && file_exists(public_path('/images/question/' . $detail->gambar_d))) {
                unlink(public_path('/images/question/' . $detail->gambar_d));
            }

            $input['gambar_d'] = str_slug($und, '-') . '.' . $request->gambar_d->getClientOriginalExtension();
            $request->gambar_d->move(public_path('/images/question'), $input['gambar_d']);
        }


        $input['gambar_e'] = $detail->gambar_e;
        if ($request->hasFile('gambar_e')) {
            if ($detail->gambar_e != NULL && file_exists(public_path('/images/question/' . $detail->gambar_e))) {
                unlink(public_path('/images/question/' . $detail->gambar_e));
            }

            $input['gambar_e'] = str_slug($une, '-') . '.' . $request->gambar_e->getClientOriginalExtension();
            $request->gambar_e->move(public_path('/images/question'), $input['gambar_e']);
        }


        if ($request->question_model == '1') {
            $input['kunci_jawaban'] = $request->kunci_jawaban;
        } else if ($request->question_model == '2') {
            $kunci = $request->kunci_jawaban;
            if (! empty($kunci)) {
                $kunciJawaban = implode("|", $kunci);
                $input['kunci_jawaban'] = $kunciJawaban;
            } else {
                $input['kunci_jawaban'] = '';
            }
        } else if ($request->question_model == '3') {
            $kunci = $request->kunci_jawaban;
            if (! empty($kunci)) {
                $kunciJawaban = implode("|", $kunci);
                $input['kunci_jawaban'] = $kunciJawaban;
            } else {
                $input['kunci_jawaban'] = '';
            }
        } else if ($request->question_model == '4') {
            $input['kunci_jawaban'] = $request->kunci_jawaban;
        }

        $detail->update($input);

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $detail = TkaDetail::findOrFail($id);

        $images = [
            $detail->gambar_soal,
            $detail->gambar_a,
            $detail->gambar_b,
            $detail->gambar_c,
            $detail->gambar_d,
            $detail->gambar_e,
        ];

        foreach ($images as $image) {
            if (!empty($image)) {
                $path = public_path('images/question/' . $image);

                if (File::exists($path)) {
                    File::delete($path);
                }
            }
        }

        $detail->delete();

        return response()->json([
            'success' => true,
            'message' => 'Soal berhasil dihapus'
        ]);
    }


    public function deleteImage(Request $request)
    {
        $input = $request->all();
        $detail = TkaDetail::findorFail($input['id']);
        $type = $input['type'];
        if ($type == 0) {
            unlink(public_path('/images/question/' . $detail->gambar_soal));
            $detail->update(['gambar_soal' => NULL]);
        }


        if ($type == 1) {
            unlink(public_path('/images/question/' . $detail->gambar_a));
            $detail->update(['gambar_a' => NULL]);
        }

        if ($type == 2) {
            unlink(public_path('/images/question/' . $detail->gambar_b));
            $detail->update(['gambar_b' => NULL]);
        }


        if ($type == 3) {
            unlink(public_path('/images/question/' . $detail->gambar_c));
            $detail->update(['gambar_c' => NULL]);
        }


        if ($type == 4) {
            unlink(public_path('/images/question/' . $detail->gambar_d));
            $detail->update(['gambar_d' => NULL]);
        }

        if ($type == 5) {
            unlink(public_path('/images/question/' . $detail->gambar_e));
            $detail->update(['gambar_e' => NULL]);
        }

        return response()->json([
            'success' => true
        ]);
    }

    public function generateNomorSoal(Request $request)
    {
        $input = $request->all();
        $tka = TkaDetail::where('tka_id', $input['filter_id'])
            ->max('no_soal');
        if($tka) {
            $nomorBaru = $tka + 1;
        } else {
            $nomorBaru = 1;
        }
        

        return response()->json($nomorBaru);
    }

    public function lihatSoal(Request $request)
    {
        $id = $request->id;
        $data = TkaDetail::find($id);
        return response()->json($data);
    }
}
