<?php

namespace App\Http\Controllers;

use App\Employee;
use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /**
     * @var string
     */
    private $className = "User";

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            $request->user()->authorizeRoles(['super_admin']);
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $lKry = DB::table('employees')
            ->select('employees.id', 'nama')
            ->leftJoin('users', 'employees.id', 'users.employee_id')
            ->whereNull('users.employee_id')
            ->get()->toArray();

        $lRole = Role::pluck('description','id')->toArray();
        return view('user.index', compact(['lKry','lRole']));
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
            'employee_id' => $request->get('employee_id')
        ]);
        $user
            ->roles()
            ->attach(Role::where('name', 'user')->first());

        return response()->json([
            'success' => true,
            'message' => 'Data ' . $this->className . ' Telah Ditambah'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return User
     */
    public function edit($id)
    {
        $user = User::with('roles')->where('id',$id)->first();
        return $user;
    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user->password = bcrypt($request->get('password'));
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Data ' . $this->className . ' Telah Diubah'
        ]);
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        $user->delete();
        DB::table('role_user')->where('user_id',$user->id)->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data ' . $this->className . ' Telah Dihapus'
        ]);
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData()
    {
        $user = User::with('employee', 'roles')->get();
        return DataTables::of($user)
            ->addColumn('action', function ($data) {
                return '<a onclick="editForm(' . $data->id . ')" data-toggle="tooltip" class="btn btn-xs btn-primary"> <i class="fa fa-pencil"></i> Change Password</a>&nbsp;&nbsp;' .
                    '<a onclick="roleForm(' . $data->id . ')" data-toggle="tooltip" class="btn btn-xs btn-success"> <i class="fa fa-refresh"></i> Change Role </a>&nbsp;&nbsp;'.
                    '<a onclick="deleteData(' . $data->id . ')" data-toggle="tooltip" class="btn btn-xs btn-danger"> <i class="fa fa-close"></i> Delete </a>' ;
            })
            ->make(true);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeRole(Request $request, $id)
    {
        $request->validate([
            'role_id' => 'required',
        ]);

        $role_id = $request->get('role_id');

        DB::table('role_user')
            ->where('user_id',$id)
            ->update(['role_id' => $role_id]);

        return response()->json([
            'success' => true,
            'message' => 'Data Role ' . $this->className . ' Telah Diubah'
        ]);
    }
}
