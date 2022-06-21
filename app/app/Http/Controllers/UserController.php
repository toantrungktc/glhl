<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;


use App\Http\Requests\SaveProfileRequest;
use App\Http\Requests\AddUserRequest;
use App\Http\Requests\AddPermissionRequest;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\DB;
use Response;
use DataTables;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Image;


class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view user',['only' => ['index','show']]);
        $this->middleware('permission:add user',['only' => ['store','create']]);
        $this->middleware('permission:edit user',['only' => ['edit','update']]);
        $this->middleware('permission:delete user',['only' => ['delete']]);
    }

    /**
     * Show user profile settings.
     * 
     * @return $this
     */
    public function profile()
    {
        $user = Auth::user();
        // dd($user);
        return view('user.profile')->with(array(
            'user' => $user,
        ));
    }

    public function profileSave(Request $request)
    {
        $user = User::find(Auth::user()->id);

        if($request->password)
        {
            $this->validate($request,[
                'password' => 'min:6',
            ]);
            $form_data = array(
                'name'               =>   $request->name,
                'email'               =>   $request->email,
                'password'            =>   Hash::make($request->password),
                'mail'               =>   $request->mail,
                'sms'               =>   $request->sms,
            );
            //dd($form_data);
            $user->update($form_data);
            
            return Redirect::to('user/profile');

        }else{
            $form_data = array(
                'name'               =>   $request->name,
                'email'               =>   $request->email,
                'mail'               =>   $request->mail,
                'sms'               =>   $request->sms,
                
            );
            //dd($form_data);
            $user->update($form_data);
            
            return Redirect::to('user/profile');
        }

    }

    public function show($id)
    {
        
        $roles = Role::all();
        $user = User::where('id', '=', $id)->firstOrFail();
        //dd($user->roles->first());
        $roleofusers = $user->roles->first();
        if($roleofusers == null){
            $roleofuser = null;
        }else{
            $roleofuser = $roleofusers->id;
        }
        
        //dd($roleofuser);
        return view('user.view', compact('user','roles','roleofuser'));
    }

    public function edit($id)
    {
        
        $user = User::where('id', '=', $id)->firstOrFail();

        $roles = Role::all();

        $roleofusers = $user->roles->first();
        if($roleofusers == null){
            $roleofuser = null;
        }else{
            $roleofuser = $roleofusers->id;
        }
 
        return Response::json($user);
    }

    public function getUsers(Request $request)
    {
        if ($request->ajax()) {
            //$data = User::all();
            $data = User::with('roles')->get();
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $actionBtn = '';
                    if (Auth::user()->can('edit user')) {
                        if(Auth::user()->can('delete user')){
                            $actionBtn = '<a href="javascript:void(0)" id="edit-post" data-id="'.$data->id.'" ><i class="far fa-edit"></i></a>&nbsp;&nbsp;<a href="javascript:void(0)" id="delete-post" data-id="'.$data->id.'" ><i class="far fa-trash-alt"></i></a>';
                        }else{
                            $actionBtn = '<a href="javascript:void(0)" id="edit-post" data-id="'.$data->id.'" ><i class="far fa-edit"></i></a>';
                        }
                    }else{
                        if(Auth::user()->can('delete user')){
                            $actionBtn = '<a href="javascript:void(0)" id="delete-post" data-id="'.$data->id.'" ><i class="far fa-trash-alt"></i></a>';
                        }
                    }
                    return $actionBtn;
                })

                ->addColumn('role', function($data){
                    $roles =json_decode($data->roles,true);
                    $test = '';
                    foreach($roles as $role)
                    {   
                        $test= '<span class="badge badge-danger">'.$role["name"].'</span>'; 
                    }
                    return $test;
                })

                ->editColumn('name', function ($data) {
                    return '<a href="'. route('show_user', $data->id) .'" style="color: black">'.$data->name.'</a>';
                })
                ->rawColumns(['name','role', 'action'])
                ->make(true);
        }
    }

    public function index()
    {
        $users = User::with('roles')->get();
        $roles = Role::all();

        // $roleofusers = $user->roles->first();
        // if($roleofusers == null){
        //     $roleofuser = null;
        // }else{
        //     $roleofuser = $roleofusers->id;
        // }

        return view('user.index', compact('users','roles'));
    }

    public function index2()
    {
        $users = User::with('roles')->get();
        //dd($users);
        
        return view('user.index2',compact('users'));
    }

    public function update(Request $request, $id)
    {
        //dd($request->role);
        if($request->password)
        {
            $form_data = array(
                'name'               =>   $request->name,
                'username'           =>   $request->username,
                'email'              =>   $request->email,
                'password'           =>   Hash::make($request->password),
                'mail'               =>   $request->mail,
                'sms'                =>   $request->sms,
            );
            //dd($form_data);
            $user= User::find($id)->update($form_data);
            $user2= User::find($id);
            $user2->syncRoles($request->role);
            return redirect()->route('list_user');

        }else{
            $form_data = array(
                'name'               =>   $request->name,
                'username'           =>   $request->username,
                'email'              =>   $request->email,
                'mail'               =>   $request->mail,
                'sms'                =>   $request->sms,
                
            );
            //dd($form_data);

            $user= User::find($id)->update($form_data);
            $user2= User::find($id);
            $user2->syncRoles($request->role);
            return redirect()->route('list_user');
        }
    }

    public function store(AddUserRequest $request)
    {
        //
        $userID = $request->id;
        $user = User::updateOrCreate(['id' => $userID],
                [
                    'name'               =>   $request->name,
                    'username'           =>   $request->username,
                    'email'              =>   $request->email,
                    'password'           =>   Hash::make($request->password),
                    'mail'               =>   $request->mail,
                    'sms'                =>   $request->sms,
                    'avatar'             =>   'fileupload/avatar/default.jpg', 
                ]);
        $user->syncRoles($request->role);
        return Response::json($user);
    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();
      
        return Response::json($user);

    }

    public function restore($id)
    {
        $user = User::withTrashed()->find($id);
        $user->restore();
      
        return Response::json($user);

    }

    public function forcedelete($id)
    {
        $user= User::withTrashed()->find($id);   
        $user->syncRoles([]);
        $user->forceDelete();
        return Response::json($user);
    }

    public function trash()
    {
        
        return view('user.trash');
    }

    public function getTrashUsers(Request $request)
    {
        if ($request->ajax()) {
            //$data = User::all();
            $data = User::with('roles')->onlyTrashed()->get();
            
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

                ->addColumn('role', function($data){
                    $roles =json_decode($data->roles,true);
                    $test = '';
                    foreach($roles as $role)
                    {   
                        $test= '<span class="badge badge-danger">'.$role["name"].'</span>'; 
                    }
                    return $test;
                })

                ->editColumn('name', function ($data) {
                    return '<a href="'. route('show_user', $data->id) .'" style="color: black">'.$data->name.'</a>';
                })
                ->rawColumns(['name','role', 'action'])
                ->make(true);
        }
    }

    

    public function test()
    {
        $users = User::where('mail', '=', '1')->select('email')->get();
        $test = User::find(1)->authentications;
        $test = DB::table('authentication_log')
                ->join('users', 'authentication_log.authenticatable_id', '=', 'users.id')
                ->select('users.name','authentication_log.ip_address','authentication_log.login_at','authentication_log.logout_at')
                ->get();
        dd($test);
    }


    ################# ROLE ####################
    public function role()
    {
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();
        
        return view('user.role.index', compact('roles','permissions'));

    }

    public function getRoles(Request $request)
    {
        if ($request->ajax()) {
            //$data = User::all();
            $data = Role::with('permissions')->get();
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $actionBtn = '';
                    if (Auth::user()->can('edit congthuc')) {
                        
                        $actionBtn = '<a href="javascript:void(0)" id="edit-post" data-id="'.$data->id.'" ><i class="far fa-edit"></i></a>&nbsp;&nbsp;<a href="javascript:void(0)" id="delete-post" data-id="'.$data->id.'" ><i class="far fa-trash-alt"></i></a>';
                    }
                    return $actionBtn;
                })

                ->addColumn('permission', function($data){
                    $permissions =json_decode($data->permissions,true);
                    $per = [];
                    foreach($permissions as $permission)
                    {   
                        $per[]= '<span class="badge badge-danger">'.$permission["name"].'</span>'; 
                    }
                    $per = implode(' ', $per);

                    return $per;
                })

                ->editColumn('name', function ($data) {
                    return '<a href="'. route('show_role', $data->id) .'" style="color: black">'.$data->name.'</a>';
                })
                ->rawColumns(['name','permission', 'action'])
                ->make(true);
        }
    }

    public function role_create()
    {
        # code...
    }

    public function role_store(Request $request)
    {
        
        if(!isset($request->id)){
            $role = Role::create(['name' => $request->name]);
            $permissions = $request->permission;
            $role->syncPermissions($permissions);
        }else{
            $role = Role::find($request->id);
            $permissions = $request->permission;
            $role->syncPermissions($permissions);
        }

        return Response::json($role);

    }


    public function role_show($id)
    {
        $role  = Role::with('permissions')->where('id', '=', $id)->first();
        $permissionofrole = $role->permissions;
        $permissions = Permission::all();
        
        return view('user.role.view', compact('role','permissions','permissionofrole'));
    }
    
    public function role_edit($id)
    {
        $role  = Role::with('permissions')->where('id', '=', $id)->first();
        $permissionofrole = $role->permissions;
        $permissions = Permission::all();
        
        return Response::json($role);
    }

    // public function role_update(Request $request, $id)
    // {
    //     $role = Role::find($id);
    //     $permissions = $request->permission;
    //     $role->syncPermissions($permissions);

    //     return redirect()->route('show_role',$id);
    // }

    public function role_delete($id)
    {
        $role = Role::find($id);
        $role->delete();
      
        return Response::json($role);

    }

    ################# PERMISSION ####################
    public function permission()
    {
        $permissions = Permission::all();
        
        return view('user.permission.index', compact('permissions'));
    }

    
    public function permission_store(AddPermissionRequest $request)
    {
        if(!isset($request->id)){
            $permission = Permission::Create(['name' => $request->name]);
        
        }else{
            $permission = Permission::find($request->id)->update(['name' => $request->name]);
        }
        
        return Response::json($permission);
    }

    
    public function permission_edit($id)
    {
        $permission  = Permission::where('id', '=', $id)->first();
 
        return Response::json($permission);
    }

    // public function permission_update(Request $request,$id)
    // {
    //     $permissionID = $request->id2;
    //     $permission = Permission::find($permissionID)->update(['name' => $request->name2]);
    //     return Response::json($permission);
    // }

    public function permission_delete($id)
    {
        $permission = Permission::find($id);
        $permission->delete();
      
        return Response::json($permission);
    }

    public function getPermissions(Request $request)
    {
        if ($request->ajax()) {
            
            $data = Permission::all();
            
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($data){
                    $actionBtn = '<a href="javascript:void(0)" id="edit-post" data-id="'.$data->id.'" ><i class="far fa-edit"></i></a>&nbsp;&nbsp;<a href="javascript:void(0)" id="delete-post" data-id="'.$data->id.'" ><i class="far fa-trash-alt"></i></a>';
                    return $actionBtn;
                })
                // ->editColumn('name', function ($data) {
                //     return '<a href="'. route('show_user', $data->id) .'" style="color: black">'.$data->name.'</a>';
                // })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    // public function update_avatar(Request $request)
    // {
    //     $user = Auth::user();
    //     $id = Auth::user()->id;
    //     $file = request()->file('file');
    //     $date = date('dmY');
    //     //$date = date('mY', strtotime($request->created_at));
    //     $filename=$id.'-'.$date.'.'.$file->getClientOriginalExtension();
        
    //     //$file->move('fileupload/avatar/'.$id, $filename); 
    //     $path = public_path('fileupload/avatar/'.$id.'/'.$filename);
    //     Image::make($file)->resize(300, 300)->save( public_path('fileupload/avatar/'.$filename) );

    //     $avatar='fileupload/avatar/'.$filename;
    //     //dd($avatar);
    //     $form_data = array(
    //         'avatar'            =>   $avatar,  
    //     );
    //     $user->update($form_data);

    //     return redirect()->route('profile_user');  
    // }

    public function crop_avatar(Request $request)
    {
        $user = Auth::user();
        $path = 'fileupload/avatar';
        $file = $request->file('admin_image');
        $id = Auth::user()->id;
        $new_name = 'UIMG'.date('YmdHis').uniqid().'.jpg';
        //$filename=$id.'-'.$date.'.'.$file->getClientOriginalExtension();


        //Upload new image
        $upload = $file->move($path, $new_name);

        $avatar='fileupload/avatar/'.$new_name;
        if( !$upload ){
            return response()->json(['status'=>0,'msg'=>'Something went wrong, upload new picture failed']);
        }else{
            $oldPicture = Auth::user()->avatar;

            if( $oldPicture != ''){
                if( \File::exists($oldPicture)){
                    \File::delete($oldPicture);
                }
            }

            $update = $user -> update(['avatar'=>$avatar]);

            if( !$upload ){
                return response()->json(['status'=>0,'msg'=>'Something went wrong, uploading picture in db failed']);
            }else{
                return response()->json(['status'=>1,'msg'=>'Your profile picture has been updated successfully']);
            }

        }
    }

    function changePassword(Request $request){
        //Validate form
        $validator = \Validator::make($request->all(),[
            'oldpassword'=>[
                'required', function($attribute, $value, $fail){
                    if( !\Hash::check($value, Auth::user()->password) ){
                        return $fail(__('The current password is incorrect'));
                    }
                },
                'min:8',
                'max:30'
             ],
             'newpassword'=>'required|min:8|max:30',
             'cnewpassword'=>'required|same:newpassword'
         ],[
             'oldpassword.required'=>'Enter your current password',
             'oldpassword.min'=>'Old password must have atleast 8 characters',
             'oldpassword.max'=>'Old password must not be greater than 30 characters',
             'newpassword.required'=>'Enter new password',
             'newpassword.min'=>'New password must have atleast 8 characters',
             'newpassword.max'=>'New password must not be greater than 30 characters',
             'cnewpassword.required'=>'ReEnter your new password',
             'cnewpassword.same'=>'New password and Confirm new password must match'
         ]);

        if( !$validator->passes() ){
            return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
             
         $update = User::find(Auth::user()->id)->update(['password'=>\Hash::make($request->newpassword)]);

         if( !$update ){
             return response()->json(['status'=>0,'msg'=>'Something went wrong, Failed to update password in db']);
         }else{
             return response()->json(['status'=>1,'msg'=>'Your password has been changed successfully']);
         }
        }
    }

    function update_info(Request $request){
           
        $validator = \Validator::make($request->all(),[
            'name'=>'required',
            'email'=> 'required|email|unique:users,email,'.Auth::user()->id,
            'username'=>'required',
        ]);

        if(!$validator->passes()){
            return response()->json(['status'=>0,'error'=>$validator->errors()->toArray()]);
        }else{
             $query = User::find(Auth::user()->id)->update([
                'name'               =>   $request->name,
                'username'           =>   $request->username,
                'email'              =>   $request->email,
                'mail'               =>   $request->mail,
                'sms'                =>   $request->sms,
             ]);

             if(!$query){
                 return response()->json(['status'=>0,'msg'=>'Something went wrong.']);
             }else{
                 return response()->json(['status'=>1,'msg'=>'Your profile info has been update successfuly.']);
             }
        }
}

    

    


}
