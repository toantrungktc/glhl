<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddXuatRequest;


use App\Xuat;
use App\Xuat_detail;
use App\Congthuc;
use App\Blend;
use Spatie\Activitylog\Models\Activity;

use Redirect,Response;
use DataTables;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;




class XuatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view xuat',['only' => ['index','show']]);
        $this->middleware('permission:add xuat',['only' => ['store','create']]);
        $this->middleware('permission:edit xuat',['only' => ['edit','update']]);
        $this->middleware('permission:delete xuat',['only' => ['delete']]);
        
    }
    
    public function index()
    {
        $logs = Xuat::with('details')->get();
        //$congthucs = Congthuc::all();

        //dd($congthucs);
        
        return view('xuat.index', compact('logs'));
    }

    public function create2()
    {
        
        $congthucs = Congthuc::with('blend')->get();
        //$congthucs = Congthuc::all();

        //dd($congthucs);
        
        return view('xuat.add', compact('congthucs'));
        
    }

    

    public function store2(AddXuatRequest $request)
    {
        
        $log_id = strtoupper(substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 10)), 0, 10));
        $form_data = array(
            'id'             =>    $log_id,
            'ngay_pha'       =>   $request->ngay_pha,
            'ct_id2'          =>   $request->ct_id,
            'kl_la'          =>   $request->kl_la,
            'kl_gialieu'     =>   $request->kl_gialieu,
            'kl_thung_gl'    =>   $request->kl_thung_gl,
            'kl_soi'         =>   $request->kl_soi, 
            'kl_huonglieu'   =>   $request->kl_huonglieu,
            'kl_thung_hl'    =>   $request->kl_thung_hl,
            'user_id'        =>   Auth::user()->id,         
        );
        //dd($form_data);
        $log = Xuat::create($form_data);
        //dd($form_data);
        
        $gialieus = $request->gialieu;
        $tyles = $request->tyle;
        $khoiluongs = $request->khoiluong;
        
        //$test = array();
        foreach ($gialieus as $index => $gialieu) 
        {
            $data2 = array(
                'log_id'    => $log_id,
                'loai_vt'    => '1',
                'vattu_id'  => $gialieu,
                'tyle' => $tyles[$index],
                'khoiluong' => $khoiluongs[$index],
            ); 
            $detail = Xuat_detail::create($data2);
        }

        if ($request->huonglieu){
            $huonglieus = $request->huonglieu;
            $tyle2s = $request->tyle2;
            $khoiluong2s = $request->khoiluong2;
    
            foreach ($huonglieus as $index2 => $huonglieu) 
            {
                $data2 = array(
                    'log_id'    => $log_id,
                    'loai_vt'    => '2',
                    'vattu_id'  => $huonglieu,
                    'tyle' => $tyle2s[$index2],
                    'khoiluong' => $khoiluong2s[$index2],
                ); 
                $detail = Xuat_detail::create($data2);
            }
        }
        

       return redirect()->route('show_xuat',$log_id);
    }

    public function show($id)
    {
        $log = Xuat::with('details','congthuc')->where('id','=',$id)->first();
        $huonglieu = $log->details->where('loai_vt','=','2')->count();
        //dd($huonglieu);

        return view('xuat.view', compact('log','huonglieu'));

        
    }

    public function getXuats(Request $request)
    {
        if ($request->ajax()) {
            $data = Xuat::with('congthuc')->get();
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $actionBtn = '';
                    
                    if (Auth::user()->can('edit xuat')) {
                        if(Auth::user()->can('delete xuat')){
                            $actionBtn = '<a href="'. route('edit_xuat', $data->id) .'"  ><i class="far fa-edit"></i></a>&nbsp;&nbsp;<a href="javascript:void(0)" id="delete-xuat" data-id="'.$data->id.'" ><i class="far fa-trash-alt"></i></a>';
                        }else{
                            $actionBtn = '<a href="'. route('edit_xuat', $data->id) .'"  ><i class="far fa-edit"></i></a>';
                        }
                    }else{
                        if(Auth::user()->can('delete xuat')){
                            $actionBtn = '<a href="javascript:void(0)" id="delete-xuat" data-id="'.$data->id.'" ><i class="far fa-trash-alt"></i></a>';
                        }
                    }

                    return $actionBtn;
                })
                
                ->addColumn('name', function($data) {
                    return '<a href="'. route('show_xuat', $data->id) .'" style="color: black">'.$data->congthuc->blend->name.'</a>';
                })

                ->rawColumns(['name','action'])
                ->make(true);
        }
    }

    public function print($id)
    {
        $log = Xuat::with('details','congthuc')->where('id','=',$id)->first();
        //$gialieu = $xuat->details->where('loai_vt','=',1)->sum('khoiluong');
        //dd($gialieu);

        return view('xuat.print', compact('log'));

        
    }

    public function print_nhan_gl($id)
    {
        $log = Xuat::with('details','congthuc')->where('id','=',$id)->first();
        $gl_tong = $log->kl_gialieu;

        $kl_me = $log->kl_thung_gl;
        $test2 = explode('.',$gl_tong/$kl_me);
        
        $sodu = $gl_tong - ($kl_me*$test2[0]);
        if( $sodu == 0 ){
            for ($i = 1; $i <= $test2[0]; $i++){
                    $data[] = $kl_me;
            }
        }else{
            for ($i = 1; $i <= $test2[0]+1; $i++){
                if($i != $test2[0]+1 ){
                    $data[] = $kl_me;
                }else{
                    $data[] = $sodu;
                }
            }
        }
        
        return view('xuat.nhan_gl', compact('log','data'));
    }

    public function print_nhan_hl($id)
    {
        $log = Xuat::with('details','congthuc')->where('id','=',$id)->first();
        $gl_tong = $log->kl_huonglieu;

        $kl_me = $log->kl_thung_hl;
        $test2 = explode('.',$gl_tong/$kl_me);
        
        $sodu = $gl_tong - ($kl_me*$test2[0]);
        if( $sodu == 0 ){
            for ($i = 1; $i <= $test2[0]; $i++){
                    $data[] = $kl_me;
            }
        }else{
            for ($i = 1; $i <= $test2[0]+1; $i++){
                if($i != $test2[0]+1 ){
                    $data[] = $kl_me;
                }else{
                    $data[] = $sodu;
                }
            }
        }
        
        return view('xuat.nhan_hl', compact('log','data'));
    }

    public function edit($id)
    {
        
        $congthucs = Congthuc::with('blend')->get();
        $log = Xuat::with('details','congthuc')->where('id','=',$id)->first();

        
        return view('xuat.edit', compact('congthucs','log'));
        
    }

    public function update(Request $request, $id)
    {
        $form_data = array(
            'kl_la'            =>   $request->kl_la,
            'kl_soi'         =>   $request->kl_soi,
            'ngay_pha'         =>   $request->ngay_pha,      
        );
        //dd($form_data);
        $xuat = Xuat::find($id);
        $xuatupdate=$xuat->update($form_data);
        
        $gialieus = $request->gialieu;
        $khoiluongs = $request->khoiluong;
        //dd($gialieus);

        foreach ($gialieus as $index => $gialieu) 
        {
            $data = array(
                'khoiluong'            =>   $khoiluongs[$index],   
            );
            //dd($form_data);
            $detail = Xuat_detail::where('id','=', $gialieus[$index])->update($data);
        }

        $huonglieus = $request->huonglieu;
        $khoiluong2s = $request->khoiluong2;
        //dd($gialieus);

        foreach ($huonglieus as $index => $huonglieu) 
        {
            $data = array(
                'khoiluong'            =>   $khoiluong2s[$index],   
            );
            //dd($form_data);
            $detail = Xuat_detail::where('id','=', $huonglieus[$index])->update($data);
        }

        return redirect()->route('show_xuat',$id);
    }

    public function delete($id)
    {
        $xuat = Xuat::find($id);
        $xuat->delete();
      
        return Response::json($xuat);

    }

    public function restore($id)
    {
        $xuat = Xuat::withTrashed()->find($id);
        $xuat->restore();
        return Response::json($xuat);
    }


    public function forcedelete($id)
    {
        $xuat= Xuat::withTrashed()->find($id);   
        
        $xuat->forceDelete();
        return Response::json($xuat);
    }
    
    public function trash()
    {
        
        return view('xuat.trash');
    }


    public function getTrashXuats(Request $request)
    {
        if ($request->ajax()) {
            $data = Xuat::with('congthuc')->onlyTrashed()->get();
            
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
                    return '<a href="'. route('show_xuat', $data->id) .'" style="color: black">'.$data->congthuc->blend->name.'</a>';
                })

                ->rawColumns(['name','action'])
                ->make(true);
        }
    }

    public function log()
    {
     
        return view('xuat.log');

    }

    public function getLogs(Request $request)
    {
        if ($request->ajax()) {
            $data = Activity::where('subject_type', '=', 'App\Xuat')->orderBy('created_at', 'desc')
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
                        if( $index == 'ct_id2' ) {
                            // $congthuc = Congthuc::with('blend')->where('id','=',$detail)->first();
                            $blend = Congthuc::with('blend')->where('id','=',$detail)->first()->blend->name; 
                            $new[]= 'Công thức: '.$blend.'<br>'; 
                        }else if( $index == 'ngay_pha' ) {
                            $new[]= 'Ngày pha: '.$detail.'<br>'; 
                        }else if( $index == 'kl_la' ) {
                            $new[]= 'Khối lượng lá: '.$detail.'<br>'; 
                        }else if ( $index == 'kl_soi' ){
                            $new[]= 'Khối lượng sợi: '.$detail.'<br>';
                        }else if ( $index == 'kl_gialieu' ){
                            $new[]= 'KL Gia liệu: '.$detail.'<br>';
                        }else if ( $index == 'kl_huonglieu' ){
                            $new[]= 'KL Gia liệu: '.$detail.'<br>';
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
                                if( $index == 'ct_id2' ) {
                                    //$congthuc = Congthuc::with('blend')->where('id','=',$detail)->first();
                                    $blend = Congthuc::with('blend')->where('id','=',$detail)->first()->blend->name; 
                                    $old[]= 'Công thức: '.$blend.'<br>'; 
                                }else if( $index == 'ngay_pha' ) {
                                    $old[]= 'Ngày pha: '.$detail.'<br>'; 
                                }else if( $index == 'kl_la' ) {
                                    $old[]= 'Khối lượng lá: '.$detail.'<br>'; 
                                }else if ( $index == 'kl_soi' ){
                                    $old[]= 'Khối lượng sợi: '.$detail.'<br>';
                                }else if ( $index == 'kl_gialieu' ){
                                    $old[]= 'KL Gia liệu: '.$detail.'<br>';
                                }else if ( $index == 'kl_huonglieu' ){
                                    $old[]= 'KL Gia liệu: '.$detail.'<br>';
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



    public function create()
    {
        
        $congthucs = Congthuc::with('blend')->get();
        //$congthucs = Congthuc::all();

        //dd($congthucs);
        
        return view('xuat.add2', compact('congthucs'));
        
    }

    

    public function store(AddXuatRequest $request)
    {
        
        $log_id = strtoupper(substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 10)), 0, 10));
        $form_data = array(
            'id'             =>    $log_id,
            'ngay_pha'       =>   $request->ngay_pha,
            'ct_id2'          =>   $request->ct_id,
            'kl_la'          =>   $request->kl_la,
            'kl_gialieu'     =>   $request->kl_gialieu,
            'kl_thung_gl'    =>   $request->kl_thung_gl,
            'kl_soi'         =>   $request->kl_soi, 
            'kl_huonglieu'   =>   $request->kl_huonglieu,
            'kl_thung_hl'    =>   $request->kl_thung_hl,
            'user_id'        =>   Auth::user()->id,         
        );
        //dd($form_data);
        $log = Xuat::create($form_data);
        //dd($form_data);
        
        $gialieus = $request->gialieu;
        $tyles = $request->tyle;
        $khoiluongs = $request->khoiluong;
        
        //$test = array();
        foreach ($gialieus as $index => $gialieu) 
        {
            $data2 = array(
                'log_id'    => $log_id,
                'loai_vt'    => '1',
                'vattu_id'  => $gialieu,
                'tyle' => $tyles[$index],
                'khoiluong' => $khoiluongs[$index],
            ); 
            $detail = Xuat_detail::create($data2);
        }

        if ($request->kl_soi != null){
            $huonglieus = $request->huonglieu;
            $tyle2s = $request->tyle2;
            $khoiluong2s = $request->khoiluong2;
    
            foreach ($huonglieus as $index2 => $huonglieu) 
            {
                $data2 = array(
                    'log_id'    => $log_id,
                    'loai_vt'    => '2',
                    'vattu_id'  => $huonglieu,
                    'tyle' => $tyle2s[$index2],
                    'khoiluong' => $khoiluong2s[$index2],
                ); 
                $detail = Xuat_detail::create($data2);
            }
        }
        

       //return redirect()->route('show_xuat',$log_id);
       return Response::json($log);
    }

    public function getQuantityWeek()
    {
        $startOfSubWeek = Carbon::now()->subWeek()->startOfWeek();
        //$b = Carbon::now()->subWeek()->endOfWeek();
        $startOfCurrentWeek = Carbon::now()->startOfWeek();
        //$d = Carbon::now()->endOfWeek();
        
        // Khối lượng sợi sản xuất trong tuần trước
        $count = 7;
        $dates = [];
        $date = $startOfSubWeek->subDay(1);
        for ($i = 0; $i < $count; $i++) {
            $dates[] = $date->addDay()->format('F d, Y');
        }

        if(! empty( $dates ) ){
            foreach($dates as $index => $date){
                $date_sum = Xuat::where( 'ngay_pha', '=', $date )->pluck('kl_soi')->sum();
                $kl_SubWeek[]= $date_sum;
            }
        }
        // Khối lượng sợi sản xuất trong tuần hiện tại
        $date2s = [];
        $date2 = $startOfCurrentWeek->subDay(1);
        for ($i = 0; $i < $count; $i++) {
            $date2s[] = $date2->addDay()->format('F d, Y');
        }

        if(! empty( $date2s ) ){
            foreach($date2s as $index => $date){
                $date_sum = Xuat::where( 'ngay_pha', '=', $date )->pluck('kl_soi')->sum();
                $kl_CurrentWeek[]= $date_sum;
            }
        }

        $days = [
            'Thứ 2',
            'Thứ 3',
            'Thứ 4',
            'Thứ 5',
            'Thứ 6',
            'Thứ 7',
            'CN'
        ];
        
        $data = array(
            'day' => $days,
            'kl_SubWeek'  => $kl_SubWeek,
            'kl_CurrentWeek'  => $kl_CurrentWeek,
            
        );
        
        return response()->json($data);

    }

    public function getTop5Week(Request $request)
    {
        if ($request->ajax()) {
            $a = Carbon::now()->startOfWeek();
            $b = Carbon::now()->endOfWeek();

            $data = Xuat_detail::with('glhl')->select('vattu_id', DB::raw('SUM(khoiluong) as sum_kl'))
                    ->whereBetween('created_at', 
                        [$a, $b]
                    )
                    ->whereNotIn('vattu_id',['1A3Z69BW8Q','31J5GS86RX'])
                    ->groupBy('vattu_id')
                    ->orderBy('sum_kl', 'DESC')
                    ->limit(5)
                    ->get();
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function($data) {
                    return $data->glhl->name;
                })
                ->rawColumns(['name'])
                ->make(true);
        }
    }

    public function getQuantitySuppliesWeek()
    {
        $startOfSubWeek = Carbon::now()->subWeek()->startOfWeek();
        //$b = Carbon::now()->subWeek()->endOfWeek();
        $startOfCurrentWeek = Carbon::now()->startOfWeek();
        //$d = Carbon::now()->endOfWeek();
        
        // Khối lượng sợi sản xuất trong tuần trước
        $count = 7;
        $dates = [];
        $date = $startOfSubWeek->subDay(1);
        for ($i = 0; $i < $count; $i++) {
            $dates[] = $date->addDay()->format('F d, Y');
        }

        if(! empty( $dates ) ){
            foreach($dates as $index => $date){
                $date_sum = Xuat_detail::whereHas('xuat', function ($query) use ($date) {
                    $query->where('ngay_pha', '=', $date);
                })->pluck('khoiluong')->sum();
                $date_sum = number_format($date_sum,2,'.', '');
                $kl_SubWeek[]= $date_sum;
            }
        }
        // Khối lượng sợi sản xuất trong tuần hiện tại
        $date2s = [];
        $date2 = $startOfCurrentWeek->subDay(1);
        for ($i = 0; $i < $count; $i++) {
            $date2s[] = $date2->addDay()->format('F d, Y');
        }

        if(! empty( $date2s ) ){
            foreach($date2s as $index => $date){
                $date_sum = Xuat_detail::whereHas('xuat', function ($query) use ($date) {
                    $query->where('ngay_pha', '=', $date);
                })->pluck('khoiluong')->sum();
                $date_sum = number_format($date_sum,2,'.', '');
                $kl_CurrentWeek[]= $date_sum;
            }
        }

        $days = [
            'Thứ 2',
            'Thứ 3',
            'Thứ 4',
            'Thứ 5',
            'Thứ 6',
            'Thứ 7',
            'CN'
        ];
        
        $data = array(
            'day' => $days,
            'kl_SubWeek'  => $kl_SubWeek,
            'kl_CurrentWeek'  => $kl_CurrentWeek,
            
        );

        //dd($dates);
        
        return response()->json($data);

    }

    public function getTop5SpWeek(Request $request)
    {
        if ($request->ajax()) {
            $a = Carbon::now()->startOfWeek();
            $b = Carbon::now()->endOfWeek();

            $data = DB::table('congthucs')
                    ->Join('xuats', 'xuats.ct_id2', '=', 'congthucs.id')
                    ->Join('blends', 'congthucs.blend_id', '=', 'blends.id')
                    ->groupBy('blends.id', 'blends.name')
                    ->whereBetween('ngay_pha', array($a, $b))
                    ->where('xuats.deleted_at', '=', Null)
                    ->selectRaw(' blends.id,blends.name, SUM(xuats.kl_soi) AS kl_soi')
                    ->limit(5)
                    ->get();
            
            return Datatables::of($data)
                ->addIndexColumn()
                // ->addColumn('name', function($data) {
                //     return $data->glhl->name;
                // })
                // ->rawColumns(['name'])
                ->make(true);
        }
    }


    public function test(Request $request)
    {
        dd(request()->getIp());
        $startOfSubWeek = Carbon::now()->subWeek()->startOfWeek();
        //$b = Carbon::now()->subWeek()->endOfWeek();
        $startOfCurrentWeek = Carbon::now()->startOfWeek();
        //$d = Carbon::now()->endOfWeek();
        
        // Khối lượng sợi sản xuất trong tuần trước
        $a = Carbon::now()->subWeek()->startOfWeek();
        $b = Carbon::now()->subWeek()->endOfWeek();
        $c = Carbon::now()->startOfWeek();
        $d = Carbon::now()->endOfWeek();
        $e = Carbon::now()->subWeek()->startOfWeek()->addDay(3);
        $xuats_current = Xuat::select('*')
        ->whereBetween('created_at', 
            [$c, $d]
        )
        ->get();

        $xuats_subweek = Xuat::select('ngay_pha', DB::raw('SUM(kl_soi) as sum_soi'))
        ->whereBetween('ngay_pha', 
            [$a, $b]
        )
        ->groupBy('ngay_pha')
        ->get();

        
        $xuats_subweek2 = Xuat::select('*')
        ->whereBetween('ngay_pha', 
            [$a, $b]
        )
        ->get();

 
        $glhls = Xuat_detail::select('*')
        ->whereBetween('created_at', 
        [$c, $d])
        ->get();

        $glhl2s = Xuat_detail::with('glhl')->select('vattu_id', DB::raw('SUM(khoiluong) as sum_kl'))
        ->whereBetween('created_at', 
            [$a, $b]
        )
        ->whereNotIn('vattu_id',['1A3Z69BW8Q','31J5GS86RX'])
        ->groupBy('vattu_id')
        ->orderBy('sum_kl', 'DESC')
        ->limit(5)
        ->get();

        $test = DB::table('congthucs')
                ->Join('xuats', 'xuats.ct_id2', '=', 'congthucs.id')
                ->Join('blends', 'congthucs.blend_id', '=', 'blends.id')
                ->groupBy('blends.id', 'blends.name')
                ->whereBetween('ngay_pha', array($a, $b))
                ->where('xuats.deleted_at', '=', Null)
                ->selectRaw(' blends.id,blends.name, SUM(xuats.kl_soi) AS xuat')
                ->get();
        
        
        dd($test);
        
        return response()->json($data);

    }

        
}
