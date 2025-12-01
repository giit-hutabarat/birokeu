<?php $this->section("style"); ?>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&display=swap" rel="stylesheet">

<style>
    :root {
        --bg-dark: #050505;
        --sidebar-bg: rgba(11, 61, 32, 0.85); /* Hijau Adhyaksa Glass */
        --gold-primary: #FFD700;
        --text-white: #ffffff;
        --glass-border: 1px solid rgba(255,255,255,0.1);
    }

    body {
        font-family: 'Outfit', sans-serif;
        background: #000;
        color: white;
        overflow: hidden;
        margin: 0;
    }

    /* BACKGROUND LAYER */
    .bg-layer {
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        z-index: -1;
        background: radial-gradient(circle at 70% 50%, #1a1a1a 0%, #000 100%);
    }
    
    /* Bisa diganti video background di sini */
    #bg-video {
        position: fixed;
        right: 0; bottom: 0;
        min-width: 100%; min-height: 100%;
        z-index: -2;
        object-fit: cover;
        opacity: 0.4;
    }

    /* === LAYOUT SPLIT SCREEN === */
    .screen-wrapper {
        display: flex;
        height: 100vh;
        width: 100vw;
    }

    /* 1. SMART SIDEBAR (LEFT) */
    .sidebar {
        width: 380px; /* Fixed width */
        height: 100%;
        background: var(--sidebar-bg);
        backdrop-filter: blur(20px);
        border-right: 4px solid var(--gold-primary);
        display: flex;
        flex-direction: column;
        padding: 2.5rem 2rem;
        position: relative;
        box-shadow: 10px 0 30px rgba(0,0,0,0.5);
        z-index: 10;
    }

    /* Header Clock */
    .sidebar-header { margin-bottom: 3rem; }
    .clock-big { font-size: 4.5rem; font-weight: 800; line-height: 0.9; letter-spacing: -2px; }
    .date-text { font-size: 1.1rem; color: var(--gold-primary); margin-top: 10px; font-weight: 600; text-transform: uppercase; }

    /* Weather Widget */
    .weather-box {
        background: rgba(0,0,0,0.2);
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border: var(--glass-border);
    }
    .temp-big { font-size: 2.5rem; font-weight: 700; }

    /* Prayer Times List */
    .prayer-list {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .prayer-item {
        display: flex;
        justify-content: space-between;
        padding: 12px 15px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        font-size: 1.1rem;
    }
    .prayer-item.active {
        background: var(--gold-primary);
        color: #000;
        font-weight: 800;
        border-radius: 8px;
        border: none;
        transform: scale(1.05);
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    }

    /* QR Guestbook (Bottom) */
    .qr-section {
        margin-top: auto;
        text-align: center;
        background: white;
        padding: 15px;
        border-radius: 15px;
        color: black;
    }
    .qr-label { font-size: 0.9rem; font-weight: 700; margin-bottom: 5px; text-transform: uppercase; }

    /* BOSS BOOSTER: PULSE INDICATOR */
    .boss-pulse {
        position: absolute;
        top: 30px;
        right: 30px;
        width: 15px;
        height: 15px;
        border-radius: 50%;
        background: #00ff00; /* Default Green */
        box-shadow: 0 0 0 rgba(0, 255, 0, 0.4);
        animation: pulse 2s infinite;
    }
    .boss-pulse.alert {
        background: #ff0000;
        box-shadow: 0 0 0 rgba(255, 0, 0, 0.4);
        animation: pulse-alert 1s infinite;
    }

    /* 2. MAIN CONTENT (RIGHT) */
    .main-stage {
        flex: 1;
        padding: 3rem 4rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
    }

    /* Content Styling */
    .instansi-header {
        position: absolute;
        top: 30px; right: 40px;
        text-align: right;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .big-card {
        background: rgba(255,255,255,0.03);
        border: var(--glass-border);
        border-radius: 30px;
        padding: 3rem;
        height: 80%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        backdrop-filter: blur(5px);
    }

    .stat-row { display: flex; gap: 30px; margin-top: 3rem; }
    .stat-item {
        flex: 1;
        background: rgba(0,0,0,0.3);
        padding: 2rem;
        border-radius: 20px;
        border-left: 5px solid var(--gold-primary);
    }

    /* Animasi */
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(0, 255, 0, 0.7); }
        70% { box-shadow: 0 0 0 15px rgba(0, 255, 0, 0); }
        100% { box-shadow: 0 0 0 0 rgba(0, 255, 0, 0); }
    }
    @keyframes pulse-alert {
        0% { box-shadow: 0 0 0 0 rgba(255, 0, 0, 0.7); }
        70% { box-shadow: 0 0 0 20px rgba(255, 0, 0, 0); }
        100% { box-shadow: 0 0 0 0 rgba(255, 0, 0, 0); }
    }
    
    .fade-enter-active, .fade-leave-active { transition: opacity 0.8s ease; }
    .fade-enter-from, .fade-leave-to { opacity: 0; }
</style>
<?php $this->endSection("style") ?>

<div class="bg-layer"></div>
<div class="screen-wrapper">
    
    <aside class="sidebar">
        <div class="boss-pulse" :class="{ 'alert': !isPerformanceSafe }" title="Status Kinerja Biro"></div>

        <div class="sidebar-header">
            <div class="clock-big">{{ jam }}</div>
            <div class="date-text">{{ tanggal }}</div>
            <div class="mt-2 text-muted"><i class="mdi mdi-map-marker"></i> Jakarta Selatan</div>
        </div>

        <div class="weather-box">
            <div>
                <i class="mdi mdi-weather-partly-cloudy text-warning display-4"></i>
                <div class="small text-muted">Cuaca Saat Ini</div>
            </div>
            <div class="text-end">
                <div class="temp-big">29°C</div>
                <div class="text-white-50">Berawan</div>
            </div>
        </div>

        <h6 class="text-muted text-uppercase mb-3 ps-2" style="font-size: 0.8rem; letter-spacing: 2px;">Jadwal Sholat</h6>
        <div class="prayer-list">
            <div v-for="(time, name) in jadwalSholat" :key="name" 
                 class="prayer-item" 
                 :class="{ 'active': name === nextSholat }">
                <span>{{ name }}</span>
                <span>{{ time }}</span>
            </div>
        </div>

        <div class="qr-section">
            <div class="qr-label">Buku Tamu Digital</div>
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=https://kejaksaan.go.id/tamu" 
                 alt="Scan QR" class="img-fluid" style="width: 120px; height: 120px;">
            <div style="font-size: 0.7rem; margin-top: 5px; color: #333;">Scan untuk mengisi kehadiran</div>
        </div>
    </aside>

    <main class="main-stage">
        
        <div class="instansi-header">
            <div>
                <h3 class="fw-bold m-0 text-uppercase">Biro Keuangan</h3>
                <span class="text-gold" style="letter-spacing: 3px;">KEJAKSAAN AGUNG R.I.</span>
            </div>
            <img src="<?= base_url('/' . ($logo == "" ? 'logo.png' : 'assets/img/logo_kejaksaan.png')); ?>" width="80">
        </div>

        <transition name="fade" mode="out-in">
            
            <div v-if="activeSlide === 0" key="finance" class="big-card">
                <div class="mb-4">
                    <span class="badge bg-warning text-dark mb-2">MONITORING DIPA</span>
                    <h1 class="display-3 fw-bold">Realisasi Anggaran</h1>
                    <p class="h4 text-muted">Update Real-time per {{ tanggal }}</p>
                </div>

                <div class="py-4">
                    <div class="d-flex justify-content-between mb-2 h4">
                        <span>Progress Penyerapan</span>
                        <span :class="isPerformanceSafe ? 'text-success' : 'text-danger'">{{ finance.persen }}%</span>
                    </div>
                    <div class="progress" style="height: 40px; background: rgba(255,255,255,0.1); border-radius: 20px;">
                        <div class="progress-bar progress-bar-striped progress-bar-animated" 
                             :class="isPerformanceSafe ? 'bg-success' : 'bg-danger'"
                             role="progressbar" :style="{ width: finance.persen + '%' }"></div>
                    </div>
                </div>

                <div class="stat-row">
                    <div class="stat-item">
                        <div class="text-muted text-uppercase small mb-2">Total Pagu</div>
                        <div class="h2 fw-bold">{{ formatRupiah(finance.pagu) }}</div>
                    </div>
                    <div class="stat-item" style="border-left-color: #0f0;">
                        <div class="text-muted text-uppercase small mb-2">Realisasi</div>
                        <div class="h2 fw-bold text-success">{{ formatRupiah(finance.realisasi) }}</div>
                    </div>
                    <div class="stat-item" style="border-left-color: #f00;">
                        <div class="text-muted text-uppercase small mb-2">Sisa Anggaran</div>
                        <div class="h2 fw-bold">{{ formatRupiah(finance.sisa) }}</div>
                    </div>
                </div>
            </div>

            <div v-else-if="activeSlide === 1" key="agenda" class="big-card">
                <div class="mb-5 border-bottom border-secondary pb-3">
                    <h1 class="display-3 fw-bold"><i class="mdi mdi-calendar-check text-gold"></i> Agenda Hari Ini</h1>
                </div>

                <div class="row">
                    <div class="col-md-7">
                        <div class="d-flex flex-column gap-4">
                             <div v-for="(item, i) in dataAgenda" :key="i" class="d-flex align-items-center">
                                <div class="text-center me-4">
                                    <div class="h3 fw-bold text-gold m-0">{{ item.waktu.substring(0,5) }}</div>
                                    <small class="text-muted">WIB</small>
                                </div>
                                <div class="flex-grow-1 p-3 rounded" style="background: rgba(255,255,255,0.05);">
                                    <h4 class="fw-bold m-0">{{ item.nama_agenda }}</h4>
                                    <div class="text-white-50 mt-1"><i class="mdi mdi-map-marker"></i> {{ item.tempat_agenda }}</div>
                                </div>
                            </div>
                            <div v-if="dataAgenda.length === 0" class="alert alert-secondary">
                                Tidak ada agenda terjadwal untuk hari ini.
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5 text-center d-flex flex-column justify-content-center border-start border-secondary">
                        <i class="mdi mdi-format-quote-open display-1 text-muted opacity-25"></i>
                        <h3 class="fst-italic fw-light">"Transparansi dan Akuntabilitas adalah kunci kepercayaan publik."</h3>
                        <div class="mt-4 fw-bold text-gold">- Jaksa Agung RI</div>
                    </div>
                </div>
            </div>

        </transition>
    </main>
</div>

<?php $this->section("js") ?>
<script>
    function addZero(n) { return (n < 10 ? '0' : '') + n; }

    dataVue = {
        ...dataVue,
        jam: "",
        tanggal: "",
        
        // Data Slideshow
        activeSlide: 0,
        totalSlides: 2,

        // Data Utility (Sidebar)
        jadwalSholat: { Subuh: '04:12', Dzuhur: '11:51', Ashar: '15:15', Maghrib: '17:58', Isya: '19:12' },
        nextSholat: 'Ashar', // Nanti dibikin otomatis via JS
        
        // Data Finance (Dummy)
        finance: {
            pagu: 12000000000,
            realisasi: 8500000000,
            sisa: 3500000000,
            persen: 70.8,
            target_bulan: 75 // Target Boss Booster
        },
        dataAgenda: [], // Ambil dari API
        
        // Logic Boss Booster
        isPerformanceSafe: true 
    }

    createdVue = function() {
        setInterval(this.updateTime, 1000);
        this.getAgenda();
        this.checkBossBooster();
    }

    mountedVue = function() {
        // Ganti slide setiap 15 detik
        setInterval(() => {
            this.activeSlide = (this.activeSlide + 1) % this.totalSlides;
        }, 15000);

        // Update sholat active (Simulasi)
        setInterval(() => {
            // Logic penentuan sholat aktif bisa ditaruh sini
        }, 60000);
    }

    methodsVue = {
        ...methodsVue,
        
        formatRupiah: function(num) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(num);
        },

        updateTime: function() {
            const d = new Date();
            this.jam = `${addZero(d.getHours())}:${addZero(d.getMinutes())}`;
            
            const days = ["MINGGU", "SENIN", "SELASA", "RABU", "KAMIS", "JUMAT", "SABTU"];
            const months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
            this.tanggal = `${days[d.getDay()]}, ${d.getDate()} ${months[d.getMonth()]} ${d.getFullYear()}`;
        },

        getAgenda: function() {
            axios.get('<?= base_url() ?>/api/display/agenda').then(res => {
                if (res.data.status) this.dataAgenda = res.data.data;
            });
        },

        checkBossBooster: function() {
            // FITUR INOVATIF: BOSS BOOSTER
            // Jika realisasi di bawah target, lampu indikator jadi merah
            if (this.finance.persen < this.finance.target_bulan) {
                this.isPerformanceSafe = false;
            } else {
                this.isPerformanceSafe = true;
            }
        }
    }
</script>
<?php $this->endSection("js") ?>