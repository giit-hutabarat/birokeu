<?php $this->section("style"); ?>
<link href="https://fonts.googleapis.com/css2?family=Titillium+Web:wght@300;400;600;700;900&family=Roboto+Condensed:wght@400;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/weather-icons/2.0.12/css/weather-icons.min.css">

<style>
    :root {
        --bg-color: #050505;
        --panel-bg: #111;
        --bloomberg-orange: #ff9800; /* Warna khas breaking news */
        --adhyaksa-gold: #FFD700;
        --adhyaksa-green: #00AA00;
        --alert-red: #D50000;
        --text-white: #f5f5f5;
        --border-color: #333;
    }

    /* --- RESET & BASE --- */
    html, body {
        height: 100vh; margin: 0; padding: 0;
        background: var(--bg-color); 
        font-family: 'Titillium Web', sans-serif; 
        color: var(--text-white);
        overflow: hidden; /* Default TV: No Scroll */
    }

    /* --- LAYOUT GRID UTAMA --- */
    .bloomberg-grid {
        display: grid;
        grid-template-columns: 70fr 30fr; /* Kiri Video (70%), Kanan Agenda (30%) */
        grid-template-rows: 60px auto 50px; /* Header, Content, Ticker */
        height: 100vh;
        width: 100vw;
    }

    /* 1. HEADER (TOP BAR) */
    .top-bar {
        grid-column: 1 / -1;
        background: #000;
        border-bottom: 2px solid var(--adhyaksa-gold);
        display: flex; align-items: center; justify-content: space-between;
        padding: 0 20px;
        z-index: 50;
    }
    .brand-area { display: flex; align-items: center; gap: 15px; }
    .brand-text { line-height: 1; text-transform: uppercase; }
    .brand-title { font-weight: 900; font-size: 1.5rem; letter-spacing: 1px; color: white; display: block; }
    .brand-sub { font-weight: 600; color: var(--adhyaksa-gold); font-size: 0.9rem; display: block; }
    
    .header-info { display: flex; gap: 30px; align-items: center; }
    .clock-widget { text-align: right; font-family: 'Roboto Condensed', sans-serif; line-height: 1; }
    .clock-time { font-size: 2.2rem; font-weight: 700; color: white; }
    .clock-date { font-size: 0.9rem; color: #aaa; text-transform: uppercase; }

    /* BOSS BOOSTER: E-AUDIT STATUS */
    .boss-status {
        display: flex; align-items: center; gap: 10px;
        padding: 5px 15px; border-radius: 4px; border: 1px solid #333;
    }
    .status-light { width: 12px; height: 12px; border-radius: 50%; animation: blink 1s infinite; }
    .st-green { background: var(--adhyaksa-green); box-shadow: 0 0 10px var(--adhyaksa-green); }
    .st-red { background: var(--alert-red); box-shadow: 0 0 10px var(--alert-red); animation-duration: 0.3s; }

    /* 2. MAIN STAGE (LEFT) - VIDEO & FINANCE */
    .main-stage {
        grid-column: 1 / 2;
        grid-row: 2 / 3;
        display: flex; flex-direction: column;
        background: #000;
        border-right: 1px solid var(--border-color);
        position: relative;
    }

    /* Video Wrapper */
    .video-container {
        flex: 1; /* Isi sisa ruang */
        position: relative; background: #000;
    }
    .live-badge {
        position: absolute; top: 20px; left: 20px;
        background: var(--alert-red); color: white;
        padding: 2px 8px; font-weight: 700; font-size: 0.8rem;
        border-radius: 2px; z-index: 10;
    }

    /* Finance Dashboard (Lower Third style) */
    .finance-overlay {
        height: 180px; /* Fixed height for data */
        background: #111;
        border-top: 4px solid var(--adhyaksa-green);
        display: flex;
    }
    .finance-box {
        flex: 1; padding: 15px; border-right: 1px solid #333;
        display: flex; flex-direction: column; justify-content: center;
    }
    .f-label { font-size: 0.9rem; color: #888; text-transform: uppercase; font-weight: 600; margin-bottom: 5px; }
    .f-value { font-size: 1.8rem; font-weight: 700; color: white; font-family: 'Roboto Condensed'; }
    .f-sub { font-size: 0.8rem; color: var(--adhyaksa-gold); }
    
    /* Progress Bar Kecil */
    .mini-progress { height: 6px; background: #333; margin-top: 10px; width: 100%; }
    .mini-fill { height: 100%; background: var(--adhyaksa-green); }

    /* 3. AGENDA MODULE (RIGHT SIDEBAR) - MENONJOL */
    .agenda-sidebar {
        grid-column: 2 / 3;
        grid-row: 2 / 3;
        background: #151515;
        display: flex; flex-direction: column;
        border-left: 2px solid var(--adhyaksa-gold); /* Aksen Pemisah Tegas */
    }

    .agenda-header {
        background: var(--adhyaksa-gold);
        color: black;
        padding: 15px;
        text-align: center;
        font-weight: 900;
        font-size: 1.4rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        z-index: 10;
    }

    .agenda-list-wrapper {
        flex: 1; overflow: hidden; position: relative;
    }
    .agenda-scroller {
        animation: scrollAgenda 45s linear infinite; 
    }

    /* Agenda Item Styling - HIGH CONTRAST */
    .agenda-card {
        padding: 20px;
        border-bottom: 1px solid #333;
        background: #1a1a1a;
        transition: background 0.3s;
        position: relative;
    }
    .agenda-card:nth-child(even) { background: #151515; }
    
    /* Highlight for NOW */
    .agenda-card.is-now {
        background: #2a1c00; /* Dark Gold Tint */
        border-left: 5px solid var(--adhyaksa-gold);
    }
    .status-badge {
        display: inline-block; padding: 2px 6px; border-radius: 2px;
        font-size: 0.7rem; font-weight: bold; text-transform: uppercase;
        margin-bottom: 5px;
    }
    .badge-now { background: var(--alert-red); color: white; animation: blink 2s infinite; }
    .badge-next { background: #0277BD; color: white; }

    .ag-time { font-size: 1.6rem; font-weight: 700; color: white; font-family: 'Roboto Condensed'; display: block; line-height: 1; margin-bottom: 5px; }
    .ag-title { font-size: 1.1rem; color: #ddd; font-weight: 600; line-height: 1.2; margin-bottom: 5px; }
    .ag-loc { font-size: 0.85rem; color: #888; display: flex; align-items: center; gap: 5px; }

    /* 4. FOOTER (TICKER & UTILITY) */
    .footer-bar {
        grid-column: 1 / -1;
        grid-row: 3 / 4;
        background: #222;
        display: flex;
        border-top: 1px solid #333;
    }
    .utility-box {
        width: 300px; background: #333; color: white;
        display: flex; align-items: center; padding: 0 15px; gap: 15px;
        font-weight: bold; font-size: 0.9rem;
        z-index: 20;
    }
    .ticker-wrapper {
        flex: 1; background: var(--bg-color);
        display: flex; align-items: center; overflow: hidden;
        position: relative;
    }
    .news-scroll {
        white-space: nowrap;
        padding-left: 100%;
        animation: marquee 30s linear infinite;
        font-size: 1.2rem; font-weight: 600; text-transform: uppercase;
    }
    .news-item { margin-right: 50px; color: #fff; }
    .news-hl { color: var(--bloomberg-orange); margin-right: 5px; }

    /* ANIMATIONS */
    @keyframes blink { 0% { opacity: 1; } 50% { opacity: 0.4; } 100% { opacity: 1; } }
    @keyframes marquee { 0% { transform: translate(0, 0); } 100% { transform: translate(-100%, 0); } }
    @keyframes scrollAgenda { 0% { transform: translateY(0); } 100% { transform: translateY(-50%); } }

    /* =========================================
       RESPONSIVE (MOBILE & TABLET)
       ========================================= */
    @media screen and (max-width: 1024px) {
        html, body { overflow-y: auto; height: auto; }
        
        .bloomberg-grid {
            display: flex; flex-direction: column;
            height: auto; width: 100%;
        }

        /* 1. HEADER MOBILE */
        .top-bar {
            padding: 10px 15px; flex-direction: row; justify-content: space-between;
        }
        .brand-text { font-size: 0.8rem; }
        .clock-time { font-size: 1.5rem; }
        .boss-status { display: none; } /* Hide boss booster on mobile header */

        /* 2. VIDEO MOBILE */
        .main-stage {
            border-right: none; height: auto;
        }
        .video-container {
            height: 250px; /* Fix height for video */
        }
        
        /* Data Finance Mobile (Stack Horizontal scroll or Wrap) */
        .finance-overlay {
            height: auto; flex-wrap: wrap; border-top: 2px solid var(--adhyaksa-green);
        }
        .finance-box {
            flex: 1 0 50%; /* 2 kolom per baris */
            padding: 10px; border-bottom: 1px solid #333;
        }
        .f-value { font-size: 1.4rem; }

        /* 3. AGENDA MOBILE (Tetap Menonjol tapi Scrollable) */
        .agenda-sidebar {
            border-left: none; border-top: 4px solid var(--adhyaksa-gold);
            height: 400px; /* Fix height scrollable */
        }
        .agenda-scroller { animation: none; } /* Matikan auto scroll */
        .agenda-list-wrapper { overflow-y: auto; }
        .ag-time { font-size: 1.4rem; }

        /* 4. FOOTER MOBILE */
        .footer-bar { position: fixed; bottom: 0; width: 100%; z-index: 100; height: 40px; }
        .utility-box { display: none; } /* Hide utility, show ticker only */
        .news-scroll { font-size: 1rem; animation-duration: 20s; }
        
        /* Padding bottom biar konten gak ketutup footer */
        .agenda-sidebar { margin-bottom: 40px; }
    }
</style>
<?php $this->endSection("style") ?>

<div class="bloomberg-grid">
    
    <header class="top-bar">
        <div class="brand-area">
            <img src="<?php echo base_url('/' . ($logo == "" ? 'logo.png' : $logo)); ?>" width="50" />
            <div class="brand-text">
                <span class="brand-title">BIRO KEUANGAN</span>
                <span class="brand-sub">LIVE MONITORING CENTER</span>
            </div>
        </div>

        <div class="header-info">
            <div class="boss-status" :title="bossMessage">
                <span class="status-light" :class="bossColor"></span>
                <span style="font-weight: bold; font-size: 0.9rem; color: #fff;">SYSTEM STATUS</span>
            </div>
            
            <div class="clock-widget">
                <div class="clock-time">{{ jam }}</div>
                <div class="clock-date">{{ tanggal }}</div>
            </div>
        </div>
    </header>

    <main class="main-stage">
        <div class="video-container">
            <div class="live-badge">LIVE BROADCAST</div>
            <?php 
                $finalVideoId = $videoId;
                if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $videoId, $match)) { $finalVideoId = $match[1]; }
                $finalVideoId = trim($finalVideoId);
                if (empty($finalVideoId)) { $finalVideoId = 'r3wW21ddf9U'; } 
            ?>
            <?php if ($video_youtube == 'no') : ?>
                <video id="myplayer" autoplay muted loop style="width:100%; height:100%; object-fit:cover;"></video>
            <?php else : ?>
                <iframe width="100%" height="100%" src="https://www.youtube.com/embed/<?= $finalVideoId; ?>?autoplay=1&mute=1&loop=1&playlist=<?= $finalVideoId; ?>&controls=0&showinfo=0" frameborder="0" allow="autoplay; encrypted-media"></iframe>
            <?php endif; ?>
        </div>

        <div class="finance-overlay">
            <div class="finance-box">
                <span class="f-label">Realisasi Anggaran</span>
                <span class="f-value">{{ finance.persen }}%</span>
                <span class="f-sub">{{ formatRupiah(finance.realisasi) }}</span>
                <div class="mini-progress"><div class="mini-fill" :style="{ width: finance.persen + '%' }"></div></div>
            </div>
            <div class="finance-box">
                <span class="f-label">Sisa Anggaran</span>
                <span class="f-value" style="color: var(--bloomberg-orange);">{{ formatRupiah(finance.sisa) }}</span>
                <span class="f-sub">Target Bulan: {{ finance.target }}%</span>
            </div>
            <div class="finance-box">
                <span class="f-label">PNBP (Penerimaan)</span>
                <span class="f-value" style="color: var(--adhyaksa-gold);">{{ formatRupiah(pnbp.total) }}</span>
                <span class="f-sub"><i class="mdi mdi-arrow-up"></i> +12% YoY</span>
            </div>
            <div class="finance-box" style="border-right: none;">
                <span class="f-label">Cuaca Terkini</span>
                <div class="d-flex align-items-center gap-2">
                    <i class="wi wi-day-cloudy" style="font-size: 1.8rem; color: #aaa;"></i>
                    <span class="f-value">29°C</span>
                </div>
                <span class="f-sub">Jakarta Selatan</span>
            </div>
        </div>
    </main>

    <aside class="agenda-sidebar">
        <div class="agenda-header">
            <i class="mdi mdi-calendar-clock"></i> AGENDA BIRO
        </div>
        
        <div class="agenda-list-wrapper">
            <div v-if="dataAgenda.length === 0" class="p-4 text-center text-muted">
                TIDAK ADA JADWAL HARI INI
            </div>
            <div v-else class="agenda-scroller">
                <div v-for="(item, i) in dataAgenda" :key="i" class="agenda-card" :class="{ 'is-now': isEventNow(item.waktu) }">
                    <div v-if="isEventNow(item.waktu)" class="status-badge badge-now">SEDANG BERLANGSUNG</div>
                    <div v-else class="status-badge badge-next">AKAN DATANG</div>

                    <span class="ag-time">{{ item.waktu.substring(0,5) }} WIB</span>
                    <div class="ag-title">{{ item.nama_agenda }}</div>
                    <div class="ag-loc"><i class="mdi mdi-map-marker"></i> {{ item.tempat_agenda }}</div>
                </div>

                <div v-for="(item, i) in dataAgenda" :key="'d-'+i" class="agenda-card">
                    <div class="status-badge badge-next">AKAN DATANG</div>
                    <span class="ag-time">{{ item.waktu.substring(0,5) }} WIB</span>
                    <div class="ag-title">{{ item.nama_agenda }}</div>
                    <div class="ag-loc"><i class="mdi mdi-map-marker"></i> {{ item.tempat_agenda }}</div>
                </div>
            </div>
        </div>
    </aside>

    <footer class="footer-bar">
        <div class="utility-box">
            <i class="mdi mdi-mosque"></i> {{ nextPrayer.name }} : {{ nextPrayer.time }}
        </div>
        <div class="ticker-wrapper">
            <div class="news-scroll">
                <span v-for="item in dataNews" :key="item.id" class="news-item">
                    <span class="news-hl">NEWS UPDATE:</span> {{ item.text_news }}
                </span>
                <span v-for="item in dataNews" :key="'d-'+item.id" class="news-item">
                     <span class="news-hl">NEWS UPDATE:</span> {{ item.text_news }}
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
        
        // Data & Logic
        dataNews: [], dataAgenda: [],
        finance: { pagu: 15000000000, realisasi: 9800000000, sisa: 5200000000, persen: 65.3, target: 70 },
        pnbp: { total: 1600000000 },
        nextPrayer: { name: 'Ashar', time: '15:15' },
        
        // Boss Booster
        bossColor: 'st-green', // st-green, st-red
        bossMessage: 'System Normal'
    }

    createdVue = function() {
        setInterval(this.updateTime, 1000);
        this.getNews(); this.getAgenda();
        this.checkStatus();
    }

    mountedVue = function() {
        setInterval(() => this.getNews(), <?= $news_refresh; ?> * 1000);
        setInterval(() => this.getAgenda(), <?= $agenda_refresh; ?> * 1000);
    }

    methodsVue = {
        ...methodsVue,
        
        formatRupiah: function(num) {
            // Format angka pendek (1.5 M, 120 Jt) biar muat di kotak
            if(num >= 1000000000) return (num/1000000000).toFixed(1) + ' M';
            if(num >= 1000000) return (num/1000000).toFixed(0) + ' Jt';
            return new Intl.NumberFormat('id-ID').format(num);
        },

        updateTime: function() {
            const d = new Date();
            this.jam = `${addZero(d.getHours())}:${addZero(d.getMinutes())}:${addZero(d.getSeconds())}`;
            const m = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des"];
            this.tanggal = `${d.getDate()} ${m[d.getMonth()]} ${d.getFullYear()}`;
        },

        // Logic Highlight Agenda "NOW"
        isEventNow: function(waktuStr) {
            // Simulasi logic sederhana: 
            // Kalau jam agenda == jam sekarang, return true. 
            // Di real app, bandingkan Date object
            const currentH = new Date().getHours();
            const agendaH = parseInt(waktuStr.substring(0,2));
            return currentH === agendaH; 
        },

        // API
        getNews: function() { axios.get('<?= base_url() ?>/api/news/news').then(res => { if(res.data.status) this.dataNews = res.data.data; }).catch(e=>{}); },
        getAgenda: function() { axios.get('<?= base_url() ?>/api/display/agenda').then(res => { if(res.data.status) this.dataAgenda = res.data.data; }).catch(e=>{}); },
        
        // Boss Booster Logic
        checkStatus: function() {
            // Jika realisasi < target lebih dari 5%, Merah
            const gap = this.finance.target - this.finance.persen;
            if (gap > 5) {
                this.bossColor = 'st-red';
                this.bossMessage = 'ALERT: Realisasi di bawah Target!';
            } else {
                this.bossColor = 'st-green';
                this.bossMessage = 'System Normal';
            }
        }
    }
</script>
<?php $this->endSection("js") ?>