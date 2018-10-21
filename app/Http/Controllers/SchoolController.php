<?php

namespace App\Http\Controllers;

use App\School;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schools = School::all();
        return view('school.index', compact('schools'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('school.create');
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
            'npsn'=>'required|max:8|unique:schools',
            'nama'=> 'required|max:35',
            'alamat' => 'required',
            'no_telp' => 'required|max:13'
        ]);

        $school = new School();
        $school->npsn = $request->get('npsn');
        $school->nama = $request->get('nama');
        $school->alamat = $request->get('alamat');
        $school->no_telp = $request->get('no_telp');

        $school->save();

        return redirect('/school')->with('success', 'Information has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $school = School::find($id);
        return view('school.edit',compact('school','id'));
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
        $school= School::find($id);
        $school->npsn = $request->get('npsn');
        $school->nama = $request->get('nama');
        $school->alamat = $request->get('alamat');
        $school->no_telp = $request->get('no_telp');
        $school->save();
        return redirect('school');
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
        return redirect('school')->with('success','Information has been  deleted');
    }
}
