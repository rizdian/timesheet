<?php

namespace App\Http\Controllers;

use App\AnakAsuh;
use App\Division;
use App\Donatur;
use Carbon\Carbon;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class DonaturController extends Controller
{
    /**
     * @var string
     */
    private $className = "Donatur";

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
        return view('donatur.index');
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
            'nama' => 'required|max:50',
            'tmpt_lahir' => 'required|max:30',
            'tgl_lahir' => 'required|date',
            'no_telp' => 'required|max:15',
            'email' => 'required|max:100',
            'alamat' => 'required',
        ]);

        $newDate = new Carbon($request->get('tgl_lahir'));
        $newDate->format('Y-m-d');

        $donatur = new Donatur();
        $donatur->nama = $request->get('nama');
        $donatur->tmpt_lahir = $request->get('tmpt_lahir');
        $donatur->tgl_lahir = $newDate;
        $donatur->no_telp = $request->get('no_telp');
        $donatur->email = $request->get('email');
        $donatur->alamat = $request->get('alamat');
        $donatur->save();

        return response()->json([
            'success' => true,
            'message' => 'Data ' . $this->className . ' Telah Ditambah'
        ]);
    }

    /**
     * @param Donatur $donatur
     */
    public function show(Donatur $donatur)
    {
        //
    }

    /**
     * @param Donatur $donatur
     * @return Donatur
     */
    public function edit(Donatur $donatur)
    {
        return $donatur;
    }

    /**
     * @param Request $request
     * @param Donatur $donatur
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Donatur $donatur)
    {
        $request->validate([
            'nama' => 'required|max:50',
            'tmpt_lahir' => 'required|max:30',
            'tgl_lahir' => 'required|date',
            'no_telp' => 'required|max:15',
            'email' => 'required|max:100',
            'alamat' => 'required',
        ]);

        $newDate = new Carbon($request->get('tgl_lahir'));
        $newDate->format('Y-m-d');

        $donatur->nip = $request->get('nip');
        $donatur->nama = $request->get('nama');
        $donatur->tmpt_lahir = $request->get('tmpt_lahir');
        $donatur->tgl_lahir = $newDate;
        $donatur->no_telp = $request->get('no_telp');
        $donatur->email = $request->get('email');
        $donatur->alamat = $request->get('alamat');

        $donatur->save();

        return response()->json([
            'success' => true,
            'message' => 'Data ' . $this->className . ' Telah Diubah'
        ]);
    }

    /**
     * @param Donatur $donatur
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Donatur $donatur)
    {
        $donatur->delete();
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
        $donaturs = Donatur::all();
        return DataTables::of($donaturs)
            ->editColumn('tgl_lahir', function ($data) {
                return date('d M Y', strtotime($data->tgl_lahir));
            })
            ->addColumn('action', function ($data) {
                return '<a onclick="editForm(' . $data->id . ')" data-toggle="tooltip" class="btn btn-xs btn-primary"> <i class="fa fa-pencil"></i></a>&nbsp;&nbsp;' .
                    '<a onclick="deleteData(' . $data->id . ')" data-toggle="tooltip" class="btn btn-xs btn-danger"> <i class="fa fa-close"></i> </a>&nbsp;&nbsp;' .
                    '<a href="' . route('page.list.donatur-donasi', $data->id) . '" data-toggle="tooltip" class="btn btn-xs btn-info"> <i class="fa fa-hand-paper-o"></i> </a>&nbsp;&nbsp;' .
                    '<a href="' . route('page.list.donatur-anakasuh', $data->id) . '" data-toggle="tooltip" class="btn btn-xs btn-warning"> <i class="fa fa-users"></i> </a>';
            })
            ->make(true);
    }

    /**
     * @return Donatur[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getList()
    {
        $donaturs = Donatur::all();
        return $donaturs;
    }

    public function getPageListDonasi($id)
    {
        $donatur = Donatur::where('id', $id)->firstOrFail();
        return view('donatur.list-donasi', compact('donatur'));
    }

    public function getListDonasi($id)
    {
        $donatur = Donatur::with('donasis')->where('id', $id)->firstOrFail();
        return DataTables::of($donatur->donasis)
            ->addIndexColumn()
            ->editColumn('tgl_transfer', function ($data) {
                return date('d F Y', strtotime($data->tgl_transfer));
            })
            ->make(true);
    }

    public function getPageListAnakAsuh($id)
    {
        $donatur = Donatur::where('id', $id)->firstOrFail();

        $lAnakAsuh = AnakAsuh::whereRaw('id not in (select a.id
                   from anak_asuhs a
                            inner join anak_asuh_donatur aad on a.id = aad.anak_asuh_id
                            inner join donaturs d on aad.donatur_id = d.id
                   where d.id = ' . $id . ')')->pluck('nama', 'id')->toArray();

        return view('donatur.list-anakasuh', compact('donatur', 'lAnakAsuh'));
    }

    public function getListAnakAsuh($id)
    {
        $donatur = Donatur::with('anakasuhs')->where('id', $id)->firstOrFail();
        return DataTables::of($donatur->anakasuhs)
            ->addColumn('action', function ($data) {
                return '<a onclick="deleteData(' . $data->id . ')" data-toggle="tooltip" class="btn btn-xs btn-danger"> <i class="fa fa-close"></i> </a>';
            })->make(true);
    }
}
