<x-layout>
    <x-slot:title>{{$title}}</x-slot:title>
    <div id="main">
        <header class="mb-3">
            <a href="#" class="burger-btn d-block d-xl-none">
                <i class="bi bi-justify fs-3"></i>
            </a>
        </header>

        <div class="page-heading">
            <h3>Dashboard</h3>
        </div>
        <div class="page-content">
            <section class="row">
                <div class="col-12 col-lg-12">
                    <div class="row">
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card shadow">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                            <div class="stats-icon purple mb-2">
                                                <i class="bi bi-box-seam mb-4 me-2"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                            <h6 class="text-muted font-semibold">Total Material</h6>
                                            <h6 class="font-extrabold mb-0">{{ $totalMaterial }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card shadow">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                            <div class="stats-icon blue mb-2">
                                                <i class="bi bi-arrow-down-circle mb-4 me-2"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                            <h6 class="text-muted font-semibold">Penerimaan</h6>
                                            <h6 class="font-extrabold mb-0">{{ $totalPenerimaan }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card shadow">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                            <div class="stats-icon green mb-2">
                                                <i class="bi bi-arrow-up-circle mb-4 me-2"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                            <h6 class="text-muted font-semibold">Pengeluaran</h6>
                                            <h6 class="font-extrabold mb-0">{{ $totalPengeluaran }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card shadow">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                            <div class="stats-icon red mb-2">
                                                <i class="bi bi-qr-code-scan mb-4 me-2"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                            <h6 class="text-muted font-semibold">Total QR Code</h6>
                                            <h6 class="font-extrabold mb-0">{{ $totalRealisasi }}</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @auth
                    @if(Str::contains(Auth::user()->level_user, ['administrator', 'administrasi', 'manager', 'atu']))
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4>DOWNLOAD LAPORAN PERBULAN</h4>
                                    <div class="d-flex">
                                        <select id="monthSelect" class="form-select me-2" style="width:auto;">
                                            <option value="">-- Bulan --</option>
                                            @for ($m = 1; $m <= 12; $m++)
                                                <option value="{{ $m }}">{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                                            @endfor
                                        </select>

                                        <select id="yearSelect" class="form-select me-2" style="width:auto;">
                                            @foreach($years as $year)
                                                <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>{{ $year }}</option>
                                            @endforeach
                                        </select>

                                        <button id="downloadExcelBtn" class="btn btn-success">
                                            <i class="bi bi-file-earmark-excel"></i> Download Excel
                                        </button>
                                    </div>
                                </div>

                                <div class="card-body">
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endauth
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h4>DIAGRAM PENERIMAAN DAN PENGELUARAN </h4>
                                    <select id="yearSelectArea" class="form-select" style="width:auto;">
                                        @foreach($years as $year)
                                        <option value="{{ $year }}" {{ $selectedYear == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="card-body">
                                    <div id="area"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card shadow">
                                <div class="card-header">
                                    <h4>GRAFIK STOK MATERIAL</h4>
                                </div>
                                <div class="card-body">
                                    <div id="stokMaterialChart"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        </div>

    </div>

</x-layout>

<script>
    var areaOptions = {
        series: [{
                name: "Pengeluaran",
                data: {!! json_encode($pengeluaranData) !!},
            },
            {
                name: "Penerimaan",
                data: {!! json_encode($penerimaanData) !!},
            }
        ],
        chart: {
            height: 350,
            type: "area",
            toolbar: {
                show: true, // ✅ aktifkan toolbar
                tools: {
                    download: true, // ✅ tombol download gambar/chart
                    selection: true,
                    zoom: true,
                    zoomin: true,
                    zoomout: true,
                    pan: true,
                    reset: true
                }
            },
            zoom: {
                enabled: false
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: "smooth"
        },
        colors: ["#dc3545", "#28a745"],
        xaxis: {
            type: "category",
            categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        },
        tooltip: {
            x: {
                format: "MMM"
            },
            y: {
                formatter: function(val) {
                    return val + " /Kg";
                }
            }
        },
    };


    var areaChart = new ApexCharts(document.querySelector("#area"), areaOptions);
    areaChart.render();

    // Event filter tahun
    document.getElementById("yearSelectArea").addEventListener("change", function() {
        var year = this.value;
        fetch(`/dashboard/chart-data/${year}`)
            .then(res => res.json())
            .then(data => {
                areaChart.updateSeries([{
                        name: "Pengeluaran",
                        data: data.pengeluaran
                    },
                    {
                        name: "Penerimaan",
                        data: data.penerimaan
                    }
                ]);
            });
    });
</script>
<script>
    // === Grafik Stok Material ===
    var stokOptions = {
        series: [{
            data: {!! json_encode($stokData) !!},

        }],
        chart: {
            type: 'bar',
            height: 350
        },
        plotOptions: {
            bar: {
                horizontal: true,
            }
        },
        xaxis: {
            categories: {!! json_encode($stokLabels) !!},
        },
        colors: ["#827fe2ff"]
    };
    var stokChart = new ApexCharts(document.querySelector("#stokMaterialChart"), stokOptions);
    stokChart.render();
</script>
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- download excel -->
<script>
    document.getElementById("downloadExcelBtn").addEventListener("click", function() {
        const month = document.getElementById("monthSelect").value;
        const year = document.getElementById("yearSelect").value;

        // Validasi: wajib isi bulan & tahun
        if (!month || !year) {
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: 'Silakan pilih bulan dan tahun terlebih dahulu sebelum mendownload Excel.',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK',
            });
            return;
        }

        // Jika sudah lengkap → konfirmasi download
        Swal.fire({
            icon: 'question',
            title: 'Download Laporan?',
            html: `Anda akan mendownload laporan untuk <b>${month}/${year}</b>`,
            showCancelButton: true,
            confirmButtonText: 'Ya, Download!',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
        }).then((result) => {
            if (result.isConfirmed) {
                const url = `/dashboard/export-excel?year=${year}&month=${month}`;
                window.location.href = url;
            }
        });
    });
</script>