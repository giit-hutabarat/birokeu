<?php $this->section("style"); ?>
<style>
    :root {
        --adhyaksa-dark: #051e11; /* Hijau Hitam */
        --adhyaksa-green: #0e4d2a; /* Hijau Kejaksaan */
        --adhyaksa-gold: #fbbf24;  /* Emas Terang */
        --text-light: #f3f4f6;
    }

    body {
        background: radial-gradient(circle at center, var(--adhyaksa-green) 0%, var(--adhyaksa-dark) 100%);
        color: var(--text-light);
        overflow: hidden; /* Hilangkan scrollbar untuk TV Display */
        font-family: 'Segoe UI', sans-serif;
    }

    /* Navbar/Header Transparent */
    .navbar-glass {
        background: rgba(0, 0, 0, 0.4);
        backdrop-filter: blur(10px);
        border-bottom: 2px solid var(--adhyaksa-gold);
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.5);
    }

    .instansi-title { font-size: 1.8rem; letter-spacing: 2px; text-transform: uppercase; color: #fff; }
    .instansi-subtitle { color: var(--adhyaksa-gold); font-size: 1.1rem; }

    /* Main Content Area */
    .main-display {
        height: 75vh; /* Sisa tinggi layar untuk konten */
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Transition Fade Vue */
    .fade-enter-active, .fade-leave-active { transition: opacity 1s ease; }
    .fade-enter-from, .fade-leave-to { opacity: 0; }

    /* Custom Progress Bar for Budget */
    .progress-glass {
        height: 35px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    .progress-bar-glow {
        background: linear-gradient(90deg, var(--adhyaksa-gold), #f59e0b);
        box-shadow: 0 0 15px var(--adhyaksa-gold);
    }

    /* Footer Ticker */
    .footer-ticker {
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background: #000;
        border-top: 3px solid var(--adhyaksa-gold);
        height: 60px;
        display: flex;
        align-items: center;
        z-index: 100;
    }
    
    .kurs-box {
        background: var(--adhyaksa-gold);
        color: #000;
        font-weight: bold;
        padding: 0 20px;
        height: 100%;
        display: flex;
        align-items: center;
        font-size: 1.2rem;
    }
</style>
<?php $this->endSection("style") ?>

<nav class="navbar navbar-glass p-3 mb-4">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <img class="img-fluid me-4" style="filter: drop-shadow(0 0 10px rgba(255,255,255,0.3));" src="<?php echo base_url('/' . ($logo == "" ? 'logo.png' : $logo)); ?>" width="90" />
            <div class="d-flex flex-column">
                <span class="fw-bold instansi-title">Biro Keuangan</span>
                <span class="instansi-subtitle">Kejaksaan Republik Indonesia</span>
            </div>
        </div>
        <div class="text-end">
            <div class="display-5 fw-bold text-white" style="text-shadow: 0 0 10px rgba(0,0,0,0.5);">{{ jam }}</div>
            <div class="h4 text-warning m-0">{{ tanggal }}</div>
        </div>
    </div>
</nav>

<div class="container-fluid px-5">
    <div class="main-display position-relative">
        
        <transition name="fade">
            <div v-if="activeSlide === 0" class="w-100 position-absolute">
                <h1 class="display-4 fw-bold text-center mb-5 text-warning border-bottom border-warning d-inline-block pb-2 mx-auto">
                    <i class="mdi mdi-chart-pie"></i> REALISASI ANGGARAN TAHUN BERJALAN
                </h1>
                
                <div class="row align-items-center mt-4">
                    <div class="col-md-5 text-end border-end border-secondary pe-5">
                        <div class="mb-5">
                            <h4 class="text-secondary text-uppercase">Total Pagu</h4>
                            <h1 class="display-3 fw-bold text-white">{{ formatRupiah(publicFinance.pagu) }}</h1>
                        </div>
                        <div>
                            <h4 class="text-secondary text-uppercase">Total Realisasi</h4>
                            <h1 class="display-3 fw-bold text-success">{{ formatRupiah(publicFinance.realisasi) }}</h1>
                        </div>
                    </div>
                    
                    <div class="col-md-7 ps-5">
                        <h2 class="mb-3">Persentase Penyerapan: <span class="text-warning display-4 fw-bold">{{ publicFinance.persen }}%</span></h2>
                        <div class="progress progress-glass mb-3" style="height: 60px;">
                            <div class="progress-bar progress-bar-glow progress-bar-striped progress-bar-animated" role="progressbar" 
                                 :style="{ width: publicFinance.persen + '%' }"></div>
                        </div>
                        <p class="h4 text-muted mt-3">Target Bulan Ini: {{ publicFinance.target_bulan }}%</p>
                    </div>
                </div>
            </div>
        </transition>

        <transition name="fade">
            <div v-if="activeSlide === 1" class="w-100 position-absolute">
                <h1 class="display-4 fw-bold text-center mb-5 text-white border-bottom border-white d-inline-block pb-2 mx-auto">
                    <i class="mdi mdi-cash-register"></i> PENERIMAAN NEGARA BUKAN PAJAK (PNBP)
                </h1>
                
                <div class="row g-4 justify-content-center">
                    <div class="col-md-4" v-for="(item, i) in pnbpData" :key="i">
                        <div class="card bg-transparent border border-warning h-100 text-center p-4" 
                             style="box-shadow: 0 0 20px rgba(251, 191, 36, 0.1);">
                            <div class="card-body">
                                <div class="display-1 text-warning mb-3">
                                    <i :class="item.icon"></i>
                                </div>
                                <h3 class="text-white text-uppercase mb-3">{{ item.jenis }}</h3>
                                <h2 class="fw-bold text-success">{{ formatRupiah(item.nilai) }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </transition>

        <transition name="fade">
            <div v-if="activeSlide === 2" class="w-100 position-absolute">
                <h1 class="display-4 fw-bold text-center mb-5 text-info border-bottom border-info d-inline-block pb-2 mx-auto">
                    <i class="mdi mdi-calendar-clock"></i> AGENDA KEGIATAN HARI INI
                </h1>
                
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="list-group">
                            <div v-for="(item, i) in dataAgenda" :key="i" 
                                 class="list-group-item bg-dark border-secondary text-white d-flex align-items-center p-4 mb-2 rounded">
                                <div class="bg-primary text-white rounded p-3 text-center me-4" style="min-width: 100px;">
                                    <h3 class="m-0 fw-bold">{{ item.waktu.substring(0,5) }}</h3>
                                    <small>WIB</small>
                                </div>
                                <div>
                                    <h2 class="fw-bold m-0 text-warning">{{ item.nama_agenda }}</h2>
                                    <p class="h4 m-0 text-muted mt-1"><i class="mdi mdi-map-marker"></i> {{ item.tempat_agenda }}</p>
                                </div>
                            </div>
                            <div v-if="dataAgenda.length === 0" class="text-center py-5">
                                <h2 class="text-muted fst-italic">Tidak ada agenda publik hari ini.</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </transition>

    </div>
</div>

<div class="footer-ticker">
    <div class="kurs-box">
        <span class="me-3"><i class="mdi mdi-currency-usd"></i> KURS BI:</span>
        <span class="me-3">USD: {{ kurs.usd }}</span>
        <span>EUR: {{ kurs.eur }}</span>
    </div>
    <div class="flex-grow-1 overflow-hidden position-relative h-100 d-flex align-items-center">
        <marquee scrollamount="8" class="text-white h3 m-0 fw-light">
            <span v-for="item in dataNews" :key="item.id" class="me-5">
                <img src="<?= base_url('assets/img/adhyaksa-icon.png') ?>" height="30" class="me-2" style="opacity:0.7">
                {{ item.text_news }}
            </span>
        </marquee>
    </div>
</div>

<?php $this->section("js") ?>
<script>
    function addZeroBefore(n) { return (n < 10 ? '0' : '') + n; }

    dataVue = {
        ...dataVue,
        tanggal: "",
        jam: "",
        dataNews: [],
        dataAgenda: [], // Menggunakan struktur layout_1
        
        // Data Khusus Layout 3
        activeSlide: 0,
        totalSlides: 3,
        publicFinance: { pagu: 0, realisasi: 0, persen: 0, target_bulan: 0 },
        pnbpData: [],
        kurs: { usd: '15.400', eur: '16.800' } // Dummy/Default
    }

    createdVue = function() {
        setInterval(this.getDate, 1000);
        setInterval(this.getTime, 1000);
        this.getNews();
        this.getAgenda(); // Pakai function lama
        this.getPublicData(); // Function baru
    }

    mountedVue = function() {
        // Refresh konten
        setInterval(() => this.getNews(), <?= $news_refresh; ?> * 1000);
        setInterval(() => this.getAgenda(), <?= $agenda_refresh; ?> * 1000);
        setInterval(() => this.getPublicData(), 60 * 1000);

        // Slide Rotator (Ganti slide tiap 15 detik)
        setInterval(() => {
            this.activeSlide = (this.activeSlide + 1) % this.totalSlides;
        }, 15000);
    }

    methodsVue = {
        ...methodsVue,
        
        formatRupiah: function(number) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(number);
        },

        getDate: function() {
            const weekday = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
            const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
            const today = new Date();
            this.tanggal = weekday[today.getDay()] + ', ' + today.getDate() + ' ' + monthNames[today.getMonth()] + ' ' + today.getFullYear();
        },

        getTime: function() {
            const today = new Date();
            this.jam = addZeroBefore(today.getHours()) + ":" + addZeroBefore(today.getMinutes());
        },

        getNews: function() {
             axios.get('<?= base_url() ?>/api/news/news').then(res => {
                if (res.data.status) this.dataNews = res.data.data;
            });
        },
        
        getAgenda: function() {
             axios.get('<?= base_url() ?>/api/display/agenda').then(res => {
                if (res.data.status) this.dataAgenda = res.data.data;
            });
        },

        // Simulasi Data Publik
        getPublicData: function() {
            // Simulasi API call
            // axios.get('<?= base_url() ?>/api/public/display')...
            
            // Dummy Data untuk visualisasi
            this.publicFinance = {
                pagu: 50000000000,
                realisasi: 32500000000,
                persen: 65,
                target_bulan: 70
            };

            this.pnbpData = [
                { jenis: 'Uang Pengganti', nilai: 1500000000, icon: 'mdi mdi-gavel' },
                { jenis: 'Denda Tilang', nilai: 250000000, icon: 'mdi mdi-ticket-percent' },
                { jenis: 'Penjualan Barang Rampasan', nilai: 850000000, icon: 'mdi mdi-car-convertible' }
            ];
            
            // Update Kurs dummy
            this.kurs = { usd: 'Rp 15.850', eur: 'Rp 17.100' };
        }
    }
</script>
<?php $this->endSection("js") ?>