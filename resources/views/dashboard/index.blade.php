@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    {{-- <h1 class="m-0 text-dark">Agenda</h1> --}}
@stop

@push('css')
    
@endpush

@section('content')
<div class="row">
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box bg-gradient-info">
            <span class="info-box-icon"><i class="far fa-envelope"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Agenda Masuk</span>
                <span id="agenda_count" class="info-box-number">0</span>

            <div class="progress">
                <div id="agenda_progress" class="progress-bar" style="width: 0%"></div>
            </div>
                <span id="agenda_send" class="progress-description">
                    0 Berkas telah diteruskan
                </span>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box bg-gradient-success">
            <span class="info-box-icon"><i class="far fa-flag"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Berkas pada Kasubbid</span>
                <span id="kasi_count" class="info-box-number">0</span>

            <div class="progress">
                <div id="kasi_progress" class="progress-bar" style="width: 0%"></div>
            </div>
                <span id="kasi_send" class="progress-description">
                    0 Berkas telah diteruskan
                </span>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box bg-gradient-warning">
            <span class="info-box-icon"><i class="far fa-copy"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Berkas pada Pengelola</span>
                <span id="pengelola_count" class="info-box-number">0</span>

            <div class="progress">
                <div id="pengelola_progress" class="progress-bar" style="width: 0%"></div>
            </div>
                <span id="pengelola_send" class="progress-description">
                    0 Berkas telah diteruskan
                </span>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box bg-gradient-danger">
            <span class="info-box-icon"><i class="far fa-star"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Berkas pada BUD/ Kuasa BUD</span>
                <span id="bud_count" class="info-box-number">0</span>

            <div class="progress">
                <div id="bud_progress" class="progress-bar" style="width: 0%"></div>
            </div>
                <span id="bud_send" class="progress-description">
                    0 Berkas telah diteruskan
                </span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
                <div class="card-header">
                    Data Agenda
                </div>
                <div class="card-body">
                    <table id="dashboardTable" class="table table-bordered table-striped display nowrap">
                        <thead>
                            <tr>
                                <th>Aksi</th>
                                <th>Nomor</th>
                                <th>Tgl Agenda</th>
                                <th>SKPK</th>
                                <th>No SPM</th>
                                <th>Tgl SPM</th>
                                <th>Uraian</th>
                                <th>Jml Kotor</th>
                                <th>Potongan</th>
                                <th>Jml Bersih</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- {{ dd($data['agenda_count']) }} --}}
@stop

@push('js')
    <script>
        $(function () {
            var table = $('#dashboardTable').DataTable({
                processing: true,
                responsive: false, 
                autoWidth: false,
                serverSide: true,
                scrollY: 500,
                scrollX: true,
                ajax: "{{ route('dashboard.index') }}",
                columns: [
                    {
                        data: 'actions', 
                        name: 'actions', 
                        orderable: false, 
                        searchable: false
                    },
                    {data: 'nomor', name: 'agenda.nomor'},
                    {data: 'tgl_agenda', name: 'agenda.tgl_agenda'},
                    {data: 'nm_skpk', name: 'skpk.nm_skpk'},
                    {data: 'no_spm', name: 'agenda.no_spm'},
                    {data: 'tgl_spm', name: 'agenda.tgl_spm'},
                    {data: 'uraian', name: 'agenda.uraian'},
                    {data: 'jml_kotor', name: 'agenda.jml_kotor', className: "text-right", render: $.fn.dataTable.render.number('.', ',', 0, '')},
                    {data: 'potongan', name: 'agenda.potongan', className: "text-right", render: $.fn.dataTable.render.number('.', ',', 0, '')},
                    {data: 'jml_bersih', name: 'agenda.jml_bersih', className: "text-right", render: $.fn.dataTable.render.number('.', ',', 0, '')},
                ],
                columnDefs: [ 
                    {
                        targets: 6,
                        render: function ( data, type, row ) {
                            return data.length > 100 ?
                                data.substr( 0, 100 ) +'…' :
                                data;
                        }
                    }
                ],
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            let agenda_count = 0, agenda_progress = 0, agenda_send = 0;
            let kasi_count = 0, kasi_progress = 0, kasi_send = 0;
            let pengelola_count = 0, pengelola_progress = 0, pengelola_send = 0;
            let bud_count = 0, bud_progress = 0, bud_send = 0;

            let setStartValue = () => {
                agenda_count = parseInt("{{ $data['agenda_count'] }}"); 
                agenda_send = parseInt("{{ $data['agenda_send'] }}"); 
                agenda_progress = agenda_send / agenda_count * 100; 

                kasi_count = parseInt("{{ $data['kasi_count'] }}"); 
                kasi_send = parseInt("{{ $data['kasi_send'] }}"); 
                kasi_progress = kasi_send / kasi_count * 100; 

                pengelola_count = parseInt("{{ $data['pengelola_count'] }}"); 
                pengelola_send = parseInt("{{ $data['pengelola_send'] }}"); 
                pengelola_progress = pengelola_send / pengelola_count * 100; 

                bud_count = parseInt("{{ $data['bud_count'] }}"); 
                bud_send = parseInt("{{ $data['bud_send'] }}"); 
                bud_progress = bud_send / bud_count * 100; 
            }
            setStartValue();

            let updateBox = () => {
                document.getElementById('agenda_count').textContent = agenda_count;
                document.getElementById('agenda_progress').style.width = agenda_progress + "%";
                document.getElementById('agenda_send').textContent = agenda_send + " Berkas telah diteruskan";

                document.getElementById('kasi_count').textContent = kasi_count;
                document.getElementById('kasi_progress').style.width = kasi_progress + "%";
                document.getElementById('kasi_send').textContent = kasi_send + " Berkas telah diteruskan";

                document.getElementById('pengelola_count').textContent = pengelola_count;
                document.getElementById('pengelola_progress').style.width = pengelola_progress + "%";
                document.getElementById('pengelola_send').textContent = pengelola_send + " Berkas telah diteruskan";

                document.getElementById('bud_count').textContent = bud_count;
                document.getElementById('bud_progress').style.width = bud_progress + "%";
                document.getElementById('bud_send').textContent = bud_send + " Berkas telah diterima";
            }
            updateBox();

            let startUpdateProcedure = () =>{
                $.ajax({
                    type: "get",
                    url: "{{ route('dashboard.updateBox') }}" ,
                    success: function (data) {
                        if(data.response){
                            agenda_count = parseInt(data.response.agenda_count);
                            agenda_send = parseInt(data.response.agenda_send);
                            agenda_progress = agenda_send / agenda_count * 100;

                            kasi_count = parseInt(data.response.kasi_count);
                            kasi_send = parseInt(data.response.kasi_send);
                            kasi_progress = kasi_send / kasi_count * 100;

                            pengelola_count = parseInt(data.response.pengelola_count);
                            pengelola_send = parseInt(data.response.pengelola_send);
                            pengelola_progress = pengelola_send / pengelola_count * 100;

                            bud_count = parseInt(data.response.bud_count);
                            bud_send = parseInt(data.response.bud_send);
                            bud_progress = bud_send / bud_count * 100;

                            updateBox();

                        }
                       
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });

            }

            

            setInterval(() => {
                startUpdateProcedure();
            }, 3000);

        });
    </script>
@endpush