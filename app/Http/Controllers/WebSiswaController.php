<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\Datatables;
use App\User;
use App\Kelas;
use App\School;
use Session;

class WebSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(! Session::has('id')) {
            return Redirect(route('login'));
        }
        
        if(Session::get('level') != 1) {
            return Redirect(route('default'));
        }
        
        
        $view = 'siswa';
        $kelas = Kelas::all();
        $sekolah = School::all();
        return view('siswa.siswa', compact('view', 'kelas','sekolah'));
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
        $input['profile_image'] = null;
        $unique = uniqid();
        if($request->hasFile('profile_image')){
            $input['profile_image'] = str_slug($unique, ' - ').'.'.$request->profile_image->getClientOriginalExtension();
            $request->profile_image->move(public_path('/storage/images/profil'), $input['profile_image']);
        }

        $user = new User;
        $user->name = $input['name'];
        $user->nis = $input['nis'];
        $user->email = $input['email'];
        $user->password = bcrypt($input['password']);
        $user->id_kelas = $input['id_kelas'];
        $user->profile_image = $input['profile_image'];
        $user->phone = $input['phone'];
        $user->created_at = date('Y-m-d H:i:s');
        $user->school_id = $input['school_id'];
        $user->is_active = $input['is_active'];
        $user->save();
        
        return response()->json([
            'success'=>true
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
        $user = User::findorFail($id);
        return $user;
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
        $user = User::findorFail($id);
        
        $input['profile_image'] = $user->profile_image;

        if($request->hasFile('profile_image')){
            if($user->profile_image != NULL){
                unlink(public_path('/storage/images/profil/'.$user->profile_image));
            }
            
            $unique = uniqid();
            $input['profile_image'] = str_slug($unique, ' - ').'.'.$request->profile_image->getClientOriginalExtension();
            $request->profile_image->move(public_path('/storage/images/profil'), $input['profile_image']);
        }

        $user->name = $input['name'];
        $user->nis = $input['nis'];
        $user->email = $input['email'];
        $user->id_kelas = $input['id_kelas'];
        $user->profile_image = $input['profile_image'];
        $user->phone = $input['phone'];
        $user->school_id = $input['school_id'];
        $user->is_active = $input['is_active'];
        if(! empty($input['password']))
        {
            $user->password = bcrypt($input['password']);
        }
        
        $user->save();
        
        return response()->json([
            'success'=>true
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
        $user=User::findorFail($id);
        if($user->profile_image != NULL && file_exists(public_path('/storage/images/profil/'.$user->profile_image))){
            unlink(public_path('/storage/images/profil/'.$user->profile_image));
        }

        User::destroy($id);

        return response()->json([
            'success'=>true

        ]);
    }
    
    
    
    public function siswaTable()
    {
        $siswa = User::all();
        return Datatables::of($siswa)
          
           ->addColumn('profile_image', function($siswa){
               if(! empty($siswa->profile_image)) {
                    return '<img style="width:50px;height:50px;border-radius:25px;border:1px solid grey;" src="'.asset('/storage/images/profil').'/'.$siswa->profile_image.'" >';    
               } else {
                   return '<img style="width:50px;height:50px;border-radius:25px;border:1px solid grey;" src="'.asset('/images/playstore.png').'" >';
               }
               
           })
           ->addColumn('id_kelas', function($siswa){
               $kelas = Kelas::findorFail($siswa->id_kelas);
               return '<div>'.$kelas->nama_kelas.'</div>';
           })
           ->addColumn('created_at', function($siswa){
               return '<center>'.date('d-m-Y', strtotime($siswa->created_at)).'</center>';
           })
           
           ->addColumn('last_action', function($siswa){
               if(!empty($siswa->last_activity)) {
                   return '<center>'.date('d-m-Y H:i:s', strtotime($siswa->last_activity)).'</center>';
               } else {
                   return '';
               }
               
           })
           
           ->addColumn('school_id', function($siswa){
               if(! empty($siswa->school_id)) {
                   $sekolah = \App\School::findorFail($siswa->school_id);
                   return '<div>'.$sekolah->school_name.'</div>';
               } else {
                   return 'not-set';
               }
               
           })
           ->addColumn('is_active', function($siswa){
               if($siswa->is_active == 1) {
                   return '<center><span class="label label-success">Active</span></center>';
               }
               else {
                   return '<center><span class="label label-danger">Inactive</span></center>';
               }
           })
            ->addColumn('name', function($siswa){
                if($siswa->is_login == 1) {
                    return '<div>'.$siswa->name.'<br><br><span class="label label-success">Login</span></div>';
                   
                } else {
                   return '<div>'.$siswa->name.'<br><br><span class="label label-danger">Logout</span></div>';
                   
                }
                
            })
            ->addColumn('action', function($siswa){
                $html = "";
                $html .= '<center>';
                $html .= '<a onclick="contactData('. $siswa->id.')" style="margin-bottom:5px;width:80px;" class="btn btn-info btn-xs"><i class="glyphicon glyphicon-list-alt
"></i> Contact</a>'.
                '<br><a onclick="editData('. $siswa->id.')" style="margin-bottom:5px;width:80px;" class="btn btn-primary btn-xs"><i class="glyphicon glyphicon-edit"></i> Edit</a>'.
                '<br><a onclick="deleteData('. $siswa->id.')" style="width:80px;" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
                if($siswa->is_login == 1) {
                    $html .= '<br><a onclick="logoutData('. $siswa->id.')" style="width:80px;margin-top:5px;" class="btn btn-warning btn-xs"><i class="glyphicon glyphicon-off"></i> Logout</a>';
                }
                $html .= '</center>';
                return $html;
        })->rawColumns(['is_active','school_id','created_at','id_kelas','profile_image','action','name', 'last_action'])
        ->make(true);
    
    }
    
    
    public function contactList($id) 
    {
        if(! Session::has('id')) {
            return Redirect(route('login'));
        }
        $view = 'contact';
        $ids = $id;
        return view('siswa.contact', compact('view', 'ids'));
    }
    
    
    public function contactTable($id)
    {
        $contact = \App\Contact::where('id_user', $id)->get();
        return Datatables::of($contact)
        ->addColumn('phone_number', function($contact){
            return '<div>'.$contact->phone_number.'</div>';
        })      
        ->rawColumns(['phone_number'])
        ->make(true);
    
    }
    
    
    public function logoutUser($id) {
        $user = User::findorFail($id);
        $user->is_login = 0;
        $user->save();
        return response()->json(['success'=> true]);
        
    }
}
