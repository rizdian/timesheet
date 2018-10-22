<?php

namespace App\Http\Controllers;

use App\School;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $schools = School::all(); compact('schools')
        return view('school.index');
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
            'npsn' => 'required|max:8|unique:schools',
            'nama' => 'required|max:35',
            'alamat' => 'required',
            'no_telp' => 'required|max:13'
        ]);

        $school = new School();
        $school->npsn = $request->get('npsn');
        $school->nama = $request->get('nama');
        $school->alamat = $request->get('alamat');
        $school->no_telp = $request->get('no_telp');

        $school->save();

        return response()->json([
            'success' => true,
            'message' => 'Sekolah telah ditambah'
        ]);

        //return redirect('/school')->with('success', 'Sekolah telah ditambah');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $school = School::findOrFail($id);
        return $school;

        /*$school = School::find($id);
        return view('school.edit', compact('school', 'id'));*/
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'npsn' => 'required|max:8|',
            'nama' => 'required|max:35',
            'alamat' => 'required',
            'no_telp' => 'required|max:13'
        ]);

        $school = School::findOrFail($id);
        $school->npsn = $request->get('npsn');
        $school->nama = $request->get('nama');
        $school->alamat = $request->get('alamat');
        $school->no_telp = $request->get('no_telp');
        $school->update();

        return response()->json([
            'success' => true,
            'message' => 'Sekolah telah diubah'
        ]);

        //return redirect('/school')->with('success', 'Sekolah telah diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $school = School::find($id);
        $school->delete();
        return response()->json([
            'success' => true,
            'message' => 'Sekolah Terhapus'
        ]);
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData()
    {
        return DataTables::of(School::query())
            ->addColumn('action', function ($school) {
                return '<a onclick="editForm('. $school->id .')" data-toggle="tooltip" class="btn btn-xs btn-primary"> <i class="fa fa-pencil"></i></a>&nbsp;&nbsp;'.
                    '<a onclick="deleteData('.$school->id.')" data-toggle="tooltip" class="btn btn-xs btn-danger"> <i class="fa fa-close"></i> </a>';
            })
            ->make(true);
    }
}
