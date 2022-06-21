<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\GLHL;
use Redirect,Response;
use DataTables;
use App\Http\Requests\AddGlHlRequest;
use App\Imports\GlhlImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\Auth;




class GLHLController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view glhl',['only' => ['index','show']]);
        $this->middleware('permission:add glhl',['only' => ['store','create']]);
        $this->middleware('permission:edit glhl',['only' => ['edit','update']]);
        $this->middleware('permission:delete glhl',['only' => ['delete']]);
    }

    public function index()
    {
        $glhls = GLHL::all();
        
        return view('glhl.index', compact('glhls'));
    }
    
    public function store(AddGlHlRequest $request)
    {
        $glhlID = $request->id;
        $glhl   = GLHL::updateOrCreate(['id' => $glhlID],
                    ['stt'           => $request->stt,
                     'name'           => $request->name,
                     'code1'          => $request->code1,
                     'code2'          => $request->code2,
                     'dvt'            => $request->dvt,
                               
                ]);
        
        return Response::json($glhl);
    }

    public function edit($id)
    {
        $glhl  = GLHL::where('id', '=', $id)->first();
 
        return Response::json($glhl);
    }

    public function delete($id)
    {
        $glhl = GLHL::find($id);
        //dd($glhl);
        $glhl->delete();
      
        return Response::json($glhl);
    }

    public function restore($id)
    {
        $glhl = GLHL::withTrashed()->find($id);
        $glhl->restore();
        return Response::json($glhl);
    }


    public function forcedelete($id)
    {
        $glhl= GLHL::withTrashed()->find($id);   
        
        $glhl->forceDelete();
        return Response::json($glhl);
    }
    
    public function trash()
    {
        
        return view('glhl.trash');
    }

    public function getTrashGlhls(Request $request)
    {
        if ($request->ajax()) {
            $data = GLHL::onlyTrashed()->get();
            
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
                
                ->editColumn('name', function ($data) {
                    return '<a href="javascript:void(0)" id="edit-key" data-id="'.$data->id.'" style="color: black">'.$data->name.'</a>';
                })

                ->rawColumns(['name','action'])
                ->make(true);
        }
    }


    public function search(Request $request)
    {
        $glhl = GLHL::where('name', 'LIKE', '%'.$request->input('term', '').'%')          
                ->get(['id', 'name as text']);
        
        //return response()->json($blend);

            return ['results' => $glhl];
    }

    public function getGlhls(Request $request)
    {
        if ($request->ajax()) {
            $data = GLHL::all();
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $actionBtn = '';
                    
                    if (Auth::user()->can('edit glhl')) {
                        if(Auth::user()->can('delete glhl')){
                            $actionBtn = '<a href="javascript:void(0)" id="edit-key" data-id="'.$data->id.'" ><i class="far fa-edit"></i></a>&nbsp;&nbsp;<a href="javascript:void(0)" id="delete-key" data-id="'.$data->id.'" ><i class="far fa-trash-alt"></i></a>';
                        }else{
                            $actionBtn = '<a href="javascript:void(0)" id="edit-key" data-id="'.$data->id.'" ><i class="far fa-edit"></i></a>';
                        }
                    }else{
                        if(Auth::user()->can('delete glhl')){
                            $actionBtn = '<a href="javascript:void(0)" id="delete-key" data-id="'.$data->id.'" ><i class="far fa-trash-alt"></i></a>';
                        }
                    }

                    return $actionBtn;
                })
                
                ->editColumn('name', function ($data) {
                    return '<a href="javascript:void(0)" id="edit-key" data-id="'.$data->id.'" style="color: black">'.$data->name.'</a>';
                })

                ->rawColumns(['name','action'])
                ->make(true);
        }
    }

    public function import(Request $request) 
    {
        //dd('ttt');
        $request->validate([
            'file' => 'required|max:10000|mimes:xlsx,xls',
        ]);
        Excel::import(new GlhlImport, request()->file('file'));
        
        return redirect()->route('list_glhl')->with('message', 'All good!');
    }

    public function test()
    {
        $date = Carbon::createFromFormat('Y-m-d', '2022-03-01')->toDateString();
        $date2 = Carbon::createFromFormat('Y-m-d', '2022-03-31')->toDateString();
        //dd(date("m/Y",strtotime($date)));
        $start = Carbon::now()->startOfMonth()->toDateString();
        $end = Carbon::now()->endOfMonth()->toDateString();
        

        //dd($end);

        $from_date = Carbon::now()->startOfMonth()->toDateString();
        $to_date = Carbon::now()->endOfMonth()->toDateString();


        $nhap = DB::table('nhaps')
        ->Join('nhap_details', 'nhap_details.log_id', '=', 'nhaps.id')
        ->groupBy('vattu_id')
        ->whereBetween('ngay_nhap', array($date, $date2))
        ->where('nhap_details.deleted_at', '=', Null)
        ->selectRaw(' vattu_id, SUM(nhap_details.khoiluong) AS nhap, 0 as xuat ');
        //->get();

        $xuat = DB::table('xuats')
        ->Join('xuat_details', 'xuat_details.log_id', '=', 'xuats.id')
        ->groupBy('vattu_id')
        ->whereBetween('ngay_pha', array($date, $date2))
        ->where('xuat_details.deleted_at', '=', Null)
        ->selectRaw(' vattu_id, 0 as nhap, SUM(xuat_details.khoiluong) AS xuat')
        ->union($nhap);
        //->get();

        $nhap2 = DB::table('nhaps')
        ->Join('nhap_details', 'nhap_details.log_id', '=', 'nhaps.id')
        ->groupBy('vattu_id')
        ->whereDate('ngay_nhap','<' ,$date)
        ->selectRaw(' vattu_id, SUM(nhap_details.khoiluong) AS nhap2, 0 as xuat2 ');
        //->get();
        //dd($nhap2);

        $xuat2 = DB::table('xuats')
        ->Join('xuat_details', 'xuat_details.log_id', '=', 'xuats.id')
        ->groupBy('vattu_id')
        ->whereDate('ngay_pha','<' ,$date)
        ->selectRaw(' vattu_id, 0 as nhap2, SUM(xuat_details.khoiluong) AS xuat2')
        ->union($nhap2);
        //->get();
        //dd($xuat);
        

        $ton = DB::table('glhls')
        ->leftjoinSub($xuat2, 'solieu2', function ($join) {
            $join->on('glhls.id', '=', 'solieu2.vattu_id');
        })
        
        ->groupBy('glhls.id', 'glhls.name','glhls.code2','glhls.dvt')
        //->whereNOTNull('stt')
        ->select('glhls.id', 'glhls.name', 'glhls.code2', 'glhls.dvt', DB::raw('SUM(solieu2.nhap2)-SUM(solieu2.xuat2) As ton'));
        
        $nhap_xuat = DB::table('glhls')
        ->leftjoinSub($xuat, 'solieu', function ($join) {
            $join->on('glhls.id', '=', 'solieu.vattu_id');
        })
        
        ->groupBy('glhls.id', 'glhls.name','glhls.code2','glhls.dvt')
        //->whereNOTNull('stt')
        ->select('glhls.id', 'glhls.name', 'glhls.code2', 'glhls.dvt', DB::raw('SUM(solieu.nhap) As nhap'), DB::raw('SUM(solieu.xuat) As xuat'));
        
        $data = DB::table('glhls')
        ->leftjoinSub($nhap_xuat, 'solieu', function ($join) {
            $join->on('glhls.id', '=', 'solieu.id');
        })
        ->leftjoinSub($ton, 'solieu2', function ($join) {
            $join->on('glhls.id', '=', 'solieu2.id');
        })
        
        ->groupBy('glhls.id', 'glhls.name','glhls.code2','glhls.dvt')
        ->whereNOTNull('stt')
        ->select('glhls.id', 'glhls.name', 'glhls.code2', 'glhls.dvt', DB::raw('SUM(solieu2.ton) As ton'), DB::raw('SUM(solieu.nhap) As nhap'), DB::raw('SUM(solieu.xuat) As xuat'))
        ->get();

         
        dd($data);

        //return view('test2', compact('glhl5'));

    }

    public function getBaocaos(Request $request)
    {
        $from_date = Carbon::now()->startOfMonth()->toDateString();
        
        $to_date = Carbon::now()->endOfMonth()->toDateString();

        if ($request->ajax()) {
            if(!empty($request->from_date)){
                $nhap = DB::table('nhaps')
                ->Join('nhap_details', 'nhap_details.log_id', '=', 'nhaps.id')
                ->groupBy('vattu_id')
                ->whereBetween('ngay_nhap', array($request->from_date, $request->to_date))
                ->where('nhap_details.deleted_at', '=', Null)
                ->selectRaw(' vattu_id, SUM(nhap_details.khoiluong) AS nhap, 0 as xuat ');
                //->get();

                $xuat = DB::table('xuats')
                ->Join('xuat_details', 'xuat_details.log_id', '=', 'xuats.id')
                ->groupBy('vattu_id')
                ->whereBetween('ngay_pha', array($request->from_date, $request->to_date))
                ->where('xuat_details.deleted_at', '=', Null)
                ->selectRaw(' vattu_id, 0 as nhap, SUM(xuat_details.khoiluong) AS xuat')
                ->union($nhap);
                //->get();

                $nhap2 = DB::table('nhaps')
                ->Join('nhap_details', 'nhap_details.log_id', '=', 'nhaps.id')
                ->groupBy('vattu_id')
                ->whereDate('ngay_nhap','<' ,$request->from_date)
                ->where('nhap_details.deleted_at', '=', Null)
                ->selectRaw(' vattu_id, SUM(nhap_details.khoiluong) AS nhap2, 0 as xuat2 ');
                // ->get();

                $xuat2 = DB::table('xuats')
                ->Join('xuat_details', 'xuat_details.log_id', '=', 'xuats.id')
                ->groupBy('vattu_id')
                ->whereDate('ngay_pha','<' ,$request->from_date)
                ->where('xuat_details.deleted_at', '=', Null)
                ->selectRaw(' vattu_id, 0 as nhap2, SUM(xuat_details.khoiluong) AS xuat2')
                ->union($nhap2);
                

                $ton = DB::table('glhls')
                ->leftjoinSub($xuat2, 'solieu2', function ($join) {
                    $join->on('glhls.id', '=', 'solieu2.vattu_id');
                })
                
                ->groupBy('glhls.id', 'glhls.name','glhls.code2','glhls.dvt')
                //->whereNOTNull('stt')
                ->select('glhls.id', 'glhls.name', 'glhls.code2', 'glhls.dvt', DB::raw('SUM(solieu2.nhap2)-SUM(solieu2.xuat2) As ton'));
                
                $nhap_xuat = DB::table('glhls')
                ->leftjoinSub($xuat, 'solieu', function ($join) {
                    $join->on('glhls.id', '=', 'solieu.vattu_id');
                })
                
                ->groupBy('glhls.id', 'glhls.name','glhls.code2','glhls.dvt')
                //->whereNOTNull('stt')
                ->select('glhls.id', 'glhls.name', 'glhls.code2', 'glhls.dvt', DB::raw('SUM(solieu.nhap) As nhap'), DB::raw('SUM(solieu.xuat) As xuat'));
                
                $data = DB::table('glhls')
                ->leftjoinSub($nhap_xuat, 'solieu', function ($join) {
                    $join->on('glhls.id', '=', 'solieu.id');
                })
                ->leftjoinSub($ton, 'solieu2', function ($join) {
                    $join->on('glhls.id', '=', 'solieu2.id');
                })
                
                ->groupBy('glhls.id', 'glhls.name','glhls.code2','glhls.dvt')
                ->whereNOTNull('stt')
                ->select('glhls.id', 'glhls.name', 'glhls.code2', 'glhls.dvt', DB::raw('SUM(solieu2.ton) As ton'), DB::raw('SUM(solieu.nhap) As nhap'), DB::raw('SUM(solieu.xuat) As xuat'))
                ->get();

            }else{
                $nhap = DB::table('nhaps')
                ->Join('nhap_details', 'nhap_details.log_id', '=', 'nhaps.id')
                ->groupBy('vattu_id')
                ->whereBetween('ngay_nhap', array($from_date, $to_date))
                ->where('nhap_details.deleted_at', '=', Null)
                ->selectRaw(' vattu_id, SUM(nhap_details.khoiluong) AS nhap, 0 as xuat ');
                //->get();

                $xuat = DB::table('xuats')
                ->Join('xuat_details', 'xuat_details.log_id', '=', 'xuats.id')
                ->groupBy('vattu_id')
                ->whereBetween('ngay_pha', array($from_date, $to_date))
                ->where('xuat_details.deleted_at', '=', Null)
                ->selectRaw(' vattu_id, 0 as nhap, SUM(xuat_details.khoiluong) AS xuat')
                ->union($nhap);
                //->get();

                $nhap2 = DB::table('nhaps')
                ->Join('nhap_details', 'nhap_details.log_id', '=', 'nhaps.id')
                ->groupBy('vattu_id')
                ->whereDate('ngay_nhap','<' ,$from_date)
                ->where('nhap_details.deleted_at', '=', Null)
                ->selectRaw(' vattu_id, SUM(nhap_details.khoiluong) AS nhap2, 0 as xuat2 ');
                // ->get();

                $xuat2 = DB::table('xuats')
                ->Join('xuat_details', 'xuat_details.log_id', '=', 'xuats.id')
                ->groupBy('vattu_id')
                ->whereDate('ngay_pha','<' ,$from_date)
                ->where('xuat_details.deleted_at', '=', Null)
                ->selectRaw(' vattu_id, 0 as nhap2, SUM(xuat_details.khoiluong) AS xuat2')
                ->union($nhap2);
                

                $ton = DB::table('glhls')
                ->leftjoinSub($xuat2, 'solieu2', function ($join) {
                    $join->on('glhls.id', '=', 'solieu2.vattu_id');
                })
                
                ->groupBy('glhls.id', 'glhls.name','glhls.code2','glhls.dvt')
                //->whereNOTNull('stt')
                ->select('glhls.id', 'glhls.name', 'glhls.code2', 'glhls.dvt', DB::raw('SUM(solieu2.nhap2)-SUM(solieu2.xuat2) As ton'));
                
                $nhap_xuat = DB::table('glhls')
                ->leftjoinSub($xuat, 'solieu', function ($join) {
                    $join->on('glhls.id', '=', 'solieu.vattu_id');
                })
                
                ->groupBy('glhls.id', 'glhls.name','glhls.code2','glhls.dvt')
                //->whereNOTNull('stt')
                ->select('glhls.id', 'glhls.name', 'glhls.code2', 'glhls.dvt', DB::raw('SUM(solieu.nhap) As nhap'), DB::raw('SUM(solieu.xuat) As xuat'));
                
                $data = DB::table('glhls')
                ->leftjoinSub($nhap_xuat, 'solieu', function ($join) {
                    $join->on('glhls.id', '=', 'solieu.id');
                })
                ->leftjoinSub($ton, 'solieu2', function ($join) {
                    $join->on('glhls.id', '=', 'solieu2.id');
                })
                
                ->groupBy('glhls.id', 'glhls.name','glhls.code2','glhls.dvt')
                ->whereNOTNull('stt')
                ->select('glhls.id', 'glhls.name', 'glhls.code2', 'glhls.dvt', DB::raw('SUM(solieu2.ton) As ton'), DB::raw('SUM(solieu.nhap) As nhap'), DB::raw('SUM(solieu.xuat) As xuat'))
                ->get();

            }
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->editColumn('name', function ($data) {
                    return '<a href="'. route('show_glhl', $data->id) .'" style="color: black">'.$data->name.'</a>';
                })
                ->editColumn('ton', function ($data) {
                    
                    return number_format($data->ton,1);
                })

                ->editColumn('nhap', function ($data) {
                    
                    return number_format($data->nhap,1);
                })
                
                ->editColumn('xuat', function ($data) {
                    
                    return number_format($data->xuat,1);
                })
                ->addColumn('toncuoi', function($data){
                    $ketqua = $data->ton + $data->nhap - $data->xuat ;
                    return number_format($ketqua,1);
                })

                ->rawColumns(['name', 'ton', 'nhap', 'xuat', 'toncuoi'])
                ->make(true);
        }
    }

    public function test2()
    {
        return view('baocao.index');
    }

    public function pdf(Request $request)
    {

        $from_date = Carbon::now()->startOfMonth()->toDateString();
        
        $to_date = Carbon::now()->endOfMonth()->toDateString();

        if(!empty($request->from_date)){
            $date1 = $request->from_date;
            $date2 = $request->to_date;
            
            $nhap = DB::table('nhaps')
            ->Join('nhap_details', 'nhap_details.log_id', '=', 'nhaps.id')
            ->groupBy('vattu_id')
            ->whereBetween('ngay_nhap', array($request->from_date, $request->to_date))
            ->where('nhap_details.deleted_at', '=', Null)
            ->selectRaw(' vattu_id, SUM(nhap_details.khoiluong) AS nhap, 0 as xuat ');
            //->get();

            $xuat = DB::table('xuats')
            ->Join('xuat_details', 'xuat_details.log_id', '=', 'xuats.id')
            ->groupBy('vattu_id')
            ->whereBetween('ngay_pha', array($request->from_date, $request->to_date))
            ->where('xuat_details.deleted_at', '=', Null)
            ->selectRaw(' vattu_id, 0 as nhap, SUM(xuat_details.khoiluong) AS xuat')
            ->union($nhap);
            //->get();

            $nhap2 = DB::table('nhaps')
            ->Join('nhap_details', 'nhap_details.log_id', '=', 'nhaps.id')
            ->groupBy('vattu_id')
            ->whereDate('ngay_nhap','<' ,$request->from_date)
            ->where('nhap_details.deleted_at', '=', Null)
            ->selectRaw(' vattu_id, SUM(nhap_details.khoiluong) AS nhap2, 0 as xuat2 ');
            // ->get();

            $xuat2 = DB::table('xuats')
            ->Join('xuat_details', 'xuat_details.log_id', '=', 'xuats.id')
            ->groupBy('vattu_id')
            ->whereDate('ngay_pha','<' ,$request->from_date)
            ->where('xuat_details.deleted_at', '=', Null)
            ->selectRaw(' vattu_id, 0 as nhap2, SUM(xuat_details.khoiluong) AS xuat2')
            ->union($nhap2);
            

            $ton = DB::table('glhls')
            ->leftjoinSub($xuat2, 'solieu2', function ($join) {
                $join->on('glhls.id', '=', 'solieu2.vattu_id');
            })
            
            ->groupBy('glhls.id', 'glhls.name','glhls.code2','glhls.dvt')
            //->whereNOTNull('stt')
            ->select('glhls.id', 'glhls.name', 'glhls.code2', 'glhls.dvt', DB::raw('SUM(solieu2.nhap2)-SUM(solieu2.xuat2) As ton'));
            
            $nhap_xuat = DB::table('glhls')
            ->leftjoinSub($xuat, 'solieu', function ($join) {
                $join->on('glhls.id', '=', 'solieu.vattu_id');
            })
            
            ->groupBy('glhls.id', 'glhls.name','glhls.code2','glhls.dvt')
            //->whereNOTNull('stt')
            ->select('glhls.id', 'glhls.name', 'glhls.code2', 'glhls.dvt', DB::raw('SUM(solieu.nhap) As nhap'), DB::raw('SUM(solieu.xuat) As xuat'));
            
            $data = DB::table('glhls')
            ->leftjoinSub($nhap_xuat, 'solieu', function ($join) {
                $join->on('glhls.id', '=', 'solieu.id');
            })
            ->leftjoinSub($ton, 'solieu2', function ($join) {
                $join->on('glhls.id', '=', 'solieu2.id');
            })
            
            ->groupBy('glhls.id', 'glhls.stt', 'glhls.name','glhls.code2','glhls.dvt')
            ->whereNOTNull('stt')
            ->select('glhls.id', 'glhls.stt', 'glhls.name', 'glhls.code2', 'glhls.dvt', DB::raw('SUM(solieu2.ton) As ton'), DB::raw('SUM(solieu.nhap) As nhap'), DB::raw('SUM(solieu.xuat) As xuat'))
            ->get();

        }else{
            $date1 = $from_date;
            $date2 = $to_date;
            $nhap = DB::table('nhaps')
            ->Join('nhap_details', 'nhap_details.log_id', '=', 'nhaps.id')
            ->groupBy('vattu_id')
            ->whereBetween('ngay_nhap', array($from_date, $to_date))
            ->where('nhap_details.deleted_at', '=', Null)
            ->selectRaw(' vattu_id, SUM(nhap_details.khoiluong) AS nhap, 0 as xuat ');
            //->get();

            $xuat = DB::table('xuats')
            ->Join('xuat_details', 'xuat_details.log_id', '=', 'xuats.id')
            ->groupBy('vattu_id')
            ->whereBetween('ngay_pha', array($from_date, $to_date))
            ->where('xuat_details.deleted_at', '=', Null)
            ->selectRaw(' vattu_id, 0 as nhap, SUM(xuat_details.khoiluong) AS xuat')
            ->union($nhap);
            //->get();

            $nhap2 = DB::table('nhaps')
            ->Join('nhap_details', 'nhap_details.log_id', '=', 'nhaps.id')
            ->groupBy('vattu_id')
            ->whereDate('ngay_nhap','<' ,$from_date)
            ->where('nhap_details.deleted_at', '=', Null)
            ->selectRaw(' vattu_id, SUM(nhap_details.khoiluong) AS nhap2, 0 as xuat2 ');
            // ->get();

            $xuat2 = DB::table('xuats')
            ->Join('xuat_details', 'xuat_details.log_id', '=', 'xuats.id')
            ->groupBy('vattu_id')
            ->whereDate('ngay_pha','<' ,$from_date)
            ->where('xuat_details.deleted_at', '=', Null)
            ->selectRaw(' vattu_id, 0 as nhap2, SUM(xuat_details.khoiluong) AS xuat2')
            ->union($nhap2);
            

            $ton = DB::table('glhls')
            ->leftjoinSub($xuat2, 'solieu2', function ($join) {
                $join->on('glhls.id', '=', 'solieu2.vattu_id');
            })
            
            ->groupBy('glhls.id', 'glhls.name','glhls.code2','glhls.dvt')
            //->whereNOTNull('stt')
            ->select('glhls.id', 'glhls.name', 'glhls.code2', 'glhls.dvt', DB::raw('SUM(solieu2.nhap2)-SUM(solieu2.xuat2) As ton'));
            
            $nhap_xuat = DB::table('glhls')
            ->leftjoinSub($xuat, 'solieu', function ($join) {
                $join->on('glhls.id', '=', 'solieu.vattu_id');
            })
            
            ->groupBy('glhls.id', 'glhls.name','glhls.code2','glhls.dvt')
            //->whereNOTNull('stt')
            ->select('glhls.id', 'glhls.name', 'glhls.code2', 'glhls.dvt', DB::raw('SUM(solieu.nhap) As nhap'), DB::raw('SUM(solieu.xuat) As xuat'));
            
            $data = DB::table('glhls')
            ->leftjoinSub($nhap_xuat, 'solieu', function ($join) {
                $join->on('glhls.id', '=', 'solieu.id');
            })
            ->leftjoinSub($ton, 'solieu2', function ($join) {
                $join->on('glhls.id', '=', 'solieu2.id');
            })
            
            ->groupBy('glhls.id', 'glhls.stt', 'glhls.name','glhls.code2','glhls.dvt')
            ->whereNOTNull('stt')
            ->select('glhls.id', 'glhls.stt', 'glhls.name', 'glhls.code2', 'glhls.dvt', DB::raw('SUM(solieu2.ton) As ton'), DB::raw('SUM(solieu.nhap) As nhap'), DB::raw('SUM(solieu.xuat) As xuat'))
            ->get();

        }
        
        $thang = date("m/Y",strtotime($date1));  
        $pdf = PDF::loadView('test2', compact('data','date1','date2'));
        //$pdf = PDF::loadView('test4', $data);
    
        return $pdf->download('Bao_cao_'.$thang.'.pdf');
    }
}


