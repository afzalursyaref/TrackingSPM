<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $model = User::orderBy('name', 'ASC');

            return datatables()->of($model)
                ->editColumn('role', function($row){
                    $output = '';
                    foreach ($row->roles()->pluck('display_name') as $role) {
                        $output .= $role . ', ';
                    }
                    return $output;
                })
                ->addColumn('actions', function($row){
                    $actionBtn = '<a class="btn btn-info btn-sm" href="'.route('user.edit', $row->id).'"><i class="fas fa-pencil-alt"></i></a>
                                  <a class="btn btn-danger btn-sm deleteUser" href="javascript:void(0)" data-id="'.$row->id.'"><i class="fas fa-trash"></i></a>';
                    return $actionBtn;
                })->rawColumns(['actions'])
                ->toJson();
        }
        return view('user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|alpha_dash|unique:users,username',
            'password' => 'required|min:4|confirmed',
            'role' => 'required'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
        ]);

        $user->attachRoles($request->role);
        // $user->roles()->attach($request->role);

        return redirect()->route('user.index')
            ->with('success_message', 'Berhasil menambah Pengguna Baru');

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
        $user = User::find($id);
        $roles = Role::all();
        return view('user.edit', compact('user', 'roles'));
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
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'username' => 'required|alpha_dash|unique:users,username,'.$id,
            'password' => 'nullable|min:4|confirmed',
            'role' => 'required'
        ]);

        $user = User::find($id);

        if($request->password == null){
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username
            ]);
        }else{
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request->password)
            ]);
        }

        $user->syncRoles($request->role);

        return redirect()->route('user.index')
            ->with('success_message', 'Berhasil Mengubah Data Pengguna');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
        return response()->json(['success'=>'Berhasil Hapus Data Pengguna']);
    }
}
