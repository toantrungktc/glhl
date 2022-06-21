<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddBlendRequest;
use Illuminate\Http\Request;
use App\Blend;
use Redirect,Response;
use DataTables;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BlendImport;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\DB;





class BlendController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view congthuc',['only' => ['index','show']]);
        $this->middleware('permission:add congthuc',['only' => ['store','create']]);
        $this->middleware('permission:edit congthuc',['only' => ['edit','update']]);
        $this->middleware('permission:delete congthuc',['only' => ['delete']]);
    }

    public function index()
    {
        $blends = Blend::all();
        
        return view('blend.index', compact('blends'));
    }
    
    public function store(AddBlendRequest $request)
    {
        $blendID = $request->id;
        $blend   = Blend::updateOrCreate(['id' => $blendID],
                    ['name'           => $request->name,
                               
                ]);
        
        return Response::json($blend);
    }

    public function store2(AddBlendRequest $request)
    {
        $form_data = array(
                'id'                =>   strtoupper(substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 10)), 0, 10)),
                'name'              =>   $request->name,
              
           );
            //var_dump($form_data);
            $blend= Blend::create($form_data);
            //dd($request->role_id);
            
            
        return redirect()->route('list_blend');
    }

    public function show($id)
    {
        $blend = Blend::where('id', '=', $id)->with('congthucs')->firstOrFail();
        // dd($key);
        return view('blend.view', compact('blend'));
    }

    public function edit($id)
    {
        $blend  = Blend::where('id', '=', $id)->first();
 
        return Response::json($blend);
    }

    public function delete($id)
    {
        $blend = Blend::find($id);
        $blend->delete();
      
        return Response::json($blend);
    }

    public function restore($id)
    {
        $blend = Blend::withTrashed()->find($id);
        $blend->restore();
      
        return Response::json($blend);

    }

    public function forcedelete($id)
    {
        $blend= Blend::withTrashed()->find($id);   
        //$user->syncRoles([]);
        $blend->forceDelete();
        return Response::json($blend);
    }


    public function search(Request $request)
    {
        $blend = Blend::where('name', 'LIKE', '%'.$request->input('term', '').'%')          
                ->get(['id', 'name as text']);
        
        //return response()->json($blend);

            return ['results' => $blend];
    }

    public function getBlends(Request $request)
    {
        if ($request->ajax()) {
            $data = Blend::with('congthucs')->orderBy('name', 'asc')->get();
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    
                    $actionBtn = '';

                    if (Auth::user()->can('edit congthuc')) {
                        if(Auth::user()->can('delete congthuc')){
                            $actionBtn = '<a href="javascript:void(0)" id="edit-key" data-id="'.$data->id.'" ><i class="far fa-edit"></i></a>&nbsp;&nbsp;<a href="javascript:void(0)" id="delete-key" data-id="'.$data->id.'" ><i class="far fa-trash-alt"></i></a>';
                        }else{
                            $actionBtn = '<a href="javascript:void(0)" id="edit-key" data-id="'.$data->id.'" ><i class="far fa-edit"></i></a>';
                        }
                    }else{
                        if(Auth::user()->can('delete congthuc')){
                            $actionBtn = '<a href="javascript:void(0)" id="delete-key" data-id="'.$data->id.'" ><i class="far fa-trash-alt"></i></a>';
                        }
                    }

                    return $actionBtn;
                })
                
                ->addColumn('congthuchh', function($data) {
                    $dem = $data->congthucs->count();
                    if($dem == 0){
                        $congthuc = '';
                    }else{
                        $sotb = $data->congthucs->sortByDesc('ngay_thongbao')->first()->sothongbao;
                        $ngaytb = $data->congthucs->sortByDesc('ngay_thongbao')->first()->ngay_thongbao;
                        $congthuc = '<a href="'. route('show_congthuc', $data->congthucs->sortByDesc('ngay_thongbao')->first()->id) .'" style="color: black"><i> Thông báo số: </i><b>'.$sotb.'</b>; <i>Ngày: </i><b>'.$ngaytb.'</b></a>';
                    }
                    return $congthuc;
                })

                ->editColumn('name', function ($data) {
                    return '<a href="'. route('show_blend', $data->id) .'" style="color: black">'.$data->name.'</a>';
                })


                ->rawColumns(['name','congthuchh','action'])
                ->make(true);
        }
    }

    public function import(Request $request) 
    {
        //dd('ttt');
        $request->validate([
            'file' => 'required|max:10000|mimes:xlsx,xls',
        ]);
        Excel::import(new BlendImport, request()->file('file'));
        
        return redirect()->route('list_blend')->with('message', 'All good!');
    }

    public function trash()
    {
        
        return view('blend.trash');
    }

    public function getTrashBlends(Request $request)
    {
        if ($request->ajax()) {
            $data = Blend::with('congthucs')->onlyTrashed()->get();
            
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
                
                ->addColumn('congthuchh', function($data) {
                    $dem = $data->congthucs->count();
                    if($dem == 0){
                        $congthuc = '';
                    }else{
                        $congthuc = '<a href="'. route('show_congthuc', $data->congthucs->sortByDesc('ngay_thongbao')->first()->id) .'" style="color: black">'.$data->congthucs->sortByDesc('ngay_thongbao')->first()->sothongbao.'</a>';
                    }
                    return $congthuc;
                })
                ->editColumn('name', function ($data) {
                    return '<a href="'. route('show_blend', $data->id) .'" style="color: black">'.$data->name.'</a>';
                })

                ->rawColumns(['name','congthuchh','action'])
                ->make(true);
        }
    }

    public function log()
    {
     
        return view('blend.log');

    }

    public function getLogs(Request $request)
    {
        if ($request->ajax()) {
            $data = Activity::where('subject_type', '=', 'App\Blend')->orderBy('created_at', 'desc')
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
                        if( $index == 'name' ) {
                            $new[]= 'Tên Blend : '.$detail.'<br>'; 
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
                                if( $index == 'name' ) {
                                    $old[]= 'Tên Blend: '.$detail.'<br>'; 
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


    public function test()
    {
        $blends = Blend::with('congthucs')->first();
        $dem = $blends->congthucs->sortByDesc('ngay_thongbao')->first(); 
        dd($dem);
        
        return view('blend.index', compact('blends'));
    }
}
