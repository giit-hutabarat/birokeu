<?php $this->section("style"); ?>
<link href="https://fonts.googleapis.com/css2?family=Lato:wght@300;400;700&family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/weather-icons/2.0.12/css/weather-icons.min.css">

<style>
    :root {
        --bg-paper: #fdfbf7; /* Putih Gading Kertas */
        --bg-ink: #111111;   /* Hitam Tinta */
        --accent-gold: #c5a017; /* Emas Gelap Elegan */
        --text-grey: #666666;
        --border-line: 1px solid rgba(0,0,0,0.1);
    }

    html, body {
        height: 100vh; margin: 0; padding: 0;
        background-color: var(--bg-ink);
        font-family: 'Lato', sans-serif;
        color: var(--bg-ink);
        overflow: hidden;
    }

    /* === MAGAZINE GRID LAYOUT === */
    .magazine-wrapper {
        display: flex;
        height: 100vh;
        width: 100vw;
    }

    /* === 1. LEFT COLUMN (SIDEBAR - DARK) === */
    .col-sidebar {
        width: 40%;
        background-color: var(--bg-ink);
        color: white;
        display: flex; flex-direction: column;
        padding: 40px;
        position: relative;
        border-right: 1px solid #222;
    }

    /* Brand Header */
    .brand-section { margin-bottom: 50px; }
    .brand-logo { filter: invert(1); opacity: 0.9; margin-bottom: 20px; } /* Logo jadi putih */
    .brand-title { 
        font-family: 'Playfair Display', serif; font-size: 2.5rem; 
        font-weight: 700; line-height: 1; letter-spacing: -1px; margin: 0;
    }
    .brand-sub { 
        font-family: 'Lato', sans-serif; font-size: 0.8rem; 
        letter-spacing: 3px; text-transform: uppercase; color: var(--accent-gold); margin-top: 10px; display: block;
    }

    /* Finance Section (Thin Line Chart) */
    .finance-section { margin-bottom: 40px; flex: 1; display: flex; flex-direction: column; justify-content: center; }
    .section-head { 
        font-size: 0.75rem; text-transform: uppercase; letter-spacing: 2px; 
        color: #555; border-bottom: 1px solid #333; padding-bottom: 10px; margin-bottom: 20px; 
    }
    
    .finance-big-num { font-family: 'Playfair Display'; font-size: 3.5rem; margin: 0; line-height: 1; }
    .finance-label { font-size: 0.9rem; color: #888; margin-bottom: 20px; display: block; }
    
    /* SVG Line Chart Container */
    .chart-container {
        width: 100%; height: 100px; position: relative;
        border-bottom: 1px solid #333;
    }
    .chart-svg { width: 100%; height: 100%; overflow: visible; }
    .chart-line {
        fill: none; stroke: var(--accent-gold); stroke-width: 2;
        stroke-dasharray: 1000; stroke-dashoffset: 1000;
        animation: drawLine 3s ease-out forwards;
    }
    @keyframes drawLine { to { stroke-dashoffset: 0; } }

    /* Utility (Weather & Sholat) */
    .utility-section { margin-top: auto; }
    .weather-row { display: flex; align-items: center; gap: 20px; margin-bottom: 30px; }
    .temp-val { font-family: 'Playfair Display'; font-size: 2.5rem; }
    
    .sholat-list { display: flex; justify-content: space-between; border-top: 1px solid #333; padding-top: 20px; }
    .sholat-item { text-align: center; }
    .sholat-name { font-size: 0.7rem; color: #666; text-transform: uppercase; display: block; }
    .sholat-time { font-size: 1rem; font-weight: 700; color: white; display: block; margin-top: 5px; }
    .sholat-item.active .sholat-time { color: var(--accent-gold); }

    /* === 2. RIGHT COLUMN (AGENDA - LIGHT/PAPER) === */
    .col-agenda {
        width: 60%;
        background-color: var(--bg-paper);
        display: flex; flex-direction: column;
        position: relative;
    }

    /* Top Bar (Clock) */
    .top-bar {
        padding: 30px 40px;
        display: flex; justify-content: space-between; align-items: flex-end;
        border-bottom: 2px solid black;
    }
    .date-display { font-family: 'Playfair Display'; font-size: 1.2rem; font-style: italic; }
    .clock-display { font-family: 'Lato'; font-weight: 700; font-size: 1.2rem; letter-spacing: 1px; }

    /* Agenda Content (Scrollable) */
    .agenda-wrapper {
        flex: 1; padding: 40px; overflow-y: hidden; position: relative;
    }
    .agenda-scroller { animation: scrollUpMagazine 60s linear infinite; }

    /* The "Editorial" Agenda Card */
    .editorial-card {
        display: flex; align-items: flex-start; gap: 30px;
        margin-bottom: 60px; /* Jarak antar artikel luas */
        border-bottom: 1px solid #ddd;
        padding-bottom: 40px;
    }
    
    /* Super Big Date */
    .big-date-col {
        flex: 0 0 120px; text-align: center; line-height: 0.8;
    }
    .bd-day { font-family: 'Playfair Display'; font-size: 6rem; font-weight: 900; color: black; display: block; }
    .bd-month { 
        font-family: 'Lato'; font-size: 1.5rem; font-weight: 900; 
        color: var(--accent-gold); text-transform: uppercase; display: block; margin-top: 5px;
    }

    /* Content */
    .content-col { flex: 1; }
    .cat-label { 
        font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; 
        background: black; color: white; padding: 4px 8px; display: inline-block; margin-bottom: 15px;
    }
    .agenda-title {
        font-family: 'Playfair Display'; font-size: 2.5rem; font-weight: 700; line-height: 1.1; margin: 0 0 15px 0;
        color: #111;
    }
    .agenda-details {
        font-size: 1.1rem; color: #555; line-height: 1.5; border-left: 3px solid var(--accent-gold); padding-left: 15px;
    }

    /* Footer Ticker (News Wire Style) */
    .news-wire {
        background: white; border-top: 4px solid black;
        height: 60px; display: flex; align-items: center;
        padding: 0; overflow: hidden;
    }
    .wire-label {
        background: black; color: white; height: 100%; padding: 0 30px;
        display: flex; align-items: center; font-weight: 900; font-style: italic; font-family: 'Playfair Display'; font-size: 1.2rem;
        z-index: 10;
    }
    /* Fixed Ticker Viewport */
    .wire-viewport {
        flex: 1; height: 100%; overflow: hidden; display: flex; align-items: center;
        position: relative;
    }
    .wire-track {
        white-space: nowrap; animation: marquee 30s linear infinite;
        font-family: 'Lato'; font-weight: 700; text-transform: uppercase; font-size: 1rem; color: black;
    }

    /* ANIMATIONS */
    @keyframes scrollUpMagazine { 0% { transform: translateY(0); } 100% { transform: translateY(-50%); } }
    @keyframes marquee { 0% { transform: translateX(0); } 100% { transform: translateX(-100%); } }

    /* =========================================
       RESPONSIVE (MOBILE PHONE STYLE)
       ========================================= */
    @media screen and (max-width: 1024px) {
        html, body { overflow-y: auto; height: auto; background-color: var(--bg-paper); }
        .magazine-wrapper { flex-direction: column; height: auto; }

        /* 1. Header (Sidebar jadi Top Bar) */
        .col-sidebar {
            width: 100%; padding: 20px; border-right: none; border-bottom: 5px solid var(--accent-gold);
            height: auto;
        }
        .brand-section { margin-bottom: 20px; display: flex; align-items: center; gap: 15px; }
        .brand-logo { width: 40px; margin-bottom: 0; }
        .brand-title { font-size: 1.5rem; }
        .brand-sub { display: none; }
        
        .finance-section { 
            flex-direction: row; justify-content: space-between; align-items: center; margin-bottom: 20px; 
            border-top: 1px solid #333; padding-top: 15px;
        }
        .chart-container { display: none; } /* Hide chart di mobile biar simpel */
        .finance-big-num { font-size: 2rem; }
        .finance-label { margin-bottom: 0; font-size: 0.8rem; }
        
        .utility-section { display: none; } /* Hide weather/sholat detail di header */

        /* 2. Agenda (Main Feed) */
        .col-agenda { width: 100%; height: auto; }
        .top-bar { display: none; } /* Hide topbar clock */
        
        .agenda-wrapper { padding: 20px; height: auto; overflow: visible; }
        .agenda-scroller { animation: none; }
        
        .editorial-card { margin-bottom: 30px; gap: 15px; padding-bottom: 20px; }
        .big-date-col { flex: 0 0 70px; }
        .bd-day { font-size: 3.5rem; }
        .bd-month { font-size: 1rem; }
        
        .agenda-title { font-size: 1.5rem; }
        .agenda-details { font-size: 0.9rem; }

        /* 3. Footer Fixed */
        .news-wire { position: fixed; bottom: 0; left: 0; width: 100%; height: 40px; z-index: 99; border-top: 2px solid black; }
        .wire-label { padding: 0 15px; font-size: 0.9rem; }
        .wire-track { font-size: 0.8rem; }
        
        /* Spacer bawah */
        .col-agenda { padding-bottom: 50px; }
    }
</style>
<?php $this->endSection("style") ?>

<div class="magazine-wrapper">

    <aside class="col-sidebar">
        <div class="brand-section">
            <img class="brand-logo" src="<?php echo base_url('/' . ($logo == "" ? 'logo.png' : $logo)); ?>" width="60" />
            <h1 class="brand-title">The Financial<br>Bureau.</h1>
            <span class="brand-sub">Kejaksaan Agung Republik Indonesia</span>
        </div>

        <div class="finance-section">
            <div class="section-head">Realisasi Anggaran</div>
            <h2 class="finance-big-num">{{ finance.persen }}%</h2>
            <span class="finance-label">{{ formatRupiahShort(finance.realisasi) }} dari {{ formatRupiahShort(finance.pagu) }}</span>
            
            <div class="chart-container">
                <svg class="chart-svg" viewBox="0 0 300 100" preserveAspectRatio="none">
                    <line x1="0" y1="25" x2="300" y2="25" stroke="#333" stroke-width="0.5" />
                    <line x1="0" y1="50" x2="300" y2="50" stroke="#333" stroke-width="0.5" />
                    <line x1="0" y1="75" x2="300" y2="75" stroke="#333" stroke-width="0.5" />
                    
                    <path d="M0,80 Q50,70 100,50 T200,40 T300,10" fill="none" class="chart-line" />
                    
                    <circle cx="300" cy="10" r="4" fill="var(--accent-gold)" />
                </svg>
            </div>
        </div>

        <div class="utility-section">
            <div class="section-head">Utility</div>
            <div class="weather-row">
                <i class="wi wi-day-cloudy" style="font-size: 2rem; color: #888;"></i>
                <div>
                    <div class="temp-val">29°</div>
                    <small style="color:#666; text-transform:uppercase;">Jakarta Sel.</small>
                </div>
            </div>
            
            <div class="sholat-list">
                <div v-for="(time, name) in jadwalSholat" :key="name" 
                     class="sholat-item" :class="{ 'active': name === nextPrayer }">
                    <span class="sholat-name">{{ name }}</span>
                    <span class="sholat-time">{{ time }}</span>
                </div>
            </div>
        </div>
    </aside>

    <main class="col-agenda">
        <div class="top-bar">
            <div class="date-display">{{ tanggal }}</div>
            <div class="clock-display">{{ jam }} WIB</div>
        </div>

        <div class="agenda-wrapper">
            <div v-if="dataAgenda.length === 0" class="text-center p-5 text-muted">
                <h2 style="font-family: 'Playfair Display';">Tidak Ada Jadwal</h2>
                <p>Belum ada agenda kegiatan yang terjadwal untuk hari ini.</p>
            </div>

            <div v-else class="agenda-scroller">
                <div v-for="(item, i) in dataAgenda" :key="i" class="editorial-card">
                    <div class="big-date-col">
                        <span class="bd-day">{{ getDayNum(item.waktu_tanggal) }}</span>
                        <span class="bd-month">{{ getMonthName(item.waktu_tanggal) }}</span>
                    </div>
                    <div class="content-col">
                        <span class="cat-label">Agenda Resmi</span>
                        <h2 class="agenda-title">{{ item.nama_agenda }}</h2>
                        <div class="agenda-details">
                            <div><i class="mdi mdi-clock-outline"></i> {{ item.waktu }} WIB</div>
                            <div><i class="mdi mdi-map-marker-outline"></i> {{ item.tempat_agenda }}</div>
                        </div>
                    </div>
                </div>

                <div v-for="(item, i) in dataAgenda" :key="'d-'+i" class="editorial-card">
                    <div class="big-date-col">
                        <span class="bd-day">{{ getDayNum(item.waktu_tanggal) }}</span>
                        <span class="bd-month">{{ getMonthName(item.waktu_tanggal) }}</span>
                    </div>
                    <div class="content-col">
                        <span class="cat-label">Agenda Resmi</span>
                        <h2 class="agenda-title">{{ item.nama_agenda }}</h2>
                        <div class="agenda-details">
                            <div><i class="mdi mdi-clock-outline"></i> {{ item.waktu }} WIB</div>
                            <div><i class="mdi mdi-map-marker-outline"></i> {{ item.tempat_agenda }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="news-wire">
            <div class="wire-label">NEWS WIRE</div>
            <div class="wire-viewport">
                <div class="wire-track">
                     <span v-for="item in dataNews" :key="item.id" style="margin-right: 60px;">
                        <span style="color: #999;">///</span> {{ item.text_news }}
                    </span>
                    <span v-for="item in dataNews" :key="'d-'+item.id" style="margin-right: 60px;">
                        <span style="color: #999;">///</span> {{ item.text_news }}
                    </span>
                     <span v-if="dataNews.length == 0" style="margin-right: 60px;">
                        SELAMAT DATANG DI BIRO KEUANGAN KEJAKSAAN AGUNG RI. TRANSFORMATION FOR EXCELLENCE.
                    </span>
                </div>
            </div>
        </footer>
    </main>

</div>

<?php $this->section("js") ?>
<script>
    function addZero(n) { return (n < 10 ? '0' : '') + n; }

    dataVue = {
        ...dataVue,
        jam: "", tanggal: "",
        
        // Data Modules
        dataNews: [], dataAgenda: [],
        finance: { pagu: 15000000000, realisasi: 8500000000, sisa: 6500000000, persen: 56 },
        jadwalSholat: { Subuh: '04:12', Dzuhur: '11:51', Ashar: '15:15', Maghrib: '17:58', Isya: '19:12' },
        nextPrayer: 'Ashar',
        
        // Dummy Agenda (Kalo API blm siap)
        // Pastikan API return 'waktu_tanggal' (Y-m-d)
        dataAgenda: [] 
    }

    createdVue = function() {
        setInterval(this.updateTime, 1000);
        this.getNews(); 
        this.getAgenda();
    }

    mountedVue = function() {
        setInterval(() => this.getNews(), <?= $news_refresh; ?> * 1000);
        setInterval(() => this.getAgenda(), <?= $agenda_refresh; ?> * 1000);
    }

    methodsVue = {
        ...methodsVue,
        
        formatRupiahShort: function(num) {
            if(num >= 1000000000) return (num/1000000000).toFixed(1) + ' M';
            if(num >= 1000000) return (num/1000000).toFixed(0) + ' Jt';
            return (num/1000).toFixed(0) + ' K';
        },

        updateTime: function() {
            const d = new Date();
            this.jam = `${addZero(d.getHours())}:${addZero(d.getMinutes())}`;
            const m = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            const days = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
            this.tanggal = `${days[d.getDay()]}, ${d.getDate()} ${m[d.getMonth()]} ${d.getFullYear()}`;
            
            // Logic Prayer Highlight
            const h = d.getHours();
            if(h<4) this.nextPrayer='Subuh'; else if(h<12) this.nextPrayer='Dzuhur';
            else if(h<15) this.nextPrayer='Ashar'; else if(h<18) this.nextPrayer='Maghrib';
            else if(h<19) this.nextPrayer='Isya'; else this.nextPrayer='Subuh';
        },

        // Helper Tanggal Agenda
        getDayNum: function(dateStr) {
            if(!dateStr) return new Date().getDate();
            return new Date(dateStr).getDate();
        },
        getMonthName: function(dateStr) {
            const m = ["JAN", "FEB", "MAR", "APR", "MEI", "JUN", "JUL", "AGS", "SEP", "OKT", "NOV", "DES"];
            if(!dateStr) return m[new Date().getMonth()];
            return m[new Date(dateStr).getMonth()];
        },

        getNews: function() { axios.get('<?= base_url() ?>/api/news/news').then(res => { if(res.data.status) this.dataNews = res.data.data; }).catch(e=>{}); },
        getAgenda: function() { 
            axios.get('<?= base_url() ?>/api/display/agenda').then(res => { 
                if(res.data.status) {
                    this.dataAgenda = res.data.data; 
                    // Fallback date dummy jika API tidak ada tanggal
                    this.dataAgenda.forEach(item => {
                        if(!item.waktu_tanggal) item.waktu_tanggal = new Date().toISOString().slice(0,10);
                    });
                }
            }).catch(e=>{}); 
        },
    }
</script>
<?php $this->endSection("js") ?>