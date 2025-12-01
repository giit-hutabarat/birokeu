<?php $this->section("style"); ?>
<link href="https://fonts.googleapis.com/css2?family=Chakra+Petch:wght@300;400;600;700&family=Inter:wght@300;400;600;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/weather-icons/2.0.12/css/weather-icons.min.css">

<style>
    :root {
        --sidebar-w: 25vw;
        --bg-dark: #0f172a;
        --sidebar-bg: rgba(15, 23, 42, 0.95);
        --gold: #F59E0B;
        --accent-green: #10B981;
        --accent-red: #EF4444;
        --glass-border: 1px solid rgba(255,255,255,0.1);
    }

    /* Reset & Base */
    html, body {
        height: 100vh; margin: 0; padding: 0;
        background: #000; font-family: 'Inter', sans-serif; color: white;
        overflow: hidden; /* Default TV: No Scroll */
    }

    /* --- LAYOUT GRID UTAMA --- */
    .dashboard-container {
        display: flex; height: 100vh; width: 100vw;
        transition: all 0.3s ease;
    }

    /* 1. SIDEBAR (KIRI) */
    .sidebar {
        width: var(--sidebar-w);
        background: var(--sidebar-bg);
        border-right: 2px solid var(--gold);
        display: flex; flex-direction: column;
        padding: 2rem;
        z-index: 100; /* Sidebar selalu di atas */
        box-shadow: 10px 0 50px rgba(0,0,0,0.5);
        position: relative;
    }

    .header-section { margin-bottom: 2rem; text-align: center; position: relative; }
    .clock-big { font-family: 'Chakra Petch', sans-serif; font-size: 4rem; font-weight: 700; line-height: 1; }
    .date-small { color: var(--gold); font-weight: 600; text-transform: uppercase; letter-spacing: 1px; margin-top: 0.5rem; }
    
    /* Boss Booster */
    .boss-indicator {
        position: absolute; top: 10px; right: 10px;
        width: 12px; height: 12px; border-radius: 50%;
        background: var(--accent-green);
        box-shadow: 0 0 15px var(--accent-green);
        animation: pulse 2s infinite;
    }
    .boss-indicator.warning { background: var(--gold); box-shadow: 0 0 15px var(--gold); }
    .boss-indicator.danger { background: var(--accent-red); box-shadow: 0 0 15px var(--accent-red); animation: pulse-fast 0.5s infinite; }

    /* Widgets Sidebar */
    .weather-card {
        background: rgba(255,255,255,0.05); border-radius: 15px; padding: 1.5rem;
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 2rem; border: var(--glass-border);
    }
    .weather-temp { font-size: 2.5rem; font-weight: 700; font-family: 'Chakra Petch'; }
    
    .sholat-container { flex: 1; display: flex; flex-direction: column; gap: 10px; overflow-y: auto; }
    .sholat-item {
        display: flex; justify-content: space-between; padding: 12px 15px;
        background: rgba(255,255,255,0.03); border-radius: 8px; font-weight: 500;
        transition: all 0.3s;
    }
    .sholat-item.next-prayer {
        background: var(--gold); color: #000; font-weight: 800; transform: scale(1.02);
        box-shadow: 0 5px 20px rgba(245, 158, 11, 0.3); border: none;
    }

    .qr-area { margin-top: auto; text-align: center; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.1); }

    /* 2. MAIN CONTENT (KANAN) */
    .main-content {
        flex: 1; display: flex; flex-direction: column;
        background: #1e293b;
        height: 100%; /* Full height di desktop */
        overflow: hidden;
    }

    /* TV Section */
    .tv-section {
        flex: 55; /* 55% Tinggi Layar */
        background: #000; position: relative; overflow: hidden;
        min-height: 300px; /* Minimal height biar gak gepeng */
    }
    .tv-wrapper { width: 100%; height: 100%; }
    .tv-label {
        position: absolute; top: 20px; left: 20px;
        background: rgba(220, 38, 38, 0.9); color: white;
        padding: 5px 15px; font-weight: bold; border-radius: 4px;
        font-size: 0.9rem; z-index: 20; display: flex; align-items: center; gap: 8px;
    }

    /* Data Section (Finance & Agenda) */
    .data-section {
        flex: 45; /* 45% Tinggi Layar */
        display: flex; border-top: 1px solid rgba(255,255,255,0.1);
        background: radial-gradient(circle at top right, #1e293b 0%, #0f172a 100%);
        overflow: hidden;
    }

    .finance-area {
        flex: 6; /* 60% Lebar */
        padding: 2rem; border-right: 1px solid rgba(255,255,255,0.1);
        position: relative; display: flex; flex-direction: column; justify-content: center;
    }
    
    .agenda-area {
        flex: 4; /* 40% Lebar */
        padding: 1.5rem; background: rgba(0,0,0,0.2);
        display: flex; flex-direction: column;
    }
    
    .agenda-title { font-size: 1.1rem; color: var(--gold); font-weight: 700; margin-bottom: 1rem; text-transform: uppercase; border-bottom: 2px solid var(--gold); padding-bottom: 5px; display: inline-block;}
    .agenda-list { overflow: hidden; flex: 1; position: relative; }
    .scroller-agenda { animation: scrollUp 40s linear infinite; }
    .agenda-item {
        background: rgba(255,255,255,0.05); border-left: 3px solid var(--accent-green);
        padding: 10px; margin-bottom: 10px; border-radius: 0 6px 6px 0;
    }
    .agenda-time { font-weight: 800; color: var(--accent-green); font-size: 0.9rem; }
    .agenda-desc { font-size: 0.95rem; line-height: 1.2; margin-top: 2px; }

    /* Footer Ticker */
    .ticker-bar {
        height: 50px; background: #b91c1c; flex-shrink: 0;
        display: flex; align-items: center; overflow: hidden; z-index: 20;
    }
    .ticker-content { white-space: nowrap; padding-left: 100%; animation: marquee 25s linear infinite; font-size: 1.2rem; font-weight: 600; }

    .progress-custom { height: 25px; background: rgba(255,255,255,0.1); border-radius: 12px; overflow: hidden; margin-top: 10px; }
    .bar-fill { height: 100%; background: var(--accent-green); display: flex; align-items: center; justify-content: flex-end; padding-right: 10px; font-size: 0.8rem; font-weight: bold; color: #000; transition: width 1s ease; }

    /* Animations */
    @keyframes pulse { 0% { opacity: 0.6; transform: scale(1); } 50% { opacity: 1; transform: scale(1.2); } 100% { opacity: 0.6; transform: scale(1); } }
    @keyframes pulse-fast { 0% { opacity: 1; } 50% { opacity: 0.3; } 100% { opacity: 1; } }
    @keyframes marquee { 0% { transform: translate(0, 0); } 100% { transform: translate(-100%, 0); } }
    @keyframes scrollUp { 0% { transform: translateY(0); } 100% { transform: translateY(-50%); } }

    /* ==========================================================================
       RESPONSIVE BREAKPOINTS (Mobile & Tablet)
       ========================================================================== */
    @media screen and (max-width: 1024px) {
        /* Ubah container jadi scrollable vertikal */
        html, body { overflow-y: auto; height: auto; }
        
        .dashboard-container {
            flex-direction: column; /* Stack ke bawah */
            height: auto;
            width: 100%;
        }

        /* 1. SIDEBAR JADI HEADER */
        .sidebar {
            width: 100%;
            height: auto;
            border-right: none;
            border-bottom: 3px solid var(--gold);
            padding: 1.5rem;
            box-shadow: none;
        }

        .header-section { 
            display: flex; justify-content: space-between; align-items: center; 
            margin-bottom: 1rem; text-align: left;
        }
        .header-section .clock-big { font-size: 2.5rem; }
        .header-section .date-small { font-size: 0.9rem; margin-top: 0; }
        
        /* Sembunyikan elemen kurang penting di mobile biar gak panjang banget */
        .weather-card, .qr-area { display: none; } 
        
        .sholat-container { 
            flex-direction: row; flex-wrap: wrap; gap: 5px; 
            justify-content: center; /* Sholat jadi tombol-tombol kecil */
        }
        .sholat-item { padding: 5px 10px; font-size: 0.8rem; flex: 1 0 30%; text-align: center; }

        /* 2. MAIN CONTENT JADI STACK */
        .main-content { width: 100%; height: auto; display: block; }
        
        .tv-section {
            height: 250px; /* Tinggi video fix di HP */
            flex: none; /* Matikan flex ratio */
        }

        .data-section {
            flex-direction: column; /* Agenda di bawah Finance */
            height: auto;
            flex: none;
        }

        .finance-area {
            width: 100%;
            border-right: none;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            padding: 1.5rem;
            min-height: 350px; /* Space buat grafik */
        }

        .agenda-area {
            width: 100%;
            min-height: 400px; /* Space buat agenda */
            flex: none;
        }
        
        .agenda-list { overflow-y: auto; } /* Di HP bisa scroll manual agendanya */
        .scroller-agenda { animation: none; } /* Matikan auto scroll di HP biar enak dibaca */

        .ticker-bar {
            position: fixed; bottom: 0; width: 100%; /* Ticker tetep nempel bawah */
        }
        
        /* Boss Booster di HP dipindah */
        .boss-indicator { top: 50%; right: 0; transform: translateY(-50%); position: relative; margin-left: 10px; }
    }
</style>
<?php $this->endSection("style") ?>

<div class="dashboard-container">
    
    <div class="sidebar">
        <div class="header-section">
            <div class="boss-indicator" :class="bossStatus" title="Indikator Kinerja Biro"></div>
            
            <div class="clock-big">{{ jam }}</div>
            <div class="date-small">{{ tanggal }}</div>
        </div>

        <div class="weather-card">
            <div class="d-flex align-items-center">
                <i class="wi wi-day-cloudy text-warning" style="font-size: 2.5rem; margin-right: 15px;"></i>
                <div style="line-height:1.1;">
                    <div style="font-size:0.9rem; color:#ccc;">Jakarta</div>
                    <div class="fw-bold">Berawan</div>
                </div>
            </div>
            <div class="weather-temp">29°</div>
        </div>

        <h6 class="text-muted text-uppercase fw-bold mb-3"><i class="mdi mdi-mosque"></i> Jadwal Sholat</h6>
        <div class="sholat-container">
            <div v-for="(time, name) in jadwalSholat" :key="name" 
                 class="sholat-item" :class="{ 'next-prayer': name === nextPrayer }">
                <span>{{ name }}</span>
                <span>{{ time }}</span>
            </div>
        </div>

        <div class="mt-auto text-center pt-4 border-top border-secondary">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=100x100&data=BukuTamu" width="80" class="mb-2 bg-white p-1 rounded">
            <div style="font-size:0.8rem; color:#aaa;">Scan Buku Tamu</div>
        </div>
    </div>

    <div class="main-content">
        
        <div class="tv-section">
            <div class="tv-label">
                <span class="spinner-grow spinner-grow-sm bg-white" role="status"></span>
                LIVE STREAMING
            </div>
            <div class="tv-wrapper">
                <?php 
                    // Logic Pembersih ID Youtube (Sama kayak sebelumnya)
                    $finalVideoId = $videoId;
                    if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $videoId, $match)) { $finalVideoId = $match[1]; }
                    $finalVideoId = trim($finalVideoId);
                    if (empty($finalVideoId)) { $finalVideoId = 'r3wW21ddf9U'; } // Default Live TV (misal Kompas/AlJazeera)
                ?>
                <?php if ($video_youtube == 'no') : ?>
                    <video id="myplayer" autoplay muted loop style="width:100%; height:100%; object-fit:cover;"></video>
                <?php else : ?>
                    <iframe width="100%" height="100%" 
                        src="https://www.youtube.com/embed/<?= $finalVideoId; ?>?autoplay=1&mute=1&loop=1&playlist=<?= $finalVideoId; ?>&controls=0&showinfo=0" 
                        frameborder="0" allow="autoplay; encrypted-media">
                    </iframe>
                <?php endif; ?>
            </div>
        </div>

        <div class="data-section">
            
            <div class="finance-area">
                <div id="carouselFinance" class="carousel slide carousel-fade h-100" data-bs-ride="carousel">
                    <div class="carousel-inner h-100">
                        
                        <div class="carousel-item active h-100 d-flex flex-column justify-content-center">
                            <h3 class="fw-bold mb-4"><i class="mdi mdi-chart-bar text-warning"></i> REALISASI ANGGARAN</h3>
                            <div class="mb-4">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Penyerapan Global</span>
                                    <span class="fw-bold text-warning">{{ finance.persen }}%</span>
                                </div>
                                <div class="progress-custom">
                                    <div class="bar-fill" :style="{ width: finance.persen + '%' }">{{ formatRupiah(finance.realisasi) }}</div>
                                </div>
                            </div>
                            <div class="row text-center mt-3">
                                <div class="col-6 border-end border-secondary">
                                    <small class="text-muted">Total Pagu</small>
                                    <h4 class="fw-bold">{{ formatRupiah(finance.pagu) }}</h4>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted">Sisa Anggaran</small>
                                    <h4 class="fw-bold text-danger">{{ formatRupiah(finance.sisa) }}</h4>
                                </div>
                            </div>
                        </div>

                        <div class="carousel-item h-100 d-flex flex-column justify-content-center">
                            <h3 class="fw-bold mb-4"><i class="mdi mdi-cash-register text-success"></i> PNBP TERKINI</h3>
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="bg-dark p-3 rounded d-flex justify-content-between align-items-center border border-secondary">
                                        <div><i class="mdi mdi-gavel text-warning"></i> Uang Pengganti</div>
                                        <div class="h4 m-0 fw-bold">{{ formatRupiah(pnbp.uang_pengganti) }}</div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="bg-dark p-3 rounded d-flex justify-content-between align-items-center border border-secondary">
                                        <div><i class="mdi mdi-ticket-percent text-info"></i> Denda Tilang</div>
                                        <div class="h4 m-0 fw-bold">{{ formatRupiah(pnbp.denda_tilang) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="agenda-area">
                <div class="agenda-title">Agenda Biro</div>
                <div class="agenda-list">
                    <div v-if="dataAgenda.length === 0" class="text-center text-muted mt-5">Tidak ada agenda.</div>
                    <div v-else class="scroller-agenda">
                        <div v-for="(item, i) in dataAgenda" :key="i" class="agenda-item">
                            <div class="agenda-time"><i class="mdi mdi-clock-outline"></i> {{ item.waktu.substring(0,5) }} WIB</div>
                            <div class="agenda-desc">{{ item.nama_agenda }}</div>
                            <small class="text-muted">{{ item.tempat_agenda }}</small>
                        </div>
                        <div v-for="(item, i) in dataAgenda" :key="'d-'+i" class="agenda-item">
                            <div class="agenda-time"><i class="mdi mdi-clock-outline"></i> {{ item.waktu.substring(0,5) }} WIB</div>
                            <div class="agenda-desc">{{ item.nama_agenda }}</div>
                            <small class="text-muted">{{ item.tempat_agenda }}</small>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="ticker-bar">
            <div class="ticker-content">
                <span v-for="item in dataNews" :key="item.id">
                    <span class="text-warning">INFO:</span> {{ item.text_news }} &nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;&nbsp;
                </span>
                <span v-for="item in dataNews" :key="'d-'+item.id">
                    <span class="text-warning">INFO:</span> {{ item.text_news }} &nbsp;&nbsp;&nbsp;&bull;&nbsp;&nbsp;&nbsp;
                </span>
            </div>
        </div>

    </div>
</div>

<?php $this->section("js") ?>
<script>
    function addZero(n) { return (n < 10 ? '0' : '') + n; }

    dataVue = {
        ...dataVue,
        jam: "", tanggal: "",
        
        // Data Core
        dataNews: [], dataAgenda: [], dataVideo: [],
        
        // Data Finance (Dummy)
        finance: { pagu: 15000000000, realisasi: 9500000000, sisa: 5500000000, persen: 63.3, target: 65 },
        pnbp: { uang_pengganti: 1250000000, denda_tilang: 350000000 },
        
        // Utility
        jadwalSholat: { Subuh: '04:15', Dzuhur: '11:52', Ashar: '15:15', Maghrib: '17:58', Isya: '19:10' },
        nextPrayer: 'Ashar',
        
        // Boss Booster State
        bossStatus: 'ok' // ok (hijau), warning (kuning), danger (merah)
    }

    createdVue = function() {
        this.updateTime();
        setInterval(this.updateTime, 1000);
        
        // Fetch Data
        this.getNews(); this.getAgenda(); this.getVideo();
        
        // Check Performance
        this.checkBossPerformance();
    }

    mountedVue = function() {
        setInterval(() => this.getNews(), <?= $news_refresh; ?> * 1000);
        setInterval(() => this.getAgenda(), <?= $agenda_refresh; ?> * 1000);
        
        // Carousel Finance Slide Otomatis
        var myCarousel = document.querySelector('#carouselFinance');
        var carousel = new bootstrap.Carousel(myCarousel, { interval: 10000, ride: 'carousel' });
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
            const months = ["JAN", "FEB", "MAR", "APR", "MEI", "JUN", "JUL", "AGS", "SEP", "OKT", "NOV", "DES"];
            this.tanggal = `${days[d.getDay()]}, ${d.getDate()} ${months[d.getMonth()]} ${d.getFullYear()}`;
            
            // Logic Simple Next Prayer (Bisa dikembangin pake library PrayerTimes)
            // Disini cuma dummy logic
            const currentHour = d.getHours();
            if(currentHour < 4) this.nextPrayer = 'Subuh';
            else if(currentHour < 12) this.nextPrayer = 'Dzuhur';
            else if(currentHour < 15) this.nextPrayer = 'Ashar';
            else if(currentHour < 18) this.nextPrayer = 'Maghrib';
            else if(currentHour < 19) this.nextPrayer = 'Isya';
            else this.nextPrayer = 'Subuh';
        },

        // --- FETCHING API (Gunakan variable lo yang ada) ---
        getNews: function() { axios.get('<?= base_url() ?>/api/news/news').then(res => { if(res.data.status) this.dataNews = res.data.data; }).catch(e=>{}); },
        getAgenda: function() { axios.get('<?= base_url() ?>/api/display/agenda').then(res => { if(res.data.status) this.dataAgenda = res.data.data; }).catch(e=>{}); },
        
        getVideo: function() {
             axios.get('<?= base_url(); ?>/api/video/display').then(res => {
                if (res.data.status && res.data.data) {
                    this.dataVideo = res.data.data;
                    <?php if ($video_youtube == 'no') : ?> 
                       // Logic play local video
                       // ... (Implementasi playVideo function lo yang lama)
                    <?php endif; ?>
                }
            }).catch(e=>{});
        },

        // --- BOSS BOOSTER LOGIC ---
        checkBossPerformance: function() {
            // Logika: Jika Realisasi < Target, maka Danger
            // Jika Realisasi mendekati Target (selisih 2%), maka Warning
            const diff = this.finance.target - this.finance.persen;
            
            if (diff > 5) {
                this.bossStatus = 'danger'; // Merah Kedip Cepat
            } else if (diff > 0) {
                this.bossStatus = 'warning'; // Kuning Solid
            } else {
                this.bossStatus = 'ok'; // Hijau Pulse (Aman)
            }
        }
    }
</script>
<?php $this->endSection("js") ?>