@extends('adminlte::page')

@section('title', 'Edit Report')

@section('content_header')
    <h1>Edit Report Barang Reject</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ route('rejected-reports.update', $report->uuid) }}" id="form-edit-report">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Tanggal</label>
                    <input type="text" class="form-control" value="{{ $report->tanggal->format('d/m/Y H:i') }}" disabled>
                </div>

                <div class="form-group">
                    <label>Jenis Barang</label>
                    <input type="text" name="jenis_barang"
                        class="form-control @error('jenis_barang') is-invalid @enderror"
                        value="{{ old('jenis_barang', $report->jenis_barang) }}">
                    @error('jenis_barang')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Nomor Produksi</label>
                    <input type="text" name="nomor_produksi"
                        class="form-control @error('nomor_produksi') is-invalid @enderror"
                        value="{{ old('nomor_produksi', $report->nomor_produksi) }}">
                    @error('nomor_produksi')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Nomor Batch</label>
                    <input type="text" name="nomor_batch" class="form-control @error('nomor_batch') is-invalid @enderror"
                        value="{{ old('nomor_batch', $report->nomor_batch) }}">
                    @error('nomor_batch')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Jumlah Barang</label>
                    <input type="number" name="jumlah_barang"
                        class="form-control @error('jumlah_barang') is-invalid @enderror"
                        value="{{ old('jumlah_barang', $report->jumlah_barang) }}" min="1">
                    @error('jumlah_barang')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Jenis Cacat</label>
                    @error('jenis_cacat')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                    @foreach ($jenisCacatOptions as $option)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="jenis_cacat[]"
                                value="{{ $option }}" id="cacat_{{ $loop->index }}"
                                {{ in_array($option, old('jenis_cacat', $report->jenis_cacat ?? [])) ? 'checked' : '' }}>
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
                    @foreach ($keputusanHandlingOptions as $option)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="keputusan_handling[]"
                                value="{{ $option }}" id="handling_{{ $loop->index }}"
                                {{ in_array($option, old('keputusan_handling', $report->keputusan_handling ?? [])) ? 'checked' : '' }}>
                            <label class="form-check-label" for="handling_{{ $loop->index }}">
                                {{ $option }}
                            </label>
                        </div>
                    @endforeach
                </div>

                <div class="form-group">
                    <label>Catatan</label>
                    <textarea name="catatan" rows="3" class="form-control @error('catatan') is-invalid @enderror">{{ old('catatan', $report->catatan) }}</textarea>
                    @error('catatan')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="button" class="btn btn-primary btn-save">
                    <i class="fas fa-save"></i> Save
                </button>

                <a href="{{ route('rejected-reports.index') }}" class="btn btn-secondary">
                    Batal
                </a>
            </form>

            <form method="POST" action="{{ route('rejected-reports.destroy', $report->uuid) }}" style="display:inline"
                id="form-delete-user">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </form>
        </div>
    </div>
@endsection

@section('plugins.Sweetalert2', true)

@section('js')
    <script>
        window.addEventListener('load', function() {
            history.replaceState(null, null, "{{ route('rejected-reports.index') }}");
        });

        $('.btn-danger').click(function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            Swal.fire({
                title: 'Konfirmasi Hapus',
                text: 'Yakin ingin menghapus user ini? Data tidak bisa dikembalikan!',
                type: 'error',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.value) {
                    $('#form-delete-user').submit();
                }
            });
        });

        $('.btn-save').click(function(e) {
            Swal.fire({
                title: 'Konfirmasi Simpan',
                text: 'Yakin ingin menyimpan perubahan ini?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#007bff',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Simpan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.value) {
                    $('#form-edit-report').submit();
                }
            });
        });
    </script>
@endsection
