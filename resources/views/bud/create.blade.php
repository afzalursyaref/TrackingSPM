@extends('adminlte::page')

@section('title', 'Catatan BUD atau Kuasa BUD')

@section('content_header')
    {{-- <h1 class="m-0 text-dark">Tambah Agenda</h1> --}}
@stop

@section('content')
@php
    $pengelola = $bud->pengelola;
@endphp
<div class="row">
    <div class="col-12">
        <div class="callout callout-info">
            <h5>
                Nomor Agenda : <strong>{{ $pengelola->verifikasi->agenda->nomor }}</strong>
                <small class="float-right">Tanggal: {{ $pengelola->verifikasi->agenda->tgl_agenda->format('d-m-Y H:i') }}</small>
            </h5>
            Kode : <b>{{ $pengelola->verifikasi->agenda->kode }}</b>
        </div>

        <div class="invoice p-3 mb-3">
            <div class="row">
                <div class="col-12">
                    <h4>
                        Nomor SPM : {{ $pengelola->verifikasi->agenda->no_spm }}
                        <small class="float-right">Tanggal: {{ $pengelola->verifikasi->agenda->tgl_spm }}</small>
                    </h4>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-4">
                    <b>{{ $pengelola->verifikasi->agenda->skpk->nm_skpk }}</b>
                    <div>
                        <i>"{{ $pengelola->verifikasi->agenda->uraian }}"</i>
                    </div>
                    Jenis SPM : <b>{{ $pengelola->verifikasi->agenda->jenis_spm }}</b> <br/>
                    Sumber Dana : <b>{{ $pengelola->verifikasi->agenda->sumberdana }}</b> <br/>
                </div>
            
                <div class="col-sm-4">
                    Penerima:
                    <div>
                        <strong>{{ $pengelola->verifikasi->agenda->nm_penerima }}</strong><br>
                        {{ $pengelola->verifikasi->agenda->bank_penerima }}<br>
                        {{ $pengelola->verifikasi->agenda->rek_penerima }}
                    </div>
                </div>
            
                <div class="col-sm-4 text-right">
                    <b>Jumlah Kotor:</b> Rp. {{ $pengelola->verifikasi->agenda->jml_kotor }}<br>
                    <b>Potongan:</b> Rp. {{ $pengelola->verifikasi->agenda->potongan }}<br>
                    <b>Jumlah Bersih:</b> Rp. {{ $pengelola->verifikasi->agenda->jml_bersih }}<br>
                    <button type="button" class="btn btn-block btn-primary mt-2" 
                        id="tarik_data" 
                        data-attr="{{ route('spm_all', $pengelola->verifikasi->agenda->no_spm) }}"
                        data-oldspm="{{ $pengelola->verifikasi->agenda->no_spm }}"
                        data-urusan="{{ $pengelola->verifikasi->agenda->skpk->kd_urusan }}"
                        data-bidang="{{ $pengelola->verifikasi->agenda->skpk->kd_bidang }}"
                        data-unit="{{ $pengelola->verifikasi->agenda->skpk->kd_unit }}"
                        data-sub="{{ $pengelola->verifikasi->agenda->skpk->kd_sub }}"
                        data-agendaId = "{{ $pengelola->verifikasi->agenda->id }}"
                        data-budId = "{{ $bud->id }}">
                            Tarik Ulang Data dari SIMDA
                    </button>
                </div>
            
            </div>
            <hr/>
            <div class="row">
                <div class="col-sm-12">
                    <b>Riwayat Catatan:</b><br/>
                    {{ $pengelola->verifikasi->updated_at->format('d-m-Y H:i') }} - 
                    <b class="text-primary">{{ $pengelola->verifikasi->user_input }} : </b>
                    {{ $pengelola->verifikasi->catatan }}
                </div>
                @if (count($pengelola->detailPengelola) > 0)
                    @foreach ($pengelola->detailPengelola()->orderBy('created_at','desc')->get() as $item)
                        <div class="col-sm-12">
                            {{ $item->created_at->format('d-m-Y H:i') }} - 
                            <b class="text-primary">{{ $pengelola->user_input }} : </b>
                            {{ $item->catatan }}
                        </div>
                    @endforeach
                
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6">
                <h5>Catatan BUD</h5>
                @if (count($bud->detailBud) > 0)
                    @foreach ($bud->detailBud()->orderBy('created_at','desc')->get() as $item)
                        <div class="callout callout-warning">
                            <h5>
                                {{ $item->catatan }}
                                <small class="float-right text-muted">{{ \Carbon\Carbon::createFromTimeStamp(strtotime($item->created_at))->diffForHumans() }}</small>
                            </h5>
                            <button type="button" class="btn bg-gradient-danger btn-xs btn-hapus-catatan" data-id="{{ $item->id }}">Hapus</button>
                        </div>
                    @endforeach
                @else
                    <small class="text-danger">Empty</small>
                @endif
            </div>

            <div class="col-sm-6">
                <form id="form" class="form-horizontal" action="{{ route('bud.store', $bud->id) }}" method="POST">
                    <div class="card">
                        <div class="card-body">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="col-form-label" for="catatan">Tambah Catatan bud</label>
                                        <textarea class="form-control @error('catatan') is-invalid @enderror" required
                                            id="catatan" name="catatan" rows="3">{{ old('catatan') }}</textarea>
                                        @error('catatan')
                                            <span class="error invalid-feedback">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('bud.index') }}" class="btn btn-secondary" >Kembali</a>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<div class="modal fade" id="modal-overlay" data-backdrop="static" data-keyboard="true">
    <div class="modal-dialog modal-xl" >
      <div class="modal-content">  
        <div class="modal-body">
            <table id="example1" class="table table-bordered table-striped display nowrap">
                <thead>
                    <tr>
                        <th>Aksi</th>
                        <th>No SPM</th>
                        <th>Tgl SPM</th>
                        <th>Uraian</th>
                        <th>Nama Penerima</th>
                        <th>Bank Penerima</th>
                        <th>Rek Penerima</th>
                        <th>NPWP</th>
                        <th>Jml Kotor</th>
                        <th>Potongan</th>
                        <th>Jml Bersih</th>
                    </tr>
                </thead>
            </table>
        </div>
        <div class="modal-footer justify-content-end">
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
</div>
<div class="modal fade" id="modal-danger" data-backdrop="static" data-keyboard="true">
    <div class="modal-dialog">
      <div class="modal-content bg-danger">
        <div class="modal-header">
          <h4 class="modal-title">Error!</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Gagal Menghubungkan ke Server SIMDA. <br> Harap Menghubungi Administrator</p>
        </div>
      </div>
    </div>
</div>

@stop

@push('js')
    <script>
        $('body').on('click', '.btn-hapus-catatan', function(){
            var catatanId = $(this).data("id");
            var result = confirm("Apakah anda yakin ingin menghapus catatan ini?");
            var url = "{{ route('bud.hapusCatatan', ':id') }}";
            url = url.replace(':id', catatanId );
            if(result){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "DELETE",
                    url: url ,
                    success: function (data) {
                        success_message(data.success);
                        location.reload();
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            }else{
                return false;
            }
        });

        let agendaID, budID;
        $(document).on('click', '#tarik_data', function(event) {
            event.preventDefault();
            $('#modal-overlay').modal("show");
            let urusan = $(this).attr('data-urusan');
            let bidang = $(this).attr('data-bidang');
            let unit = $(this).attr('data-unit');
            let sub = $(this).attr('data-sub');
            
            let href = $(this).attr('data-attr') + '?kd_urusan=' + urusan + '&kd_bidang=' + bidang + '&kd_unit=' + unit + '&kd_sub=' + sub;
            
            agendaID = $(this).attr('data-agendaId');
            budID = $(this).attr('data-budId');

            table = $('#example1').DataTable({
                destroy: true,
                processing: true,
                language: {
                    "loadingRecords": "Loading...",
                    "processing":     "Harap Menunggu, sistem sedang menghubungkan ke Server SIMDA..."
                },
                responsive: false, 
                lengthChange: false, 
                autoWidth: false,
                serverSide: true,
                scrollY: 500,
                scrollX: true,
                ajax: {
                    url: href,
                    error: function (jqXHR, textStatus, errorThrown) {
                        $('#modal-danger').modal("show");
                    } 
                },
                columns: [
                    {
                        data: 'action', 
                        name: 'action', 
                        orderable: false, 
                        searchable: false
                    },
                    {data: 'no_spm', name: 'no_spm'},
                    {data: 'tgl_spm', name: 'tgl_spm'},
                    {data: 'uraian', name: 'uraian'},
                    {data: 'nm_penerima', name: 'nm_penerima'},
                    {data: 'bank_penerima', name: 'bank_penerima'},
                    {data: 'rek_penerima', name: 'rek_penerima'},
                    {data: 'npwp', name: 'npwp'},
                    {data: 'jml_kotor', name: 'jml_kotor', className: "text-right", render: $.fn.dataTable.render.number('.', ',', 0, '')},
                    {data: 'potongan', name: 'potongan', className: "text-right", render: $.fn.dataTable.render.number('.', ',', 0, '')},
                    {data: 'jml_bersih', name: 'jml_bersih', className: "text-right", render: $.fn.dataTable.render.number('.', ',', 0, '')},
                    
                ],
                columnDefs: [ 
                    {
                        targets: 3,
                        render: function ( data, type, row ) {
                            return data.length > 100 ?
                                data.substr( 0, 100 ) +'…' :
                                data;
                        }
                    },
                    {
                        targets: [5,6,7],
                        visible: false,
                    }
                ]
            });
        });

        $('#example1').on( 'click', 'tbody .pilih-btn', function () {
            var data = table.row( $(this).parents('tr') ).data();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: "{{ route('bud.updateSpm') }}" ,
                data : {
                    agenda_id : agendaID,
                    bud_id : budID,
                    no_spm : data.no_spm,
                    tgl_spm : data.tgl_spm,
                    uraian : data.uraian,
                    nm_penerima : data.nm_penerima,
                    bank_penerima : data.bank_penerima,
                    rek_penerima : data.rek_penerima,
                    npwp : data.npwp,
                    jml_kotor : data.jml_kotor,
                    potongan : data.potongan,
                    jml_bersih : data.jml_bersih
                },
                success: function (data) {
                    if(data.error){
                        error_message(data.error);
                    }else{
                        success_message(data.success);
                        location.reload();
                    }
                },
                error: function (data) {
                    console.log('Error:', data);
                }
            });

            $('#modal-overlay').modal("hide");
        });
    </script>
@endpush