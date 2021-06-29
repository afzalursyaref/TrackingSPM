<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Skpk;
use App\Models\User;
use App\Models\Verifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            $model = Agenda::leftJoin('skpk', 'agenda.skpk_id', '=', 'skpk.id')
                ->leftJoin('users', 'agenda.disposisi_user_id', '=', 'users.id')
                ->select('agenda.*', 'skpk.nm_skpk', 'users.name')
                ->where('agenda.send', '=', false);
                // ->orderBy('agenda.tgl_agenda', 'asc');
            
            return datatables()->of($model)
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
        return view('agenda.index');
    }

    public function listAgenda(Request $request)
    {
        if($request->ajax()){
            $model = Agenda::leftJoin('skpk', 'agenda.skpk_id', '=', 'skpk.id')
                ->leftJoin('users', 'agenda.disposisi_user_id', '=', 'users.id')
                ->select('agenda.*', 'skpk.nm_skpk', 'users.name')
                ->where('agenda.send', '=', true);
                // ->orderBy('agenda.tgl_agenda', 'desc');
            
            return datatables()->of($model)
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
                        <a href="'.route('agenda.show', $row->id).'" class="dropdown-item" ><span class="fas fa-eye mr-2"></span>Lihat Data</a>
                        <a href="'.route('agenda.cetak', $row->id).'" target="_blank" class="dropdown-item" ><span class="fas fa-print mr-2"></span>Cetak</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="'.route('dashboard.timeline', $row->kode).'" target="_blank">Riwayat</a>
                        </div>
                    </div>';
                    return $actionBtn;
                })->rawColumns(['actions'])
                ->toJson();
        }
        return view('agenda.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $skpk = Skpk::all();
        $users = User::whereRole('verifikator')->orderBy('name')->get();
        return view('agenda.create', compact('skpk', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {    
        $validator = Validator::make($request->all(), [
            'dari' => 'required',
            'no_hp' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'tgl_agenda' => 'required',
            'skpk_id' => 'required',
            'no_spm' => 'required',
            'tgl_spm' => 'required',
            'uraian' => 'required',
            'bank_penerima' => 'required',
            'rek_penerima' => 'required',
            'npwp' => 'required',
            'jml_kotor' => 'required',
            'potongan' => 'required',
            'jml_bersih' => 'required',
            'jenis_spm' => 'required',
            'sumberdana' => 'required',
        ]);

        $no_spm = explode("/", $request->no_spm);
        $jenis_spm = $request->jenis_spm;
        $standart_penomoran = array('UP', 'GU', 'TU', 'LS.GJ', 'LS.NON-GJ', 'LS.BJ', 'LS.PPKD');

        $validator->after(function ($validator) use ($no_spm, $jenis_spm, $standart_penomoran) {
            if(in_array($no_spm[2], $standart_penomoran)){
                if($jenis_spm != $no_spm[2]){
                    $validator->errors()->add('jenis_spm', 'Jenis SPM yang dipilih tidak sesuai standar penomoran SPM');
                }
            }else{
                $validator->errors()->add('no_spm', 'Nomor SPM Tidak sesuai standar Penomoran, harap periksa kembali');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
        }

        $spm_belanja_daerah = array('UP', 'GU', 'TU', 'LS.BJ');
        $spm_penatausahaan = array('LS.GJ', 'LS.NON-GJ', 'LS.PPKD');
        if(in_array($jenis_spm, $spm_belanja_daerah)){
            $user_id_disposisi = User::whereRole('verifikator')->orderBy('id', 'asc')->first()->id;
        }elseif(in_array($jenis_spm, $spm_penatausahaan)){
            $user_id_disposisi = User::whereRole('verifikator')->orderBy('id', 'desc')->first()->id;
        }else{
            return redirect()->back()
            ->with('error_message', 'Gagal Mendapatkan Data Kasubbid');
        }

        $nomor_urut_akhir = Agenda::max('nomor');
        // $kode = 'JP' . sprintf("%04s", abs($nomor_urut_akhir + 1)). '-2021';
        $cekDuplicate = false;
        do {
            $kode = strtoupper(uniqid('JP-'));
            if(!Agenda::where('kode', '=', $kode)->exists()){
                $cekDuplicate = true;
            }
        } while ($cekDuplicate == false);

        $agenda = Agenda::create([
            'nomor' => abs($nomor_urut_akhir + 1),
            'kode' => $kode,
            'dari' => $request->dari,
            'no_hp' => $request->no_hp,
            'tgl_agenda' => $this->format_datetime($request->tgl_agenda),
            'skpk_id' => $request->skpk_id,
            'no_spm' => $request->no_spm,
            'tgl_spm' => $this->format_date($request->tgl_spm),
            'uraian' => $request->uraian,
            'nm_penerima' => $request->nm_penerima,
            'bank_penerima' => $request->bank_penerima,
            'rek_penerima' => $request->rek_penerima,
            'npwp' => $request->npwp,
            'jml_kotor' => $this->angka($request->jml_kotor),
            'potongan' => $this->angka($request->potongan),
            'jml_bersih' => $this->angka($request->jml_bersih),
            'jenis_spm' => $request->jenis_spm,
            'sumberdana' => $request->sumberdana,
            'user_id' => Auth::id(),
            'user_input' => Auth::user()->name,
            'disposisi_user_id' => $user_id_disposisi
        ]);

        if($request->cetak){
            session()->flash('backUrl', route('agenda.index'));
            return redirect()->route('agenda.cetak', $agenda->id);
        }else{
            return redirect()->route('agenda.index')
                ->with('success_message', 'Berhasil menambah Agenda Baru');
        }


    }

    public function angka($num)
    {
        return floatval(preg_replace('/[^\d\,]+/', '', $num));
    }

    public function format_date($tgl)
    {
        return \Carbon\Carbon::createFromFormat('d-m-Y', $tgl)->format('Y-m-d');
    }

    public function format_datetime($tgl)
    {
        return \Carbon\Carbon::createFromFormat('d-m-Y H:i', $tgl)->format('Y-m-d H:i');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $agenda = Agenda::findOrFail($id);
        $agenda->tgl_agenda = $agenda->tgl_agenda->format('d-m-y H:i');
        $agenda->tgl_spm = \Carbon\Carbon::createFromFormat('Y-m-d', $agenda->tgl_spm)->format('d-m-y');
        $agenda->jml_kotor = number_format($agenda->jml_kotor, 0, ',', '.');
        $agenda->potongan = number_format($agenda->potongan, 0, ',', '.');
        $agenda->jml_bersih = number_format($agenda->jml_bersih, 0, ',', '.');
        return view('agenda.show', compact('agenda'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $agenda = Agenda::find($id);
        $agenda->tgl_agenda = $agenda->tgl_agenda->format('d-m-y H:i');
        $agenda->tgl_spm = \Carbon\Carbon::createFromFormat('Y-m-d', $agenda->tgl_spm)->format('d-m-y');
        $agenda->jml_kotor = number_format($agenda->jml_kotor, 0, ',', '.');
        $agenda->potongan = number_format($agenda->potongan, 0, ',', '.');
        $agenda->jml_bersih = number_format($agenda->jml_bersih, 0, ',', '.');
        $users = User::all();
        $skpk = Skpk::all();
        return view('agenda.edit', compact('agenda', 'users', 'skpk'));
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
        $validator = Validator::make($request->all(), [
            'dari' => 'required',
            'no_hp' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'tgl_agenda' => 'required',
            'skpk_id' => 'required',
            'no_spm' => 'required',
            'tgl_spm' => 'required',
            'uraian' => 'required',
            'bank_penerima' => 'required',
            'rek_penerima' => 'required',
            'npwp' => 'required',
            'jml_kotor' => 'required',
            'potongan' => 'required',
            'jml_bersih' => 'required',
            'jenis_spm' => 'required',
            'sumberdana' => 'required',
        ]);

        $no_spm = explode("/", $request->no_spm);
        $jenis_spm = $request->jenis_spm;
        $standart_penomoran = array('UP', 'GU', 'TU', 'LS.GJ', 'LS.NON-GJ', 'LS.BJ');

        $validator->after(function ($validator) use ($no_spm, $jenis_spm, $standart_penomoran) {
            if(in_array($no_spm[2], $standart_penomoran)){
                if($jenis_spm != $no_spm[2]){
                    $validator->errors()->add('jenis_spm', 'Jenis SPM yang dipilih tidak sesuai standar penomoran SPM');
                }
            }else{
                $validator->errors()->add('no_spm', 'Nomor SPM Tidak sesuai standar Penomoran, harap periksa kembali');
            }
        });

        if ($validator->fails()) {
            return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
        }

        $spm_belanja_daerah = array('UP', 'GU', 'TU', 'LS.BJ');
        $spm_penatausahaan = array('LS.GJ', 'LS.NON-GJ', 'LS.PPKD');
        if(in_array($jenis_spm, $spm_belanja_daerah)){
            $user_id_disposisi = User::whereRole('verifikator')->orderBy('id', 'asc')->first()->id;
        }elseif(in_array($jenis_spm, $spm_penatausahaan)){
            $user_id_disposisi = User::whereRole('verifikator')->orderBy('id', 'desc')->first()->id;
        }else{
            return redirect()->back()
            ->with('error_message', 'Gagal Mendapatkan Data Kasubbid');
        }

        Agenda::find($id)->update([
            'dari' => $request->dari,
            'no_hp' => $request->no_hp,
            'tgl_agenda' => $this->format_datetime($request->tgl_agenda),
            'skpk_id' => $request->skpk_id,
            'no_spm' => $request->no_spm,
            'tgl_spm' => $this->format_date($request->tgl_spm),
            'uraian' => $request->uraian,
            'nm_penerima' => $request->nm_penerima,
            'bank_penerima' => $request->bank_penerima,
            'rek_penerima' => $request->rek_penerima,
            'npwp' => $request->npwp,
            'jml_kotor' => $this->angka($request->jml_kotor),
            'potongan' => $this->angka($request->potongan),
            'jml_bersih' => $this->angka($request->jml_bersih),
            'jenis_spm' => $request->jenis_spm,
            'sumberdana' => $request->sumberdana,
            'user_id' => Auth::id(),
            'user_input' => Auth::user()->name,
            'disposisi_user_id' => $user_id_disposisi
        ]);

        if($request->cetak){
            session()->flash('backUrl', route('agenda.index'));
            return redirect()->route('agenda.cetak', $id);
        }else{
            return redirect()->route('agenda.index')
            ->with('success_message', 'Berhasil Mengubah Data Agenda');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Agenda::find($id)->delete();
        return response()->json(['success'=>'Berhasil Hapus Data Agenda']);
    }

    public function mark(Request $request)
    {
        foreach($request->id as $id){
            Verifikasi::create([
                'agenda_id' => $id
            ]);

            Agenda::find($id)->update([
                'send' => true
            ]);
        }
  
        return response()->json(['success'=>'Data Berhasil diteruskan']);
    }

    public function cetak($id)
    {
        $agenda = Agenda::findOrFail($id);
        $users = User::whereRole('pengelola')->get();
        $verifikators = User::whereRole('verifikator')->get();
        return view('cetak.blangko_agenda', compact('agenda', 'users', 'verifikators'));
        // dd($agenda);
    }
}
