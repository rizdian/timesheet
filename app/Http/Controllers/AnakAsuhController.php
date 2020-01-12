<?php

namespace App\Http\Controllers;

use App\AnakAsuh;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class AnakAsuhController extends Controller
{
    /**
     * @var string
     */
    private $className = "Anak Asuh";

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
        return view('anakAsuh.index');
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
            'no_reg' => 'required|max:19',
            'nama' => 'required|max:50',
            'filename' => 'required|mimetypes:application/pdf|max:10000',
        ]);

        $data = new AnakAsuh();
        $data->no_reg = $request->get('no_reg');
        $data->nama = $request->get('nama');
        $data->filename = time() . '-' . $request->filename->getClientOriginalName();
        //move file to folder storage
        $request->filename->storeAs('anakAsuh', $data->filename);

        $data->save();

        return response()->json([
            'success' => true,
            'message' => 'Data ' . $this->className . ' Telah Ditambah'
        ]);
    }

    /**
     * @param AnakAsuh $anakAsuh
     */
    public function show(AnakAsuh $anakAsuh)
    {
        //
    }

    /**
     * @param AnakAsuh $anakAsuh
     * @return AnakAsuh
     */
    public function edit(AnakAsuh $anakAsuh)
    {
        return $anakAsuh;
    }

    /**
     * @param Request $request
     * @param AnakAsuh $anakAsuh
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, AnakAsuh $anakAsuh)
    {
        $request->validate([
            'no_reg' => 'required|max:19',
            'nama' => 'required|max:50',
        ]);

        $anakAsuh->no_reg = $request->get('no_reg');
        $anakAsuh->nama = $request->get('nama');
        if ($request->filename != null) {
            $anakAsuh->filename = time() . '-' . $request->filename->getClientOriginalName();
            $request->filename->storeAs('anakAsuh', $anakAsuh->filename);
        }
        $anakAsuh->save();

        return response()->json([
            'success' => true,
            'message' => 'Data ' . $this->className . ' Telah Diubah'
        ]);
    }

    /**
     * @param AnakAsuh $anakAsuh
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(AnakAsuh $anakAsuh)
    {
        $anakAsuh->delete();
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
        $anakAsuhs = AnakAsuh::all();
        return DataTables::of($anakAsuhs)
            ->addColumn('action', function ($data) {
                return '<a onclick="editForm(' . $data->id . ')" data-toggle="tooltip" class="btn btn-xs btn-primary"> <i class="fa fa-pencil"></i></a>&nbsp;&nbsp;' .
                    '<a onclick="deleteData(' . $data->id . ')" data-toggle="tooltip" class="btn btn-xs btn-danger"> <i class="fa fa-close"></i> </a>';
            })
            ->make(true);
    }

    /**
     * @return AnakAsuh[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getList()
    {
        $anakAsuhs = AnakAsuh::all();
        return $anakAsuhs;
    }

    public function downloadProfile($id)
    {
        $data = AnakAsuh::select('filename')->where('id', $id)->first();
        return Storage::download('anakAsuh/' . $data->filename);
    }
}
