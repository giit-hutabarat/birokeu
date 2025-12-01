<?php $this->section("style"); ?>
<style>
    :root {
        --adhyaksa-green: #0b3d20; /* Hijau Tua Kejaksaan */
        --adhyaksa-gold: #c5a017;  /* Emas */
        --bg-body: #f4f6f9;
    }

    body {
        background-color: var(--bg-body);
    }

    /* Header Styling */
    .navbar-adhyaksa {
        background: linear-gradient(90deg, var(--adhyaksa-green) 0%, #14522d 100%);
        border-bottom: 4px solid var(--adhyaksa-gold);
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    
    .instansi-title {
        color: #fff;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .instansi-address {
        color: var(--adhyaksa-gold);
        font-size: 0.9rem;
    }

    /* Cards Styling */
    .card-kpi {
        border: none;
        border-radius: 10px;
        transition: transform 0.2s;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    
    .card-kpi:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .card-icon-bg {
        position: absolute;
        right: -10px;
        bottom: -10px;
        font-size: 5rem;
        opacity: 0.1;
        transform: rotate(-15deg);
    }

    /* Table Styling */
    .table-custom thead {
        background-color: var(--adhyaksa-green);
        color: white;
    }
    
    /* Running Text Footer */
    .news-footer {
        background-color: #212529;
        color: var(--adhyaksa-gold);
        position: fixed;
        bottom: 0;
        width: 100%;
        height: 50px;
        z-index: 999;
        display: flex;
        align-items: center;
        overflow: hidden;
    }
</style>
<?php $this->endSection("style") ?>

<nav class="navbar navbar-adhyaksa mb-4 p-3">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <img id="logo" class="img-fluid me-3" src="<?php echo base_url('/' . ($logo == "" ? 'logo.png' : $logo)); ?>" width="70" />
            <div class="d-flex flex-column">
                <span class="h3 fw-bold instansi-title m-0"><?= $nama_instansi; ?></span>
                <span class="instansi-address m-0"><?= $alamat; ?></span>
            </div>
        </div>

        <div class="text-end text-white">
            <div class="h2 fw-bold m-0 text-warning">{{ jam }}</div>
            <div class="h6 m-0">{{ tanggal }}</div>
        </div>
    </div>
</nav>

<div class="container-fluid px-4 pb-5 mb-5">
    
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card card-kpi bg-primary text-white h-100">
                <div class="card-body position-relative">
                    <h6 class="text-uppercase opacity-75">Total Pagu Anggaran</h6>
                    <h3 class="fw-bold mt-2">{{ formatRupiah(summaryFinance.pagu) }}</h3>
                    <i class="mdi mdi-cash-multiple card-icon-bg"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-kpi bg-success text-white h-100">
                <div class="card-body position-relative">
                    <h6 class="text-uppercase opacity-75">Total Realisasi</h6>
                    <h3 class="fw-bold mt-2">{{ formatRupiah(summaryFinance.realisasi) }}</h3>
                    <small class="badge bg-white text-success rounded-pill">
                        {{ summaryFinance.persen_realisasi }}% Tercapai
                    </small>
                    <i class="mdi mdi-chart-line card-icon-bg"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-kpi bg-danger text-white h-100">
                <div class="card-body position-relative">
                    <h6 class="text-uppercase opacity-75">Sisa Anggaran</h6>
                    <h3 class="fw-bold mt-2">{{ formatRupiah(summaryFinance.sisa) }}</h3>
                    <i class="mdi mdi-alert-circle-outline card-icon-bg"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-kpi bg-warning text-dark h-100">
                <div class="card-body position-relative">
                    <h6 class="text-uppercase opacity-75">Penerimaan (PNBP)</h6>
                    <h3 class="fw-bold mt-2">{{ formatRupiah(summaryFinance.pnbp) }}</h3>
                    <i class="mdi mdi-scale-balance card-icon-bg"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="m-0 fw-bold text-success"><i class="mdi mdi-poll"></i> Trend Penyerapan Anggaran (Per Bulan)</h5>
                </div>
                <div class="card-body">
                    <div id="chart-penyerapan" style="height: 350px; background: #eee; display: flex; align-items: center; justify-content: center;">
                        <span class="text-muted">Area Grafik (Integrasikan ApexCharts/ChartJS disini)</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 border-bottom border-success border-2">
                    <h5 class="m-0 fw-bold text-dark">🏆 Top 5 Realisasi Tertinggi</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped m-0">
                        <thead class="table-success">
                            <tr>
                                <th>Satuan Kerja</th>
                                <th class="text-end">Realisasi</th>
                                <th class="text-center">%</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in topSatker" :key="index">
                                <td>{{ item.nama_satker }}</td>
                                <td class="text-end">{{ formatRupiah(item.nilai) }}</td>
                                <td class="text-center fw-bold text-success">{{ item.persen }}%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 border-bottom border-danger border-2">
                    <h5 class="m-0 fw-bold text-dark">⚠️ 5 Realisasi Terendah (Perlu Atensi)</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped m-0">
                        <thead class="table-danger">
                            <tr>
                                <th>Satuan Kerja</th>
                                <th class="text-end">Realisasi</th>
                                <th class="text-center">%</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(item, index) in lowSatker" :key="index">
                                <td>{{ item.nama_satker }}</td>
                                <td class="text-end">{{ formatRupiah(item.nilai) }}</td>
                                <td class="text-center fw-bold text-danger">{{ item.persen }}%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="news-footer">
    <div class="container-fluid d-flex">
        <div class="bg-danger text-white px-3 py-2 fw-bold me-2" style="white-space: nowrap;">INFO TERKINI</div>
        <div class="w-100 overflow-hidden position-relative">
            <marquee scrollamount="5" onmouseover="this.stop();" onmouseout="this.start();">
                <span v-for="item in dataNews" :key="item.id" class="me-5">
                    <i class="mdi mdi-information-outline"></i> {{ item.text_news }}
                </span>
            </marquee>
        </div>
    </div>
</div>

<?php $this->section("js") ?>
<script>
    function addZeroBefore(n) {
        return (n < 10 ? '0' : '') + n;
    }

    // Mixin dataVue sesuai struktur layout_1.php
    dataVue = {
        ...dataVue,
        tanggal: "",
        jam: "",
        dataNews: [], // Dari layout_1
        
        // DATA BARU (Placeholder untuk Dashboard Keuangan)
        summaryFinance: {
            pagu: 0,
            realisasi: 0,
            sisa: 0,
            persen_realisasi: 0,
            pnbp: 0
        },
        topSatker: [],
        lowSatker: []
    }

    createdVue = function() {
        setInterval(this.getDate, 1000);
        setInterval(this.getTime, 1000);
        this.getNews(); // Bawaan layout_1
        
        // Panggil fungsi data keuangan
        this.getFinanceData(); 
    }

    mountedVue = function() {
        setInterval(() => this.getNews(), <?= $news_refresh; ?> * 1000);
        
        // Refresh data keuangan setiap 60 detik (contoh)
        setInterval(() => this.getFinanceData(), 60 * 1000);
    }

    methodsVue = {
        ...methodsVue,
        
        // Helper Format Rupiah
        formatRupiah: function(number) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(number);
        },

        getDate: function() {
            const weekday = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
            const today = new Date();
            const date = addZeroBefore(today.getDate()) + '-' + (addZeroBefore(today.getMonth() + 1)) + '-' + today.getFullYear();
            let Hari = weekday[today.getDay()];
            this.tanggal = Hari + ', ' + date;
        },

        getTime: function() {
            const today = new Date();
            this.jam = addZeroBefore(today.getHours()) + ":" + addZeroBefore(today.getMinutes()) + ":" + addZeroBefore(today.getSeconds());
        },

        getNews: function() {
            // Logic lama dari layout_1.php
            axios.get('<?= base_url() ?>/api/news/news')
                .then(res => {
                    if (res.data.status == true) {
                        this.dataNews = res.data.data;
                    }
                })
                .catch(err => console.log(err));
        },

        // FUNGSI BARU: Get Finance Data
        getFinanceData: function() {
            // Nanti lo ganti URL ini ke Controller API keuangan lo
            // axios.get('<?= base_url() ?>/api/finance/executive_summary')
            
            // SIMULASI DATA (Biar lo liat tampilannya dulu)
            console.log("Fetching Finance Data...");
            
            this.summaryFinance = {
                pagu: 15000000000,
                realisasi: 8500000000,
                sisa: 6500000000,
                persen_realisasi: 56.6,
                pnbp: 250000000
            };

            this.topSatker = [
                { nama_satker: 'Bidang Pembinaan', nilai: 1200000000, persen: 90 },
                { nama_satker: 'Bidang Pidum', nilai: 900000000, persen: 85 },
                { nama_satker: 'Bidang Intelijen', nilai: 850000000, persen: 82 },
            ];

            this.lowSatker = [
                { nama_satker: 'Bidang Datun', nilai: 100000000, persen: 15 },
                { nama_satker: 'Bidang Pidsus', nilai: 150000000, persen: 20 },
            ];
        }
    }
</script>
<?php $this->endSection("js") ?>