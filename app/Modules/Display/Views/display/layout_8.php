<?php $this->section("style"); ?>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700;900&family=Teko:wght@300;400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/weather-icons/2.0.12/css/weather-icons.min.css">

<style>
    :root {
        --dark-bg: #111111;
        --light-bg: #f4f4f4;
        --accent-gold: #FFC107;
        --accent-red: #D32F2F;
        --text-dark: #222;
        --text-light: #fff;
        --split-angle: 15deg; /* Kemiringan Diagonal */
    }

    html, body {
        height: 100vh; margin: 0; padding: 0;
        background: var(--light-bg);
        font-family: 'Montserrat', sans-serif;
        overflow: hidden;
    }

    .wrapper {
        position: relative; width: 100vw; height: 100vh;
        overflow: hidden;
        display: flex;
    }

    /* === LAYER 1: LIGHT SIDE (KANAN - DATA) === */
    .layer-light {
        position: absolute;
        top: 0; right: 0; bottom: 0;
        width: 60%; /* Mengambil 60% layar kanan */
        background: var(--light-bg);
        color: var(--text-dark);
        display: flex; flex-direction: column;
        padding: 40px 40px 80px 150px; /* Padding kiri besar karena tertutup diagonal */
        justify-content: center;
    }

    /* Background Pattern Halus di sisi terang */
    .bg-pattern {
        position: absolute; top:0; left:0; width:100%; height:100%;
        background-image: radial-gradient(#ccc 1px, transparent 1px);
        background-size: 20px 20px; opacity: 0.3; pointer-events: none;
    }

    /* === LAYER 2: DARK SIDE (KIRI - AGENDA) === */
    .layer-dark {
        position: absolute;
        top: 0; left: 0; bottom: 0;
        width: 55%; /* Mengambil 55% layar kiri */
        background: var(--dark-bg);
        color: var(--text-light);
        /* KUNCI DIAGONAL: Clip Path */
        clip-path: polygon(0 0, 100% 0, 85% 100%, 0% 100%);
        padding: 40px 80px 80px 40px;
        display: flex; flex-direction: column;
        z-index: 10;
        box-shadow: 10px 0 50px rgba(0,0,0,0.5); /* Shadow gak ngefek di clip-path, butuh trik lain kalau mau shadow */
    }
    
    /* Dekorasi Garis Emas di perbatasan */
    .border-accent {
        position: absolute; top: 0; left: 55%; bottom: 0; width: 5px;
        background: var(--accent-gold);
        transform: skewX(-10deg); /* Menyesuaikan kemiringan clip-path visual */
        transform-origin: bottom;
        z-index: 11;
        margin-left: -5px;
    }

    /* === MODULE STYLING === */

    /* 1. Header (Dark Side) */
    .brand-box { margin-bottom: 60px; }
    .brand-title { font-family: 'Teko', sans-serif; font-size: 3.5rem; line-height: 0.8; text-transform: uppercase; margin: 0; }
    .brand-sub { font-size: 0.9rem; letter-spacing: 2px; color: var(--accent-gold); text-transform: uppercase; }

    /* 2. AGENDA (Dark Side - MOTION FOCUS) */
    .agenda-container {
        flex: 1; display: flex; flex-direction: column; justify-content: center;
        position: relative; overflow: hidden;
    }
    .agenda-label { 
        font-size: 0.8rem; font-weight: 700; letter-spacing: 2px; color: #555; text-transform: uppercase; margin-bottom: 20px; border-bottom: 1px solid #333; padding-bottom: 10px; display: inline-block;
    }
    
    /* Agenda Item Styling */
    .ag-item { position: absolute; width: 100%; } /* Stacked for transition */
    
    .ag-date-big {
        font-family: 'Teko'; font-size: 6rem; line-height: 0.8; color: var(--accent-gold); margin-bottom: 10px;
        text-shadow: 0 0 20px rgba(255, 193, 7, 0.3);
    }
    .ag-title {
        font-size: 2.2rem; font-weight: 700; line-height: 1.2; margin-bottom: 20px;
        background: linear-gradient(90deg, #fff, #aaa); -webkit-background-clip: text; -webkit-text-fill-color: transparent;
    }
    .ag-meta {
        display: flex; gap: 30px; font-size: 1.1rem; color: #ccc;
    }
    .ag-badge {
        background: var(--accent-red); color: white; padding: 2px 8px; font-size: 0.7rem; font-weight: bold; border-radius: 2px;
        vertical-align: middle; margin-left: 10px;
    }

    /* VUE TRANSITION: SLIDE UP */
    .slide-enter-active, .slide-leave-active { transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
    .slide-enter-from { opacity: 0; transform: translateY(50px); }
    .slide-leave-to { opacity: 0; transform: translateY(-50px); }


    /* 3. FINANCE (Light Side) */
    .finance-row {
        display: flex; gap: 40px; margin-bottom: 50px;
    }
    .stat-card { flex: 1; }
    .stat-label { font-size: 0.8rem; font-weight: 700; text-transform: uppercase; color: #888; letter-spacing: 1px; }
    .stat-value { font-family: 'Teko'; font-size: 4rem; font-weight: 600; line-height: 1; color: var(--text-dark); }
    .stat-sub { font-size: 0.9rem; color: #555; margin-top: 5px; font-weight: 500; }
    
    /* Bar Chart Minimalist */
    .bar-container { width: 100%; height: 10px; background: #ddd; margin-top: 15px; position: relative; }
    .bar-fill { height: 100%; background: var(--text-dark); width: 0; transition: width 1.5s ease; }

    /* 4. UTILITY (Light Side) */
    .utility-grid {
        display: grid; grid-template-columns: 1fr 1fr; gap: 30px;
    }
    .clock-widget { border-left: 5px solid var(--text-dark); padding-left: 20px; }
    .clock-time { font-family: 'Teko'; font-size: 3.5rem; line-height: 0.9; }
    .clock-date { font-size: 0.9rem; font-weight: 600; text-transform: uppercase; }

    .weather-widget { display: flex; align-items: center; gap: 15px; }
    
    .sholat-list-mini {
        grid-column: 1 / -1; margin-top: 20px;
        display: flex; justify-content: space-between; border-top: 2px solid #ddd; padding-top: 20px;
    }
    .sl-item { text-align: center; opacity: 0.5; transition: 0.3s; }
    .sl-item.active { opacity: 1; transform: scale(1.1); font-weight: bold; color: var(--accent-red); }
    .sl-name { font-size: 0.7rem; text-transform: uppercase; }
    .sl-time { font-family: 'Teko'; font-size: 1.5rem; }

    /* 5. TICKER (BOTTOM) */
    .ticker-fixed {
        position: absolute; bottom: 0; left: 0; width: 100%; height: 60px;
        background: var(--text-dark); color: white;
        display: flex; align-items: center; z-index: 50;
    }
    .ticker-lbl { 
        background: var(--accent-gold); color: black; height: 100%; padding: 0 40px; 
        font-weight: 900; font-size: 1.2rem; display: flex; align-items: center;
        clip-path: polygon(0 0, 100% 0, 85% 100%, 0% 100%); padding-right: 60px;
    }
    .ticker-view { flex: 1; overflow: hidden; height: 100%; display: flex; align-items: center; }
    .ticker-txt { white-space: nowrap; animation: marquee 25s linear infinite; font-size: 1.2rem; font-weight: 500; }
    
    @keyframes marquee { 0% { transform: translateX(0); } 100% { transform: translateX(-100%); } }

    /* =========================================
       RESPONSIVE MOBILE
       ========================================= */
    @media screen and (max-width: 1024px) {
        html, body { overflow-y: auto; height: auto; }
        .wrapper { flex-direction: column; display: block; height: auto; }

        /* Disable Clip Path & Reset Width */
        .layer-dark {
            position: relative; width: 100%; height: auto; min-height: 50vh;
            clip-path: none; padding: 30px;
            border-bottom: 5px solid var(--accent-gold);
        }
        .layer-light {
            position: relative; width: 100%; height: auto;
            padding: 30px;
        }
        
        /* Adjust Fonts Mobile */
        .brand-title { font-size: 2.5rem; }
        .ag-date-big { font-size: 4rem; }
        .ag-title { font-size: 1.5rem; }
        
        .finance-row { flex-direction: column; gap: 30px; }
        .utility-grid { grid-template-columns: 1fr; }
        .clock-widget { border-left: none; padding-left: 0; text-align: center; }
        .weather-widget { justify-content: center; }
        
        .ticker-fixed { position: fixed; bottom: 0; height: 40px; }
        .ticker-lbl { font-size: 0.8rem; padding: 0 15px; clip-path: none; }
        .layer-light { padding-bottom: 60px; } /* Space for ticker */
    }
</style>
<?php $this->endSection("style") ?>

<div class="wrapper">
    
    <div class="layer-light">
        <div class="bg-pattern"></div>
        
        <div class="finance-row">
            <div class="stat-card">
                <span class="stat-label">Realisasi Anggaran</span>
                <div class="stat-value">{{ finance.persen }}%</div>
                <div class="bar-container"><div class="bar-fill" :style="{ width: finance.persen + '%' }"></div></div>
                <div class="stat-sub">{{ formatRupiahShort(finance.realisasi) }} Terpakai</div>
            </div>
            <div class="stat-card">
                <span class="stat-label">Total PNBP</span>
                <div class="stat-value" style="color: var(--accent-gold);">{{ formatRupiahShort(pnbp.total) }}</div>
                <div class="bar-container"><div class="bar-fill" style="width: 100%; background: #ddd;"><div style="width: 15%; background: var(--accent-gold); height: 100%;"></div></div></div>
                <div class="stat-sub">Update Terkini</div>
            </div>
        </div>

        <div class="utility-grid">
            <div class="clock-widget">
                <div class="clock-time">{{ jam }}</div>
                <div class="clock-date">{{ tanggal }}</div>
            </div>
            
            <div class="weather-widget">
                <i class="wi wi-day-sunny" style="font-size: 3rem; color: #f57c00;"></i>
                <div>
                    <div style="font-size: 2rem; font-weight: 700;">29°C</div>
                    <div style="text-transform: uppercase; font-size: 0.8rem; letter-spacing: 1px;">Jakarta Sel.</div>
                </div>
            </div>
            
            <div class="sholat-list-mini">
                <div v-for="(time, name) in jadwalSholat" :key="name" 
                     class="sl-item" :class="{ 'active': name === nextPrayer }">
                    <div class="sl-name">{{ name }}</div>
                    <div class="sl-time">{{ time }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="layer-dark">
        <div class="brand-box">
            <div class="brand-title">BIRO KEUANGAN</div>
            <span class="brand-sub">Kejaksaan Agung RI</span>
        </div>

        <span class="agenda-label">AGENDA HIGHLIGHT</span>

        <div class="agenda-container">
            <transition-group name="slide">
                <div v-if="dataAgenda.length > 0" :key="currentIndex" class="ag-item">
                    <div class="ag-date-big">
                        {{ getDayNum(currentAgenda.waktu_tanggal) }} <span style="font-size: 2rem; color: #fff;">{{ getMonthName(currentAgenda.waktu_tanggal) }}</span>
                    </div>
                    <div class="ag-title">
                        {{ currentAgenda.nama_agenda }} 
                        <span v-if="isNow(currentAgenda.waktu)" class="ag-badge">NOW</span>
                    </div>
                    <div class="ag-meta">
                        <span><i class="mdi mdi-clock-outline"></i> {{ currentAgenda.waktu }} WIB</span>
                        <span><i class="mdi mdi-map-marker"></i> {{ currentAgenda.tempat_agenda }}</span>
                    </div>
                </div>
                
                <div v-if="dataAgenda.length === 0" :key="'empty'" class="ag-item">
                    <div class="ag-title">TIDAK ADA JADWAL HARI INI</div>
                    <div class="ag-meta">Sistem Monitoring Aktif</div>
                </div>
            </transition-group>
        </div>
        
        <div style="margin-top: auto; display: flex; gap: 5px;">
             <div v-for="(item, i) in dataAgenda" :key="i" 
                  style="width: 30px; height: 4px; background: white; opacity: 0.3; transition: 0.3s;"
                  :style="{ opacity: i === currentIndex ? '1' : '0.3', background: i === currentIndex ? 'var(--accent-gold)' : 'white' }">
             </div>
        </div>
    </div>

    <div class="ticker-fixed">
        <div class="ticker-lbl">NEWS INFO</div>
        <div class="ticker-view">
            <div class="ticker-txt">
                <span v-for="item in dataNews" :key="item.id" style="margin-right: 60px;">
                    <span style="color: var(--accent-gold);">///</span> {{ item.text_news }}
                </span>
                <span v-if="dataNews.length == 0" style="margin-right: 60px;">
                     SELAMAT DATANG DI DASHBOARD INFORMASI PUBLIK BIRO KEUANGAN...
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
        
        dataNews: [], dataAgenda: [],
        finance: { pagu: 15000000000, realisasi: 8500000000, sisa: 6500000000, persen: 56 },
        pnbp: { total: 1250000000 },
        jadwalSholat: { Subuh: '04:12', Dzuhur: '11:51', Ashar: '15:15', Maghrib: '17:58', Isya: '19:12' },
        nextPrayer: 'Ashar',
        
        // Logic Slide Agenda
        currentIndex: 0,
        currentAgenda: {}
    }

    createdVue = function() {
        setInterval(this.updateTime, 1000);
        this.getNews(); 
        this.getAgenda();
    }

    mountedVue = function() {
        setInterval(() => this.getNews(), <?= $news_refresh; ?> * 1000);
        setInterval(() => this.getAgenda(), <?= $agenda_refresh; ?> * 1000);

        // Auto Slide Agenda tiap 6 detik
        setInterval(() => {
            if(this.dataAgenda.length > 0) {
                this.currentIndex = (this.currentIndex + 1) % this.dataAgenda.length;
                this.currentAgenda = this.dataAgenda[this.currentIndex];
            }
        }, 6000);
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
            const days = ["MINGGU", "SENIN", "SELASA", "RABU", "KAMIS", "JUMAT", "SABTU"];
            const m = ["JAN", "FEB", "MAR", "APR", "MEI", "JUN", "JUL", "AGS", "SEP", "OKT", "NOV", "DES"];
            this.tanggal = `${days[d.getDay()]}, ${d.getDate()} ${m[d.getMonth()]} ${d.getFullYear()}`;
            
            const h = d.getHours();
            if(h<4) this.nextPrayer='Subuh'; else if(h<12) this.nextPrayer='Dzuhur';
            else if(h<15) this.nextPrayer='Ashar'; else if(h<18) this.nextPrayer='Maghrib';
            else if(h<19) this.nextPrayer='Isya'; else this.nextPrayer='Subuh';
        },
        
        // Helpers
        getDayNum: function(dateStr) { return dateStr ? new Date(dateStr).getDate() : new Date().getDate(); },
        getMonthName: function(dateStr) { 
            const m = ["JAN", "FEB", "MAR", "APR", "MEI", "JUN", "JUL", "AGS", "SEP", "OKT", "NOV", "DES"];
            return dateStr ? m[new Date(dateStr).getMonth()] : m[new Date().getMonth()]; 
        },
        isNow: function(timeStr) {
             const h = new Date().getHours();
             return parseInt(timeStr) === h;
        },

        getNews: function() { axios.get('<?= base_url() ?>/api/news/news').then(res => { if(res.data.status) this.dataNews = res.data.data; }).catch(e=>{}); },
        getAgenda: function() { 
            axios.get('<?= base_url() ?>/api/display/agenda').then(res => { 
                if(res.data.status && res.data.data.length > 0) {
                    this.dataAgenda = res.data.data;
                    // Fallback date
                    this.dataAgenda.forEach(item => { if(!item.waktu_tanggal) item.waktu_tanggal = new Date().toISOString().slice(0,10); });
                    // Set initial
                    this.currentAgenda = this.dataAgenda[0];
                }
            }).catch(e=>{}); 
        },
    }
</script>
<?php $this->endSection("js") ?>