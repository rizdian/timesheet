<?php

namespace App\Http\Controllers;

use App\HistoryApprove;
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

        $lKry = DB::table('employees')
            ->select('employees.id', 'nama')
            ->leftJoin('prfs', 'employees.id', 'prfs.employee_id')
            ->whereNull('prfs.employee_id')
            ->orWhere('prfs.flag', 0)
            ->whereRaw('employees.id NOT IN (SELECT DISTINCT employee_id FROM prfs WHERE flag != 0)')
            ->orderBy('nama')
            ->distinct()->get()->toArray();
        return view('prf.index',compact(['lKry']));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $newDate = explode("-", $request->input('SEProject'));
        $sDate = new Carbon($newDate[0]);
        $sDate->format('Y-m-d');
        $eDate = new Carbon($newDate[1]);
        $eDate->format('Y-m-d');

        $data = new Prf();
        $data->no_prf = $request->get('no_prf');
        $data->type = $request->get('type');
        $data->nm_client = $request->get('nm_client');
        $data->employee_id = $request->get('employee_id');
        $data->start_project = $sDate;
        $data->end_project = $eDate;
        $data->keterangan = $request->get('keterangan');
        $data->flag = 1;

        if ($data->save()) {
            foreach ($request->get('insentif_id') as $value){
                $detail = new insentiveprf();
                $detail->prfs_id = $data->id;
                $detail->incentive_id = $value;
                $detail->save();
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Prf  $prf
     * @return \Illuminate\Http\Response
     */
    public function show(Prf $prf)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Prf  $prf
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return response()->json(
            Prf::with(['Insentiveprf','historyApproves','employee'])->findOrFail($id)
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Prf  $prf
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Prf $prf)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Prf  $prf
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prf $prf)
    {
        //
    }

    public function indexListApp(){
        return view('prf.approve');
    }

    public function listApp(){
        $prf = Prf::with('employee')->get();
        return DataTables::of($prf)
            ->addColumn('action', function ($data) {
                return '<a onclick="actionApprove(' . $data->id . ')" data-toggle="tooltip" class="btn btn-xs btn-primary"> <i class="fa fa-pencil"></i></a>&nbsp;&nbsp;' .
                    '<a onclick="actionReject(' . $data->id . ')" data-toggle="tooltip" class="btn btn-xs btn-danger"> <i class="fa fa-close"></i> </a>&nbsp;&nbsp;' .
                    '<a onclick="actionDetail(' . $data->id . ')" data-toggle="tooltip" class="btn btn-xs btn-default"> <i class="fa fa-search"></i> </a>';
            })
            ->make(true);
    }

    public function approve(Request $request){
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

    public function reject(Request $request){
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
}
