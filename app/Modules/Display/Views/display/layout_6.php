<?php $this->section("style"); ?>
<link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@300;400;500;600;700&family=Orbitron:wght@400;700;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/weather-icons/2.0.12/css/weather-icons.min.css">

<style>
    :root {
        --holo-gold: #FFD700;
        --holo-green: #00FF41; /* Cyber Green */
        --holo-cyan: #00F3FF;
        --glass-bg: rgba(10, 20, 30, 0.4);
        --glass-border: 1px solid rgba(100, 200, 255, 0.15);
        --neon-shadow: 0 0 15px rgba(0, 243, 255, 0.2);
    }

    /* GLOBAL SETUP */
    html, body {
        height: 100vh; margin: 0; padding: 0;
        background: #000;
        font-family: 'Rajdhani', sans-serif;
        color: #e0f7fa;
        overflow: hidden;
    }

    /* BACKGROUND VIDEO */
    .holo-bg {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -2;
    }
    .holo-bg video {
        width: 100%; height: 100%; object-fit: cover; opacity: 0.6;
        filter: hue-rotate(15deg) contrast(1.2); /* Sedikit manipulasi warna video biar sci-fi */
    }
    .grid-overlay {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%; z-index: -1;
        background-image: 
            linear-gradient(rgba(0, 255, 65, 0.03) 1px, transparent 1px),
            linear-gradient(90deg, rgba(0, 255, 65, 0.03) 1px, transparent 1px);
        background-size: 50px 50px; /* Efek Grid Sci-Fi */
    }

    /* LAYOUT GRID (HUD STRUCTURE) */
    .hud-container {
        display: grid;
        grid-template-columns: 350px 1fr 350px;
        grid-template-rows: 100px 1fr 80px;
        gap: 30px;
        height: 100vh;
        padding: 40px;
        box-sizing: border-box;
    }

    /* GLASS CARD UTILITY */
    .holo-card {
        background: var(--glass-bg);
        backdrop-filter: blur(12px);
        border: var(--glass-border);
        border-radius: 15px; /* Sudut agak tajam */
        box-shadow: var(--neon-shadow);
        position: relative;
        overflow: hidden;
        transition: all 0.4s ease;
    }
    /* Dekorasi Sudut Tech */
    .holo-card::after {
        content: ''; position: absolute; top: 0; right: 0; width: 20px; height: 20px;
        border-top: 2px solid var(--holo-cyan); border-right: 2px solid var(--holo-cyan);
    }
    .holo-card::before {
        content: ''; position: absolute; bottom: 0; left: 0; width: 20px; height: 20px;
        border-bottom: 2px solid var(--holo-cyan); border-left: 2px solid var(--holo-cyan);
    }

    /* ANIMATION: FLOATING & PULSE */
    .float-anim { animation: float 6s ease-in-out infinite; }
    @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-10px); } }

    /* === 1. HEADER (TOP LEFT) - IDENTITY === */
    .hud-header {
        grid-column: 1 / 2; grid-row: 1 / 2;
        display: flex; align-items: center; gap: 15px;
    }
    .hud-title h1 { font-family: 'Orbitron', sans-serif; font-size: 1.5rem; margin: 0; letter-spacing: 2px; text-transform: uppercase; color: white; text-shadow: 0 0 10px rgba(255,255,255,0.5); }
    .hud-title span { color: var(--holo-gold); font-weight: 700; letter-spacing: 3px; font-size: 0.8rem; }

    /* === 2. CLOCK & WEATHER (TOP RIGHT) === */
    .hud-status {
        grid-column: 3 / 4; grid-row: 1 / 2;
        text-align: right; display: flex; flex-direction: column; justify-content: center;
    }
    .digital-clock { font-family: 'Orbitron'; font-size: 2.5rem; line-height: 1; color: var(--holo-cyan); }
    .digital-date { font-size: 1rem; color: #aaa; letter-spacing: 1px; text-transform: uppercase; }

    /* === 3. FINANCE ORBITAL (LEFT SIDEBAR) === */
    .hud-finance {
        grid-column: 1 / 2; grid-row: 2 / 3;
        display: flex; flex-direction: column; justify-content: center; gap: 20px;
        opacity: 0.85; transition: opacity 0.3s;
    }
    .hud-finance:hover { opacity: 1; filter: brightness(1.2); }

    .stat-holo {
        padding: 20px; border-left: 4px solid var(--holo-gold);
        background: linear-gradient(90deg, rgba(255, 215, 0, 0.1), transparent);
    }
    .stat-label { font-size: 0.9rem; text-transform: uppercase; color: var(--holo-gold); letter-spacing: 1px; display: block; margin-bottom: 5px; }
    .stat-val { font-size: 2.2rem; font-weight: 700; font-family: 'Orbitron'; line-height: 1; }
    .stat-sub { font-size: 0.8rem; color: #888; margin-top: 5px; }

    /* Circular Progress (CSS Only) */
    .orb-circle {
        width: 120px; height: 120px; border-radius: 50%;
        border: 10px solid rgba(255,255,255,0.05);
        border-top: 10px solid var(--holo-green);
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto;
        box-shadow: 0 0 20px rgba(0, 255, 65, 0.3);
        animation: spin-slow 10s linear infinite;
    }
    .orb-inner { animation: spin-rev 10s linear infinite; font-size: 1.5rem; font-weight: bold; color: var(--holo-green); }
    @keyframes spin-slow { 100% { transform: rotate(360deg); } }
    @keyframes spin-rev { 100% { transform: rotate(-360deg); } }

    /* === 4. AGENDA HERO (CENTER STAGE) === */
    .hud-center {
        grid-column: 2 / 3; grid-row: 2 / 3;
        display: flex; align-items: center; justify-content: center;
        perspective: 1000px;
    }
    
    .agenda-hologram {
        width: 100%; padding: 40px;
        background: rgba(0, 10, 20, 0.6);
        border: 1px solid var(--holo-cyan);
        box-shadow: 0 0 50px rgba(0, 243, 255, 0.1), inset 0 0 30px rgba(0, 243, 255, 0.05);
        transform: translateZ(20px); /* Efek 3D */
        text-align: center;
        position: relative;
    }
    /* Scanning Line Animation */
    .scan-line {
        position: absolute; top: 0; left: 0; width: 100%; height: 5px;
        background: var(--holo-cyan); opacity: 0.5;
        box-shadow: 0 0 10px var(--holo-cyan);
        animation: scan 4s linear infinite;
    }
    @keyframes scan { 0% { top: 0; opacity: 0; } 50% { opacity: 1; } 100% { top: 100%; opacity: 0; } }

    .ag-hero-date {
        font-family: 'Orbitron'; font-size: 5rem; font-weight: 900; color: var(--holo-gold);
        line-height: 1; margin-bottom: 20px;
        text-shadow: 0 0 20px var(--holo-gold);
    }
    .ag-hero-title { font-size: 2.5rem; font-weight: 600; text-transform: uppercase; margin-bottom: 10px; line-height: 1.2;}
    .ag-hero-meta { font-size: 1.2rem; color: var(--holo-cyan); display: flex; justify-content: center; gap: 30px; margin-top: 20px; }
    
    /* === 5. SHOLAT (BOTTOM RIGHT) === */
    .hud-sholat {
        grid-column: 3 / 4; grid-row: 2 / 3;
        display: flex; flex-direction: column; justify-content: center;
        opacity: 0.85; transition: opacity 0.3s;
    }
    .hud-sholat:hover { opacity: 1; filter: brightness(1.2); }
    
    .sholat-list { display: flex; flex-direction: column; gap: 10px; }
    .sholat-row {
        display: flex; justify-content: space-between; padding: 10px 15px;
        background: rgba(255,255,255,0.02); border-bottom: 1px solid rgba(255,255,255,0.05);
    }
    .sholat-row.active {
        background: rgba(0, 243, 255, 0.1); border-left: 3px solid var(--holo-cyan);
        color: var(--holo-cyan); font-weight: bold; text-shadow: 0 0 8px var(--holo-cyan);
    }

    /* === 6. TICKER (BOTTOM CENTER) === */
    .hud-ticker {
        grid-column: 1 / -1; grid-row: 3 / 4;
        display: flex; align-items: center;
        background: rgba(0,0,0,0.5); border-top: 1px solid var(--holo-green);
        overflow: hidden;
    }
    .ticker-head {
        background: var(--holo-green); color: black; font-weight: 800; padding: 0 30px;
        height: 100%; display: flex; align-items: center; font-size: 1.1rem;
        clip-path: polygon(0 0, 100% 0, 90% 100%, 0% 100%); /* Tech Shape */
        padding-right: 50px;
    }
    
    /* Marquee Setup - Fixed Centering */
    .ticker-viewport {
        flex: 1; height: 100%; overflow: hidden; position: relative;
        display: flex; align-items: center;
        mask-image: linear-gradient(to right, transparent, black 30px);
    }
    .ticker-track {
        white-space: nowrap; animation: marquee 25s linear infinite;
        font-size: 1.2rem; text-transform: uppercase; letter-spacing: 1px;
    }
    @keyframes marquee { 0% { transform: translateX(0); } 100% { transform: translateX(-100%); } }

    /* =========================================
       RESPONSIVE (MOBILE)
       ========================================= */
    @media screen and (max-width: 1024px) {
        html, body { overflow-y: auto; height: auto; }
        
        .hud-container {
            display: flex; flex-direction: column; gap: 20px; padding: 15px; height: auto;
        }

        /* Re-order for Mobile */
        .hud-header { order: 1; justify-content: center; text-align: center; margin-bottom: 10px; }
        .hud-status { order: 2; flex-direction: row; justify-content: space-between; align-items: center; background: rgba(0,0,0,0.5); padding: 10px; border-radius: 10px; }
        .digital-clock { font-size: 1.8rem; }
        
        .hud-center { order: 3; perspective: none; }
        .agenda-hologram { transform: none; padding: 20px; }
        .ag-hero-date { font-size: 3rem; }
        .ag-hero-title { font-size: 1.5rem; }
        
        .hud-finance { order: 4; flex-direction: row; flex-wrap: wrap; gap: 10px; }
        .holo-card.stat-holo { flex: 1 1 45%; } /* Grid 2 kolom di HP */
        .orb-circle { width: 80px; height: 80px; font-size: 1rem; }
        
        .hud-sholat { order: 5; }
        .hud-ticker { order: 6; position: fixed; bottom: 0; left: 0; width: 100%; height: 40px; z-index: 99; border-radius: 0; }
        .ticker-head { font-size: 0.8rem; padding: 0 15px; clip-path: none; padding-right: 15px; }
        .ticker-track { font-size: 0.9rem; }
        
        .hud-container { padding-bottom: 50px; } /* Space for fixed ticker */
    }
</style>
<?php $this->endSection("style") ?>

<div class="holo-bg">
    <?php 
        $finalVideoId = $videoId;
        // Logic default video jika kosong
        if (empty($finalVideoId)) { $finalVideoId = 'r3wW21ddf9U'; } 
    ?>
     <div style="position: absolute; top: -50%; left: -50%; width: 200%; height: 200%;">
        <iframe width="100%" height="100%" src="https://www.youtube.com/embed/<?= $finalVideoId; ?>?autoplay=1&mute=1&controls=0&showinfo=0&loop=1&playlist=<?= $finalVideoId; ?>&start=10" frameborder="0" allow="autoplay; encrypted-media" style="opacity: 0.4; filter: contrast(1.2);"></iframe>
    </div>
</div>
<div class="grid-overlay"></div>

<div class="hud-container">

    <div class="hud-header">
        <img src="<?php echo base_url('/' . ($logo == "" ? 'logo.png' : $logo)); ?>" width="70" style="filter: drop-shadow(0 0 10px var(--holo-cyan));" />
        <div class="hud-title">
            <h1>Biro Keuangan</h1>
            <span>SYSTEM :: ONLINE</span>
        </div>
    </div>

    <div class="hud-status">
        <div class="digital-clock">{{ jam }}</div>
        <div class="digital-date">{{ tanggal }}</div>
        <div style="margin-top: 5px; font-size: 0.9rem; color: var(--holo-gold);">
            <i class="wi wi-day-cloudy"></i> 29°C JAKARTA
        </div>
    </div>

    <aside class="hud-finance">
        <div style="text-align: center; margin-bottom: 20px;">
            <div class="orb-circle">
                <div class="orb-inner">{{ finance.persen }}%</div>
            </div>
            <div style="margin-top: 10px; color: var(--holo-green); letter-spacing: 2px; font-size: 0.8rem;">REALISASI</div>
        </div>

        <div class="holo-card stat-holo float-anim">
            <span class="stat-label">ANGGARAN TAHUNAN</span>
            <span class="stat-val">{{ formatRupiahShort(finance.pagu) }}</span>
            <div class="stat-sub">TOTAL PAGU</div>
        </div>

        <div class="holo-card stat-holo float-anim" style="animation-delay: 1s; border-color: var(--holo-cyan);">
            <span class="stat-label" style="color: var(--holo-cyan);">SISA ANGGARAN</span>
            <span class="stat-val" style="color: white;">{{ formatRupiahShort(finance.sisa) }}</span>
            <div class="stat-sub">AVAILABLE FUNDS</div>
        </div>
    </aside>

    <main class="hud-center">
        <div v-if="dataAgenda.length > 0" class="holo-card agenda-hologram">
            <div class="scan-line"></div> <div class="ag-hero-date">
                {{ currentAgenda.date }}
                <div style="font-size: 1.5rem; letter-spacing: 5px; font-weight: 400; color: white; margin-top: -10px;">{{ currentAgenda.month }}</div>
            </div>
            
            <div class="ag-hero-title">
                {{ currentAgenda.title }}
            </div>
            
            <div class="ag-hero-meta">
                <span><i class="mdi mdi-clock-outline"></i> {{ currentAgenda.time }} WIB</span>
                <span><i class="mdi mdi-map-marker-radius"></i> {{ currentAgenda.place }}</span>
            </div>

            <div style="margin-top: 30px; font-size: 0.9rem; color: #aaa; letter-spacing: 2px;">
                <span class="spinner-grow spinner-grow-sm text-success" role="status"></span>
                ACTIVE PROTOCOL // NEXT AGENDA: {{ nextAgendaCount }}
            </div>
        </div>

        <div v-else class="holo-card agenda-hologram" style="display: flex; align-items: center; justify-content: center; height: 300px;">
             <h2 style="color: #666;">NO DATA STREAM</h2>
        </div>
    </main>

    <aside class="hud-sholat">
        <div class="holo-card" style="padding: 20px;">
            <h4 style="margin: 0 0 15px 0; color: var(--holo-gold); text-align: center; letter-spacing: 3px;">PRAYER TIME</h4>
            <div class="sholat-list">
                <div v-for="(time, name) in jadwalSholat" :key="name" 
                     class="sholat-row" :class="{ 'active': name === nextPrayer }">
                    <span>{{ name }}</span>
                    <span>{{ time }}</span>
                </div>
            </div>
        </div>
    </aside>

    <footer class="hud-ticker">
        <div class="ticker-head">
            <i class="mdi mdi-access-point-network me-2"></i> SYSTEM INFO
        </div>
        <div class="ticker-viewport">
            <div class="ticker-track">
                <span v-for="item in dataNews" :key="item.id" style="margin-right: 50px;">
                    <span style="color: var(--holo-gold);">>></span> {{ item.text_news }}
                </span>
                <span v-for="item in dataNews" :key="'d-'+item.id" style="margin-right: 50px;">
                    <span style="color: var(--holo-gold);">>></span> {{ item.text_news }}
                </span>
                 <span v-if="dataNews.length == 0" style="margin-right: 50px;">
                    SYSTEM OPERATIONAL // WELCOME TO FINANCIAL BUREAU DASHBOARD // SECURE CONNECTION ESTABLISHED...
                </span>
            </div>
        </div>
    </footer>

</div>

<?php $this->section("js") ?>
<script>
    function addZero(n) { return (n < 10 ? '0' : '') + n; }

    dataVue = {
        ...dataVue,
        jam: "", tanggal: "",
        
        // Data Modules
        dataNews: [], dataAgenda: [],
        finance: { pagu: 15000000000, realisasi: 9500000000, sisa: 5500000000, persen: 63 },
        jadwalSholat: { Subuh: '04:12', Dzuhur: '11:51', Ashar: '15:15', Maghrib: '17:58', Isya: '19:12' },
        nextPrayer: 'Ashar',
        
        // Hologram Logic
        currentAgendaIndex: 0,
        currentAgenda: { date: '01', month: 'JAN', title: 'Loading...', time: '--:--', place: '---' },
        nextAgendaCount: 0
    }

    createdVue = function() {
        setInterval(this.updateTime, 1000);
        this.getNews(); 
        this.getAgenda();
    }

    mountedVue = function() {
        setInterval(() => this.getNews(), <?= $news_refresh; ?> * 1000);
        setInterval(() => this.getAgenda(), <?= $agenda_refresh; ?> * 1000);

        // Hologram Rotator (Ganti Agenda Tengah setiap 10 detik)
        setInterval(() => {
            if (this.dataAgenda.length > 0) {
                this.currentAgendaIndex = (this.currentAgendaIndex + 1) % this.dataAgenda.length;
                this.updateHologram();
            }
        }, 10000);
    }

    methodsVue = {
        ...methodsVue,
        
        // Format Ringkas (15 M, 120 Jt)
        formatRupiahShort: function(num) {
            if(num >= 1000000000) return (num/1000000000).toFixed(1) + ' M';
            if(num >= 1000000) return (num/1000000).toFixed(0) + ' Jt';
            return (num/1000).toFixed(0) + ' K';
        },

        updateTime: function() {
            const d = new Date();
            this.jam = `${addZero(d.getHours())}:${addZero(d.getMinutes())}`;
            const m = ["JAN", "FEB", "MAR", "APR", "MEI", "JUN", "JUL", "AGS", "SEP", "OKT", "NOV", "DES"];
            this.tanggal = `${d.getDate()} ${m[d.getMonth()]} ${d.getFullYear()}`;
            
            // Logic Prayer Highlight
            const h = d.getHours();
            if(h<4) this.nextPrayer='Subuh'; else if(h<12) this.nextPrayer='Dzuhur';
            else if(h<15) this.nextPrayer='Ashar'; else if(h<18) this.nextPrayer='Maghrib';
            else if(h<19) this.nextPrayer='Isya'; else this.nextPrayer='Subuh';
        },

        getNews: function() { axios.get('<?= base_url() ?>/api/news/news').then(res => { if(res.data.status) this.dataNews = res.data.data; }).catch(e=>{}); },
        getAgenda: function() { 
            axios.get('<?= base_url() ?>/api/display/agenda').then(res => { 
                if(res.data.status) {
                    this.dataAgenda = res.data.data; 
                    this.updateHologram();
                }
            }).catch(e=>{}); 
        },

        updateHologram: function() {
            if(this.dataAgenda.length === 0) return;
            
            const item = this.dataAgenda[this.currentAgendaIndex];
            
            // Parsing Tanggal (Asumsi format YYYY-MM-DD atau auto today)
            let dObj = new Date(); // Default today
            // if(item.waktu_tanggal) dObj = new Date(item.waktu_tanggal); 
            
            const mNames = ["JAN", "FEB", "MAR", "APR", "MEI", "JUN", "JUL", "AGS", "SEP", "OKT", "NOV", "DES"];
            
            this.currentAgenda = {
                date: dObj.getDate(),
                month: mNames[dObj.getMonth()],
                title: item.nama_agenda,
                time: item.waktu.substring(0,5),
                place: item.tempat_agenda
            };
            this.nextAgendaCount = this.dataAgenda.length - 1;
        }
    }
</script>
<?php $this->endSection("js") ?>