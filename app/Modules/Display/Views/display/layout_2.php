<?php $this->section("style"); ?>
<link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;600;700&family=Exo+2:wght@400;700&display=swap" rel="stylesheet">

<style>
    :root {
        --glass-bg: rgba(0, 0, 0, 0.35); /* Warna dasar kaca gelap */
        --glass-border: rgba(255, 255, 255, 0.1);
        --adhyaksa-gold: #FFD700;
        --adhyaksa-green: #00FF7F; /* Hijau neon dikit biar pop-up di dark mode */
        --text-glow: 0 0 10px rgba(255, 215, 0, 0.5);
    }

    body {
        font-family: 'Exo 2', sans-serif;
        background-color: #000;
        color: #fff;
        overflow: hidden;
    }

    /* 1. VIDEO BACKGROUND LAYER */
    #bg-video {
        position: fixed;
        right: 0;
        bottom: 0;
        min-width: 100%;
        min-height: 100%;
        z-index: -1;
        object-fit: cover;
        opacity: 0.6; /* Gelapin dikit biar teks kebaca */
        filter: contrast(1.2) brightness(0.8);
    }

    /* Fallback Gradient kalau video gagal load */
    .bg-fallback {
        position: fixed;
        top:0; left:0; width:100%; height:100%; z-index:-2;
        background: radial-gradient(circle at center, #0f2e1a 0%, #000000 100%);
    }

    /* 2. GLASSMORPHISM UTILITY */
    .glass-panel {
        background: var(--glass-bg);
        backdrop-filter: blur(16px) saturate(120%);
        -webkit-backdrop-filter: blur(16px) saturate(120%);
        border: 1px solid var(--glass-border);
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        border-radius: 16px;
    }
    
    .glass-header {
        background: rgba(0, 0, 0, 0.2);
        backdrop-filter: blur(10px);
        border-bottom: 1px solid var(--glass-border);
    }

    /* 3. TYPOGRAPHY & GLOW */
    .text-gold { color: var(--adhyaksa-gold); }
    .text-green-neon { color: var(--adhyaksa-green); }
    
    .glow-text {
        text-shadow: 0 0 15px rgba(255, 215, 0, 0.3);
    }
    
    .big-number {
        font-family: 'Rajdhani', sans-serif;
        font-weight: 700;
        letter-spacing: 2px;
    }

    /* 4. CARD STYLING */
    .card-pnbp {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        height: 100%;
        position: relative;
        overflow: hidden;
    }
    
    .card-pnbp:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(255, 215, 0, 0.15);
        border-color: var(--adhyaksa-gold);
    }

    .card-pnbp::before {
        content: '';
        position: absolute;
        top: 0; left: -100%;
        width: 100%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
        transition: 0.5s;
    }
    
    .card-pnbp:hover::before {
        left: 100%;
    }

    /* 5. ANIMATIONS */
    .fade-enter-active, .fade-leave-active { transition: opacity 0.8s ease, transform 0.8s ease; }
    .fade-enter-from { opacity: 0; transform: scale(0.95); }
    .fade-leave-to { opacity: 0; transform: scale(1.05); }

    /* Footer Ticker */
    .glass-footer {
        position: fixed;
        bottom: 0; width: 100%;
        background: rgba(0,0,0,0.6);
        backdrop-filter: blur(10px);
        border-top: 1px solid var(--glass-border);
        height: 60px;
        display: flex;
        align-items: center;
        z-index: 10;
    }
</style>
<?php $this->endSection("style") ?>

<video autoplay muted loop id="bg-video">
    <source src="<?= base_url('assets/video/bg-smoke.mp4') ?>" type="video/mp4">
</video>
<div class="bg-fallback"></div>

<nav class="navbar glass-header mb-5 p-3 fixed-top">
    <div class="container-fluid d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <img class="img-fluid me-3" style="filter: drop-shadow(0 0 8px rgba(255,255,255,0.2));" src="<?php echo base_url('/' . ($logo == "" ? 'logo.png' : $logo)); ?>" width="70" />
            <div class="d-flex flex-column">
                <span class="h2 fw-bold text-uppercase m-0 tracking-widest text-white">Biro Keuangan</span>
                <span class="text-gold m-0" style="font-size: 1rem; letter-spacing: 3px;">KEJAKSAAN AGUNG R.I.</span>
            </div>
        </div>
        <div class="text-end text-white">
            <div class="display-6 fw-bold big-number glow-text">{{ jam }}</div>
            <div class="h6 m-0 opacity-75">{{ tanggal }}</div>
        </div>
    </div>
</nav>

<div class="container-fluid d-flex align-items-center justify-content-center" style="height: 100vh; padding-top: 80px; padding-bottom: 60px;">
    
    <transition name="fade">
        <div v-if="activeSlide === 0" class="w-100 px-5 text-center position-absolute">
            <div class="mb-5">
                <h5 class="text-gold text-uppercase letter-spacing-2 mb-2">Laporan Transparansi</h5>
                <h1 class="display-3 fw-bold text-white glow-text">
                    <i class="mdi mdi-cash-register me-2"></i> PENERIMAAN NEGARA BUKAN PAJAK
                </h1>
                <div class="mx-auto mt-3" style="width: 150px; height: 3px; background: linear-gradient(90deg, transparent, var(--adhyaksa-gold), transparent);"></div>
            </div>

            <div class="row g-4 justify-content-center px-5">
                <div class="col-md-4">
                    <div class="glass-panel card-pnbp p-5">
                        <div class="mb-4">
                            <i class="mdi mdi-gavel display-2 text-gold"></i>
                        </div>
                        <h4 class="text-white text-uppercase fw-light mb-3">Uang Pengganti</h4>
                        <h2 class="big-number text-green-neon display-5" id="val-up">
                            {{ formatRupiah(pnbpData.uang_pengganti) }}
                        </h2>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="glass-panel card-pnbp p-5">
                        <div class="mb-4">
                            <i class="mdi mdi-ticket-percent display-2 text-gold"></i>
                        </div>
                        <h4 class="text-white text-uppercase fw-light mb-3">Denda Tilang</h4>
                        <h2 class="big-number text-green-neon display-5">
                            {{ formatRupiah(pnbpData.denda_tilang) }}
                        </h2>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="glass-panel card-pnbp p-5">
                        <div class="mb-4">
                            <i class="mdi mdi-car-pickup display-2 text-gold"></i>
                        </div>
                        <h4 class="text-white text-uppercase fw-light mb-3">Barang Rampasan</h4>
                        <h2 class="big-number text-green-neon display-5">
                            {{ formatRupiah(pnbpData.barang_rampasan) }}
                        </h2>
                    </div>
                </div>
            </div>
        </div>
    </transition>

    <transition name="fade">
        <div v-if="activeSlide === 1" class="w-100 px-5 position-absolute">
            <div class="row align-items-center">
                <div class="col-md-5 text-center">
                     <div class="position-relative d-inline-block p-5">
                        <svg width="350" height="350" viewBox="0 0 200 200">
                            <circle cx="100" cy="100" r="90" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="15" />
                            <circle cx="100" cy="100" r="90" fill="none" stroke="var(--adhyaksa-gold)" stroke-width="15" 
                                    stroke-dasharray="565" :stroke-dashoffset="565 - (565 * financeData.persen / 100)" 
                                    transform="rotate(-90 100 100)" style="transition: stroke-dashoffset 2s ease-out;" />
                        </svg>
                        <div class="position-absolute top-50 start-50 translate-middle text-center">
                            <h1 class="display-2 big-number text-white fw-bold">{{ financeData.persen }}%</h1>
                            <span class="text-gold text-uppercase">Terserap</span>
                        </div>
                     </div>
                </div>
                <div class="col-md-7">
                    <h5 class="text-gold mb-2">MONITORING DIPA</h5>
                    <h1 class="display-4 fw-bold mb-5">REALISASI ANGGARAN</h1>
                    
                    <div class="glass-panel p-4 mb-3 d-flex justify-content-between align-items-center">
                        <span class="h3 m-0"><i class="mdi mdi-safe"></i> Total Pagu</span>
                        <span class="h2 big-number text-white m-0">{{ formatRupiah(financeData.pagu) }}</span>
                    </div>
                    
                    <div class="glass-panel p-4 mb-3 d-flex justify-content-between align-items-center" style="border-left: 5px solid var(--adhyaksa-green);">
                        <span class="h3 m-0"><i class="mdi mdi-chart-line"></i> Realisasi</span>
                        <span class="h2 big-number text-green-neon m-0">{{ formatRupiah(financeData.realisasi) }}</span>
                    </div>

                    <div class="glass-panel p-4 d-flex justify-content-between align-items-center" style="border-left: 5px solid red;">
                        <span class="h3 m-0"><i class="mdi mdi-alert-circle-outline"></i> Sisa Anggaran</span>
                        <span class="h2 big-number text-white m-0">{{ formatRupiah(financeData.sisa) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </transition>

</div>

<div class="glass-footer">
    <div class="bg-gold text-dark px-4 h-100 d-flex align-items-center fw-bold fs-4" style="background: var(--adhyaksa-gold);">
        INFO TERKINI
    </div>
    <div class="flex-grow-1 overflow-hidden">
        <marquee class="fs-4 mt-1">
            <span v-for="item in dataNews" :key="item.id" class="me-5 text-shadow">
                <i class="mdi mdi-information text-gold"></i> {{ item.text_news }}
            </span>
        </marquee>
    </div>
</div>

<?php $this->section("js") ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

<script>
    function addZeroBefore(n) { return (n < 10 ? '0' : '') + n; }

    dataVue = {
        ...dataVue,
        tanggal: "",
        jam: "",
        dataNews: [],
        
        // State Slide & Data
        activeSlide: 0,
        totalSlides: 2, // Ubah sesuai jumlah slide
        
        // Dummy Data (Nanti ganti fetch API)
        pnbpData: {
            uang_pengganti: 1500000000,
            denda_tilang: 250000000,
            barang_rampasan: 850000000
        },
        financeData: {
            pagu: 15000000000,
            realisasi: 9500000000,
            sisa: 5500000000,
            persen: 63.3
        }
    }

    createdVue = function() {
        setInterval(this.getDate, 1000);
        setInterval(this.getTime, 1000);
        this.getNews();
        
        // Panggil data awal
        this.getRealData();
    }

    mountedVue = function() {
        // Auto Refresh Data
        setInterval(() => this.getNews(), <?= $news_refresh; ?> * 1000);
        setInterval(() => this.getRealData(), 60 * 1000);

        // Slide Rotation (Ganti tiap 15 detik)
        setInterval(() => {
            this.activeSlide = (this.activeSlide + 1) % this.totalSlides;
            
            // Trigger animasi angka setiap ganti slide (Simple logic)
            // Di Vue reactivity akan handle update, tapi untuk efek 'counting up'
            // bisa pake watcher kalau mau kompleks.
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
            this.jam = addZeroBefore(today.getHours()) + ":" + addZeroBefore(today.getMinutes()) + ":" + addZeroBefore(today.getSeconds());
        },

        getNews: function() {
            // Gunakan API existing lo
            axios.get('<?= base_url() ?>/api/news/news').then(res => {
                if(res.data.status) this.dataNews = res.data.data;
            });
        },

        getRealData: function() {
            // Disini lo tembak API Module Keuangan lo nanti
            // axios.get('<?= base_url() ?>/api/display/finance_summary')...
            console.log("Fetching new data...");
            
            // Simulasi update data acak untuk testing animasi
            // this.pnbpData.uang_pengganti += 100000; 
        }
    }
</script>
<?php $this->endSection("js") ?>