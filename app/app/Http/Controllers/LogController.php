<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use App\Congthuc;

use Illuminate\Support\Facades\DB;
use Response;
use DataTables;


class LogController extends Controller
{
    public function index()
    {
        return view('log.index');
    }

    public function test()
    {
        $data = Activity::orderBy('created_at', 'desc')->get();
        dd($data);
    }

    public function getLogs(Request $request)
    {
        if ($request->ajax()) {
            $data = Activity::orderBy('created_at', 'desc')->get();
            
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
                        if( $index == 'ct_id' ) {
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
                                if( $index == 'ct_id' ) {
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

                ->editColumn('subject_type', function($data) {
                    
                    return substr($data->subject_type, 4);
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
                ->rawColumns(['user','new','old','created_at','description','subject_type'])
                ->make(true);
        }
    }

    public function logAuth()
    {
        return view('log.loglogin');
    }

    public function getLogAuths(Request $request)
    {
        if ($request->ajax()) {
            //$data = User::all();
            $data = DB::table('authentication_log')
                    ->join('users', 'authentication_log.authenticatable_id', '=', 'users.id')
                    ->select('users.name','authentication_log.ip_address','authentication_log.login_at','authentication_log.logout_at')
                    ->get();
            
            return Datatables::of($data)
                ->addIndexColumn()
                
                ->make(true);
        }
    }

}
