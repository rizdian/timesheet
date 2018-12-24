<?php

namespace App\Http\Controllers;

use App\Employee;
use App\HistoryApprove;
use App\Incentive;
use App\insentiveprf;
use App\Prf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class PrfController extends Controller
{
    /**
     * @var string
     */
    private $className = "Prf";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $divisi = $this->getDivisi();
        if ($divisi->nama != 'Personalia') abort(401, 'This action is unauthorized.');

        $lKry = DB::table('employees')
            ->select('employees.id', 'nama')
            ->leftJoin('prfs', 'employees.id', 'prfs.employee_id')
            ->whereNull('prfs.employee_id')
            ->where('division_id', 24)
            ->orWhere('prfs.flag', 0)
            ->whereRaw('employees.id NOT IN (SELECT DISTINCT employee_id FROM prfs WHERE flag != 0)')
            ->orderBy('nama')
            ->distinct()->get()->toArray();

        $lInsen = Incentive::all();

        $AWAL = 'PRF';
        $noUrutAkhir = Prf::max('no_prf');
        $no = 1;
        if ($noUrutAkhir) {
            $tempNo = explode('-', $noUrutAkhir);
            $noFinal = $AWAL . '-' . date('Y') . '-' . sprintf("%03s", abs($tempNo[2] + 1));
        } else {
            $noFinal = $AWAL . '-' . date('Y') . '-' . sprintf("%03s", $no);
        }

        return view('prf.index', compact(['lKry', 'lInsen', 'noFinal']));
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
        $newDate = explode("-", $request->input('SEProject'));
        $sDate = Carbon::createFromFormat('d/m/Y', trim($newDate[0]));
        $eDate = Carbon::createFromFormat('d/m/Y', trim($newDate[1]));
        $sDate->format('Y-m-d');
        $eDate->format('Y-m-d');

        $data = new Prf();
        $data->no_prf = $request->get('no_prf');
        $data->type = $request->get('type');
        $data->nm_client = $request->get('nm_client');
        $data->employee_id = $request->get('employee_id');
        $data->start_project = $sDate->toDateString();
        $data->end_project = $eDate->toDateString();
        $data->keterangan = $request->get('keterangan');
        $data->flag = 1;

        if ($data->save()) {
            foreach ($request->get('insentif_id') as $value) {
                $detail = new insentiveprf();
                $detail->prf_id = $data->id;
                $detail->incentive_id = $value;
                $detail->save();
            }
        }

        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Prf $prf
     * @return \Illuminate\Http\Response
     */
    public function show(Prf $prf)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Prf $prf
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $in = DB::table('insentiveprfs')
            ->join('incentives', 'incentives.id', 'insentiveprfs.incentive_id')
            ->join('prfs', 'prfs.id', 'insentiveprfs.prf_id')
            ->where('prf_id', $id)
            ->get()->toArray();

        $hi = DB::table('history_approves')
            ->join('prfs', 'prfs.id', 'history_approves.prf_id')
            ->join('employees', 'employees.id', 'history_approves.employee_id')
            ->where('prf_id', $id)
            ->get()->toArray();


        return response()->json([
            'header' => Prf::with(['employee'])->findOrFail($id),
            'in' => $in,
            'hi' => $hi

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Prf $prf
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Prf $prf)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Prf $prf
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prf $prf)
    {
        //
    }

    public function indexListApp()
    {
        return view('prf.approve');
    }

    public function listApp()
    {
        $prfByLogin = Prf::with('employee')->where('employee_id', Auth::user()->employee_id)->get();
        if ($prfByLogin->count() != 0){
            return DataTables::of($prfByLogin)
                ->addColumn('action', function ($data) {
                    return '<a onclick="actionDetail(' . $data->id . ')" data-toggle="tooltip" class="btn btn-xs btn-default"> <i class="fa fa-search"></i> </a>';
                })->editColumn('status', function($data) {
                    if ($data->flag == 1 || $data->flag == 2) return 'Di Proses';
                    elseif ($data->flag == 0 ) return 'Di Tolak';
                    else return 'Di Setujui';
                })
                ->make(true);
        }else{
            $divisi = $this->getDivisi();
            $prf = Prf::with('employee')->where('flag', $divisi->flag)->get();
            return DataTables::of($prf)
                ->addColumn('action', function ($data) {
                    return '<a onclick="actionApprove(' . $data->id . ')" data-toggle="tooltip" class="btn btn-xs btn-primary"> <i class="fa fa-pencil"></i></a>&nbsp;&nbsp;' .
                        '<a onclick="actionReject(' . $data->id . ')" data-toggle="tooltip" class="btn btn-xs btn-danger"> <i class="fa fa-close"></i> </a>&nbsp;&nbsp;' .
                        '<a onclick="actionDetail(' . $data->id . ')" data-toggle="tooltip" class="btn btn-xs btn-default"> <i class="fa fa-search"></i> </a>';
                })->editColumn('status', function($data) {
                    if ($data->flag == 1 || $data->flag == 2) return 'Di Proses';
                    elseif ($data->flag == 0 ) return 'Di Tolak';
                    else return 'Di Setujui';
                })
                ->make(true);
        }
    }

    public function approve(Request $request)
    {
        $id = $request->get('id');
        $isApp = Auth::user()->employee_id;

        $prf = Prf::findOrFail($id);
        $prf->flag = $prf->flag + 1;
        $prf->save();

        $historyApp = new HistoryApprove();
        $historyApp->prf_id = $id;
        $historyApp->employee_id = $isApp;
        $historyApp->status = 1;
        $historyApp->save();
        return response()->json([
            'success' => true
        ]);
    }

    public function reject(Request $request)
    {
        $id = $request->get('id');
        $alasan = $request->get('reason');
        $isApp = Auth::user()->employee_id;

        $prf = Prf::findOrFail($id);
        $prf->flag = 0;
        $prf->reason = $alasan;
        $prf->save();

        $historyApp = new HistoryApprove();
        $historyApp->prf_id = $id;
        $historyApp->employee_id = $isApp;
        $historyApp->status = 2;
        $historyApp->save();
        return response()->json([
            'success' => true
        ]);
    }

    private function getDivisi(){
        $user = Auth::user();
        $divisi = Employee::with('division')->where('id',$user->employee_id)->first();
        return $divisi->division;
    }
}
