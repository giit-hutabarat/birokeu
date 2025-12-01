<?php $this->section("style"); ?>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
<style>
    :root {
        --bg-dark: #0a0e12;
        --glass-sidebar: rgba(20, 30, 25, 0.65);
        --glass-border: rgba(255, 255, 255, 0.08);
        --gold-primary: #D4AF37;
        --green-adhyaksa: #105936;
        --text-white: #ffffff;
        --text-muted: #a0a0a0;
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background: #000;
        color: var(--text-white);
        overflow: hidden;
    }

    /* BACKGROUND VIDEO */
    #bg-video {
        position: fixed;
        right: 0; bottom: 0;
        min-width: 100%; min-height: 100%;
        z-index: -1;
        object-fit: cover;
        filter: brightness(0.6) contrast(1.1);
    }

    /* LAYOUT GRID */
    .wrapper {
        display: flex;
        height: 100vh;
        width: 100vw;
    }

    /* === SMART SIDEBAR (LEFT) === */
    .smart-sidebar {
        width: 28%;
        height: 100%;
        background: var(--glass-sidebar);
        backdrop-filter: blur(20px);
        border-right: 1px solid var(--glass-border);
        display: flex;
        flex-direction: column;
        padding: 2rem;
        position: relative;
        z-index: 10;
    }

    /* Clock Section */
    .digital-clock {
        margin-bottom: 2rem;
    }
    .time-big { font-size: 4rem; font-weight: 800; line-height: 1; letter-spacing: -2px; }
    .date-small { font-size: 1.2rem; color: var(--gold-primary); font-weight: 600; text-transform: uppercase; margin-top: 5px; }

    /* DYNAMIC ISLAND (Notification Area) */
    .dynamic-island-wrapper {
        height: 80px; /* Space holder */
        margin-bottom: 2rem;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .dynamic-island {
        background: #000;
        border-radius: 40px;
        height: 50px;
        min-width: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0 20px;
        color: white;
        box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        border: 1px solid rgba(255,255,255,0.1);
        transition: all 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        overflow: hidden;
    }
    
    /* Island Modes */
    .island-sholat { background: var(--green-adhyaksa); width: 100%; }
    .island-cuaca { background: #1a1a1a; width: 80%; }
    .island-alert { background: #8B0000; width: 100%; animation: pulse-red 2s infinite; }

    /* Prayer Schedule List */
    .prayer-list {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }
    .prayer-item {
        display: flex;
        justify-content: space-between;
        padding: 12px 15px;
        background: rgba(255,255,255,0.03);
        border-radius: 12px;
        font-weight: 500;
        border: 1px solid transparent;
    }
    .prayer-item.active {
        background: linear-gradient(90deg, var(--green-adhyaksa), transparent);
        border-color: var(--gold-primary);
        font-weight: 700;
        transform: scale(1.02);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    /* BOSS BOOSTER: PERFORMANCE PULSE */
    .performance-pulse {
        margin-top: auto;
        padding-top: 20px;
        border-top: 1px solid var(--glass-border);
    }
    .pulse-label { font-size: 0.8rem; text-transform: uppercase; letter-spacing: 2px; color: var(--text-muted); }
    .pulse-graph {
        height: 40px;
        display: flex;
        align-items: center;
        gap: 3px;
    }
    .bar {
        width: 6px;
        background: var(--green-adhyaksa);
        border-radius: 3px;
        animation: equalizer 1s infinite ease-in-out;
    }
    /* Kalau performa jelek, class ini dipake JS untuk ubah warna jadi merah */
    .pulse-danger .bar { background: #dc3545; }

    /* === MAIN CONTENT (RIGHT) === */
    .main-content {
        flex: 1;
        position: relative;
        padding: 3rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    /* Content Cards (Glass) */
    .content-card {
        background: rgba(0, 0, 0, 0.4);
        border-radius: 25px;
        padding: 3rem;
        border: 1px solid var(--glass-border);
        height: 100%;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    /* Typography */
    .hero-title { font-size: 3rem; font-weight: 800; color: var(--gold-primary); margin-bottom: 0.5rem; }
    .hero-subtitle { font-size: 1.5rem; color: white; margin-bottom: 2rem; font-weight: 300; }
    
    .stat-box {
        background: rgba(255,255,255,0.05);
        padding: 20px;
        border-radius: 15px;
        text-align: center;
        border: 1px solid rgba(255,255,255,0.05);
    }

    /* Animations */
    @keyframes equalizer {
        0% { height: 10px; }
        50% { height: 35px; }
        100% { height: 10px; }
    }
    @keyframes pulse-red {
        0% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(220, 53, 69, 0); }
        100% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
    }
    
    .slide-fade-enter-active, .slide-fade-leave-active { transition: all 0.8s ease; }
    .slide-fade-enter-from { opacity: 0; transform: translateY(20px); }
    .slide-fade-leave-to { opacity: 0; transform: translateY(-20px); }
</style>
<?php $this->endSection("style") ?>

<video autoplay muted loop id="bg-video">
    <source src="<?= base_url('/public/assets/video/bg-abstract.mp4') ?>" type="video/mp4">
</video>

<div class="wrapper">
    
    <div class="smart-sidebar">
        <div class="digital-clock text-start">
            <div class="time-big">{{ jam }}</div>
            <div class="date-small">{{ tanggal }}</div>
        </div>

        <div class="dynamic-island-wrapper">
            <div v-if="islandMode === 'sholat'" class="dynamic-island island-sholat">
                <i class="mdi mdi-mosque me-2"></i>
                <span class="fw-bold">{{ nextSholat.name }}</span>
                <span class="mx-2">|</span>
                <span class="font-monospace">{{ nextSholat.countdown }}</span>
            </div>

            <div v-if="islandMode === 'cuaca'" class="dynamic-island island-cuaca">
                <i :class="cuaca.icon + ' me-2 text-warning'"></i>
                <span>{{ cuaca.temp }}°C - {{ cuaca.desc }}</span>
            </div>

            <div v-if="islandMode === 'alert'" class="dynamic-island island-alert">
                <i class="mdi mdi-alert-circle me-2"></i> PERHATIAN: {{ alertMessage }}
            </div>
        </div>

        <div class="prayer-list mb-4">
            <div v-for="(time, name) in jadwalSholat" :key="name" 
                 class="prayer-item" 
                 :class="{ 'active': name === nextSholat.name }">
                <span>{{ name }}</span>
                <span>{{ time }}</span>
            </div>
        </div>

        <div class="performance-pulse" :class="{ 'pulse-danger': !isPerformanceGood }">
            <div class="d-flex justify-content-between align-items-end mb-2">
                <span class="pulse-label">SYSTEM HEALTH</span>
                <span class="fw-bold" :class="isPerformanceGood ? 'text-success' : 'text-danger'">
                    {{ isPerformanceGood ? 'OPTIMAL' : 'ATTENTION REQUIRED' }}
                </span>
            </div>
            <div class="pulse-graph">
                <div class="bar" style="animation-delay: 0.1s"></div>
                <div class="bar" style="animation-delay: 0.3s"></div>
                <div class="bar" style="animation-delay: 0.5s"></div>
                <div class="bar" style="animation-delay: 0.2s"></div>
                <div class="bar" style="animation-delay: 0.4s"></div>
                <div class="bar" style="animation-delay: 0.1s"></div>
                <div class="bar" style="animation-delay: 0.1s"></div>
                <div class="bar" style="animation-delay: 0.3s"></div>
                <div class="bar" style="animation-delay: 0.5s"></div>
                <div class="bar" style="animation-delay: 0.2s"></div>
            </div>
        </div>
    </div>

    <div class="main-content">
        <div class="position-absolute top-0 end-0 p-4 d-flex align-items-center">
            <div class="text-end me-3">
                <h4 class="m-0 fw-bold text-white text-uppercase">Biro Keuangan</h4>
                <small class="text-gold-primary">KEJAKSAAN AGUNG R.I.</small>
            </div>
            <img src="<?= base_url('/' . ($logo == "" ? 'logo.png' : $logo)); ?>" width="60">
        </div>

        <transition name="slide-fade" mode="out-in">
            
            <div v-if="activeSlide === 0" key="finance" class="content-card">
                <h1 class="hero-title"><i class="mdi mdi-chart-box"></i> STATUS ANGGARAN</h1>
                <p class="hero-subtitle">Realisasi Penyerapan Anggaran Tahun Berjalan</p>
                
                <div class="row g-4 align-items-center">
                    <div class="col-8">
                        <div class="progress mb-3" style="height: 50px; background: rgba(255,255,255,0.1); border-radius: 25px;">
                            <div class="progress-bar bg-success progress-bar-striped progress-bar-animated" 
                                 role="progressbar" :style="{ width: financeData.persen + '%' }">
                                <span class="fs-4 fw-bold">{{ financeData.persen }}%</span>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between text-muted fs-5">
                            <span>0%</span>
                            <span>Target: {{ financeData.target }}%</span>
                            <span>100%</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="stat-box">
                            <h6 class="text-uppercase text-muted">Sisa Anggaran</h6>
                            <h2 class="fw-bold text-white mb-0">{{ formatRupiah(financeData.sisa) }}</h2>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-5">
                    <div class="col-4">
                        <div class="stat-box border-warning">
                            <h6 class="text-warning">PNBP (Uang Pengganti)</h6>
                            <h3 class="fw-bold">{{ formatRupiah(pnbpData.uang_pengganti) }}</h3>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="stat-box">
                            <h6 class="text-info">PNBP (Tilang)</h6>
                            <h3 class="fw-bold">{{ formatRupiah(pnbpData.tilang) }}</h3>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="stat-box">
                            <h6 class="text-success">Total Realisasi</h6>
                            <h3 class="fw-bold">{{ formatRupiah(financeData.realisasi) }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <div v-else-if="activeSlide === 1" key="agenda" class="content-card">
                <h1 class="hero-title"><i class="mdi mdi-calendar-star"></i> AGENDA BIRO</h1>
                <p class="hero-subtitle">Jadwal Kegiatan Pimpinan & Rapat Hari Ini</p>

                <div class="d-flex flex-column gap-3">
                    <div v-for="(item, i) in dataAgenda" :key="i" class="d-flex align-items-center bg-dark bg-opacity-50 p-3 rounded-3 border border-secondary">
                        <div class="bg-gold-primary text-dark fw-bold rounded p-3 text-center me-4" style="min-width: 100px;">
                            <span class="h3 d-block m-0">{{ item.waktu.substring(0,5) }}</span>
                        </div>
                        <div>
                            <h3 class="fw-bold text-white m-0">{{ item.nama_agenda }}</h3>
                            <div class="text-muted"><i class="mdi mdi-map-marker"></i> {{ item.tempat_agenda }}</div>
                        </div>
                    </div>
                    <div v-if="dataAgenda.length === 0" class="text-center text-muted h3 mt-5">
                        Belum ada agenda terjadwal.
                    </div>
                </div>
            </div>

        </transition>
    </div>
</div>

<?php $this->section("js") ?>
<script>
    function addZeroBefore(n) { return (n < 10 ? '0' : '') + n; }

    dataVue = {
        ...dataVue,
        tanggal: "",
        jam: "",
        
        // Dynamic Island State
        islandMode: 'cuaca', // 'sholat', 'cuaca', 'alert'
        alertMessage: "",
        
        // Data Sholat & Cuaca
        jadwalSholat: { Subuh: '04:15', Dzuhur: '11:55', Ashar: '15:18', Maghrib: '18:05', Isya: '19:15' },
        nextSholat: { name: 'Ashar', countdown: '00:00:00' },
        cuaca: { temp: 29, desc: 'Berawan', icon: 'mdi mdi-weather-cloudy' },
        
        // Performance Indicator (Boss Booster)
        isPerformanceGood: true, // Ubah ke false kalau realisasi rendah
        
        // Slide Control
        activeSlide: 0,
        totalSlides: 2,
        
        // Dummy Finance Data
        financeData: { pagu: 50000000000, realisasi: 35000000000, sisa: 15000000000, persen: 70, target: 75 },
        pnbpData: { uang_pengganti: 1200000000, tilang: 350000000 },
        dataAgenda: []
    }

    createdVue = function() {
        setInterval(this.getDate, 1000);
        setInterval(this.getTime, 1000);
        this.getAgenda();
        
        // Check System Health (Simulasi)
        this.checkPerformance();
    }

    mountedVue = function() {
        // Rotasi Slide Utama (20 Detik)
        setInterval(() => {
            this.activeSlide = (this.activeSlide + 1) % this.totalSlides;
        }, 20000);

        // Rotasi Dynamic Island (5 Detik ganti antara Cuaca & Sholat)
        setInterval(() => {
            if(this.islandMode === 'cuaca') this.islandMode = 'sholat';
            else if(this.islandMode === 'sholat') this.islandMode = 'cuaca';
            // Mode 'alert' di-trigger manual jika ada error
        }, 8000);
        
        // Countdown Sholat Logic (Simplified)
        setInterval(this.updateSholatCountdown, 1000);
    }

    methodsVue = {
        ...methodsVue,
        
        formatRupiah: function(number) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(number);
        },
        
        getDate: function() {
            const days = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
            const months = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des"];
            const d = new Date();
            this.tanggal = `${days[d.getDay()]}, ${d.getDate()} ${months[d.getMonth()]} ${d.getFullYear()}`;
        },

        getTime: function() {
            const d = new Date();
            this.jam = `${addZeroBefore(d.getHours())}:${addZeroBefore(d.getMinutes())}`;
        },
        
        getAgenda: function() {
            axios.get('<?= base_url() ?>/api/display/agenda').then(res => {
                if (res.data.status) this.dataAgenda = res.data.data;
            });
        },

        // Logic sederhana penentuan jadwal sholat selanjutnya
        updateSholatCountdown: function() {
            // Di real project, lo harus parsing waktu dari string '15:18' ke Date object
            // Ini cuma dummy visual biar lo liat efek Dynamic Island-nya
            const now = new Date();
            this.nextSholat.countdown = "-" + addZeroBefore(60 - now.getSeconds()) + "s (Demo)";
        },

        checkPerformance: function() {
            // Fitur Boss Booster
            // Logic: Jika Persen Realisasi < Target - 10%, maka Status Merah
            if(this.financeData.persen < (this.financeData.target - 10)) {
                this.isPerformanceGood = false;
                this.islandMode = 'alert'; // Override Dynamic Island
                this.alertMessage = "Realisasi di bawah target!";
            } else {
                this.isPerformanceGood = true;
            }
        }
    }
</script>
<?php $this->endSection("js") ?>