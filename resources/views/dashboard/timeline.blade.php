@extends('adminlte::page')

@section('title', 'Timeline')

@section('content_header')
    {{-- <h1 class="m-0 text-dark">Agenda</h1> --}}
@stop

@push('css')

@endpush

@section('content')

@if (!$agenda)
    @include('notFound')
@else
    <div class="row">
        <div class="col-md-12">
            <div class="timeline">
                <div class="time-label">
                    <span class="bg-red">
                        @php
                            $oldTanggal = $agenda->tgl_agenda;
                        @endphp
                        {{ $oldTanggal->format('d-m-Y') }}
                    </span>
                </div>
                <div>
                    <i class="fas fa-envelope bg-blue"></i>
                    <div class="timeline-item">
                        <span class="time"><i class="fas fa-clock"></i> {{ $agenda->tgl_agenda->format('H:i') }}</span>
                        <h3 class="timeline-header"><a href="{{ route('dashboard.kode', $agenda->kode) }}">Nomor Agenda : {{ $agenda->nomor }}</a></h3>
                        <div class="timeline-body">
                            <b><u>Nomor SPM : {{ $agenda->no_spm }}</u></b> <br/>
                            <b>{{ $agenda->skpk->nm_skpk }}</b> <br/>
                            {{ $agenda->uraian }}
                        </div>
                        <div class="timeline-footer">
                            <small>berkas diantar oleh : {{ $agenda->dari.' ('.$agenda->no_hp.')' }} </small>
                        </div>
                    </div>
                </div>

                @if ($agenda->send)
                    @php
                        $verifikasi = $agenda->verifikasi;
                    @endphp
                    @if ($oldTanggal->isSameDays($verifikasi->created_at) == false)
                        @php
                            $oldTanggal = $verifikasi->created_at;
                        @endphp
                        <div class="time-label">
                            <span class="bg-red">{{ $oldTanggal->format('d-m-Y') }}</span>
                        </div>
                    @endif
                    <div>
                        <i class="fas fa-user bg-green"></i>
                        <div class="timeline-item">
                            <span class="time"><i class="fas fa-clock"></i> {{ $verifikasi->created_at->format('H:i') }}</span>
                            <h3 class="timeline-header no-border">
                                <a href="#">{{ $agenda->user_input }}</a>
                                Menyerahkan Dokumen Agenda kepada
                                <a href="#">
                                    {{ $agenda->disposisi_user->name }}
                                    @if ($agenda->disposisi_user->profile()->exists())
                                        ({{ $agenda->disposisi_user->profile->jabatan }})
                                    @endif
                                </a>
                            </h3>
                        </div>
                    </div>

                    @if ($verifikasi->catatan != null)
                        @if ($oldTanggal->isSameDays($verifikasi->updated_at) == false)
                            @php
                                $oldTanggal = $verifikasi->updated_at;
                            @endphp
                            <div class="time-label">
                                <span class="bg-red">{{ $oldTanggal->format('d-m-Y') }}</span>
                            </div>
                        @endif
                        <div>
                            <i class="fas fa-comments bg-yellow"></i>
                            <div class="timeline-item">
                                <span class="time"><i class="fas fa-clock"></i> {{ $verifikasi->updated_at->format('H:i') }}</span>
                                <h3 class="timeline-header"><a href="#">{{ $verifikasi->user_input }}</a> Memberikan Catatan</h3>
                                <div class="timeline-body">
                                    {{ $verifikasi->catatan }}
                                </div>
                            </div>
                        </div>

                        @if ($verifikasi->send)
                            @php
                                $pengelola = $verifikasi->pengelola;
                            @endphp
                            @if ($oldTanggal->isSameDays($pengelola->created_at) == false)
                                @php
                                    $oldTanggal = $pengelola->created_at;
                                @endphp
                                <div class="time-label">
                                    <span class="bg-red">{{ $oldTanggal->format('d-m-Y') }}</span>
                                </div>
                            @endif
                            <div>
                                <i class="fas fa-user bg-green"></i>
                                <div class="timeline-item">
                                    <span class="time"><i class="fas fa-clock"></i> {{ $pengelola->created_at->format('H:i') }}</span>
                                    <h3 class="timeline-header no-border">
                                        <a href="#">{{ $verifikasi->user_input }}</a>
                                        Meneruskan Dokumen Agenda kepada
                                        <a href="#">
                                            {{ $verifikasi->disposisi_user->name }}
                                            @if ($verifikasi->disposisi_user->profile()->exists())
                                                ({{ $verifikasi->disposisi_user->profile->jabatan }})
                                            @endif
                                        </a>
                                    </h3>
                                </div>
                            </div>

                            @if ($pengelola->detailPengelola()->exists())
                                @php
                                    $detailPengelola = $pengelola->detailPengelola;
                                @endphp
                                @foreach ($detailPengelola as $catatanPengelola)
                                    @if ($oldTanggal->isSameDays($catatanPengelola->created_at) == false)
                                        @php
                                            $oldTanggal = $catatanPengelola->created_at;
                                        @endphp
                                        <div class="time-label">
                                            <span class="bg-red">{{ $oldTanggal->format('d-m-Y') }}</span>
                                        </div>
                                    @endif
                                    <div>
                                        <i class="fas fa-comments bg-yellow"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="fas fa-clock"></i> {{ $catatanPengelola->created_at->format('H:i') }}</span>
                                            <h3 class="timeline-header"><a href="#">{{ $pengelola->user_input }}</a> Memberikan Catatan</h3>
                                            <div class="timeline-body">
                                                {{ $catatanPengelola->catatan }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                @if ($pengelola->send)
                                    @php
                                        $bud = $pengelola->bud;
                                    @endphp
                                    @if ($oldTanggal->isSameDays($bud->created_at) == false)
                                        @php
                                            $oldTanggal = $bud->created_at;
                                        @endphp
                                        <div class="time-label">
                                            <span class="bg-red">{{ $oldTanggal->format('d-m-Y') }}</span>
                                        </div>
                                    @endif
                                    <div>
                                        <i class="fas fa-user bg-green"></i>
                                        <div class="timeline-item">
                                            <span class="time"><i class="fas fa-clock"></i> {{ $bud->created_at->format('H:i') }}</span>
                                            <h3 class="timeline-header no-border">
                                                <a href="#">{{ $pengelola->user_input }}</a>
                                                Menyerahkan Dokumen kepada <a href="#">BUD / Kuasa BUD </a>
                                            </h3>
                                        </div>
                                    </div>

                                    @if ($bud->detailBud()->exists())
                                        @php
                                            $detailBud = $bud->detailBud;
                                        @endphp
                                        @foreach ($detailBud as $catatanBud)
                                            @if ($oldTanggal->isSameDays($catatanBud->created_at) == false)
                                                @php
                                                    $oldTanggal = $catatanBud->created_at;
                                                @endphp
                                                <div class="time-label">
                                                    <span class="bg-red">{{ $oldTanggal->format('d-m-Y') }}</span>
                                                </div>
                                            @endif
                                            <div>
                                                <i class="fas fa-comments bg-yellow"></i>
                                                <div class="timeline-item">
                                                    <span class="time"><i class="fas fa-clock"></i> {{ $catatanBud->created_at->format('H:i') }}</span>
                                                    <h3 class="timeline-header"><a href="#">{{ $bud->user_input }}</a> Memberikan Catatan</h3>
                                                    <div class="timeline-body">
                                                        {{ $catatanBud->catatan }}
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif

                                    @if ($bud->terima)
                                        @if ($oldTanggal->isSameDays($bud->updated_at) == false)
                                            @php
                                                $oldTanggal = $bud->updated_at;
                                            @endphp
                                            <div class="time-label">
                                                <span class="bg-red">{{ $oldTanggal->format('d-m-Y') }}</span>
                                            </div>
                                        @endif
                                        <div>
                                            <i class="fas fa-envelope bg-blue"></i>
                                            <div class="timeline-item">
                                                <span class="time"><i class="fas fa-clock"></i> {{ $bud->updated_at->format('H:i') }}</span>
                                                <h3 class="timeline-header"><a href="#">Berkas Telah Lolos VERIFIKASI</a></h3>

                                                <div class="timeline-body">
                                                    <b>Nomor SPM : {{ $agenda->no_spm }}</b> <br/>
                                                    Sudah dibuatkan SP2D
                                                </div>
                                                {{-- <div class="timeline-footer">
                                                    <small>berkas diterima oleh BUD / Kuasa BUD: {{ $bud->user_input }} </small>
                                                </div> --}}
                                            </div>
                                        </div>
                                        <div>
                                            <i class="fas fa-check bg-blue"></i>
                                            <div class="timeline-item p-2">
                                                <h5 class="text-primary">SELESAI</h5>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            @endif
                        @endif
                    @endif

                @endif

            </div>
        </div>
            <!-- /.col -->
    </div>
@endif



@stop

@push('js')
    <script>
        $(function () {


        });
    </script>
@endpush
