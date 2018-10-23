<?php

namespace App\Http\Controllers;

use App\Student;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('student.index');
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nisn' => 'required|max:8',
            'nama' => 'required|max:35',
            'tempat_lahir' => 'required|max:15',
            'tanggal_lahir' => 'required',
            'jen_kel' => 'required|boolean',
            'agama' => 'required|max:15',
            'alamat' => 'required',
            'id_sekolah' => 'required'
        ]);

        $data = new Student();
        $data->nisn = $request->get('nisn');
        $data->nama = $request->get('nama');
        $data->tempat_lahir = $request->get('tempat_lahir');
        $data->tanggal_lahir = $request->get('tanggal_lahir');
        $data->jen_kel = $request->get('jen_kel');
        $data->agama = $request->get('agama');
        $data->alamat = $request->get('alamat');
        $data->id_sekolah = $request->get('id_sekolah');

        $data->save();

        return response()->json([
            'success' => true,
            'message' => 'Data siswa telah ditambah'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Student::findOrFail($id);
        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nisn' => 'required|max:8',
            'nama' => 'required|max:35',
            'tempat_lahir' => 'required|max:15',
            'tanggal_lahir' => 'required',
            'jen_kel' => 'required|boolean',
            'agama' => 'required|max:15',
            'alamat' => 'required',
            'id_sekolah' => 'required'
        ]);

        $data = Student::findOrFail($id);
        $data->nisn = $request->get('nisn');
        $data->nama = $request->get('nama');
        $data->tempat_lahir = $request->get('tempat_lahir');
        $data->tanggal_lahir = $request->get('tanggal_lahir');
        $data->jen_kel = $request->get('jen_kel');
        $data->agama = $request->get('agama');
        $data->alamat = $request->get('alamat');
        $data->id_sekolah = $request->get('id_sekolah');
        $data->update();

        return response()->json([
            'success' => true,
            'message' => 'Data siswa telah diubah'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Student::find($id);
        $data->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data siswa dihapus'
        ]);
    }

    /**
     * Process datatables ajax request.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getData()
    {
        return DataTables::of(Student::query())
            ->addColumn('action', function ($data) {
                return '<a onclick="editForm('. $data->id .')" data-toggle="tooltip" class="btn btn-xs btn-primary"> <i class="fa fa-pencil"></i></a>&nbsp;&nbsp;'.
                    '<a onclick="deleteData('.$data->id.')" data-toggle="tooltip" class="btn btn-xs btn-danger"> <i class="fa fa-close"></i> </a>';
            })
            ->make(true);
    }
}
