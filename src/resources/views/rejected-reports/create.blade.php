@extends('adminlte::page')

@section('title', 'Buat Report')

@section('content_header')
    <h1>Buat Report Barang Reject</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('rejected-reports.store') }}">
                @csrf

                <div class="form-group">
                    <label>Tanggal</label>
                    <input type="text" class="form-control"
                           value="{{ now()->format('d/m/Y H:i') }}" disabled>
                    <small class="text-muted">Otomatis diisi waktu sekarang</small>
                </div>

                <div class="form-group">
                    <label>Jenis Barang</label>
                    <input type="text" name="jenis_barang"
                           class="form-control @error('jenis_barang') is-invalid @enderror"
                           value="{{ old('jenis_barang') }}">
                    @error('jenis_barang')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Nomor Produksi</label>
                    <input type="text" name="nomor_produksi"
                           class="form-control @error('nomor_produksi') is-invalid @enderror"
                           value="{{ old('nomor_produksi') }}">
                    @error('nomor_produksi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Nomor Batch</label>
                    <input type="text" name="nomor_batch"
                           class="form-control @error('nomor_batch') is-invalid @enderror"
                           value="{{ old('nomor_batch') }}">
                    @error('nomor_batch')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Jumlah Barang</label>
                    <input type="number" name="jumlah_barang"
                           class="form-control @error('jumlah_barang') is-invalid @enderror"
                           value="{{ old('jumlah_barang') }}" min="1">
                    @error('jumlah_barang')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Jenis Cacat</label>
                    @error('jenis_cacat')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                    @foreach($jenisCacatOptions as $option)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                   name="jenis_cacat[]" value="{{ $option }}"
                                   id="cacat_{{ $loop->index }}"
                                   {{ in_array($option, old('jenis_cacat', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="cacat_{{ $loop->index }}">
                                {{ $option }}
                            </label>
                        </div>
                    @endforeach
                </div>

                <div class="form-group">
                    <label>Keputusan Handling Barang</label>
                    @error('keputusan_handling')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                    @foreach($keputusanHandlingOptions as $option)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                   name="keputusan_handling[]" value="{{ $option }}"
                                   id="handling_{{ $loop->index }}"
                                   {{ in_array($option, old('keputusan_handling', [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="handling_{{ $loop->index }}">
                                {{ $option }}
                            </label>
                        </div>
                    @endforeach
                </div>

                <div class="form-group">
                    <label>Catatan</label>
                    <textarea name="catatan" rows="3"
                              class="form-control @error('catatan') is-invalid @enderror">{{ old('catatan') }}</textarea>
                    @error('catatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Save
                </button>
                <a href="{{ route('rejected-reports.index') }}" class="btn btn-secondary">
                    Batal
                </a>
            </form>
        </div>
    </div>
@endsection