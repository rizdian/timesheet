<?php

namespace App\Http\Controllers;

use App\Incentive;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class IncentiveController extends Controller
{
    private $className = "Insentif";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('incentive.index');
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
     * Display the specified resource.
     *
     * @param  \App\Incentive $incentive
     * @return \Illuminate\Http\Response
     */
    public function show(Incentive $incentive)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Incentive $incentive
     * @return \Illuminate\Http\Response
     */
    public function edit(Incentive $incentive)
    {
        return $incentive;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Incentive $incentive
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Incentive $incentive)
    {
        $request->validate([
            'nama' => 'required|max:20',
            'harga' => 'required|integer',
        ]);

        $incentive->nama = $request->get('nama');
        $incentive->harga = $request->get('harga');

        $incentive->update();

        return response()->json([
            'success' => true,
            'message' => 'Data ' . $this->className . ' Telah Diubah'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Incentive $incentive
     * @return \Illuminate\Http\Response
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
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
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
}
