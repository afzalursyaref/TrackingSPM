<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Bud;
use App\Models\DetailPengelola;
use App\Models\Pengelola;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengelolaController extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();
        if($request->ajax()){
            $query = Pengelola::join('verifikasi', 'verifikasi.id', '=', 'pengelola.verifikasi_id')
                        ->leftJoin('agenda', 'agenda.id', '=', 'verifikasi.agenda_id')
                        ->leftJoin('skpk', 'agenda.skpk_id', '=', 'skpk.id')
                        ->leftJoin('users', 'pengelola.disposisi_user_id', '=', 'users.id')
                        ->select(
                            'pengelola.*',
                            'verifikasi.catatan', 
                            'agenda.nomor', 'agenda.kode','agenda.tgl_agenda', 'agenda.no_spm', 'agenda.tgl_spm', 'agenda.uraian', 'agenda.jml_kotor', 'agenda.potongan', 'agenda.jml_bersih',
                            'skpk.nm_skpk', 'users.name'
                        )->where('pengelola.send', '=', false)
                        ->where('verifikasi.disposisi_user_id', '=', $userId);
            
            return datatables()->of($query)
                ->editColumn('tgl_agenda', function($row){
                    return \Carbon\Carbon::parse($row->tgl_agenda)->format('d-m-Y H:i');
                })
                ->editColumn('tgl_spm', function($row){
                    return \Carbon\Carbon::parse($row->tgl_spm)->format('d-m-Y');
                })
                ->addColumn('checkbox', function($row){
                    //cek detail
                    $cek = DetailPengelola::where('pengelola_id', '=', $row->id)->count();
                    if($cek > 0){
                        return '<input type="checkbox" name="id_checkbox[]" class="id_checkbox" value="'.$row->id.'"/>';
                    }
                })
                ->addColumn('actions', function($row){
                    $actionBtn = 
                    '<div class="input-group-prepend">
                        <button type="button" class="btn btn-info btn-flat dropdown-toggle" data-toggle="dropdown">
                            Aksi
                        </button>
                        <div class="dropdown-menu">
                            <a href="'.route('pengelola.create', $row->id).'" class="dropdown-item" ><span class="fas fa-pencil-alt mr-2"></span> Buat Catatan</a>
                            <a href="javascript:void(0)" data-id="'.$row->id.'" class="dropdown-item text-danger deletePengelola" ><span class="fas fa-trash mr-2"></span> Hapus</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="'.route('dashboard.timeline', $row->kode).'" target="_blank">Riwayat</a>
                        </div>
                    </div>';
                    return $actionBtn;
                })->rawColumns(['checkbox', 'actions'])
                ->toJson(true);
        }

        return view('pengelola.index');
    }

    public function listPengelola(Request $request)
    {
        $userId = auth()->id();
        if($request->ajax()){
            $query = Pengelola::join('verifikasi', 'verifikasi.id', '=', 'pengelola.verifikasi_id')
                        ->leftJoin('agenda', 'agenda.id', '=', 'verifikasi.agenda_id')
                        ->leftJoin('skpk', 'agenda.skpk_id', '=', 'skpk.id')
                        ->leftJoin('users', 'pengelola.disposisi_user_id', '=', 'users.id')
                        ->select(
                            'pengelola.*',
                            'verifikasi.catatan', 
                            'agenda.nomor', 'agenda.kode','agenda.tgl_agenda', 'agenda.no_spm', 'agenda.tgl_spm', 'agenda.uraian', 'agenda.jml_kotor', 'agenda.potongan', 'agenda.jml_bersih',
                            'skpk.nm_skpk', 'users.name'
                        )->where('pengelola.send', '=', true)
                        ->where('verifikasi.disposisi_user_id', '=', $userId)
                        ->orderBy('agenda.tgl_agenda', 'desc');
            
            return datatables()->of($query)
                ->editColumn('tgl_agenda', function($row){
                    return \Carbon\Carbon::parse($row->tgl_agenda)->format('d-m-Y H:i');
                })
                ->editColumn('tgl_spm', function($row){
                    return \Carbon\Carbon::parse($row->tgl_spm)->format('d-m-Y');
                })
                ->addColumn('actions', function($row){
                    $actionBtn = 
                    '<div class="input-group-prepend">
                        <button type="button" class="btn btn-info btn-flat dropdown-toggle" data-toggle="dropdown">
                            Aksi
                        </button>
                        <div class="dropdown-menu">
                        <a href="'.route('pengelola.show', $row->id).'" class="dropdown-item" ><span class="fas fa-eye mr-2"></span>Lihat Data</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="'.route('dashboard.timeline', $row->kode).'" target="_blank">Riwayat</a>
                        </div>
                    </div>';
                    return $actionBtn;
                })->rawColumns(['actions'])
                ->toJson(true);
        }

        return view('pengelola.list');
    }

    public function create($id)
    {
        $pengelola = Pengelola::with(['verifikasi', 'verifikasi.agenda'])->where('id', '=', $id)->first();
        // $pengelola->verifikasi->agenda->tgl_agenda = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $pengelola->verifikasi->agenda->tgl_agenda)->format('d-m-Y H:i');
        $pengelola->verifikasi->agenda->tgl_spm = \Carbon\Carbon::createFromFormat('Y-m-d', $pengelola->verifikasi->agenda->tgl_spm)->format('d-m-Y');
        $pengelola->verifikasi->agenda->jml_kotor = number_format($pengelola->verifikasi->agenda->jml_kotor, 0, ',', '.');
        $pengelola->verifikasi->agenda->potongan = number_format($pengelola->verifikasi->agenda->potongan, 0, ',', '.');
        $pengelola->verifikasi->agenda->jml_bersih = number_format($pengelola->verifikasi->agenda->jml_bersih, 0, ',', '.');

        // $users = User::all();
        return view('pengelola.create', compact('pengelola'));
    }

    public function store(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'required|min:5',
        ]);

        $pengelola = Pengelola::findOrFail($id);
        $pengelola->update([
            'user_id' => Auth::id(),
            'user_input' => Auth::user()->name
        ]);

        $pengelola->detailPengelola()->create([
            'catatan' => $request->catatan
        ]);

        return redirect()->back()
            ->with('success_message', 'Berhasil Tambah Catatan Pengelola');

    }

    public function show($id)
    {
        $pengelola = Pengelola::with('verifikasi', 'verifikasi.agenda')->whereId($id)->first();
        $pengelola->verifikasi->agenda->tgl_agenda = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $pengelola->verifikasi->agenda->tgl_agenda)->format('d-m-Y H:i');
        $pengelola->verifikasi->agenda->tgl_spm = \Carbon\Carbon::createFromFormat('Y-m-d', $pengelola->verifikasi->agenda->tgl_spm)->format('d-m-Y');
        $pengelola->verifikasi->agenda->jml_kotor = number_format($pengelola->verifikasi->agenda->jml_kotor, 0, ',', '.');
        $pengelola->verifikasi->agenda->potongan = number_format($pengelola->verifikasi->agenda->potongan, 0, ',', '.');
        $pengelola->verifikasi->agenda->jml_bersih = number_format($pengelola->verifikasi->agenda->jml_bersih, 0, ',', '.');
        // dd($pengelola);
        return view('pengelola.show', compact('pengelola'));
    }

    public function hapusCatatan($id)
    {
        DetailPengelola::find($id)->delete();
        return response()->json(['success'=>'Berhasil Menghapus Catatan']);
    }

    public function updateSpm(Request $request)
    {
        if($request->ajax()){
            DetailPengelola::create([
                'pengelola_id' => $request->pengelola_id,
                'catatan' => 'Melakukan Penarikan Ulang Data dari Database SIMDA Keuangan'
            ]);

            $agenda = Agenda::findOrFail($request->agenda_id);

            $no_spm = explode("/", $request->no_spm);
            $jenis_spm = $agenda->jenis_spm;
            $standart_penomoran = array('UP', 'GU', 'TU', 'LS.GJ', 'LS.NON-GJ', 'LS.BJ');

            if(in_array($no_spm[2], $standart_penomoran)){
                if($jenis_spm != $no_spm[2]){
                    return response()->json(['error'=>'Jenis SPM tidak sesuai standar penomoran SPM']);
                }
            }else{
                return response()->json(['error'=>'Nomor SPM Tidak sesuai standar Penomoran, harap periksa kembali']);
            }

            $agenda->update([
                'no_spm' => $request->no_spm,
                'tgl_spm' => $this->format_date($request->tgl_spm),
                'uraian' => $request->uraian,
                'nm_penerima' => $request->nm_penerima,
                'bank_penerima' => $request->bank_penerima,
                'rek_penerima' => $request->rek_penerima,
                'npwp' => $request->npwp,
                'jml_kotor' => $request->jml_kotor,
                'potongan' => $request->potongan,
                'jml_bersih' => $request->jml_bersih,
            ]);

            return response()->json(['success'=>'Berhasil Sinkronisasi Data']);
        }
    }

    public function format_date($tgl)
    {
        return \Carbon\Carbon::createFromFormat('d-m-Y', $tgl)->format('Y-m-d');
    }

    public function mark(Request $request)
    {
        foreach($request->id as $id){
            Bud::create([
                'pengelola_id' => $id
            ]);

            Pengelola::find($id)->update([
                'send' => true
            ]);
        }
  
        return response()->json(['success'=>'Data Berhasil diteruskan']);
    }
}
