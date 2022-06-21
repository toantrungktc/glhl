<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddNhapRequest;


use App\Nhap;
use App\Nhap_detail;
use App\Congthuc;
use Spatie\Activitylog\Models\Activity;


use Redirect,Response;
use DataTables;
use Illuminate\Support\Facades\DB;


class NhapController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view nhap',['only' => ['index','show']]);
        $this->middleware('permission:add nhap',['only' => ['store','create']]);
        $this->middleware('permission:edit nhap',['only' => ['edit','update']]);
        $this->middleware('permission:delete nhap',['only' => ['delete']]);
    }
    
    public function index()
    {
        $logs = Nhap::with('nhap_details')->get();
        //$congthucs = Congthuc::all();

        //dd($congthucs);
        
        return view('nhap.index', compact('logs'));
    }

    public function create()
    {
        
        $congthucs = Congthuc::with('blend')->get();
        $dem = Nhap::whereMonth('ngay_nhap', '=', date('m'))->count()+1;
        //$dem2 = 15;
        //$congthucs = Congthuc::all();
        $thang =  date('m');
        $chungtu =sprintf('%02d',$dem)."/".$thang;
        

        //dd($chungtu);
        
        return view('nhap.add', compact('chungtu'));
        
    }

    public function store(AddNhapRequest $request)
    {
        
        $log_id = strtoupper(substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 10)), 0, 10));
        $form_data = array(
            'id'             =>    $log_id,
            'so_ct'          =>   $request->so_ct,
            'ngay_nhap'       =>   $request->ngay_nhap,
            'user_id'         =>   Auth::user()->id,         
        );
        //dd($form_data);
        $log = Nhap::create($form_data);
        //dd($form_data);
        
        $gialieus = $request->gialieu;
        $khoiluongs = $request->khoiluong;
        //dd($gialieus);
        foreach ($gialieus as $index => $gialieu) 
        {
            $data2 = array(
                'log_id'    => $log_id,
                'vattu_id'  => $gialieu,
                'khoiluong' => $khoiluongs[$index],
            ); 
            $detail = Nhap_detail::create($data2);
        }

       return redirect()->route('show_nhap',$log_id);
    }

    public function show($id)
    {
        $log = Nhap::with('nhap_details')->where('id','=',$id)->first();
        //dd($log);

        return view('nhap.view', compact('log'));

        
    }


    public function getNhaps(Request $request)
    {
        if ($request->ajax()) {
            $data = Nhap::all();
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $actionBtn = '';
                    
                    if (Auth::user()->can('edit nhap')) {
                        if(Auth::user()->can('delete nhap')){
                            $actionBtn = '<a href="'. route('edit_nhap', $data->id) .'" ><i class="far fa-edit"></i></a>&nbsp;&nbsp;<a href="javascript:void(0)" id="delete-nhap" data-id="'.$data->id.'" ><i class="far fa-trash-alt"></i></a>';
                        }else{
                            $actionBtn = '<a href="'. route('edit_nhap', $data->id) .'" ><i class="far fa-edit"></i></a>';
                        }
                    }else{
                        if(Auth::user()->can('delete nhap')){
                            $actionBtn = '<a href="javascript:void(0)" id="delete-nhap" data-id="'.$data->id.'" ><i class="far fa-trash-alt"></i></a>';
                        }
                    }

                    return $actionBtn;
                })
                
                ->addColumn('name', function($data) {
                    return '<a href="'. route('show_nhap', $data->id) .'" style="color: black">'.$data->so_ct.'</a>';
                })

                ->rawColumns(['name','action'])
                ->make(true);
        }
    }

    public function print($id)
    {
        $log = Nhap::with('nhap_details')->where('id','=',$id)->first();
        //$gialieu = $xuat->details->where('loai_vt','=',1)->sum('khoiluong');
        //dd($log);

        return view('nhap.print', compact('log'));
        //return view('nhap.print');
        
    }

    public function edit($id)
    {
        $log = Nhap::with('nhap_details')->where('id','=',$id)->first();
        //dd($log->nhap_details);
        return view('nhap.edit', compact('log'));
    }

    public function update(Request $request,$id)
    {
        $form_data = array(
            'so_ct'            =>   $request->so_ct,
            'ngay_nhap'        =>   $request->ngay_nhap,  
        );
        
        $nhap = Nhap::find($id);
        $nhapupdate=$nhap->update($form_data);
        $old = $nhap->nhap_details->pluck('vattu_id')->toArray();
        $gialieus = $request->gialieu;
        $test = array_diff($old,$gialieus);
        

        $khoiluong_olds = $request->khoiluong_old;
        $khoiluongs = $request->khoiluong;
        $nhapIDs = $request->id;
        //dd($nhapIDs);

        
        
        if($gialieus){
            foreach ($gialieus as $index => $gialieu) 
            {
                $data = array(
                    'log_id'    => $id,
                    'vattu_id'  => $gialieu,
                    'khoiluong' => $khoiluongs[$index],
                    ); 

                if($nhapIDs[$index] == 0){
                    $nhapID = null;
                    $nhap->nhap_details()->updateOrCreate(['id' => $nhapID],$data);
                }else{
                    $nhapID = $nhapIDs[$index];
                    if($khoiluongs[$index] != $khoiluong_olds[$index]){
                        $nhap->nhap_details()->updateOrCreate(['id' => $nhapID],$data);
                    }
                }
            }
        }
        //$test2 = array_diff_assoc($test,$gialieus);
        //dd($test);
        
        if($test){
            foreach ($test as $index => $del) {
                $nhap_details = Nhap_detail::where('log_id','=',$id)->where('vattu_id','=',$del)->first();
                $test2= Nhap_detail::withTrashed()->find($nhap_details->id);   
                $test2->forceDelete();

                // if(isset($nhap_details->id)){
                //     $test= Nhap_detail::withTrashed()->find($nhap_details->id);   
                //     $test->forceDelete();
                // }
                
            } 
        }
        
        
        return redirect()->route('show_nhap',$id);
    }



    public function test($id)
    {
        $logs = Activity::where('subject_id', '=', $id)->get();
        $test = DB::table('activity_log')
        ->whereJsonContains('properties->attributes', $id)
        ->get();
        dd($test);
        //return Response::json($nhap);
    }

    public function delete($id)
    {
        $nhap = Nhap::find($id);
        $nhap->delete();
      
        return Response::json($nhap);

    }

    public function restore($id)
    {
        $nhap = Nhap::withTrashed()->find($id);
        //dd($nhap);
        $nhap->restore();

        return Response::json($nhap);
    }

    public function forcedelete($id)
    {
        $nhap= Nhap::withTrashed()->find($id);   
        
        $nhap->forceDelete();
        return Response::json($nhap);
    }
    
    public function trash()
    {
        
        return view('nhap.trash');
    }

    public function getTrashNhaps(Request $request)
    {
        if ($request->ajax()) {
            $data = Nhap::onlyTrashed()->get();
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $actionBtn = '';
                    if (Auth::user()->can('edit user')) {
                        if(Auth::user()->can('delete user')){
                            $actionBtn = '<a href="javascript:void(0)" id="restore-user" data-id="'.$data->id.'" ><i class="fas fa-trash-restore"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:void(0)" id="delete-user" data-id="'.$data->id.'" ><i class="fas fa-ban"></i></a>';
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
                    return '<a href="'. route('show_nhap', $data->id) .'" style="color: black">'.$data->so_ct.'</a>';
                })

                ->rawColumns(['name','action'])
                ->make(true);
        }
    }

    public function log2($id)
    {
        
        $logs = Activity::where('subject_id', '=', $id)->get();
        
        $log_detail= Activity::whereJsonContains('properties->attributes', $id)
        ->get();
 
        //dd($log_detail);
    
        return view('nhap.log', compact('logs','log_detail','id'));

    }

    public function log($id)
    {
     
        return view('nhap.log2', compact('id'));

    }

    public function getLogDetails(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = Activity::whereJsonContains('properties->attributes', $id)->orderBy('created_at', 'desc')
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
                        }else if ( $index == 'khoiluong' ){
                            $new[]= 'Khối lượng: '.$detail.'<br>';
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
                                }else if ( $index == 'khoiluong' ){
                                    $old[]= 'Khối lượng: '.$detail.'<br>';
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
                        if( $index == 'so_ct' ) {
                            $new[]= 'Số chứng từ: '.$detail.'<br>'; 
                        }else if ( $index == 'ngay_nhap' ){
                            $new[]= 'Ngày nhập: '.$detail.'<br>';
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
                                if( $index == 'so_ct' ) {
                                    $old[]= 'Số chứng từ: '.$detail.'<br>'; 
                                }else if ( $index == 'ngay_nhap' ){
                                    $old[]= 'Ngày nhập: '.$detail.'<br>';
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
}
