<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Skpk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SimdaController extends Controller
{
    public function spm_all(Request $request, $oldSpm="")
    {
        if($request->ajax()){
            $kd_urusan = $request->kd_urusan;
            $kd_bidang = $request->kd_bidang;
            $kd_unit = $request->kd_unit;
            $kd_sub = $request->kd_sub;

            $_no_spm = array();
            $query = Agenda::select('no_spm')->where('no_spm', '<>', $oldSpm)->get();
            foreach ($query as $value) {
                array_push($_no_spm, $value->no_spm);
            }

            if($oldSpm!=null){
                if (($key = array_search($oldSpm, $_no_spm)) !== false) {
                    unset($_no_spm[$key]);
                }
            }

            // $queryNotIn="";
            // if(count($_no_spm)>0){
            //     $binds = implode(',', $_no_spm);
            //     $queryNotIn = "and no_spm not in ($binds)";
            // }

            // $list_spm = DB::connection('sqlsrv')->select(
            //     'select
            //     no_spm, convert(varchar, tgl_spm, 105) as tgl_spm, uraian, nm_penerima, bank_penerima, rek_penerima, npwp,
            //     (select cast(SUM(nilai) as numeric(19,0)) from ta_spm_rinc where no_spm=ta_spm.no_spm) as jml_kotor,
            //     (select cast(ISNULL(SUM(nilai), 0) as numeric(19,0)) from ta_spm_pot where no_spm=ta_spm.no_spm) as potongan
            //     from ta_spm where kd_urusan=? and kd_bidang=? and kd_unit=? and kd_sub=? ',
            //     [$kd_urusan, $kd_bidang, $kd_unit, $kd_sub]
            // );

            $list_spm = DB::connection('sqlsrv')->table('ta_spm')
                ->select(
                    'no_spm',
                    DB::raw('convert(varchar, tgl_spm, 105) as tgl_spm'),
                    'uraian',
                    'nm_penerima',
                    'bank_penerima',
                    'rek_penerima',
                    'npwp',
                    DB::raw('(select cast(SUM(nilai) as numeric(19,0)) from ta_spm_rinc where no_spm=ta_spm.no_spm) as jml_kotor'),
                    DB::raw('(select cast(ISNULL(SUM(nilai), 0) as numeric(19,0)) from ta_spm_pot where no_spm=ta_spm.no_spm) as potongan'),
                )->where('kd_urusan', '=', $kd_urusan)
                ->where('kd_bidang', '=', $kd_bidang)
                ->where('kd_unit', '=', $kd_unit)
                ->where('kd_sub', '=', $kd_sub)
                ->whereNotIn('no_spm', $_no_spm)
                ->orderBy('tgl_spm', 'desc')
                ->get();

            return datatables()->of($list_spm)
                ->addColumn('jml_bersih', function($row){
                    return $row->jml_kotor - $row->potongan;
                })
                ->addColumn('action', function($row){
                    $actionBtn = '<button class="btn btn-primary pilih-btn">Pilih</button>';
                    return $actionBtn;
                })->rawColumns(['jml_bersih','action'])
                ->toJson();
        }

    }

    public function getSkpk()
    {
        $skpk = DB::connection('sqlsrv')->select(
            'select * from ref_sub_unit'
        );

        $dataSkpk = array();
        foreach ($skpk as $data) {
            array_push($dataSkpk, array(
                'nm_skpk' => $data->nm_sub_unit,
                'kd_urusan' => $data->kd_urusan,
                'kd_bidang' => $data->kd_bidang,
                'kd_unit' => $data->kd_unit,
                'kd_sub' => $data->kd_sub,
            ));
        }

        $skpkInsert = Skpk::insert($dataSkpk);
        dd($skpkInsert);
    }

    public function sp2dAll(Request $request)
    {
        if($request->ajax()){
            $sp2d = Db::connection('sqlsrv')->table('ta_sp2d')
                ->select(
                    'no_sp2d', 'no_spm', 'keterangan',
                    DB::raw('(select cast(SUM(nilai) as numeric(19,0)) from ta_spm_rinc where no_spm=ta_sp2d.no_spm) as jml_kotor'),
                    DB::raw('(select cast(ISNULL(SUM(nilai), 0) as numeric(19,0)) from ta_spm_pot where no_spm=ta_sp2d.no_spm) as potongan'),
                )
                ->get();

            return datatables()->of($sp2d)
                ->addColumn('jml_bersih', function($row){
                    return $row->jml_kotor - $row->potongan;
                })
                ->toJson();
        }

        return view('dashboard.sp2d');
    }
}
