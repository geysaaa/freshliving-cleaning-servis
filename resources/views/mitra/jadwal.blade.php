@extends('layouts.dashboard')

@section('title', 'Atur Ketersediaan')

@section('content')
    <div class="mx-auto" style="max-width: 500px;">
        <div class="text-center mb-4">
            <h3 class="mb-1">Atur Ketersediaan Jadwal</h3>
            <p class="text-muted mb-0">Aktifkan hari-hari kamu bersedia menerima pesanan</p>
        </div>

        <div class="bg-white rounded-4 shadow-sm p-4">
            <form method="POST" action="{{ route('mitra.jadwal.update') }}">
                @csrf
                @foreach ($hariList as $hari)
                    <div class="d-flex justify-content-between align-items-center py-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-calendar-day text-muted"></i>
                            <span class="text-capitalize fw-medium">{{ $hari }}</span>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" name="tersedia_{{ $hari }}" style="width:3em; height:1.5em;"
                                {{ ($jadwals[$hari]->tersedia ?? false) ? 'checked' : '' }}>
                        </div>
                    </div>
                @endforeach
                <button class="btn btn-primary mt-3 w-100 py-2"><i class="bi bi-check-lg me-1"></i>Simpan Jadwal</button>
            </form>
        </div>
    </div>
@endsection