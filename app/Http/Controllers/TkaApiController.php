<?php

namespace App\Http\Controllers;

use App\Tka;
use App\TkaDetail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TkaApiController extends Controller
{
    public function tkaList(Request $request) 
    {
        // $data = Tka::where('is_active', 1)->get();
        $input = $request->all();

        $user = User::find($input['userid']);

        $data = Tka::with('tkaKelas')->where('is_active', 1)
            ->whereHas('tkaKelas', function($query) use ($user){
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
}
