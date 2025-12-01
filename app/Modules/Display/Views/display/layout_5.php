<?php $this->section("style"); ?>
<link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;500;700&family=Lato:wght@300;400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/weather-icons/2.0.12/css/weather-icons.min.css">

<style>
    :root {
        --bg-morning: linear-gradient(135deg, #1c92d2 0%, #f2fcfe 100%); /* Cerah */
        --bg-working: #0f172a; /* Gelap Fokus */
        --bg-evening: linear-gradient(to right, #2c3e50, #4ca1af); /* Kalem */
        
        --gold: #FFD700;
        --green-adhyaksa: #0B6623;
        --card-glass: rgba(255, 255, 255, 0.1);
        --card-border: 1px solid rgba(255, 255, 255, 0.2);
    }

    /* BASE RESET */
    html, body {
        height: 100vh; margin: 0; padding: 0;
        font-family: 'Lato', sans-serif;
        color: white;
        overflow: hidden; /* Desktop default */
        transition: background 1s ease;
    }

    .wrapper {
        display: flex; height: 100vh; width: 100vw;
        position: relative;
    }

    /* ===========================
       1. SIDEBAR (STATIC)
       =========================== */
    .sidebar {
        width: 300px;
        background: rgba(0,0,0,0.6);
        backdrop-filter: blur(15px);
        display: flex; flex-direction: column;
        padding: 30px;
        border-right: 1px solid rgba(255,255,255,0.1);
        z-index: 20;
    }

    .brand-area { display: flex; align-items: center; gap: 15px; margin-bottom: 40px; }
    .brand-text h1 { font-family: 'Oswald'; font-size: 1.5rem; margin: 0; line-height: 1; text-transform: uppercase; }
    .brand-text span { font-size: 0.8rem; color: var(--gold); letter-spacing: 1px; }

    .clock-widget { text-align: center; margin-bottom: 40px; }
    .clock-big { font-family: 'Oswald'; font-size: 4rem; line-height: 1; font-weight: 700; }
    .date-small { font-size: 1rem; opacity: 0.8; text-transform: uppercase; margin-top: 5px; }

    /* BOSS BOOSTER (Contextual Widget) */
    .boss-widget {
        background: rgba(255,255,255,0.1);
        border-radius: 12px;
        padding: 20px;
        margin-top: auto; /* Push to bottom */
        border-left: 5px solid var(--gold);
        transition: all 0.5s ease;
    }
    .boss-label { font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; color: #ccc; margin-bottom: 5px; }
    .boss-value { font-size: 1.5rem; font-weight: bold; font-family: 'Oswald'; }
    .boss-sub { font-size: 0.9rem; color: var(--gold); margin-top: 5px; }

    /* ===========================
       2. MAIN CONTENT (DYNAMIC)
       =========================== */
    .main-stage {
        flex: 1; position: relative;
        padding: 30px;
        display: flex; flex-direction: column;
        overflow: hidden;
    }

    /* TRANSITIONS */
    .fade-enter-active, .fade-leave-active { transition: opacity 0.8s ease, transform 0.8s ease; }
    .fade-enter-from { opacity: 0; transform: translateY(20px); }
    .fade-leave-to { opacity: 0; transform: translateY(-20px); }

    /* --- MODE 1: MORNING (Agenda & Weather Focus) --- */
    .morning-grid {
        display: grid; grid-template-columns: 1fr 1fr; gap: 30px; height: 100%;
    }
    .morning-card {
        background: rgba(0,0,0,0.5); border-radius: 20px; padding: 30px;
        border: var(--card-border); display: flex; flex-direction: column;
    }
    .greeting { font-family: 'Oswald'; font-size: 3rem; margin-bottom: 20px; text-shadow: 2px 2px 10px rgba(0,0,0,0.3); }
    
    .weather-big { display: flex; align-items: center; gap: 30px; margin-bottom: 30px; }
    .temp-huge { font-size: 6rem; font-family: 'Oswald'; font-weight: 700; line-height: 1; }
    
    /* --- MODE 2: WORKING (Data & TV Focus) --- */
    .working-grid {
        display: grid; grid-template-columns: 2fr 1fr; grid-template-rows: 2fr 1fr; gap: 20px; height: 100%;
    }
    .tv-box { grid-column: 1 / 2; grid-row: 1 / 3; background: black; border-radius: 15px; overflow: hidden; position: relative; }
    .chart-box { grid-column: 2 / 3; grid-row: 1 / 2; background: rgba(15, 23, 42, 0.8); border-radius: 15px; padding: 20px; border: 1px solid rgba(255,255,255,0.1); }
    .sholat-box { grid-column: 2 / 3; grid-row: 2 / 3; background: rgba(11, 102, 35, 0.8); border-radius: 15px; padding: 20px; display: flex; flex-direction: column; justify-content: center; }

    /* --- MODE 3: EVENING (Summary Focus) --- */
    .evening-container {
        display: flex; flex-direction: column; justify-content: center; align-items: center; height: 100%;
        text-align: center;
    }
    .summary-card {
        background: rgba(255,255,255,0.1); backdrop-filter: blur(10px);
        padding: 50px; border-radius: 30px; border: 1px solid rgba(255,255,255,0.2);
        max-width: 800px; width: 100%;
    }
    .achieve-ring {
        width: 200px; height: 200px; border-radius: 50%;
        border: 15px solid rgba(255,255,255,0.1);
        border-top: 15px solid var(--gold);
        margin: 0 auto 30px;
        display: flex; align-items: center; justify-content: center;
        font-size: 3rem; font-family: 'Oswald'; font-weight: bold;
    }

    /* COMMON COMPONENTS */
    .list-item {
        display: flex; align-items: center; gap: 15px; padding: 15px;
        border-bottom: 1px solid rgba(255,255,255,0.1);
    }
    .time-badge { background: var(--gold); color: black; font-weight: bold; padding: 5px 10px; border-radius: 5px; }

    /* ===========================
       RESPONSIVE (MOBILE)
       =========================== */
    @media screen and (max-width: 1024px) {
        html, body { overflow-y: auto; height: auto; }
        .wrapper { flex-direction: column; height: auto; }

        /* Sidebar jadi Top Header */
        .sidebar {
            width: 100%; height: auto; flex-direction: row; justify-content: space-between; align-items: center;
            padding: 15px;
        }
        .brand-area { margin-bottom: 0; }
        .brand-text h1 { font-size: 1.2rem; }
        .clock-widget { display: none; } /* Hide clock di header mobile */
        .boss-widget { display: none; } /* Hide boss widget di header mobile */

        .main-stage { padding: 15px; height: auto; display: block; }

        /* Reset Grids to Stack */
        .morning-grid, .working-grid { display: flex; flex-direction: column; gap: 20px; }
        
        .tv-box { height: 250px; } /* Fix height TV HP */
        .chart-box, .sholat-box { height: auto; min-height: 200px; }
        
        .temp-huge { font-size: 4rem; }
        .greeting { font-size: 2rem; }
        
        .summary-card { padding: 20px; }
        .achieve-ring { width: 150px; height: 150px; font-size: 2rem; }
    }
</style>
<?php $this->endSection("style") ?>

<div class="wrapper" :style="{ background: currentBg }">
    
    <div class="sidebar">
        <div class="brand-area">
            <img src="<?php echo base_url('/' . ($logo == "" ? 'logo.png' : $logo)); ?>" width="50" />
            <div class="brand-text">
                <h1>Biro Keuangan</h1>
                <span>KEJAKSAAN AGUNG RI</span>
            </div>
        </div>

        <div class="clock-widget">
            <div class="clock-big">{{ jam }}</div>
            <div class="date-small">{{ tanggal }}</div>
        </div>

        <div class="boss-widget">
            <div class="boss-label">{{ bossData.label }}</div>
            <div class="boss-value">{{ bossData.value }}</div>
            <div class="boss-sub">{{ bossData.sub }}</div>
        </div>
    </div>

    <div class="main-stage">
        <transition name="fade" mode="out-in">

            <div v-if="mode === 'morning'" key="morning" class="morning-grid">
                <div class="morning-card" style="justify-content: center;">
                    <div class="greeting">SELAMAT PAGI, <br><span style="color:var(--gold)">PARA JAKSA HEBAT!</span></div>
                    <div class="weather-big">
                        <i class="wi wi-day-sunny text-warning" style="font-size: 5rem;"></i>
                        <div>
                            <div class="temp-huge">28°</div>
                            <div class="h4 m-0">Jakarta Selatan</div>
                        </div>
                    </div>
                    <div class="alert alert-light bg-opacity-25 border-0 text-white">
                        <i class="mdi mdi-lightbulb-on text-warning"></i> 
                        <strong>Quote Hari Ini:</strong> "Integritas adalah melakukan hal yang benar, bahkan ketika tidak ada yang melihat."
                    </div>
                </div>
                <div class="morning-card">
                    <h3 class="font-oswald mb-4 border-bottom pb-2">AGENDA HARI INI</h3>
                    <div style="overflow-y: auto; flex: 1;">
                        <div v-for="(item, i) in dataAgenda" :key="i" class="list-item">
                            <div class="time-badge">{{ item.waktu.substring(0,5) }}</div>
                            <div>
                                <div class="fw-bold fs-5">{{ item.nama_agenda }}</div>
                                <small class="text-white-50">{{ item.tempat_agenda }}</small>
                            </div>
                        </div>
                         <div v-if="dataAgenda.length === 0" class="text-center mt-5 opacity-50">Belum ada agenda.</div>
                    </div>
                </div>
            </div>

            <div v-else-if="mode === 'working'" key="working" class="working-grid">
                <div class="tv-box">
                    <div style="position:absolute; top:15px; left:15px; background:red; padding:2px 10px; font-weight:bold; border-radius:4px; z-index:10;">LIVE MONITOR</div>
                    <?php 
                        $finalVideoId = $videoId;
                        if (empty($finalVideoId)) { $finalVideoId = 'r3wW21ddf9U'; } // Default News
                    ?>
                    <iframe width="100%" height="100%" src="https://www.youtube.com/embed/<?= $finalVideoId; ?>?autoplay=1&mute=1&controls=0&showinfo=0&loop=1&playlist=<?= $finalVideoId; ?>" frameborder="0" allow="autoplay"></iframe>
                </div>

                <div class="chart-box">
                    <h4 class="font-oswald mb-3 text-warning">REALISASI ANGGARAN LIVE</h4>
                    <div class="d-flex align-items-end gap-2" style="height: 150px; padding-bottom: 10px; border-bottom: 1px solid #555;">
                        <div style="flex:1; background:rgba(255,255,255,0.1); height:100%; border-radius:5px; position:relative;">
                             <div style="position:absolute; bottom:0; width:100%; background:var(--green-adhyaksa); height:65%; border-radius:5px; transition: height 1s;"></div>
                             <div style="position:absolute; bottom: -25px; width:100%; text-align:center; font-size:0.8rem;">REALISASI</div>
                        </div>
                        <div style="flex:1; background:rgba(255,255,255,0.1); height:100%; border-radius:5px; position:relative;">
                             <div style="position:absolute; bottom:0; width:100%; background:var(--gold); height:70%; border-radius:5px; transition: height 1s;"></div>
                             <div style="position:absolute; bottom: -25px; width:100%; text-align:center; font-size:0.8rem;">TARGET</div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                         <div>
                             <small class="text-muted d-block">PENYERAPAN</small>
                             <span class="fs-2 fw-bold font-oswald">{{ finance.persen }}%</span>
                         </div>
                         <div class="text-end">
                             <small class="text-muted d-block">SISA ANGGARAN</small>
                             <span class="fs-4 fw-bold text-danger">{{ formatRupiah(finance.sisa) }}</span>
                         </div>
                    </div>
                </div>

                <div class="sholat-box">
                     <div class="text-center">
                         <i class="mdi mdi-mosque fs-1 text-white-50"></i>
                         <h5 class="mt-2 text-warning">MENUJU SHOLAT {{ nextPrayer }}</h5>
                         <div class="fs-1 fw-bold font-oswald">{{ jadwalSholat[nextPrayer] }}</div>
                     </div>
                </div>
            </div>

            <div v-else key="evening" class="evening-container">
                <div class="summary-card">
                    <h2 class="font-oswald mb-5">LAPORAN HARIAN BIRO</h2>
                    
                    <div class="achieve-ring">
                        {{ finance.persen }}%
                    </div>
                    
                    <h4 class="mb-3">Status Penyerapan Hari Ini: <span class="text-success">OPTIMAL</span></h4>
                    <p class="text-white-50 mb-4">Terima kasih atas kerja keras Anda hari ini. Pastikan semua dokumen telah tersimpan sebelum pulang.</p>
                    
                    <div class="row g-3">
                        <div class="col-md-4">
                            <div class="bg-dark p-3 rounded">
                                <small class="d-block text-muted">DOKUMEN CAIR</small>
                                <strong class="fs-4">12 SPM</strong>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-dark p-3 rounded">
                                <small class="d-block text-muted">PNBP MASUK</small>
                                <strong class="fs-4 text-warning">Rp 450 Jt</strong>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-dark p-3 rounded">
                                <small class="d-block text-muted">AGENDA BESOK</small>
                                <strong class="fs-4 text-info">3 Rapat</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </transition>
    </div>
</div>

<?php $this->section("js") ?>
<script>
    function addZero(n) { return (n < 10 ? '0' : '') + n; }

    dataVue = {
        ...dataVue,
        jam: "", tanggal: "",
        
        // Context State
        mode: 'morning', // morning, working, evening
        currentBg: 'var(--bg-morning)',
        
        // Data
        dataAgenda: [],
        finance: { pagu: 10000000000, realisasi: 6500000000, sisa: 3500000000, persen: 65 },
        jadwalSholat: { Subuh: '04:15', Dzuhur: '11:55', Ashar: '15:15', Maghrib: '18:00', Isya: '19:10' },
        nextPrayer: 'Dzuhur',
        
        // Boss Booster Data (Dynamic)
        bossData: { label: 'TARGET HARI INI', value: 'Rp 500 Juta', sub: 'Pencairan SPM' }
    }

    createdVue = function() {
        setInterval(this.updateTime, 1000);
        this.getAgenda();
        
        // Initial Check Mode
        this.checkMode();
        // Cek mode setiap 1 menit
        setInterval(this.checkMode, 60000);
    }

    mountedVue = function() {
        // Fetch data
    }

    methodsVue = {
        ...methodsVue,

        formatRupiah: function(num) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(num);
        },

        updateTime: function() {
            const d = new Date();
            this.jam = `${addZero(d.getHours())}:${addZero(d.getMinutes())}`;
            const m = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des"];
            this.tanggal = `${d.getDate()} ${m[d.getMonth()]} ${d.getFullYear()}`;
        },

        // INOVASI UTAMA: TIME-BASED UX
        checkMode: function() {
            const h = new Date().getHours();
            
            // Testing: Lo bisa ganti angka ini manual buat liat preview mode lain
            // Misal: if (true) ...
            
            if (h >= 6 && h < 10) {
                // PAGI (06:00 - 10:00)
                this.mode = 'morning';
                this.currentBg = 'var(--bg-morning)';
                this.bossData = { label: 'TARGET HARI INI', value: 'Rp 500 Juta', sub: 'Estimasi Pencairan' };
            } 
            else if (h >= 10 && h < 15) {
                // KERJA (10:00 - 15:00)
                this.mode = 'working';
                this.currentBg = 'var(--bg-working)';
                this.bossData = { label: 'STATUS SAAT INI', value: 'ON TRACK', sub: 'Semua Satker Aman' };
                
                // Set Next Prayer
                if(h < 12) this.nextPrayer = 'Dzuhur';
                else if(h < 15) this.nextPrayer = 'Ashar';
            } 
            else {
                // SORE/MALAM (15:00++)
                this.mode = 'evening';
                this.currentBg = 'var(--bg-evening)';
                this.bossData = { label: 'TOTAL CAPAIAN', value: 'Rp 480 Juta', sub: '96% dari Target Harian' };
            }
        },

        getAgenda: function() { axios.get('<?= base_url() ?>/api/display/agenda').then(res => { if(res.data.status) this.dataAgenda = res.data.data; }).catch(e=>{}); },
    }
</script>
<?php $this->endSection("js") ?>