<?php

namespace App\Http\Controllers;

use App\Incentive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class IncentiveController extends Controller
{
    /**
     * @var string
     */
    private $className = "Insentif";

    /**
     * IncentiveController constructor.
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
        return view('incentive.index');
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
            'nama' => 'required|max:20',
            'harga' => 'required|integer',
        ]);

        $data = new Incentive();
        $data->nama = $request->get('nama');
        $data->harga = $request->get('harga');

        $data->save();

        return response()->json([
            'success' => true,
            'message' => 'Data ' . $this->className . ' Telah Ditambah'
        ]);
    }

    /**
     * @param Incentive $incentive
     */
    public function show(Incentive $incentive)
    {
        //
    }

    /**
     * @param Incentive $incentive
     * @return Incentive
     */
    public function edit(Incentive $incentive)
    {
        return $incentive;
    }

    /**
     * @param Request $request
     * @param Incentive $incentive
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Incentive $incentive)
    {
        $request->validate([
            'nama' => 'required|max:20',
            'harga' => 'required|integer',
        ]);

        $incentive->nama = $request->get('nama');
        $incentive->harga = $request->get('harga');

        $incentive->save();

        return response()->json([
            'success' => true,
            'message' => 'Data ' . $this->className . ' Telah Diubah'
        ]);
    }

    /**
     * @param Incentive $incentive
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Incentive $incentive)
    {
        $incentive->delete();
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
        return DataTables::of(Incentive::query())
            ->addColumn('action', function ($data) {
                return '<a onclick="editForm(' . $data->id . ')" data-toggle="tooltip" class="btn btn-xs btn-primary"> <i class="fa fa-pencil"></i></a>&nbsp;&nbsp;' .
                    '<a onclick="deleteData(' . $data->id . ')" data-toggle="tooltip" class="btn btn-xs btn-danger"> <i class="fa fa-close"></i> </a>';
            })
            ->make(true);
    }

    /**
     * @return Incentive[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getList()
    {
        return Incentive::all();
    }
}
