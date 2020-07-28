<?php

namespace App\Http\Controllers;

use App\Acara;
use App\Donatur;
use App\Employee;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class AcaraController extends Controller
{
    /**
     * @var string
     */
    private $className = "Acara";

    /**
     * AcaraController constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('acara.index');
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
            'nama' => 'required',
            'deskripsi' => 'required',
            'periode' => 'required|date',
            'status' => 'required',
        ]);

        $newDate = new Carbon($request->get('periode'));
        $newDate->format('Y-m-d');

        $data = new Acara();
        $data->nama = $request->get('nama');
        $data->deskripsi = $request->get('deskripsi');
        $data->periode = $newDate;
        $data->status = $request->get('status');

        $data->save();

        return response()->json([
            'success' => true,
            'message' => 'Data ' . $this->className . ' Telah Ditambah'
        ]);
    }

    /**
     * @param Acara $acara
     */
    public function show(Acara $acara)
    {
        //
    }

    /**
     * @param Employee $acara
     * @return Employee
     */
    public function edit(Acara $acara)
    {
        return $acara;
    }

    /**
     * @param Request $request
     * @param Acara $acara
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Acara $acara)
    {
        $request->validate([
            'nama' => 'required',
            'deskripsi' => 'required',
            'periode' => 'required|date',
            'status' => 'required',
        ]);

        $newDate = new Carbon($request->get('tgl_transfer'));
        $newDate->format('Y-m-d');

        $acara->nama = $request->get('nama');
        $acara->deskripsi = $request->get('deskripsi');
        $acara->periode = $newDate;
        $acara->status = $request->get('status');

        $acara->save();

        return response()->json([
            'success' => true,
            'message' => 'Data ' . $this->className . ' Telah Diubah'
        ]);
    }

    /**
     * @param Acara $acara
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Acara $acara)
    {
        Auth::user()->authorizeRoles(['super_admin', 'admin']);

        $acara->delete();
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
        $acaras = Acara::withCount('donasis')->get();
        return DataTables::of($acaras)
            ->editColumn('periode', function ($data) {
                return date('F Y', strtotime($data->periode));
            })
            ->addColumn('jumlah_donasi', function ($data) {
                return $data->donasis_count;
            })
            ->addColumn('action', function ($data) {
                $isDeleteDisable = "onclick='deleteData(" . $data->id . ")'";
                if ($data->donasis_count > 0) {
                    $isDeleteDisable = "disabled";
                }
                $delete = '<a data-toggle="tooltip" title="Hapus" class="btn btn-xs btn-danger" ' . $isDeleteDisable . '> <i class="fa fa-close"></i> </a>&nbsp;&nbsp;';

                $isClosingDisable = "onclick='closeForm(" . $data->id . ")'";
                $isEditDisable = "onclick='editForm(" . $data->id . ")'";
                $isTambahDisable = "href='" . route('page.list.acara-donasi', $data->id) . "'";
                if ($data->closing_date != null) {
                    $isClosingDisable = "disabled";
                    $isEditDisable = "disabled";
                    $isTambahDisable = "disabled";
                }
                $close = '<a data-toggle="tooltip" title="Close" class="btn btn-xs btn-warning" ' . $isClosingDisable . '> <i class="fa fa-inbox"></i></a>&nbsp;&nbsp;';
                $edit = '<a data-toggle="tooltip" title="Ubah" class="btn btn-xs btn-primary" ' . $isEditDisable . '> <i class="fa fa-pencil"></i></a>&nbsp;&nbsp;';
                $tambah = '<a data-toggle="tooltip" title="Tambah Donasi" class="btn btn-xs btn-success" ' . $isTambahDisable . '> <i class="fa fa-money"></i></a>&nbsp;&nbsp;';

                return $tambah . $edit . $delete . $close;
            })
            ->make(true);
    }

    public function getPageListDonasi($id)
    {
        $acara = Acara::where('id', $id)->firstOrFail();
        $lDonatur = Donatur::pluck('nama', 'id')->toArray();
        return view('acara.list-donasi', compact('acara', 'lDonatur'));
    }

    public function getListDonasi($id)
    {
        $acara = Acara::with('donasis', 'donasis.donatur')->where('id', $id)->firstOrFail();
        return DataTables::of($acara->donasis)
            ->addIndexColumn()
            ->editColumn('filename', function ($data) {
                if ($data->type == "transfer") {
                    return $data->filename;
                } else {
                    return "-";
                }

            })
            ->editColumn('tgl_transfer', function ($data) {
                if ($data->type == "transfer") {
                    if ($data->tgl_transfer != null) {
                        return date('d F Y', strtotime($data->tgl_transfer));
                    }
                } else {
                    return "-";
                }

            })
            ->editColumn('verifikasi', function ($data) {
                if ($data->type == "transfer") {
                    if ($data->verifikasi == 1)
                        return "verifikasi";
                    else
                        return "pending";
                } else {
                    return "-";
                }
            })
            ->editColumn('created_at', function ($data) {
                return date('d F Y  H:i', strtotime($data->created_at));
            })
            ->addColumn('action', function ($data) {
                $ver = "";
                $detail = "";
                if ($data->type == 'transfer') {
                    $vDate = $data->verifikasi_date != null ? date('d F Y  H:i', strtotime($data->verifikasi_date)) : "";
                    $vBy = $data->verifikasi_by;

                    $ver = '<a onclick="verifikasiData(' . $data->id . ')" data-toggle="tooltip" class="btn btn-xs btn-success"  title="Verifikasi Donasi"> <i class="fa fa-check-circle"></i> </a>';

                    if ($data->verifikasi == 1)
                        $ver = '<a onclick="verifikasiDetail(this)" data-date="' . $vDate . '" data-by="' . $vBy . '" data-toggle="tooltip" class="btn btn-xs btn-primary"  title="Detail Verifikasi"> <i class="fa fa-info-circle"></i> </a>';
                }


                return '<a onclick="deleteData(' . $data->id . ')" data-toggle="tooltip" class="btn btn-xs btn-danger"  title="Hapus Donasi"> <i class="fa fa-close"></i> </a>' . $ver . $detail;
            })
            ->make(true);
    }

    public function getCloseDonasi($id, Request $request)
    {
        $request->validate(['total' => 'required|numeric']);

        $data = Acara::find($id);

        $newDate = new Carbon();
        $newDate->format('Y-m-d');

        $data->actual_donasi = $request->get("total");
        $data->closing_by = Auth::user()['name'];
        $data->closing_date = $newDate;
        $data->status = "closing";
        $data->save();

        return response()->json([
            'success' => true,
            'message' => 'Data ' . $this->className . ' Telah Di-Closing'
        ]);
    }
}
