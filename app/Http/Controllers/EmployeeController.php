<?php

namespace App\Http\Controllers;

use App\Division;
use App\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class EmployeeController extends Controller
{
    /**
     * @var string
     */
    private $className = "Karyawan";

    /**
     * EmployeeController constructor.
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            $request->user()->authorizeRoles(['super_admin', 'admin']);
            return $next($request);
        });
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $lDivisi = Division::pluck('nama','id')->toArray();
        return view('employee.index',compact('lDivisi'));
    }

    /**
     *
     */
    public function create()
    {
        //
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'nip' => 'required|max:10|unique:employees',
            'nama' => 'required|max:50',
            'tmpt_lahir' => 'required|max:30',
            'tgl_lahir' => 'required|date',
            'alamat' => 'required',
            'division_id' => 'required',
        ]);

        $newDate = new Carbon($request->get('tgl_lahir'));
        $newDate->format('Y-m-d');

        $data = new Employee();
        $data->nip = $request->get('nip');
        $data->nama = $request->get('nama');
        $data->tmpt_lahir = $request->get('tmpt_lahir');
        $data->tgl_lahir = $newDate;
        $data->alamat = $request->get('alamat');
        $data->division_id = $request->get('division_id');

        $data->save();

        return response()->json([
            'success' => true,
            'message' => 'Data ' . $this->className . ' Telah Ditambah'
        ]);
    }

    /**
     * @param Employee $employee
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * @param Employee $employee
     * @return Employee
     */
    public function edit(Employee $employee)
    {
        return $employee;
    }

    /**
     * @param Request $request
     * @param Employee $employee
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'nip' => 'required|max:10',
            'nama' => 'required|max:50',
            'tmpt_lahir' => 'required|max:30',
            'tgl_lahir' => 'required|date',
            'alamat' => 'required',
            'division_id' => 'required',
        ]);

        $newDate = new Carbon($request->get('tgl_lahir'));
        $newDate->format('Y-m-d');

        $employee->nip = $request->get('nip');
        $employee->nama = $request->get('nama');
        $employee->tmpt_lahir = $request->get('tmpt_lahir');
        $employee->tgl_lahir = $newDate;
        $employee->alamat = $request->get('alamat');
        $employee->division_id = $request->get('division_id');

        $employee->save();

        return response()->json([
            'success' => true,
            'message' => 'Data ' . $this->className . ' Telah Diubah'
        ]);
    }

    /**
     * @param Employee $employee
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Employee $employee)
    {
        $employee->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data ' . $this->className . ' Telah Dihapus'
        ]);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function getData()
    {
        $employees = Employee::with('division')->get();
        return DataTables::of($employees)
            ->addColumn('action', function ($data) {
                return '<a onclick="editForm(' . $data->id . ')" data-toggle="tooltip" class="btn btn-xs btn-primary"> <i class="fa fa-pencil"></i></a>&nbsp;&nbsp;' .
                    '<a onclick="deleteData(' . $data->id . ')" data-toggle="tooltip" class="btn btn-xs btn-danger"> <i class="fa fa-close"></i> </a>';
            })
            ->make(true);
    }

    /**
     * @return Employee[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getList()
    {
        $employees = Employee::all();
        return $employees;
    }
}
