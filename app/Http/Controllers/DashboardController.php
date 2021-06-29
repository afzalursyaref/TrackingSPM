<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Bud;
use App\Models\Pengelola;
use App\Models\Verifikasi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if($request->ajax()){
            $model = Agenda::leftJoin('skpk', 'agenda.skpk_id', '=', 'skpk.id')
                ->select('agenda.*', 'skpk.nm_skpk')
                ->orderBy('agenda.tgl_agenda', 'asc');
            
            return datatables()->of($model)
                ->addColumn('actions', function($row){
                    $actionBtn = 
                    '<div class="input-group-prepend">
                        <button type="button" class="btn btn-info btn-flat dropdown-toggle" data-toggle="dropdown">
                            Aksi
                        </button>
                        <div class="dropdown-menu">
                            <a href="'.route('dashboard.kode', $row->kode).'" target="_blank" class="dropdown-item" >Lihat Data</a>
                            <a class="dropdown-item" href="'.route('dashboard.timeline', $row->kode).'" target="_blank">Riwayat</a>
                        </div>
                    </div>';
                    return $actionBtn;
                })->rawColumns(['checkbox', 'actions'])
                ->toJson();
        }

        $agenda_count = Agenda::count();
        $agenda_send = Agenda::whereSend(true)->count();

        $kasi_count = Verifikasi::count();
        $kasi_send = Verifikasi::whereSend(true)->count();

        $pengelola_count = Pengelola::count();
        $pengelola_send = Pengelola::whereSend(true)->count();

        $bud_count = Bud::count();
        $bud_send = Bud::whereTerima(true)->count();

        $data = array(
            'agenda_count' => $agenda_count,
            'agenda_send' => $agenda_send,
            'kasi_count' => $kasi_count,
            'kasi_send' => $kasi_send,
            'pengelola_count' => $pengelola_count,
            'pengelola_send' => $pengelola_send,
            'bud_count' => $bud_count,
            'bud_send' => $bud_send,
        );

        return view('dashboard.index', compact('data'));
    }

    public function timeline($kode)
    {
        $agenda = Agenda::whereKode($kode)->first();
        // if(!$agenda){
        //     abort(404);
        // }
        return view('dashboard.timeline', compact('agenda'));
    }

    public function kode($kode)
    {
        $agenda = Agenda::whereKode($kode)->first();
        if(!$agenda){
            abort(404);
        }
        $agenda->jml_kotor = number_format($agenda->jml_kotor, 0, ',', '.');
        $agenda->potongan = number_format($agenda->potongan, 0, ',', '.');
        $agenda->jml_bersih = number_format($agenda->jml_bersih, 0, ',', '.');
        return view('dashboard.kode', compact('agenda'));
    }

    public function updateBox(Request $request)
    {
        $data = array();
        if($request->ajax()){
            $agenda_count = Agenda::count();
            $agenda_send = Agenda::whereSend(true)->count();

            $kasi_count = Verifikasi::count();
            $kasi_send = Verifikasi::whereSend(true)->count();

            $pengelola_count = Pengelola::count();
            $pengelola_send = Pengelola::whereSend(true)->count();

            $bud_count = Bud::count();
            $bud_send = Bud::whereTerima(true)->count();

            $data = array(
                'agenda_count' => $agenda_count,
                'agenda_send' => $agenda_send,
                'kasi_count' => $kasi_count,
                'kasi_send' => $kasi_send,
                'pengelola_count' => $pengelola_count,
                'pengelola_send' => $pengelola_send,
                'bud_count' => $bud_count,
                'bud_send' => $bud_send,
            );
            return response()->json(['response'=>$data]);
        }
    }
}
