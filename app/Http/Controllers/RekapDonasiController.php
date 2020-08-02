<?php

namespace App\Http\Controllers;

use App\Acara;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as PDF;

class RekapDonasiController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::user();
            $request->user()->authorizeRoles(['super_admin', 'admin', 'user']);
            return $next($request);
        });
    }

    public function showRekapDonasi()
    {
        $lacara = Acara::where("status", "closing")->pluck('nama', 'id')->toArray();
        return view('donasi.rekap', compact('lacara'));
    }


    public function displayReport(Request $request)
    {
        $header = Acara::find($request->input("acara_id"));

        $isi = Acara::join('donasis', 'acaras.id', '=', 'donasis.acara_id')
            ->join('donaturs', 'donasis.donatur_id', '=', 'donaturs.id')
            ->select('donaturs.nama', 'donaturs.no_telp', 'donasis.nominal', 'donasis.type', 'donasis.created_at')
            ->where('acaras.id', $request->input("acara_id"))->get();

//        return view('donasi.report', ['acara' => $header, 'isi' => $isi]);

        $pdf = PDF::loadview('donasi.report', ['acara' => $header, 'isi' => $isi]);
        return $pdf->download('laporan-donasi-acara-' . $header->nama);
    }
}
