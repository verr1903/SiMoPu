<x-layoutPrint>
    <x-slot:title>Print Realisasi #{{ $realisasi->id }}</x-slot:title>

    <div class="container mt-5 text-center">
        <h2 style="text-transform: uppercase;">NAMA PUPUK: {{ $realisasi->pengeluaran->material->uraian_material }}</h2>
        <h3 style="text-transform: uppercase;">AFDELING: {{ $realisasi->pengeluaran->user->level_user}}</h3>
        <h4 style="text-transform: uppercase;"> BLOK: {{ implode(', ', $realisasi->pengeluaran->sumber) }}</h4>
        <h4 style="text-transform: uppercase;">BERAT: {{ $realisasi->cicilan_pengeluaran }}Kg</h4>
        

        <!-- QR Code -->
        <div class="mt-3">
            <img src="{{ asset('storage/qrcodes/' . $fileName) }}" alt="QR Code Realisasi">
        </div>

    </div>
</x-layoutPrint>
