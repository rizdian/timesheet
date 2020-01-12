<?php

namespace App\Http\Controllers;

use App\Donasi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PdfReport;
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
        return view('donasi.rekap');
    }


    public function displayReport(Request $request)
    {
        $fromDate = Carbon::parse($request->input('from_date'));
        $toDate = Carbon::parse($request->input('to_date'));

        $title = 'Donasi Report'; // Report title

        $meta = [ // For displaying filters description on header
            'Transfer on' => $request->input('from_date') . ' To ' . $request->input('to_date'),
        ];

        $queryBuilder = Donasi::join('donaturs', 'donaturs.id', '=', 'donasis.donatur_id')
            ->whereBetween('tgl_transfer', [$fromDate, $toDate]);

        $columns = [ // Set Column to be displayed
            'Nama' => 'nama',
            'Tanggal Transfer' => 'tgl_transfer',
            'Nominal' => 'nominal'
        ];

        // Generate Report with flexibility to manipulate column class even manipulate column value (using Carbon, etc).
        return PdfReport::of($title, $meta, $queryBuilder, $columns)
            ->editColumn('Tanggal Transfer', [
                'displayAs' => function ($result) {
                    return date('d F Y', strtotime($result->tgl_transfer));
                },
                'class' => 'left'
            ])
            ->editColumn('Nominal', [
                'class' => 'right bold',
                'displayAs' => function($result) {
                    return number_format($result->nominal,2);
                }
            ])
            ->showTotal([ // Used to sum all value on specified column on the last table (except using groupBy method). 'point' is a type for displaying total with a thousand separator
                'Nominal' => 'Rp.' // if you want to show dollar sign ($) then use 'Total Balance' => '$'
            ])
            ->groupBy('Nama')
            ->limit(20) // Limit record to be showed
            ->stream(); // other available method: download('filename') to download pdf / make() that will producing DomPDF / SnappyPdf instance so you could do any other DomPDF / snappyPdf method such as stream() or download()
    }
}
