<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateCongthucRequest;
use App\Http\Requests\CongthucRequest;
use App\Blend;
use App\Congthuc;
use App\User;
use Redirect,Response;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

use Illuminate\Support\Facades\DB;

// use Notification;
use App\Notifications\CongthucNotification;
use Illuminate\Support\Facades\Notification;
use Pusher\Pusher;





class CongthucController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view congthuc',['only' => ['index','show']]);
        $this->middleware('permission:add congthuc',['only' => ['store','create']]);
        $this->middleware('permission:edit congthuc',['only' => ['edit','update']]);
        $this->middleware('permission:delete congthuc',['only' => ['delete']]);
        //$this->middleware('permission:delete xuat',['only' => ['log']]);

        $this->middleware('role:admin',['only' => ['log']]);

    }

    public function index()
    {
        $congthucs = Congthuc::with('blend')->get();
        //$congthucs = Congthuc::all();

        //dd($congthucs);
        
        return view('blend.congthuc.index', compact('congthucs'));
    }
    
    public function create()
    {
        $blends = Blend::all();
        
        return view('blend.congthuc.add', compact('blends'));
        
    }

    public function store(CongthucRequest $request)
    {
        
        
        $form_data = array(
            'id'                =>   strtoupper(substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 10)), 0, 10)),
            'blend_id'              =>   $request->blend,
            'sothongbao'            =>   $request->sothongbao,
            'ngay_thongbao'         =>   $request->ngay_thongbao,     
        );
        //dd($form_data);
        $congthuc = Congthuc::with('blend')->create($form_data);
        $gialieus = $request->gialieu;
        $tyles = $request->tyle;
        
        $stt = 1;
        for ($gialieu=0; $gialieu < count($gialieus); $gialieu++) {
            if ($gialieus[$gialieu] != '') {
                $congthuc->gialieus()->attach($gialieus[$gialieu],  ['stt' => $stt,'tyle' => $tyles[$gialieu]]);
                $stt++;
            }
        }
        
        if ($request->huonglieu){
            $stt2 = 1;
            $huonglieus = $request->huonglieu;
            $tyle2s = $request->tyle2;
            //dd($huonglieus);
            for ($huonglieu=0; $huonglieu < count($huonglieus); $huonglieu++) {
                if ($huonglieus[$huonglieu] != '') {
                    $congthuc->huonglieus()->attach($huonglieus[$huonglieu], ['stt' => $stt2,'tyle' => $tyle2s[$huonglieu]]);
                    $stt2++;
                }
            }
        }
        
        $user_nhan = $users = User::whereHas("roles", function($q){ $q->whereIn("name", ["QA","nvphache"]); })->get();
        foreach ($user_nhan as $key => $value) {

            $user = User::find($value->id);
            $data = [
                'user_id' => auth()->user()->id,
                'user_name' => auth()->user()->name,
                'user_avatar' => auth()->user()->avatar,
                'id_ct' => $congthuc->id,
                'name_ct' => $congthuc->blend->name,
                'title' => 'Có công thức mới',
            ];
            Notification::send($user, new CongthucNotification($data));

            $options = array(
                'cluster' => 'ap1',
                'encrypted' => true
            );
    
            $pusher = new Pusher(
                env('PUSHER_APP_KEY'),
                env('PUSHER_APP_SECRET'),
                env('PUSHER_APP_ID'),
                $options
            );
    
            $pusher->trigger('NotificationEvent'.$value->id, 'send-message', $data);
        }
        
        
        return redirect()->route('list_congthuc');
    }
    

    public function show($id)
    {
        
        $congthuc = Congthuc::with('blend','gialieus','huonglieus')->where('id','=',$id)->first();
        if(isset($congthuc)){
            return view('blend.congthuc.view', compact('congthuc'));
        }else{
            return view('blend.congthuc.index');
        }
        //dd($congthuc);


        
    }

    public function getCongthucs(Request $request)
    {
        if ($request->ajax()) {
            $data = Congthuc::with('blend')->orderBy('ngay_thongbao', 'desc')->get();
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $actionBtn = '';

                    if (Auth::user()->can('edit congthuc')) {
                        if(Auth::user()->can('delete congthuc')){
                            $actionBtn = '<a href="'. route('edit_congthuc', $data->id) .'" ><i class="far fa-edit"></i></a>&nbsp;&nbsp;<a href="javascript:void(0)" id="delete-key" data-id="'.$data->id.'" ><i class="far fa-trash-alt"></i></a>&nbsp;&nbsp;<a href="'. route('copy_congthuc', $data->id) .'" ><i class="far fa-copy"></i></a>';
                        }else{
                            $actionBtn = '<a href="'. route('edit_congthuc', $data->id) .'" ><i class="far fa-edit"></i></a>&nbsp;&nbsp;<a href="'. route('copy_congthuc', $data->id) .'" ><i class="far fa-copy"></i></a>';
                        }
                    }else{
                        if(Auth::user()->can('delete congthuc')){
                            $actionBtn = '<a href="javascript:void(0)" id="delete-key" data-id="'.$data->id.'" ><i class="far fa-trash-alt"></i></a>';
                        }
                    }
                    
                    return $actionBtn;
                })
                
                ->addColumn('name', function($data) {
                    return '<a href="'. route('show_congthuc', $data->id) .'" style="color: black">'.$data->blend->name.'</a>';
                })

                ->addColumn('vanban', function ($data) {
                    return '<a href="'. route('down_congthuc', $data->id) .'">'.substr($data->file,31).'</a>';
                })

                ->editColumn('ngay_thongbao', function ($data) {
                    return date('d/m/Y', strtotime($data->ngay_thongbao));
                })

                ->rawColumns(['name','vanban','action','ngay_thongbao'])
                ->make(true);
        }
    }
    

    public function edit($id)
    {
        $congthuc = Congthuc::with('blend','gialieus','huonglieus')->where('id','=',$id)->first();
        //dd($congthuc);

        return view('blend.congthuc.edit', compact('congthuc'));
        
    }

    public function update(UpdateCongthucRequest $request, $id)
    {
        
        
        $form_data = array(
            'sothongbao'            =>   $request->sothongbao,
            'ngay_thongbao'         =>   $request->ngay_thongbao,     
        );
        //dd($form_data);
        $congthuc = Congthuc::find($id);
        $congthucupdate=$congthuc->update($form_data);
        
        
        $gialieus = $request->gialieu;
        $tyles = $request->tyle;
        $stt = 1;
        $gialieuupdate = array();
        foreach ($gialieus as $index => $gialieu) 
        {
            $data = [$gialieu => array('stt' => $stt,'tyle' => $tyles[$index])]; 
            $gialieuupdate = $gialieuupdate + $data;
            $stt++;    
        }
        $congthuc->gialieus()->sync($gialieuupdate);
        
        if ($request->huonglieu){
            $huonglieus = $request->huonglieu;
            $tyle2s = $request->tyle2;
            $stt2 = 1;
            $hươnglieuupdate = array();
            foreach ($huonglieus as $index => $huonglieu) 
            {
                $data2 = [$huonglieu => array('stt' => $stt2,'tyle' => $tyle2s[$index])]; 
                $hươnglieuupdate = $hươnglieuupdate + $data2; 
                $stt2++;   
            }
    
            $congthuc->huonglieus()->sync($hươnglieuupdate);
        }
        
        
        return redirect()->route('show_congthuc',$id);
    }

    public function copy($id)
    {
        $congthuc = Congthuc::with('blend','gialieus','huonglieus')->where('id','=',$id)->first();
        //dd($congthuc);

        return view('blend.congthuc.copy', compact('congthuc'));
        
    }

    public function delete($id)
    {
        $congthuc = Congthuc::find($id);
        $congthuc->delete();
      
        return Response::json($congthuc);
    }
    
    public function restore($id)
    {
        $congthuc = Congthuc::withTrashed()->find($id);
        $congthuc->restore();
        
        return Response::json($congthuc);
    }

    public function forcedelete($id)
    {
        $congthuc = Congthuc::with('blend','gialieus','huonglieus')->onlyTrashed()->where('id','=',$id)->first();
        $congthuc->gialieus()->sync([]);
        $congthuc->huonglieus()->sync([]);
        $congthuc->forceDelete();
      
        return Response::json($congthuc);
    }

    
    public function search($id)
    {
        $blends = Blend::with('congthucs')->where('id','=',$id)->first();
        $congthuc_ID = $blends->congthucs->sortByDesc('ngay_thongbao')->first()->id; 
        
        $congthuc = Congthuc::with('blend','gialieus','huonglieus')->where('id','=',$congthuc_ID)->first();
        //dd($congthuc);
        
        return Response::json($congthuc);
    }

    public function update_file(Request $request, $id)
    {
        $congthuc = Congthuc::with('blend','gialieus','huonglieus')->where('id','=',$id)->first();
        $file = request()->file('file');
        //$date = date('mY', strtotime($request->created_at));
        $filename=$file->getClientOriginalName();
        $file->move('fileupload/congthuc/'.$id, $filename); 
        $diachi='fileupload/congthuc/'.$id.'/'.$filename;
        $form_data = array(
            'file'            =>   $diachi,  
        );
        $up_file_pdf=$congthuc->update($form_data);

        return redirect()->route('show_congthuc',$id);  
    }

    public function down($id)
    {
        $congthuc = Congthuc::with('blend','gialieus','huonglieus')->where('id','=',$id)->first();
        $down = $congthuc->file;
        
        return response()->download($down);
    }

    public function trash()
    {
        
        return view('blend.congthuc.trash');
    }

    public function getTrashCongthucs(Request $request)
    {
        if ($request->ajax()) {
            $data = Congthuc::with('blend')->onlyTrashed()->get();
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $actionBtn = '';
                    if (Auth::user()->can('edit user')) {
                        if(Auth::user()->can('delete user')){
                            $actionBtn = '<a href="javascript:void(0)" id="restore-user" data-id="'.$data->id.'" ><i class="fas fa-trash-restore"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" id="delete-user" data-id="'.$data->id.'" ><i class="fas fa-ban"></i></a>&nbsp;&nbsp;<a href="'. route('show_congthuc', $data->id) .'" style="color: blue" ><i class="fas fa-history"></i></a>';
                        }else{
                            $actionBtn = '<a href="javascript:void(0)" id="restore-user" data-id="'.$data->id.'" ><i class="fas fa-trash-restore"></i></a>';
                        }
                    }else{
                        if(Auth::user()->can('delete user')){
                            $actionBtn = '<a href="javascript:void(0)" id="delete-user" data-id="'.$data->id.'" ><i class="fas fa-ban"></i></a>';
                        }
                    }
                    return $actionBtn;
                })
                
                ->addColumn('name', function($data) {
                    return '<a href="'. route('log_congthuc', $data->id) .'" style="color: black">'.$data->blend->name.'</a>';
                })

                ->addColumn('vanban', function ($data) {
                    return '<a href="'. route('show_congthuc', $data->id) .'">'.substr($data->file,22).'</a>';
                })

                ->rawColumns(['name','vanban','action'])
                ->make(true);
        }
    }

    public function log($id)
    {
        //dd($id);
        return view('blend.congthuc.log', compact('id'));

    }

    public function getLogDetails(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = Activity::where('properties->attributes->ct_id',$id)->orderBy('created_at', 'desc')
            ->get();
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('user', function($data) {
                    return optional($data->causer)->name;
                })
                ->addColumn('new', function($data) {
                    $d=$data->properties['attributes'];
                    $new = [];
                    foreach($d as $index => $detail)
                    {   
                        if( $index == 'vattu_id' ) {
                            $gialieu = DB::table('glhls')->where('id',$detail)->pluck('name')->first();
                            $new[]= 'Vật tư: '.$gialieu.'<br>'; 
                        }else if ( $index == 'tyle' ){
                            $new[]= 'Tỷ lệ: '.number_format($detail,3).'<br>';
                        }
                    }
                    $new = implode(' ', $new);
                    return $new;
                })
                ->addColumn('old', function($data) {
                        if(isset($data->properties['old'])){
                            $d=$data->properties['old'];
                            $old = [];
                            foreach($d as $index => $detail)
                            {   
                                if( $index == 'vattu_id' ) {
                                    $gialieu = DB::table('glhls')->where('id',$detail)->pluck('name')->first();
                                    $old[]= 'Vật tư: '.$gialieu.'<br>'; 
                                }else if ( $index == 'tyle' ){
                                    $old[]= 'Tỷ lệ: '.number_format($detail,3).'<br>';
                                }
                                
                            }
                            $old = implode(' ', $old);
                        }else{
                            $old = '';
                        }
                        
                        // $old = implode(' ', $new);
                        return $old;
                })
                ->editColumn('created_at', function($data) {
                    
                    return date_format($data->created_at, 'Y-m-d H:i:s');
                })
                ->editColumn('description', function($data) {
                    if ($data->description == 'deleted'){
                        $d = '<span class="badge badge-danger">'.$data->description.'</span>';
                    }else if(($data->description == 'created')){
                        $d = '<span class="badge badge-primary">'.$data->description.'</span>';
                    }else if(($data->description == 'updated')){
                        $d = '<span class="badge badge-success">'.$data->description.'</span>';
                    }
                    
                    return $d;
                })
                ->rawColumns(['user','new','old','created_at','description'])
                ->make(true);
        }
    }

    public function getLogs(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = Activity::where('subject_id', '=', $id)->orderBy('created_at', 'desc')
            ->get();
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('user', function($data) {
                    return optional($data->causer)->name;
                })
                ->addColumn('new', function($data) {
                    $d=$data->properties['attributes'];
                    $new = [];
                    foreach($d as $index => $detail)
                    {   
                        if( $index == 'sothongbao' ) {
                            $new[]= 'Số thông báo: '.$detail.'<br>'; 
                        }else if ( $index == 'ngay_thongbao' ){
                            $new[]= 'Ngày thông báo: '.$detail.'<br>';
                        }else if ( $index == 'file' ){
                            $new[]= 'File: <a href="{{ '.route('down_congthuc',$detail).' }}">'.substr($detail,22).'</a><br>';
                        }
                    }
                    $new = implode(' ', $new);
                    return $new;
                })
                ->addColumn('old', function($data) {
                        if(isset($data->properties['old'])){
                            $d=$data->properties['old'];
                            $old = [];
                            foreach($d as $index => $detail)
                            {   
                                if( $index == 'sothongbao' ) {
                                    $old[]= 'Số thông báo: '.$detail.'<br>'; 
                                }else if ( $index == 'ngay_thongbao' ){
                                    $old[]= 'Ngày thông báo: '.$detail.'<br>';
                                }else if ( $index == 'file' ){
                                    $old[]= 'File: <a href="{{ '.route('down_congthuc',$detail).' }}">'.substr($detail,22).'</a><br>';
                                }
                                
                            }
                            $old = implode(' ', $old);
                        }else{
                            $old = '';
                        }
                        
                        // $old = implode(' ', $new);
                        return $old;
                })
                ->editColumn('created_at', function($data) {
                    
                    return date_format($data->created_at, 'Y-m-d H:i:s');
                })
                ->editColumn('description', function($data) {
                    if ($data->description == 'deleted'){
                        $span = '<span class="badge badge-danger">'.$data->description.'</span>';
                    }else if(($data->description == 'created')){
                        $span = '<span class="badge badge-primary">'.$data->description.'</span>';
                    }else if(($data->description == 'updated')){
                        $span = '<span class="badge badge-success">'.$data->description.'</span>';
                    }else if(($data->description == 'restored')){
                        $span = '<span class="badge badge-success">'.$data->description.'</span>';
                    }
                    
                    return $span;
                })
                ->rawColumns(['user','new','old','created_at','description'])
                ->make(true);
        }
    }


    public function markAsRead($id)
    {
        //$id_cv = Congvan_den::find($id)->id_congvan;
        //$user_send = Congvan_den::find($id)->id_send;
        //dd($id_cv);
        //dd(auth()->user()->id);
        $id_ct ='7TPJ5TRCLF';
        $notification_for_user = auth()->user()->unreadNotifications()->where('data->id_ct', $id)->first()->update(['read_at' => now()]);
        //dd($notification_for_user);
        
    
        return Redirect::route('show_congthuc', $id);

    }

    public function test()
    {
        $users = User::whereHas("roles", function($q){ $q->whereIn("name", ["QA","nvphache"]); })->get();
        dd($users);
  
        $data = [
            'title' => 'Hi Artisan',
            'noidung' => 'This is my first notification from ItSolutionStuff.com',
            'thanks' => 'Thank you for using ItSolutionStuff.com tuto!',
            'actionText' => 'View My Site',
            'actionURL' => url('/'),
            'order_id' => 101,
            'user' => auth()->user()->name,
        ];
  
        Notification::send($user, new CongthucNotification($data));
   
        dd('done');
    

        return view('blend.congthuc.test', compact('congthucs'));
    }

    public function test2($id)
    {
        $data = Activity::whereJsonContains('properties->attributes',$id)->orderBy('created_at', 'desc')->get();
        $data2 = Activity::where('properties->attributes->ct_id',$id)->orderBy('created_at', 'desc')->get();

        dd($data2);
    }
    

}
