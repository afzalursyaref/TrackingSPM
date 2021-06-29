<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Pengelola;
use App\Models\User;
use App\Models\Verifikasi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifikasiContoller extends Controller
{
    public function index(Request $request)
    {
        $userId = auth()->id();
        
        if($request->ajax()){
            $query = Verifikasi::Join('agenda', 'agenda.id', '=', 'verifikasi.agenda_id')
                        ->leftJoin('skpk', 'agenda.skpk_id', '=', 'skpk.id')
                        ->leftJoin('users', 'verifikasi.disposisi_user_id', '=', 'users.id')
                        ->select(
                            'verifikasi.*', 
                            'agenda.nomor', 'agenda.kode', 'agenda.tgl_agenda', 'agenda.no_spm', 'agenda.tgl_spm', 'agenda.uraian', 'agenda.jml_kotor', 'agenda.potongan', 'agenda.jml_bersih',
                            'skpk.nm_skpk', 'users.name'
                        )->where('verifikasi.send', '=', false)
                        ->where('agenda.disposisi_user_id', '=', $userId);
            
            return datatables()->of($query)
                ->editColumn('tgl_agenda', function($row){
                    return \Carbon\Carbon::parse($row->tgl_agenda)->format('d-m-Y H:i');
                })
                ->editColumn('tgl_spm', function($row){
                    return \Carbon\Carbon::parse($row->tgl_spm)->format('d-m-Y');
                })
                ->addColumn('checkbox', function($row){
                    if($row->catatan != null){
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
                            <a href="'.route('verifikasi.create', $row->id).'" class="dropdown-item" ><span class="fas fa-pencil-alt mr-2"></span> Buat Catatan</a>
                            <a href="javascript:void(0)" data-id="'.$row->id.'" class="dropdown-item text-danger deleteVerifikasi" ><span class="fas fa-trash mr-2"></span> Hapus</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="'.route('dashboard.timeline', $row->kode).'" target="_blank">Riwayat</a>
                        </div>
                    </div>';
                    return $actionBtn;
                })->rawColumns(['checkbox', 'actions'])
                ->make(true);
        }

        return view('verifikasi.index');
    }

    public function listVerifikasi(Request $request)
    {
        $userId = auth()->id();
        
        if($request->ajax()){
            $query = Verifikasi::Join('agenda', 'agenda.id', '=', 'verifikasi.agenda_id')
                        ->leftJoin('skpk', 'agenda.skpk_id', '=', 'skpk.id')
                        ->leftJoin('users', 'verifikasi.disposisi_user_id', '=', 'users.id')
                        ->select(
                            'verifikasi.*', 
                            'agenda.nomor', 'agenda.kode', 'agenda.tgl_agenda', 'agenda.no_spm', 'agenda.tgl_spm', 'agenda.uraian', 'agenda.jml_kotor', 'agenda.potongan', 'agenda.jml_bersih',
                            'skpk.nm_skpk', 'users.name'
                        )->where('verifikasi.send', '=', true)
                        ->where('agenda.disposisi_user_id', '=', $userId);
            
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
                        <a href="'.route('verifikasi.show', $row->id).'" class="dropdown-item" ><span class="fas fa-eye mr-2"></span>Lihat Data</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="'.route('dashboard.timeline', $row->kode).'" target="_blank">Riwayat</a>
                        </div>
                    </div>';
                    return $actionBtn;
                })->rawColumns(['actions'])
                ->toJson(true);
        }

        return view('verifikasi.list');
    }

    public function create($id)
    {
        $verifikasi = Verifikasi::with('agenda')->where('id', '=', $id)->first();
        $verifikasi->agenda->tgl_agenda = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $verifikasi->agenda->tgl_agenda)->format('d-m-Y H:i');
        $verifikasi->agenda->tgl_spm = \Carbon\Carbon::createFromFormat('Y-m-d', $verifikasi->agenda->tgl_spm)->format('d-m-Y');
        $verifikasi->agenda->jml_kotor = number_format($verifikasi->agenda->jml_kotor, 0, ',', '.');
        $verifikasi->agenda->potongan = number_format($verifikasi->agenda->potongan, 0, ',', '.');
        $verifikasi->agenda->jml_bersih = number_format($verifikasi->agenda->jml_bersih, 0, ',', '.');

        $users = User::where('role', '=', 'pengelola')->get();
        return view('verifikasi.create', compact('verifikasi', 'users'));
    }

    public function store(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'catatan' => 'required|min:5',
            'disposisi_user_id' => 'required'
        ]);

        Verifikasi::findOrFail($id)->update([
            'user_id' => Auth::id(),
            'user_input' => Auth::user()->name,
            'disposisi_user_id' => $request->disposisi_user_id,
            'catatan' => $request->catatan
        ]);

        return redirect()->route('verifikasi.index')
            ->with('success_message', 'Berhasil Tambah Catatan Verifikator');
    }

    public function show($id)
    {
        $verifikasi = Verifikasi::with('agenda')->where('id', '=', $id)->first();
        $verifikasi->agenda->tgl_agenda = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $verifikasi->agenda->tgl_agenda)->format('d-m-Y H:i');
        $verifikasi->agenda->tgl_spm = \Carbon\Carbon::createFromFormat('Y-m-d', $verifikasi->agenda->tgl_spm)->format('d-m-Y');
        $verifikasi->agenda->jml_kotor = number_format($verifikasi->agenda->jml_kotor, 0, ',', '.');
        $verifikasi->agenda->potongan = number_format($verifikasi->agenda->potongan, 0, ',', '.');
        $verifikasi->agenda->jml_bersih = number_format($verifikasi->agenda->jml_bersih, 0, ',', '.');

        return view('verifikasi.show', compact('verifikasi'));
    }

    public function destroy($id)
    {
        $verifikasi = Verifikasi::findOrFail($id);
        $agenda = Agenda::findOrFail($verifikasi->agenda_id);
        $agenda->send = false;
        $agenda->save();
        $verifikasi->delete();
        return response()->json(['success'=>'Berhasil Mengembalikan data ke bagian Front Office']);
    }

    public function mark(Request $request)
    {
        foreach($request->id as $id){
            
            Pengelola::create([
                'verifikasi_id' => $id
            ]);

            Verifikasi::find($id)->update([
                'send' => true
            ]);
        }
  
        return response()->json(['success'=>'Data Berhasil diteruskan']);
    }
}
