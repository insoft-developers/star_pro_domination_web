<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use App\MainMenu;
use Session;

class IconController extends Controller
{
   
    public function index()
    {
        if(! Session::has('id')) {
            return Redirect(route('login'));
        }
        $view = 'main-menu';
        return view('home.menu', compact('view'));
    }

   
    public function edit($id)
    {
        $menu = MainMenu::findorFail($id);
        return $menu;
    }

    
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $menu = MainMenu::findorFail($id);
        
        $input['icon_image'] = $menu->icon_image;

        if($request->hasFile('icon_image')){
            if($menu->icon_image != NULL && file_exists(public_path('/images/iconmenu/'.$menu->icon_image))){
                unlink(public_path('/images/iconmenu/'.$menu->icon_image));
            }
            
            $unique = uniqid();
            $input['icon_image'] = str_slug($unique, ' - ').'.'.$request->icon_image->getClientOriginalExtension();
            $request->icon_image->move(public_path('/images/iconmenu'), $input['icon_image']);
        }

        $menu->update($input);
        
        return response()->json([
            'success'=>true
        ]);
    }

 
    
    
    public function iconTable()
    {
        $menu = MainMenu::all();
        return Datatables::of($menu)
           
           ->addColumn('icon_image', function($menu){
               if(! empty($menu->icon_image) && file_exists(public_path('/images/iconmenu/'.$menu->icon_image))) {
                   return '<img style="width:90px;height:90px;border-radius:45px;" src="'.asset('images/iconmenu').'/'.$menu->icon_image.'" >';
               } else{
                   return 'No Image';
               }
               
           })
            ->addColumn('action', function($menu){
                return '<center><a onclick="editData('. $menu->id.')" style="margin-left:10px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a></center>';
        })->rawColumns(['icon_image','action'])
        ->make(true);
    
    }
}
