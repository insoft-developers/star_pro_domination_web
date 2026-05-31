<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Slider;
use App\Information;
use App\Promo;
use App\News;
use App\Ref;

class SliderController extends Controller
{
    public function main($id) {
        $slider = Slider::where('is_active', 1)->get();
        return response()->json([
            'success' => true,
            'message' => 'List Slider',
            'data' => $slider
        ]);
    }
    
    public function information() {
        $info = Information::where('is_active', 1)->get();
        return response()->json([
           'success' => true,
           'message' => 'list information',
           'data' => $info
        ]);
    }
    
    
    public function promo() {
        $promo = Promo::where('is_active', 1)->get();
        return response()->json([
           'success' => true,
           'message' => 'list promo',
           'data' => $promo
        ]);
    }
    
    public function news() {
        $news = News::where('is_active', 1)->get();
        return response()->json([
           'success' => true,
           'message' => 'list berita',
           'data' => $news
        ]);
    }
    
    
    public function menu() {
        
        $menu = \App\MainMenu::all();
        return response()->json([
           'success' => true,
           'message' => 'list icon',
           'data' => $menu
        ]);
    }
    
    
    public function refList(Request $request) {
        $input = $request->all();
        $ref = Ref::where('is_active', 1)
                ->get();
        
        $rows = [];
        $baris = 1;
        foreach($ref as $k) {
            $kelas = explode(",", $k->id_kelas);
            $cek = array_search((string)$input['id_kelas'], $kelas, true);
            
            if($cek !== false) {
                if($input['limit'] == 1) {
                    if($baris < 7) {
                        $row['id'] = $k->id;
                        $row['ref_title'] = $k->ref_title;
                        $row['ref_url'] = $k->ref_url;
                        $row['ref_image'] = $k->ref_image;
                        $row['id_kelas'] = $k->id_kelas;
                        array_push($rows, $row);
                    }
                } else {
                    $row['id'] = $k->id;
                    $row['ref_title'] = $k->ref_title;
                    $row['ref_url'] = $k->ref_url;
                    $row['ref_image'] = $k->ref_image;
                    $row['id_kelas'] = $k->id_kelas;
                    array_push($rows, $row);
                }
                
                
                $baris++;
            }
        }
        
        return response()->json([
            "success" => true,
            "data" => $rows
        ]);
        
    }    
    
    
    
    
}
