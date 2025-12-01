<?php $this->section("style"); ?>
<link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&family=Playfair+Display:ital,wght@0,600;1,600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/weather-icons/2.0.12/css/weather-icons.min.css">

<style>
    :root {
        --bg-color: #080808;
        --card-bg: rgba(20, 20, 20, 0.6);
        --card-border: 1px solid rgba(255, 255, 255, 0.08);
        --accent-gold: #D4AF37;
        --accent-green: #0e4d2a;
        --text-muted: #888;
        --glass-blur: blur(20px);
    }

    /* GLOBAL RESET */
    html, body {
        height: 100vh; margin: 0; padding: 0;
        background-color: var(--bg-color);
        background-image: radial-gradient(circle at 10% 20%, rgba(14, 77, 42, 0.2) 0%, transparent 40%),
                          radial-gradient(circle at 90% 80%, rgba(212, 175, 55, 0.1) 0%, transparent 40%);
        font-family: 'Outfit', sans-serif;
        color: white;
        overflow: hidden; /* Desktop TV Fix */
    }

    /* === GRID SYSTEM (BENTO LAYOUT) === */
    .dashboard-wrapper {
        display: grid;
        grid-template-columns: 280px 1fr 320px; /* Sidebar Kiri, Konten Tengah, Sidebar Kanan */
        grid-template-rows: 80px 1fr 60px; /* Header, Konten, Ticker */
        gap: 20px;
        height: 100vh;
        padding: 20px;
        box-sizing: border-box;
    }

    /* COMMON CARD STYLE */
    .bento-card {
        background: var(--card-bg);
        border: var(--card-border);
        border-radius: 24px;
        backdrop-filter: var(--glass-blur);
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        overflow: hidden;
        position: relative;
        display: flex; flex-direction: column;
    }

    /* === 1. HEADER (LOGO & INSTANSI) === */
    .header-area {
        grid-column: 1 / -1;
        display: flex; align-items: center; justify-content: space-between;
        padding: 0 20px;
    }
    .brand-box { display: flex; align-items: center; gap: 15px; }
    .brand-text h1 { font-size: 1.8rem; margin: 0; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; }
    .brand-text span { color: var(--accent-gold); font-size: 0.9rem; letter-spacing: 2px; text-transform: uppercase; }

    /* === 2. AGENDA MODULE (HERO SECTION - BESAR) === */
    .agenda-hero {
        grid-column: 2 / 3;
        grid-row: 2 / 3;
        padding: 30px;
        position: relative;
        background: linear-gradient(145deg, rgba(255,255,255,0.05) 0%, rgba(0,0,0,0.2) 100%);
    }
    
    .section-label { 
        font-size: 0.85rem; color: var(--accent-gold); text-transform: uppercase; letter-spacing: 2px; font-weight: 700; margin-bottom: 20px; display: block;
    }

    /* Tampilan Agenda Card Besar */
    .agenda-list-container {
        flex: 1; overflow-y: hidden; position: relative;
    }
    .agenda-scroll-anim { animation: scrollUpAgenda 45s linear infinite; }
    
    .agenda-card-item {
        background: rgba(255,255,255,0.03);
        border-left: 4px solid var(--accent-gold);
        padding: 25px;
        margin-bottom: 15px;
        border-radius: 0 16px 16px 0;
        display: grid;
        grid-template-columns: 80px 1fr; /* Tanggal Kiri, Info Kanan */
        gap: 20px;
        align-items: center;
        transition: transform 0.3s ease;
    }
    .agenda-card-item:hover { transform: translateX(10px); background: rgba(255,255,255,0.07); }

    /* Tanggal Agenda (Kotak Kiri) */
    .date-box {
        text-align: center;
        background: rgba(0,0,0,0.3);
        padding: 10px; border-radius: 12px;
        border: 1px solid rgba(255,255,255,0.1);
    }
    .date-d { font-size: 1.8rem; font-weight: 800; line-height: 1; color: white; display: block; }
    .date-m { font-size: 0.8rem; text-transform: uppercase; color: var(--accent-gold); font-weight: 600; display: block; margin-top: 3px; }
    .date-time { font-size: 0.75rem; background: var(--accent-green); color: white; padding: 2px 5px; border-radius: 4px; margin-top: 5px; display: inline-block; }

    /* Info Agenda (Kanan) */
    .agenda-info h3 { margin: 0 0 8px 0; font-size: 1.4rem; font-weight: 600; line-height: 1.2; font-family: 'Playfair Display', serif; }
    .agenda-meta { display: flex; gap: 15px; font-size: 0.9rem; color: var(--text-muted); }
    .agenda-meta i { color: var(--accent-gold); margin-right: 5px; }

    /* === 3. FINANCE MODULE (SIDEBAR KIRI) === */
    .finance-panel {
        grid-column: 1 / 2;
        grid-row: 2 / 3;
        display: flex; flex-direction: column; gap: 20px;
    }
    .finance-card {
        flex: 1; padding: 20px;
        background: radial-gradient(circle at top right, rgba(14, 77, 42, 0.4), transparent);
    }
    .big-number { font-size: 2.5rem; font-weight: 800; color: white; line-height: 1; margin: 10px 0; }
    .sub-number { font-size: 0.9rem; color: #ccc; }
    
    /* Progress Bar Mewah */
    .progress-lux { height: 8px; background: rgba(255,255,255,0.1); border-radius: 10px; margin-top: 15px; overflow: hidden; }
    .progress-fill { height: 100%; background: linear-gradient(90deg, var(--accent-gold), #fff); border-radius: 10px; box-shadow: 0 0 10px var(--accent-gold); }

    /* === 4. UTILITY MODULE (SIDEBAR KANAN) === */
    .utility-panel {
        grid-column: 3 / 4;
        grid-row: 2 / 3;
        display: flex; flex-direction: column; gap: 20px;
    }

    /* Jam & Cuaca */
    .time-weather-card {
        flex: 0 0 auto; padding: 25px; text-align: center;
        background: linear-gradient(to bottom, rgba(255,255,255,0.05), transparent);
    }
    .clock-digital { font-size: 3rem; font-weight: 800; line-height: 1; font-variant-numeric: tabular-nums; }
    .date-full { font-size: 0.9rem; color: var(--accent-gold); text-transform: uppercase; margin-top: 5px; letter-spacing: 1px; }
    
    .weather-row { margin-top: 20px; display: flex; align-items: center; justify-content: center; gap: 15px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 15px; }
    .weather-temp { font-size: 1.8rem; font-weight: 700; }

    /* Sholat List */
    .sholat-card {
        flex: 1; padding: 20px; overflow: hidden;
    }
    .sholat-row {
        display: flex; justify-content: space-between; padding: 12px 10px;
        border-bottom: 1px solid rgba(255,255,255,0.05); font-size: 1rem;
    }
    .sholat-row.active {
        background: var(--accent-gold); color: black; border-radius: 8px; font-weight: 800; border: none;
        box-shadow: 0 5px 15px rgba(212, 175, 55, 0.2);
    }

    /* === 5. NEWS TICKER (FOOTER - FIXED NO NABRAK & CENTERED) === */
    .ticker-area {
        grid-column: 1 / -1;
        background: var(--accent-green);
        border-radius: 12px;
        display: flex; align-items: center;
        padding: 0;
        font-weight: 600;
        overflow: hidden;
        position: relative;
    }

    .ticker-label { 
        background: black; 
        color: white; 
        padding: 0 25px; 
        height: 100%; 
        display: flex; align-items: center; 
        font-size: 0.9rem; 
        text-transform: uppercase; 
        letter-spacing: 1px; 
        white-space: nowrap; 
        z-index: 20;
        box-shadow: 5px 0 15px rgba(0,0,0,0.4);
        position: relative;
    }

    /* CONTAINER PEMBATAS TEKS BERJALAN (FIXED VERTICAL ALIGN) */
    .ticker-viewport {
        flex: 1;
        overflow: hidden;
        height: 100%;
        position: relative;
        /* Tambahan buat tengahin vertikal */
        display: flex; 
        align-items: center; 
        
        /* Masking fade effect */
        mask-image: linear-gradient(to right, transparent, black 20px);
        -webkit-mask-image: linear-gradient(to right, transparent, black 20px);
    }

    .ticker-track { 
        white-space: nowrap; 
        animation: marquee 30s linear infinite; 
        font-size: 1.1rem; 
        display: inline-block;
        padding-left: 100%;
        will-change: transform;
        /* Hapus margin/padding bawaan yg bikin naik */
        margin: 0;
        line-height: 1; 
    }

    .ticker-item { margin-right: 50px; display: inline-block; }

    /* ANIMATIONS */
    @keyframes scrollUpAgenda { 0% { transform: translateY(0); } 100% { transform: translateY(-50%); } }
    @keyframes marquee { 0% { transform: translateX(0); } 100% { transform: translateX(-100%); } }

    /* =========================================
       RESPONSIVE (MOBILE & TABLET)
       ========================================= */
    @media screen and (max-width: 1024px) {
        html, body { overflow-y: auto; height: auto; }
        
        .dashboard-wrapper {
            display: flex; flex-direction: column; height: auto; gap: 15px; padding: 15px;
        }

        .header-area { order: 1; padding: 0; margin-bottom: 10px; }
        .utility-panel { order: 2; gap: 10px; }
        .agenda-hero { order: 3; min-height: 400px; }
        .finance-panel { order: 4; display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
        .ticker-area { order: 5; position: fixed; bottom: 0; left: 0; width: 100%; border-radius: 0; z-index: 99; height: 40px; }

        .brand-text h1 { font-size: 1.2rem; }
        .time-weather-card { padding: 15px; display: flex; justify-content: space-between; align-items: center; text-align: left; }
        .weather-row { margin-top: 0; border: none; padding: 0; }
        
        .agenda-list-container { overflow-y: auto; }
        .agenda-scroll-anim { animation: none; }
        .sholat-card { display: none; } 
        .finance-card { min-height: 120px; }
        .big-number { font-size: 1.8rem; }
        
        .ticker-label { font-size: 0.7rem; padding: 0 10px; }
        .ticker-track { font-size: 0.9rem; }
    }
</style>
<?php $this->endSection("style") ?>

<div class="dashboard-wrapper">
    
    <header class="header-area">
        <div class="brand-box">
            <img src="<?php echo base_url('/' . ($logo == "" ? 'logo.png' : $logo)); ?>" width="60" />
            <div class="brand-text">
                <h1>Biro Keuangan</h1>
                <span>KEJAKSAAN AGUNG RI</span>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2 px-3 py-1 rounded-pill" style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.1);">
            <div style="width: 10px; height: 10px; background: #00e676; border-radius: 50%; box-shadow: 0 0 10px #00e676;"></div>
            <span style="font-size: 0.8rem;">SYSTEM ONLINE</span>
        </div>
    </header>

    <aside class="finance-panel">
        <div class="bento-card finance-card">
            <span class="section-label"><i class="mdi mdi-chart-bar"></i> Realisasi Anggaran</span>
            <div class="mt-auto">
                <div class="d-flex align-items-end gap-2">
                    <div class="big-number">{{ finance.persen }}%</div>
                    <div class="mb-2 text-muted">Tercapai</div>
                </div>
                <div class="sub-number">{{ formatRupiah(finance.realisasi) }} / {{ formatRupiah(finance.pagu) }}</div>
                <div class="progress-lux">
                    <div class="progress-fill" :style="{ width: finance.persen + '%' }"></div>
                </div>
            </div>
        </div>

        <div class="bento-card finance-card" style="background: radial-gradient(circle at bottom right, rgba(212, 175, 55, 0.2), transparent);">
            <span class="section-label"><i class="mdi mdi-cash-multiple"></i> Total PNBP</span>
            <div class="mt-auto">
                <div class="big-number" style="color: var(--accent-gold);">{{ formatRupiah(pnbp.total) }}</div>
                <div class="sub-number"><i class="mdi mdi-arrow-up"></i> +15% dari Target</div>
            </div>
        </div>
    </aside>

    <main class="bento-card agenda-hero">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <span class="section-label" style="font-size: 1.2rem; margin: 0;"><i class="mdi mdi-calendar-star"></i> AGENDA UTAMA</span>
            <span class="badge bg-white text-dark">{{ dataAgenda.length }} Kegiatan Hari Ini</span>
        </div>

        <div class="agenda-list-container">
            <div v-if="dataAgenda.length === 0" class="h-100 d-flex align-items-center justify-content-center text-muted">
                <h3>TIDAK ADA JADWAL KEGIATAN</h3>
            </div>
            
            <div v-else class="agenda-scroll-anim">
                <div v-for="(item, i) in dataAgenda" :key="i" class="agenda-card-item">
                    <div class="date-box">
                        <span class="date-d">{{ getDayNum(item.waktu_tanggal) }}</span>
                        <span class="date-m">{{ getMonthName(item.waktu_tanggal) }}</span>
                        <span class="date-time">{{ item.waktu.substring(0,5) }}</span>
                    </div>
                    <div class="agenda-info">
                        <h3>{{ item.nama_agenda }}</h3>
                        <div class="agenda-meta">
                            <span><i class="mdi mdi-map-marker"></i> {{ item.tempat_agenda }}</span>
                            <span><i class="mdi mdi-clock-outline"></i> {{ item.waktu }} WIB</span>
                        </div>
                    </div>
                </div>

                <div v-for="(item, i) in dataAgenda" :key="'d-'+i" class="agenda-card-item">
                    <div class="date-box">
                        <span class="date-d">{{ getDayNum(item.waktu_tanggal) }}</span>
                        <span class="date-m">{{ getMonthName(item.waktu_tanggal) }}</span>
                        <span class="date-time">{{ item.waktu.substring(0,5) }}</span>
                    </div>
                    <div class="agenda-info">
                        <h3>{{ item.nama_agenda }}</h3>
                        <div class="agenda-meta">
                            <span><i class="mdi mdi-map-marker"></i> {{ item.tempat_agenda }}</span>
                            <span><i class="mdi mdi-clock-outline"></i> {{ item.waktu }} WIB</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <aside class="utility-panel">
        <div class="bento-card time-weather-card">
            <div class="clock-digital">{{ jam }}</div>
            <div class="date-full">{{ tanggal }}</div>
            
            <div class="weather-row">
                <i class="wi wi-day-cloudy" style="font-size: 2.5rem; color: #fff;"></i>
                <div class="text-start">
                    <div class="weather-temp">29°C</div>
                    <div style="font-size: 0.8rem; opacity: 0.7;">Jakarta Selatan</div>
                </div>
            </div>
        </div>

        <div class="bento-card sholat-card">
            <span class="section-label mb-3">Jadwal Sholat</span>
            <div style="overflow-y: auto;">
                <div v-for="(time, name) in jadwalSholat" :key="name" 
                     class="sholat-row" :class="{ 'active': name === nextPrayer }">
                    <span>{{ name }}</span>
                    <span>{{ time }}</span>
                </div>
            </div>
        </div>
    </aside>

    <footer class="ticker-area">
        <div class="ticker-label">BREAKING NEWS</div>
        
        <div class="ticker-viewport">
            <div class="ticker-track">
                <span v-for="item in dataNews" :key="item.id" class="ticker-item">
                    <i class="mdi mdi-newspaper" style="color: var(--accent-gold);"></i> {{ item.text_news }}
                </span>
                <span v-for="item in dataNews" :key="'d-'+item.id" class="ticker-item">
                    <i class="mdi mdi-newspaper" style="color: var(--accent-gold);"></i> {{ item.text_news }}
                </span>
                <span v-if="dataNews.length == 0" class="ticker-item">
                    SELAMAT DATANG DI DASHBOARD BIRO KEUANGAN KEJAKSAAN AGUNG RI... TERUS TINGKATKAN KINERJA DAN PELAYANAN...
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
        finance: { pagu: 15000000000, realisasi: 10500000000, sisa: 4500000000, persen: 70 },
        pnbp: { total: 1250000000 },
        jadwalSholat: { Subuh: '04:12', Dzuhur: '11:51', Ashar: '15:15', Maghrib: '17:58', Isya: '19:12' },
        nextPrayer: 'Ashar',
        
        // Dummy Agenda with Date (Simulasi)
        // Di real app, pastikan API lo kirim field 'waktu_tanggal' format YYYY-MM-DD
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
        
        formatRupiah: function(num) {
            if(num >= 1000000000) return (num/1000000000).toFixed(1) + ' M';
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(num);
        },

        updateTime: function() {
            const d = new Date();
            this.jam = `${addZero(d.getHours())}:${addZero(d.getMinutes())}`;
            const days = ["MINGGU", "SENIN", "SELASA", "RABU", "KAMIS", "JUMAT", "SABTU"];
            const months = ["JANUARI", "FEBRUARI", "MARET", "APRIL", "MEI", "JUNI", "JULI", "AGUSTUS", "SEPTEMBER", "OKTOBER", "NOVEMBER", "DESEMBER"];
            this.tanggal = `${days[d.getDay()]}, ${d.getDate()} ${months[d.getMonth()]} ${d.getFullYear()}`;
            
            // Logic simple next prayer
            const h = d.getHours();
            if(h<4) this.nextPrayer='Subuh'; else if(h<12) this.nextPrayer='Dzuhur';
            else if(h<15) this.nextPrayer='Ashar'; else if(h<18) this.nextPrayer='Maghrib';
            else if(h<19) this.nextPrayer='Isya'; else this.nextPrayer='Subuh';
        },

        // Helpers untuk Agenda Date Box
        getDayNum: function(dateStr) {
            // Asumsi dateStr = "2025-12-01" or handled by backend
            // Jika kosong pakai tanggal hari ini
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
                    // Simulasi nambahin tanggal field kalo di API lo belom ada
                    this.dataAgenda.forEach(item => {
                        if(!item.waktu_tanggal) item.waktu_tanggal = new Date().toISOString().slice(0,10);
                    });
                }
            }).catch(e=>{}); 
        },
    }
</script>
<?php $this->endSection("js") ?>