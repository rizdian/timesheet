<?php

namespace App\Http\Controllers;

use App\Donatur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonaturAnakAsuhController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            $request->user()->authorizeRoles(['super_admin', 'admin', 'user']);
            return $next($request);
        });
    }

    public function saveDonaturAnakAsuh(Request $request)
    {
        $request->validate([
            'donatur_id' => 'required',
            'anak_asuh_id' => 'required',
        ]);

        $donatur = Donatur::where('id', $request->donatur_id)->first();
        $donatur->anakasuhs()->attach($request->anak_asuh_id);
        return response()->json([
            'success' => true,
            'message' => 'Data Anak Asuh Atas Nama ' . $donatur->nama . ' Telah Ditambah'
        ]);
    }

    public function deleteDonaturAnakAsuh(Request $request, $id)
    {
        $donatur = Donatur::where('id', $request->donatur_id)->first();
        $donatur->anakasuhs()->detach($id);
        return response()->json([
            'success' => true,
            'message' => 'Data Anak Asuh Atas Nama ' . $donatur->nama . ' Telah Dihapus'
        ]);
    }
}
