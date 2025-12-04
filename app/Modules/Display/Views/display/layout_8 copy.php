<?php $this->section("style"); ?>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700;900&family=Teko:wght@300;400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/weather-icons/2.0.12/css/weather-icons.min.css">

<style>
    :root {
        --dark-bg: #0f0f0f;
        --light-bg: #f4f4f4;
        --accent-gold: #FFC107;
        --accent-red: #D32F2F;
        --text-dark: #222;
        --text-light: #fff;
    }

    /* BASE SETUP */
    html, body {
        height: 100vh; margin: 0; padding: 0;
        background: var(--light-bg);
        font-family: 'Montserrat', sans-serif;
        overflow: hidden; /* Desktop default no scroll */
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
        width: 100%; /* Full width, tapi nanti ketutup layer dark */
        background: var(--light-bg);
        color: var(--text-dark);
        display: flex; flex-direction: column;
        /* Padding Kiri GEDE biar gak ketutup diagonal hitam */
        padding: 40px 40px 80px 55vw; 
        justify-content: center;
        z-index: 1;
    }

    /* Background Dot Pattern */
    .bg-pattern {
        position: absolute; top:0; left:0; width:100%; height:100%;
        background-image: radial-gradient(#ccc 1px, transparent 1px);
        background-size: 20px 20px; opacity: 0.5; pointer-events: none;
    }

    /* === LAYER 2: DARK SIDE (KIRI - AGENDA) === */
    .layer-dark {
        position: absolute;
        top: 0; left: 0; bottom: 0;
        width: 55%; /* Lebar area hitam */
        background: var(--dark-bg);
        color: var(--text-light);
        /* KUNCI VISUAL DIAGONAL */
        clip-path: polygon(0 0, 100% 0, 85% 100%, 0% 100%);
        padding: 40px 100px 80px 40px; /* Padding kanan agak besar biar teks gak kena potong */
        display: flex; flex-direction: column;
        z-index: 10;
        box-shadow: 10px 0 50px rgba(0,0,0,0.5);
    }

    /* === MODULE STYLING === */

    /* 1. Header */
    .brand-box { margin-bottom: 40px; }
    .brand-title { font-family: 'Teko', sans-serif; font-size: 3.5rem; line-height: 0.8; text-transform: uppercase; margin: 0; color: #fff; }
    .brand-sub { font-size: 0.9rem; letter-spacing: 2px; color: var(--accent-gold); text-transform: uppercase; display: block; margin-top: 5px; }

    /* 2. AGENDA (Motion Focus) */
    .agenda-container {
        flex: 1; display: flex; flex-direction: column; justify-content: center;
        position: relative; overflow: hidden;
    }
    .agenda-label { 
        font-size: 0.8rem; font-weight: 700; letter-spacing: 2px; color: #666; 
        text-transform: uppercase; margin-bottom: 20px; border-bottom: 1px solid #333; 
        padding-bottom: 10px; display: inline-block; width: 100%;
    }
    
    .ag-item { position: absolute; width: 100%; top: 20%; } 
    
    .ag-date-big {
        font-family: 'Teko'; font-size: 7rem; line-height: 0.8; 
        color: var(--accent-gold); margin-bottom: 0;
        text-shadow: 0 0 30px rgba(255, 193, 7, 0.2);
    }
    .ag-date-month {
        font-size: 1.5rem; font-weight: 700; text-transform: uppercase; 
        color: #fff; margin-bottom: 20px; display: block; letter-spacing: 3px;
    }
    .ag-title {
        font-size: 2.5rem; font-weight: 700; line-height: 1.1; margin-bottom: 20px;
        color: #fff;
    }
    .ag-meta {
        display: flex; gap: 30px; font-size: 1.1rem; color: #bbb; align-items: center;
    }

    /* VUE TRANSITION */
    .slide-enter-active, .slide-leave-active { transition: all 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
    .slide-enter-from { opacity: 0; transform: translateY(50px); }
    .slide-leave-to { opacity: 0; transform: translateY(-50px); }

    /* 3. FINANCE (Light Side) */
    .finance-row {
        display: flex; gap: 40px; margin-bottom: 50px;
    }
    .stat-card { flex: 1; }
    .stat-label { font-size: 0.8rem; font-weight: 700; text-transform: uppercase; color: #888; letter-spacing: 1px; display: block; margin-bottom: 5px; }
    .stat-value { font-family: 'Teko'; font-size: 4.5rem; font-weight: 600; line-height: 0.8; color: var(--text-dark); display: block; }
    .stat-sub { font-size: 0.9rem; color: #555; margin-top: 10px; font-weight: 500; display: block; border-top: 2px solid #ddd; padding-top: 5px; }
    
    /* Bar Chart Minimalist */
    .bar-container { width: 100%; height: 8px; background: #e0e0e0; margin-top: 15px; position: relative; border-radius: 4px; overflow: hidden; }
    .bar-fill { height: 100%; background: var(--text-dark); width: 0; transition: width 1.5s ease; border-radius: 4px; }

    /* 4. UTILITY (Light Side) */
    .utility-grid {
        display: grid; grid-template-columns: 1fr 1fr; gap: 30px;
    }
    .clock-widget { border-left: 5px solid var(--text-dark); padding-left: 20px; }
    .clock-time { font-family: 'Teko'; font-size: 4rem; line-height: 0.8; font-weight: 600; display: block; }
    .clock-date { font-size: 0.9rem; font-weight: 700; text-transform: uppercase; color: #555; }

    .weather-widget { display: flex; align-items: center; gap: 15px; }
    
    .sholat-list-mini {
        grid-column: 1 / -1; margin-top: 30px;
        display: flex; justify-content: space-between; border-top: 2px solid #ddd; padding-top: 20px;
    }
    .sl-item { text-align: center; opacity: 0.5; transition: 0.3s; }
    .sl-item.active { opacity: 1; transform: scale(1.1); font-weight: bold; color: var(--accent-red); }
    .sl-name { font-size: 0.7rem; text-transform: uppercase; margin-bottom: 3px; display: block; }
    .sl-time { font-family: 'Teko'; font-size: 1.5rem; line-height: 1; }

    /* 5. TICKER (BOTTOM) */
    .ticker-fixed {
        position: absolute; bottom: 0; left: 0; width: 100%; height: 60px;
        background: #222; color: white;
        display: flex; align-items: center; z-index: 50;
    }
    .ticker-lbl { 
        background: var(--accent-gold); color: black; height: 100%; padding: 0 40px; 
        font-weight: 900; font-size: 1.2rem; display: flex; align-items: center;
        /* Clip path miring yang serasi sama layout atas */
        clip-path: polygon(0 0, 100% 0, 85% 100%, 0% 100%); 
        padding-right: 60px; z-index: 20;
    }
    .ticker-view { flex: 1; overflow: hidden; height: 100%; display: flex; align-items: center; position: relative; }
    .ticker-txt { 
        white-space: nowrap; animation: marquee 30s linear infinite; 
        font-size: 1.2rem; font-weight: 500; text-transform: uppercase;
        padding-left: 100%; display: inline-block;
    }
    
    @keyframes marquee { 0% { transform: translateX(0); } 100% { transform: translateX(-100%); } }

    /* =========================================
       RESPONSIVE (MOBILE & TABLET)
       ========================================= */
    @media screen and (max-width: 1024px) {
        html, body { overflow-y: auto; height: auto; background: var(--light-bg); }
        
        .wrapper { 
            flex-direction: column; display: block; height: auto; 
            padding-bottom: 60px; /* Space for ticker */
        }

        /* 1. Dark Layer (Agenda) jadi Header Atas */
        .layer-dark {
            position: relative; width: 100%; height: auto; min-height: 450px;
            clip-path: none; /* Hilangkan diagonal */
            padding: 30px;
            border-bottom: 5px solid var(--accent-gold);
            box-shadow: none;
        }

        /* 2. Light Layer (Data) jadi Content Bawah */
        .layer-light {
            position: relative; width: 100%; height: auto;
            padding: 30px;
        }
        
        /* Adjust Fonts Mobile */
        .brand-title { font-size: 2rem; }
        .ag-date-big { font-size: 5rem; }
        .ag-title { font-size: 1.8rem; }
        .ag-item { position: relative; top: auto; margin-bottom: 20px; } /* Disable absolute di mobile */
        
        /* Layout Grid Mobile */
        .finance-row { flex-direction: column; gap: 30px; margin-bottom: 30px; }
        .utility-grid { grid-template-columns: 1fr; gap: 30px; }
        
        .clock-widget { border-left: none; padding-left: 0; text-align: left; border-bottom: 1px solid #ddd; padding-bottom: 20px; }
        .weather-widget { border-bottom: 1px solid #ddd; padding-bottom: 20px; }
        
        .sholat-list-mini { overflow-x: auto; justify-content: start; gap: 20px; padding-bottom: 10px; }
        .sl-item { min-width: 60px; }

        /* Ticker Mobile */
        .ticker-fixed { position: fixed; bottom: 0; height: 50px; }
        .ticker-lbl { font-size: 0.9rem; padding: 0 15px; clip-path: none; width: auto; padding-right: 15px; }
        .ticker-txt { font-size: 0.9rem; }
    }
</style>
<?php $this->endSection("style") ?>

<div class="wrapper">
    
    <div class="layer-light">
        <div class="bg-pattern"></div>
        
        <div class="finance-row">
            <div class="stat-card">
                <span class="stat-label">Realisasi Anggaran</span>
                <div class="stat-value">{{ finance.persen }}<span style="font-size: 2rem">%</span></div>
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
                <i class="wi wi-day-sunny text-warning" style="font-size: 4rem;"></i>
                <div>
                    <div style="font-size: 2.5rem; font-weight: 700;">29°C</div>
                    <div style="text-transform: uppercase; font-size: 0.8rem; letter-spacing: 1px; font-weight: 600; color: #777;">Jakarta Sel.</div>
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
                    <div class="ag-date-big">{{ getDayNum(currentAgenda.waktu_tanggal) }}</div>
                    <span class="ag-date-month">{{ getMonthName(currentAgenda.waktu_tanggal) }}</span>
                    
                    <div class="ag-title">
                        {{ currentAgenda.nama_agenda }} 
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
    </div>

    <div class="ticker-fixed">
        <div class="ticker-lbl">NEWS INFO</div>
        <div class="ticker-view">
            <div class="ticker-txt">
                <span v-for="item in dataNews" :key="item.id" style="margin-right: 60px;">
                    <span style="color: var(--accent-gold);">///</span> {{ item.text_news }}
                </span>
                <span v-if="dataNews.length == 0" style="margin-right: 60px;">
                     SELAMAT DATANG DI DASHBOARD PELAYANAN DAN INFORMASI BIRO KEUANGAN...
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
            if(num >= 1000000) return (num/1000000).toFixed(1) + ' Jt';
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