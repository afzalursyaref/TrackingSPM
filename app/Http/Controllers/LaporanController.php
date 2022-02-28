<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function format_date($tgl)
    {
        return \Carbon\Carbon::createFromFormat('d-m-Y', $tgl)->format('Y-m-d');
    }

    public function index(Request $request)
    {
        if($request->ajax()){
            $model = Agenda::leftJoin('skpk', 'agenda.skpk_id', '=', 'skpk.id')
            ->leftJoin('users', 'agenda.disposisi_user_id', '=', 'users.id')
            ->select('agenda.*', 'skpk.nm_skpk', 'users.name');
                // ->orderBy('agenda.tgl_agenda', 'asc');

            return datatables()->of($model)
                ->startsWithSearch()
                ->filter(function ($query) use ($request) {
                    if($request->filled('tgl_start') && $request->filled('tgl_end')){
                        $query->whereDate('tgl_agenda', '>=', $this->format_date($request->tgl_start))
                        ->whereDate('tgl_agenda', '<=', $this->format_date($request->tgl_end));
                    }
                })
                ->editColumn('tgl_agenda', function($row){
                    return \Carbon\Carbon::parse($row->tgl_agenda)->format('d-m-Y H:i');
                })
                ->editColumn('tgl_spm', function($row){
                    return \Carbon\Carbon::parse($row->tgl_spm)->format('d-m-Y');
                })
                ->addColumn('checkbox', function($row){
                    return '<input type="checkbox" name="id_checkbox[]" class="id_checkbox" value="'.$row->id.'"/>';
                })
                ->addColumn('actions', function($row){
                    $actionBtn =
                    '<div class="input-group-prepend">
                        <button type="button" class="btn btn-info btn-flat dropdown-toggle" data-toggle="dropdown">
                            Aksi
                        </button>
                        <div class="dropdown-menu">
                            <a href="'.route('agenda.edit', $row->id).'" class="dropdown-item" ><span class="fas fa-pencil-alt mr-2"></span> Ubah</a>
                            <a href="javascript:void(0)" data-id="'.$row->id.'" class="dropdown-item text-danger deleteAgenda" ><span class="fas fa-trash mr-2"></span> Hapus</a>
                            <a href="'.route('agenda.show', $row->id).'" class="dropdown-item" ><span class="fas fa-eye mr-2"></span>Lihat Data</a>
                            <a href="'.route('agenda.cetak', $row->id).'" target="_blank" class="dropdown-item" ><span class="fas fa-print mr-2"></span>Cetak</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="'.route('dashboard.timeline', $row->kode).'" target="_blank">Riwayat</a>
                        </div>
                    </div>';
                    return $actionBtn;
                })->rawColumns(['checkbox', 'actions'])
                ->make(true);
        }
        return view('laporan.register.index');
    }

    public function cetakRegister(Request $request)
    {
        $request->validate([
            'tgl_start' => 'required|date_format:d-m-Y',
            'tgl_end' => 'required|date_format:d-m-Y',
        ]);

        $data = Agenda::leftJoin('skpk', 'agenda.skpk_id', '=', 'skpk.id')
            ->leftJoin('users', 'agenda.disposisi_user_id', '=', 'users.id')
            ->select('agenda.*', 'skpk.nm_skpk', 'users.name')
            ->whereDate('tgl_agenda', '>=', $this->format_date($request->tgl_start))
            ->whereDate('tgl_agenda', '<=', $this->format_date($request->tgl_end))
            ->orderBy('nomor', 'ASC')
            ->get();


        $tgl_1 = Carbon::createFromFormat('d-m-Y', $request->tgl_start)->isoFormat('D MMMM Y');
        $tgl_2 = Carbon::createFromFormat('d-m-Y', $request->tgl_end)->isoFormat('D MMMM Y');
        return view('laporan.register.template', compact('data', 'tgl_1', 'tgl_2'));
    }
}
