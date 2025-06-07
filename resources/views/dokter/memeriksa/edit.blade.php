<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Memeriksa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">
            <div class="p-4 bg-white shadow-sm sm:p-8 sm:rounded-lg">
                <div class="max-w-xl">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Periksa Pasien') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Silakan isi form di bawah ini untuk mencatat hasil pemeriksaan pasien dan memilihkan obat yang akan diresepkan.') }}
                            </p>

                            @if (session('alert'))
                                <div class="mb-4 alert alert-success">
                                    {{ session('alert') }}
                                </div>
                            @endif
                        </header>

                        <form class="mt-6" id="formPeriksa"
                            action="{{ route('dokter.memeriksa.update', ['id' => $janjiPeriksa->id]) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="mb-3 form-group">
                                <label for="nama_pasien">Nama Pasien</label>
                                <input type="text"
                                    class="rounded form-control @error('nama_pasien') is-invalid @enderror"
                                    id="namaObat" name="nama_pasien"
                                    value="{{ old('nama_pasien', $janjiPeriksa->pasien->nama) }}" readonly>
                                @error('nama_pasien')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 form-group">
                                <label for="tgl_periksa">Tanggal Periksa</label>
                                <input type="datetime-local"
                                    class="rounded form-control @error('tgl_periksa') is-invalid @enderror"
                                    id="tgl_periksa" name="tgl_periksa"
                                    value="{{ old('tgl_periksa', $janjiPeriksa->periksa ? $janjiPeriksa->periksa->tgl_periksa->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}">
                                @error('tgl_periksa')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 form-group">
                                <label for="catatan">Catatan</label>
                                <textarea class="rounded form-control @error('catatan') is-invalid @enderror" id="catatan" name="catatan"
                                    rows="3" placeholder="Catatan Pemeriksaan">{{ old('catatan', $janjiPeriksa->periksa ? $janjiPeriksa->periksa->catatan : '') }}</textarea>
                                @error('catatan')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 form-group">
                                <label for="obats">Pilih Obat</label>
                                <select class="rounded form-control @error('obats') is-invalid @enderror" id="obats"
                                    name="obats[]" multiple>
                                    @foreach ($obats as $obat)
                                        <option value="{{ $obat->id }}" data-harga="{{ $obat->harga }}"
                                            {{ in_array($obat->id, old('obats', $janjiPeriksa->periksa->detailPeriksas->pluck('id_obat')->toArray())) ? 'selected' : '' }}>
                                            {{ $obat->nama_obat }} - {{ $obat->kemasan }} (Rp
                                            {{ number_format($obat->harga, 0, ',', '.') }})
                                        </option>
                                    @endforeach
                                </select>
                                <small class="form-text text-muted">Tekan CTRL (Windows) atau Command (Mac) untuk
                                    memilih lebih dari satu.</small>
                                @error('obats')
                                    <div class="invalid-feedback text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <input type="number"
                                class="rounded form-control @error('biaya_periksa') is-invalid @enderror"
                                id="biaya_periksa" name="biaya_periksa"
                                value="{{ old('biaya_periksa', $janjiPeriksa->periksa ? $janjiPeriksa->periksa->biaya_periksa : 150000) }}"
                                placeholder="Masukkan biaya pemeriksaan" readonly>
                            @error('biaya_periksa')
                                <div class="invalid-feedback text-danger">{{ $message }}</div>
                            @enderror

                            <div class="mb-3">
                                <label>Total Biaya (Rp)</label>
                                <input type="text" id="total_biaya" class="form-control" readonly
                                    value="{{ $janjiPeriksa->periksa ? $janjiPeriksa->periksa->biaya_periksa : 150000 }}">
                            </div>

                            <a type="button" href="{{ route('dokter.obat.index') }}" class="btn btn-secondary">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Simpan
                            </button>
                        </form>
                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const obatSelect = document.getElementById('obats');
                                const biayaPeriksaInput = document.getElementById('biaya_periksa');
                                const totalBiayaField = document.getElementById('total_biaya');

                                function hitungTotal() {
                                    let totalObat = 0;

                                    // Ambil semua option yang dipilih
                                    const selectedOptions = Array.from(obatSelect.selectedOptions);
                                    selectedOptions.forEach(opt => {
                                        const harga = parseInt(opt.getAttribute('data-harga')) || 0;
                                        totalObat += harga;
                                    });

                                    const biayaPeriksa = parseInt(biayaPeriksaInput.value) || 0;
                                    const total = totalObat + biayaPeriksa;

                                    // Format angka ke format rupiah
                                    totalBiayaField.value = total.toLocaleString('id-ID');
                                }

                                // Event listeners
                                obatSelect.addEventListener('change', hitungTotal);
                                biayaPeriksaInput.addEventListener('input', hitungTotal);

                                // Hitung di awal jika ada nilai sebelumnya
                                hitungTotal();
                            });
                        </script>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
