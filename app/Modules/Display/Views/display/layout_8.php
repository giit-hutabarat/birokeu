<?php $this->section("style"); ?>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;800&family=Teko:wght@300;400;500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/weather-icons/2.0.12/css/weather-icons.min.css">
<link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">

<style>
    :root {
        --dark-bg: #121212;
        --dark-gradient: linear-gradient(135deg, #000000 0%, #1a1a1a 100%);
        --light-bg: #f8f9fa;
        --accent-gold: #D4AF37;
        --accent-red: #A31414;
        --text-dark: #333;
        --text-light: #fff;
    }

    /* BASE SETUP */
    html, body {
        height: 100vh; margin: 0; padding: 0;
        background: var(--light-bg);
        font-family: 'Montserrat', sans-serif;
        overflow: hidden; 
    }

    .wrapper {
        position: relative; width: 100vw; height: 100vh;
        overflow: hidden; display: flex;
    }

    /* === LAYER 1: DATA SIDE (KANAN - LIGHT) === */
    .layer-light {
        position: absolute; top: 0; right: 0; bottom: 0;
        width: 100%;
        background: var(--light-bg);
        color: var(--text-dark);
        display: flex; flex-direction: column;
        padding: 60px 60px 100px 60vw; 
        justify-content: center;
        z-index: 1;
    }

    .bg-pattern {
        position: absolute; top:0; left:0; width:100%; height:100%;
        background-image: 
            linear-gradient(rgba(200, 200, 200, 0.1) 1px, transparent 1px),
            linear-gradient(90deg, rgba(200, 200, 200, 0.1) 1px, transparent 1px);
        background-size: 40px 40px; 
        opacity: 0.6; pointer-events: none;
    }

    /* === LAYER 2: AGENDA SIDE (KIRI - DARK) === */
    .layer-dark {
        position: absolute; top: 0; left: 0; bottom: 0;
        width: 60%;
        background: var(--dark-gradient);
        color: var(--text-light);
        clip-path: polygon(0 0, 100% 0, 85% 100%, 0% 100%);
        padding: 40px 120px 80px 50px; 
        display: flex; flex-direction: column;
        z-index: 10;
        filter: drop-shadow(10px 0 20px rgba(0,0,0,0.5));
    }

    /* === HEADER & BRAND === */
    .brand-box { 
        margin-bottom: 30px; 
        display: flex; align-items: center; gap: 20px; 
        border-bottom: 1px solid rgba(255,255,255,0.1);
        padding-bottom: 15px;
    }
    .brand-logo-img { width: 80px; height: auto; filter: drop-shadow(0 0 10px rgba(212, 175, 55, 0.3)); }
    .brand-title { font-family: 'Teko', sans-serif; font-size: 3.5rem; line-height: 0.85; font-weight: 700; text-transform: uppercase; color: #fff; letter-spacing: 1px; }
    .brand-sub { font-size: 0.9rem; letter-spacing: 3px; color: var(--accent-gold); text-transform: uppercase; font-weight: 600; margin-top: 5px; }

    /* === MAIN DISPLAY AREA === */
    .main-display {
        flex: 1; display: flex; flex-direction: column; justify-content: flex-start;
        position: relative; padding-top: 20px;
    }
    
    .agenda-label { 
        font-size: 0.9rem; font-weight: 700; letter-spacing: 3px; color: #888; 
        text-transform: uppercase; margin-bottom: 20px; display: block;
        border-left: 3px solid var(--accent-gold); padding-left: 15px;
    }

    /* Transition Group Wrapper */
    .display-content { position: relative; width: 100%; min-height: 250px; }
    .ag-item { position: absolute; width: 100%; top: 0; } 

    /* Agenda Style */
    .date-badge { display: inline-flex; align-items: baseline; gap: 10px; margin-bottom: 5px; }
    .ag-date-big { font-family: 'Teko'; font-size: 6rem; line-height: 0.8; color: var(--accent-gold); text-shadow: 2px 2px 0px rgba(0,0,0,0.5); }
    .ag-date-month { font-size: 2rem; font-weight: 800; text-transform: uppercase; color: rgba(255,255,255,0.8); }
    .ag-title { font-size: 2.2rem; font-weight: 700; line-height: 1.2; margin-bottom: 20px; color: #fff; display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
    .ag-meta { display: flex; gap: 30px; font-size: 1.1rem; color: #ccc; background: rgba(255,255,255,0.05); padding: 10px 20px; border-radius: 8px; backdrop-filter: blur(5px); width: fit-content; }
    .ag-meta i { color: var(--accent-gold); margin-right: 8px; }

    /* Quote Style */
    .quote-icon { font-size: 4rem; color: var(--accent-gold); opacity: 0.4; line-height: 1; margin-bottom: 10px; }
    .quote-text { font-family: 'Montserrat', sans-serif; font-size: 1.8rem; font-style: italic; font-weight: 300; line-height: 1.4; color: #fff; }
    .quote-author { margin-top: 15px; font-size: 1rem; color: var(--accent-gold); text-transform: uppercase; letter-spacing: 2px; font-weight: 700; }

    /* === MODULE: UPCOMING AGENDA (PAGINATION STYLE) === */
    .upcoming-box {
        margin-top: auto; 
        padding-top: 20px;
        border-top: 1px solid rgba(255,255,255,0.1);
        padding-right: 50px;
    }
    .up-label { font-size: 0.8rem; color: #666; letter-spacing: 2px; font-weight: 700; margin-bottom: 15px; text-transform: uppercase; }
    
    .up-list-container {
        min-height: 350px; /* Dipertinggi sedikit karena 4 items */
        position: relative;
    }
    
    /* Pagination Dots */
    .up-pagination {
        display: flex; gap: 5px; justify-content: flex-end; margin-bottom: 10px;
    }
    .dot { width: 8px; height: 8px; background: rgba(255,255,255,0.2); border-radius: 50%; transition: 0.3s; }
    .dot.active { background: var(--accent-gold); transform: scale(1.2); }

    .up-list { display: flex; flex-direction: column; gap: 12px; } /* Gap diperkecil biar muat 4 */
    .up-item { display: flex; align-items: center; gap: 15px; opacity: 0.9; }
    
    .up-date-box { 
        background: rgba(212, 175, 55, 0.15); border: 1px solid rgba(212, 175, 55, 0.3);
        color: var(--accent-gold); padding: 5px 10px; border-radius: 4px; 
        text-align: center; min-width: 60px;
    }
    .up-date-box.empty { background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); color: #666; }

    .up-d-num { font-family: 'Teko'; font-size: 1.4rem; line-height: 1; font-weight: 600; }
    .up-d-mo { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; }
    .up-content { flex: 1; overflow: hidden; } 
    
    /* Horizontal Marquee (Judul Panjang) */
    .h-marquee-wrap {
        overflow: hidden; 
        white-space: nowrap; 
        max-width: 100%; 
        position: relative;
        /* FIX: Huruf awal gak ketutup lagi. Masking cuma di kanan */
        mask-image: linear-gradient(to right, black 0%, black 95%, transparent 100%);
        -webkit-mask-image: linear-gradient(to right, black 0%, black 95%, transparent 100%);
    }
    .h-marquee-content {
        display: inline-block; padding-left: 0;
        /* FIX: Speed diperlambat jadi 35s */
        animation: scrollLeft 35s linear infinite; 
    }
    .no-anim { animation: none; }

    @keyframes scrollLeft {
        0% { transform: translateX(0); }
        15% { transform: translateX(0); } /* Diam lebih lama di awal */
        100% { transform: translateX(-100%); }
    }
    
    .up-title { font-size: 1rem; color: #fff; font-weight: 600; line-height: 1.2; margin-bottom: 2px; }
    .up-time { font-size: 0.85rem; color: #999; }

    /* Transitions Slide Up (Pagination) */
    .slide-enter-active, .slide-leave-active { transition: all 0.8s cubic-bezier(0.2, 1, 0.3, 1); }
    .slide-enter-from { opacity: 0; transform: translateY(30px); }
    .slide-leave-to { opacity: 0; transform: translateY(-30px); }

    /* FIX: Slide Up diperlambat jadi 1.5s */
    .slide-up-enter-active, .slide-up-leave-active { transition: all 1.5s cubic-bezier(0.4, 0, 0.2, 1); }
    .slide-up-enter { opacity: 0; transform: translateY(20px); }
    .slide-up-leave-to { opacity: 0; transform: translateY(-20px); }

    /* RIGHT SIDE WIDGETS */
    .finance-row { display: flex; gap: 40px; margin-bottom: 40px; }
    .stat-card { flex: 1; }
    .stat-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 10px; }
    .stat-label { font-size: 0.85rem; font-weight: 700; text-transform: uppercase; color: #999; letter-spacing: 1px; }
    .stat-value { font-family: 'Teko'; font-size: 4.5rem; font-weight: 500; line-height: 0.8; color: #222; }
    .bar-bg { width: 100%; height: 8px; background: #e0e0e0; border-radius: 20px; overflow: hidden; }
    .bar-fill { height: 100%; background: linear-gradient(90deg, #222, #555); width: 0; transition: width 1.5s ease; border-radius: 20px; }
    .bar-fill.gold { background: linear-gradient(90deg, #D4AF37, #FDD835); }
    .stat-footer { margin-top: 8px; font-size: 0.9rem; color: #666; font-weight: 500; display: flex; justify-content: space-between;}

    .utility-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; }
    .clock-widget { border-left: 5px solid var(--accent-red); padding-left: 20px; }
    .clock-time { font-family: 'Teko'; font-size: 5rem; line-height: 0.8; color: #222; }
    .clock-date { font-size: 1rem; font-weight: 700; text-transform: uppercase; color: #666; margin-top: 5px; letter-spacing: 1px;}
    .weather-widget { display: flex; align-items: center; gap: 15px; }
    .temp-val { font-size: 2.5rem; font-weight: 800; color: #222; }
    .loc-val { font-weight: 600; text-transform: uppercase; color: #888; font-size: 0.8rem; }

    .sholat-list-mini {
        grid-column: 1 / -1; margin-top: 30px; display: flex; justify-content: space-between; 
        background: #fff; padding: 15px 25px; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
    .sl-item { text-align: center; opacity: 0.4; transition: 0.3s; position: relative;}
    .sl-item.active { opacity: 1; transform: translateY(-3px); }
    .sl-item.active .sl-name { color: var(--accent-red); font-weight: 800; }
    .sl-name { font-size: 0.75rem; text-transform: uppercase; margin-bottom: 3px; font-weight: 600; }
    .sl-time { font-family: 'Teko'; font-size: 1.6rem; line-height: 1; color: #222; }

    /* TICKER */
    .ticker-fixed {
        position: absolute; bottom: 0; left: 0; width: 100%; height: 60px;
        background: #000; color: white;
        display: flex; align-items: center; z-index: 50;
        border-top: 4px solid var(--accent-gold);
    }
    .ticker-lbl { 
        background: var(--accent-gold); color: #000; height: 100%; padding: 0 40px; 
        font-weight: 900; font-size: 1.2rem; display: flex; align-items: center;
        clip-path: polygon(0 0, 100% 0, 85% 100%, 0% 100%); padding-right: 70px; z-index: 20; font-family: 'Teko'; letter-spacing: 2px;
    }
    .ticker-view { flex: 1; overflow: hidden; height: 100%; display: flex; align-items: center; }
    .ticker-txt { white-space: nowrap; animation: marquee 35s linear infinite; font-size: 1.1rem; font-weight: 500; text-transform: uppercase; letter-spacing: 1px; }
    @keyframes marquee { 0% { transform: translateX(0); } 100% { transform: translateX(-100%); } }

    @media screen and (max-width: 1024px) {
        .wrapper { flex-direction: column; overflow-y: auto; height: auto; padding-bottom: 70px; }
        .layer-dark { width: 100%; clip-path: none; height: auto; min-height: 600px; padding: 40px; }
        .layer-light { width: 100%; padding: 40px; }
        .ag-item { position: relative; top: auto; }
        .upcoming-box { margin-top: 50px; }
        .ticker-fixed { position: fixed; bottom: 0; }
    }
</style>
<?php $this->endSection("style") ?>

<div class="wrapper">
    
    <div class="layer-light">
        <div class="bg-pattern"></div>
        <div class="finance-row">
            <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-label">Realisasi Anggaran</span>
                    <div class="stat-value">{{ finance.persen }}<span style="font-size: 2.5rem">%</span></div>
                </div>
                <div class="bar-bg"><div class="bar-fill" :style="{ width: finance.persen + '%' }"></div></div>
                <div class="stat-footer">
                    <span>Terpakai: {{ formatRupiahShort(finance.realisasi) }}</span>
                    <span>Pagu: {{ formatRupiahShort(finance.pagu) }}</span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-header">
                    <span class="stat-label">Total PNBP</span>
                    <div class="stat-value" style="color: var(--accent-gold);">{{ formatRupiahShort(pnbp.total) }}</div>
                </div>
                <div class="bar-bg"><div class="bar-fill gold" style="width: 35%;"></div></div>
                <div class="stat-footer">
                    <span>Update Terkini</span>
                    <i class="mdi mdi-chart-line" style="color: green;"></i>
                </div>
            </div>
        </div>
        <div class="utility-grid">
            <div class="clock-widget">
                <div class="clock-time">{{ jam }}</div>
                <div class="clock-date">{{ tanggal }}</div>
            </div>
            
            <div class="weather-widget">
                <i :class="'wi ' + weather.iconClass + ' text-warning'" style="font-size: 4rem;"></i>
                <div>
                    <div class="temp-val">{{ weather.temp }}°C</div>
                    <div class="loc-val">
                        <i class="mdi mdi-map-marker"></i> {{ weather.city }}
                    </div>
                </div>
            </div>

            <div class="sholat-list-mini">
                <div v-for="(time, name) in jadwalSholat" :key="name" class="sl-item" :class="{ 'active': name === nextPrayer }">
                    <div class="sl-name">{{ name }}</div>
                    <div class="sl-time">{{ time }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="layer-dark">
        <div class="brand-box">
            <img src="<?= base_url('assets/images/logo_kejaksaan.png') ?>" class="brand-logo-img" alt="Logo">
            <div class="brand-text-col">
                <div class="brand-title">BIRO KEUANGAN</div>
                <span class="brand-sub">KEJAKSAAN AGUNG REPUBLIK INDONESIA</span>
            </div>
        </div>

        <div class="main-display">
            <span class="agenda-label">
                {{ filteredAgenda.length > 0 ? 'AGENDA PRIORITAS HARI INI' : 'MOTIVASI HARI INI' }}
            </span>

            <div class="display-content">
                <transition-group name="slide" mode="out-in">
                    
                    <div v-if="filteredAgenda.length > 0" :key="'agenda-'+currentIndex" class="ag-item">
                        <div class="date-badge">
                            <div class="ag-date-big">{{ getDayNum(currentAgenda.tgl_agenda) }}</div>
                            <span class="ag-date-month">{{ getMonthName(currentAgenda.tgl_agenda) }}</span>
                        </div>
                        <div class="ag-title">{{ currentAgenda.nama_agenda }}</div>
                        <div class="ag-meta">
                            <span><i class="mdi mdi-clock-outline"></i> {{ currentAgenda.waktu }} WIB</span>
                            <span style="border-left: 1px solid #555; padding-left: 15px; margin-left: -15px;"></span>
                            <span><i class="mdi mdi-map-marker"></i> {{ currentAgenda.tempat_agenda }}</span>
                        </div>
                    </div>
                    
                    <div v-else :key="'quote-'+quoteIndex" class="ag-item">
                        <i class="mdi mdi-format-quote-close quote-icon"></i>
                        <div class="quote-text">"{{ currentQuote.text }}"</div>
                        <div class="quote-author">— {{ currentQuote.author }}</div>
                    </div>

                </transition-group>
            </div>
        </div>

        <div class="upcoming-box">
            <div style="display:flex; justify-content:space-between; align-items:center;">
                <div class="up-label">AGENDA HARI KERJA BERIKUTNYA</div>
                <div class="up-pagination" v-if="upcomingAgenda.length > itemsPerPage">
                    <div v-for="n in Math.ceil(upcomingAgenda.length / itemsPerPage)" :key="n" 
                         class="dot" :class="{ active: upcomingPage === (n-1) }"></div>
                </div>
            </div>
            
            <div class="up-list-container">
                <transition-group name="slide-up" tag="div" class="up-list" v-if="upcomingAgenda.length > 0">
                    
                    <div class="up-item" v-for="(item, idx) in getPaginatedUpcoming()" :key="item.id || idx">
                        <div class="up-date-box">
                            <div class="up-d-num">{{ getDayNum(item.tgl_agenda) }}</div>
                            <div class="up-d-mo">{{ getMonthNameShort(item.tgl_agenda) }}</div>
                        </div>
                        
                        <div class="up-content">
                            <div class="h-marquee-wrap">
                                <div class="h-marquee-content" :class="{ 'no-anim': item.nama_agenda.length <= 40 }">
                                    <div class="up-title">{{ item.nama_agenda }}</div>
                                </div>
                            </div>
                            <div class="up-time">
                                <i class="mdi mdi-clock-outline" style="font-size:0.8rem; margin-right:5px;"></i> 
                                {{ item.waktu }} WIB - {{ item.tempat_agenda }}
                            </div>
                        </div>
                    </div>

                </transition-group>

                <div class="up-list" v-else>
                    <div class="up-item" v-for="(dateStr, idx) in listHariKosong.slice(0, 4)" :key="idx" style="opacity: 0.5;">
                        <div class="up-date-box empty">
                            <div class="up-d-num">{{ getDayNum(dateStr) }}</div>
                            <div class="up-d-mo">{{ getMonthNameShort(dateStr) }}</div>
                        </div>
                        <div class="up-content">
                            <div class="up-title" style="color: #777;">-</div>
                            <div class="up-time" style="color: #666;">Tidak ada kegiatan</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="ticker-fixed">
        <div class="ticker-lbl">INFO TERKINI</div>
        <div class="ticker-view">
            <div class="ticker-txt">
                <span v-for="item in dataNews" :key="item.id" style="margin-right: 80px;">
                    <i class="mdi mdi-star" style="color: var(--accent-gold);"></i> {{ item.text_news }}
                </span>
                <span v-if="dataNews.length == 0" style="margin-right: 60px;">
                     SELAMAT DATANG DI DASHBOARD PELAYANAN DAN INFORMASI BIRO KEUANGAN KEJAKSAAN AGUNG RI...
                </span>
            </div>
        </div>
    </div>

</div>

<?php $this->section("js") ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2.6.14"></script>
<script>
    function addZero(n) { return (n < 10 ? '0' : '') + n; }

    dataVue = {
        ...dataVue,
        jam: "", tanggal: "",
        dataNews: [], 
        
        filteredAgenda: [], 
        upcomingAgenda: [], 
        listHariKosong: [], 
        
        // PAGINATION LOGIC (FIX: 4 Items)
        upcomingPage: 0,
        itemsPerPage: 4,

        currentAgenda: {},
        currentIndex: 0,

        // WEATHER DATA
        weather: {
            temp: 0, city: "Memuat...", iconClass: "wi-day-sunny", desc: "" 
        },

        quotes: [
            { text: "Integritas adalah melakukan hal yang benar, bahkan ketika tidak ada orang yang melihat.", author: "C.S. Lewis" },
            { text: "Bekerja keraslah dalam kesunyian, biarkan kesuksesanmu yang membuat keributan.", author: "Inspirasi" },
            { text: "Pelayanan publik adalah amanah, bukan sekadar pekerjaan rutin.", author: "Birokrasi Bersih" },
            { text: "Waktu adalah modal utama. Gunakan dengan bijak untuk hasil terbaik.", author: "Manajemen Waktu" }
        ],
        currentQuote: {},
        quoteIndex: 0,

        finance: { pagu: 15000000000, realisasi: 8500000000, sisa: 6500000000, persen: 56 },
        pnbp: { total: 1250000000 },
        jadwalSholat: { Subuh: '04:12', Dzuhur: '11:51', Ashar: '15:15', Maghrib: '17:58', Isya: '19:12' },
        nextPrayer: 'Ashar',
    }

    createdVue = function() {
        setInterval(this.updateTime, 1000);
        this.getNews(); 
        this.getAgenda();
        this.getCuaca(); 
        this.currentQuote = this.quotes[0];
    }

    mountedVue = function() {
        setInterval(() => this.getNews(), <?= $news_refresh; ?> * 1000);
        setInterval(() => this.getAgenda(), <?= $agenda_refresh; ?> * 1000);
        setInterval(() => this.getCuaca(), 900000); 

        this.generateNext7Days();
        setInterval(() => this.generateNext7Days(), 3600000);

        // SLIDE UTAMA
        setInterval(() => {
            if(this.filteredAgenda.length > 0) {
                this.currentIndex = (this.currentIndex + 1) % this.filteredAgenda.length;
                this.currentAgenda = this.filteredAgenda[this.currentIndex];
            } else {
                this.quoteIndex = (this.quoteIndex + 1) % this.quotes.length;
                this.currentQuote = this.quotes[this.quoteIndex];
            }
        }, 8000); 

        // SLIDE BAWAH (PAGINATION)
        setInterval(() => {
            if (this.upcomingAgenda.length > this.itemsPerPage) {
                const totalPages = Math.ceil(this.upcomingAgenda.length / this.itemsPerPage);
                this.upcomingPage = (this.upcomingPage + 1) % totalPages;
            } else {
                this.upcomingPage = 0;
            }
        }, 8000); // 8 Detik per halaman
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
        getDayNum: function(dateStr) { return dateStr ? new Date(dateStr).getDate() : new Date().getDate(); },
        getMonthName: function(dateStr) { 
            const m = ["JAN", "FEB", "MAR", "APR", "MEI", "JUN", "JUL", "AGS", "SEP", "OKT", "NOV", "DES"];
            return dateStr ? m[new Date(dateStr).getMonth()] : m[new Date().getMonth()]; 
        },
        getMonthNameShort: function(dateStr) { 
            const m = ["JAN", "FEB", "MAR", "APR", "MEI", "JUN", "JUL", "AGS", "SEP", "OKT", "NOV", "DES"];
            return dateStr ? m[new Date(dateStr).getMonth()] : m[new Date().getMonth()]; 
        },
        
        generateNext7Days: function() {
            let list = []; let d = new Date(); let added = 0; let i = 1;
            while(added < 5) {
                let next = new Date(d); next.setDate(d.getDate() + i);
                let dayOfWeek = next.getDay(); 
                if(dayOfWeek !== 0 && dayOfWeek !== 6) {
                    let year = next.getFullYear(); let month = String(next.getMonth() + 1).padStart(2, '0'); let day = String(next.getDate()).padStart(2, '0');
                    list.push(`${year}-${month}-${day}`); added++;
                }
                i++;
            }
            this.listHariKosong = list;
        },

        getPaginatedUpcoming: function() {
            const start = this.upcomingPage * this.itemsPerPage;
            const end = start + this.itemsPerPage;
            return this.upcomingAgenda.slice(start, end);
        },

        getNews: function() { axios.get('<?= base_url() ?>/api/news/news').then(res => { if(res.data.status) this.dataNews = res.data.data; }).catch(e=>{}); },
        
        getAgenda: function() { 
            axios.get('<?= base_url() ?>/api/display/agenda').then(res => { 
                let rawData = [];
                if(res.data.status && Array.isArray(res.data.data)) {
                    rawData = res.data.data;
                }

                const d = new Date();
                const todayStr = `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, '0')}-${String(d.getDate()).padStart(2, '0')}`; 
                const limit = new Date(); limit.setDate(d.getDate() + 7); 
                const limitStr = `${limit.getFullYear()}-${String(limit.getMonth() + 1).padStart(2, '0')}-${String(limit.getDate()).padStart(2, '0')}`;

                this.filteredAgenda = rawData.filter(item => item.tgl_agenda === todayStr);

                this.upcomingAgenda = rawData
                    .filter(item => {
                        const dateItem = new Date(item.tgl_agenda);
                        const dayNum = dateItem.getDay(); 
                        return item.tgl_agenda > todayStr && 
                               item.tgl_agenda <= limitStr && 
                               dayNum !== 6 && dayNum !== 0; 
                    })
                    .sort((a,b) => new Date(a.tgl_agenda) - new Date(b.tgl_agenda));
                
                if(this.filteredAgenda.length > 0) this.currentAgenda = this.filteredAgenda[0];

            }).catch(e=>{ 
                console.log("Error mengambil data agenda:", e); 
            }); 
        },

        getCuaca: function() {
            axios.get('<?= base_url() ?>/api/display/cuaca').then(res => {
                if(res.data.status && res.data.data) {
                    const w = res.data.data;
                    this.weather.temp = Math.round(w.main.temp);
                    
                    let kota = w.name.toUpperCase();
                    kota = kota.replace("JAKARTA SELATAN", "JAKARTA SEL.");
                    this.weather.city = kota;

                    const iconCode = w.weather[0].icon;
                    this.weather.iconClass = this.mapIcon(iconCode);
                    this.weather.desc = w.weather[0].main; 
                }
            }).catch(e => console.log("Gagal memuat cuaca"));
        },

        mapIcon: function(code) {
            const map = {
                '01d': 'wi-day-sunny',       '01n': 'wi-night-clear',
                '02d': 'wi-day-cloudy',      '02n': 'wi-night-alt-cloudy',
                '03d': 'wi-cloud',           '03n': 'wi-cloud',
                '04d': 'wi-cloudy',          '04n': 'wi-cloudy',
                '09d': 'wi-showers',         '09n': 'wi-showers',
                '10d': 'wi-rain',            '10n': 'wi-rain',
                '11d': 'wi-thunderstorm',    '11n': 'wi-thunderstorm',
                '13d': 'wi-snow',            '13n': 'wi-snow',
                '50d': 'wi-fog',             '50n': 'wi-fog'
            };
            return map[code] || 'wi-day-sunny'; 
        }
    }
</script>
<?php $this->endSection("js") ?>