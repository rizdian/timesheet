<?php

namespace App\Http\Controllers;

use App\Division;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class DivisionController extends Controller
{
    private $className = "Divisi";

    /**
     * DivisionController constructor.
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('division.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
            'nama' => 'required|max:20',
            'flag' => 'required|numeric|max:10',
        ]);

        $data = new Division();
        $data->nama = $request->get('nama');
        $data->flag = $request->get('flag');

        $data->save();

        return response()->json([
            'success' => true,
            'message' => 'Data ' . $this->className . ' Telah Ditambah'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Division $division
     * @return \Illuminate\Http\Response
     */
    public function show(Division $division)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Division $division
     * @return \Illuminate\Http\Response
     */
    public function edit(Division $division)
    {
        return $division;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Division $division
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Division $division)
    {
        $request->validate([
            'nama' => 'required|max:20',
            'flag' => 'required|numeric|max:4',
        ]);

        $division->nama = $request->get('nama');
        $division->flag = $request->get('flag');

        $division->save();

        return response()->json([
            'success' => true,
            'message' => 'Data ' . $this->className . ' Telah Diubah'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Division $division
     * @return \Illuminate\Http\Response
     */
    public function destroy(Division $division)
    {
        $division->delete();
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
        return DataTables::of(Division::query())
            ->addColumn('action', function ($data) {
                return '<a onclick="editForm(' . $data->id . ')" data-toggle="tooltip" class="btn btn-xs btn-primary"> <i class="fa fa-pencil"></i></a>&nbsp;&nbsp;' .
                    '<a onclick="deleteData(' . $data->id . ')" data-toggle="tooltip" class="btn btn-xs btn-danger"> <i class="fa fa-close"></i> </a>';
            })
            ->make(true);
    }

    public function getList()
    {

    }
}
