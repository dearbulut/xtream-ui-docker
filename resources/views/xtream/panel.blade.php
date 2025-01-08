@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Yönetim Paneli') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">
                                    <h4>{{ $stats['categories'] }}</h4>
                                    <div>Kategoriler</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white mb-4">
                                <div class="card-body">
                                    <h4>{{ $stats['channels'] }}</h4>
                                    <div>Kanallar</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white mb-4">
                                <div class="card-body">
                                    <h4>{{ $stats['movies'] }}</h4>
                                    <div>Filmler</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white mb-4">
                                <div class="card-body">
                                    <h4>{{ $stats['series'] }}</h4>
                                    <div>Diziler</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    Hızlı İşlemler
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <form action="{{ route('xtream.sync-channels') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-primary btn-block">
                                                    <i class="fas fa-sync"></i> Kanalları Senkronize Et
                                                </button>
                                            </form>
                                        </div>
                                        <div class="col-md-4">
                                            <form action="{{ route('xtream.cache-epg') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-success btn-block">
                                                    <i class="fas fa-clock"></i> EPG Verilerini Güncelle
                                                </button>
                                            </form>
                                        </div>
                                        <div class="col-md-4">
                                            <form action="{{ route('xtream.cleanup-cache') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-warning btn-block">
                                                    <i class="fas fa-broom"></i> Önbelleği Temizle
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
