<?php

namespace App\Http\Controllers;

use App\Donasi;
use App\Donatur;
use App\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class DonasiController extends Controller
{
    /**
     * @var string
     */
    private $className = "Donasi";

    /**
     * DonasiController constructor.
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
        $lDonatur = Donatur::pluck('nama', 'id')->toArray();
        return view('donasi.index', compact('lDonatur'));
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
            'donatur_id' => 'required|integer',
            'acara_id' => 'required|integer',
            'nominal' => 'required|integer',
            'type' => 'required',
        ]);



        $data = new Donasi();
        $data->acara_id = $request->get('acara_id');
        $data->donatur_id = $request->get('donatur_id');
        $data->nominal = $request->get('nominal');
        $data->type = $request->get('type');

        if ($request->get('tgl_transfer') != null){
            $newDate = new Carbon($request->get('tgl_transfer'));
            $newDate->format('Y-m-d');
            $data->tgl_transfer = $newDate;
            $data->filename = time() . '-' . $data->donatur_id . "." . $request->filename->getClientOriginalExtension();
            //move file to folder storage
            $request->filename->storeAs('donasi', $data->filename);
        }

        $data->save();

        return response()->json([
            'success' => true,
            'message' => 'Data ' . $this->className . ' Telah Ditambah'
        ]);
    }

    /**
     * @param Donasi $donasi
     */
    public function show(Donasi $donasi)
    {
        //
    }

    /**
     * @param Employee $donasi
     * @return Employee
     */
    public function edit(Donasi $donasi)
    {
        return $donasi;
    }

    /**
     * @param Request $request
     * @param Donasi $donasi
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Donasi $donasi)
    {
        $request->validate([
            'nominal' => 'required|integer',
            'tgl_transfer' => 'required|date',
            'donatur_id' => 'required',
        ]);

        $newDate = new Carbon($request->get('tgl_transfer'));
        $newDate->format('Y-m-d');

        $donasi->nominal = $request->get('nominal');
        $donasi->tgl_transfer = $newDate;
        $donasi->donatur_id = $request->get('donatur_id');

        if ($request->filename != null) {
            Storage::delete('donasi/' . $donasi->filename);
            $donasi->filename = time() . '-' . $donasi->donatur_id . "." . $request->filename->getClientOriginalExtension();
            $request->filename->storeAs('donasi', $donasi->filename);
        }

        $donasi->save();

        return response()->json([
            'success' => true,
            'message' => 'Data ' . $this->className . ' Telah Diubah'
        ]);
    }

    /**
     * @param Donasi $donasi
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Donasi $donasi)
    {
        Storage::delete('donasi/' . $donasi->filename);
        $donasi->delete();
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
        $donasis = Donasi::with('donatur')->get();
        return DataTables::of($donasis)
            ->editColumn('tgl_transfer', function ($data) {
                return date('d F Y', strtotime($data->tgl_transfer));
            })
            ->addColumn('action', function ($data) {
                return '<a onclick="editForm(' . $data->id . ')" data-toggle="tooltip" class="btn btn-xs btn-primary"> <i class="fa fa-pencil"></i></a>&nbsp;&nbsp;' .
                    '<a onclick="deleteData(' . $data->id . ')" data-toggle="tooltip" class="btn btn-xs btn-danger"> <i class="fa fa-close"></i> </a>';
            })
            ->make(true);
    }

    /**
     * @return Donasi[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getList()
    {
        $donasis = Donasi::all();
        return $donasis;
    }

    public function downloadBukti($id)
    {
        $data = Donasi::select('filename')->where('id', $id)->first();
        return Storage::download('donasi/' . $data->filename);
    }
}
