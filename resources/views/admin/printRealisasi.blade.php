<x-layoutPrint>
    <x-slot:title>Print Realisasi #{{ $realisasi->id }}</x-slot:title>

    <div class="container mt-5 text-center">
        <h3>Pengeluaran ID: {{ $realisasi->id }}</h3>
        <h5>Pengeluaran: {{ $realisasi->cicilan_pengeluaran }}/Kg</h5>
        

        <!-- QR Code -->
        <div class="mt-3">
            <img src="{{ asset('storage/qrcodes/' . $fileName) }}" alt="QR Code Realisasi">
        </div>

    </div>
</x-layoutPrint>
