<?php $this->section("style"); ?>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;800&family=Teko:wght@300;400;500;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/weather-icons/2.0.12/css/weather-icons.min.css">
<link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">

<style>
    :root {
        --dark-bg: #121212;
        --dark-gradient: linear-gradient(135deg, #000000 0%, #1a1a1a 100%);
        --light-bg: #f8f9fa;
        --accent-gold: #D4AF37; /* Emas yang lebih elegan (Metallic Gold) */
        --accent-red: #A31414; /* Merah Kejaksaan yang lebih dalam */
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
        /* Padding disesuaikan supaya tidak tertutup layer dark */
        padding: 60px 60px 100px 60vw; 
        justify-content: center;
        z-index: 1;
    }

    /* Background Pattern Halus */
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
        width: 60%; /* Sedikit diperlebar */
        background: var(--dark-gradient);
        color: var(--text-light);
        /* Diagonal Cut yang lebih tajam */
        clip-path: polygon(0 0, 100% 0, 85% 100%, 0% 100%);
        padding: 50px 120px 80px 50px; 
        display: flex; flex-direction: column;
        z-index: 10;
        /* Shadow drop filter untuk efek kedalaman di atas light layer */
        filter: drop-shadow(10px 0 20px rgba(0,0,0,0.5));
    }

    /* === HEADER WITH LOGO (REQUEST USER) === */
    .brand-box { 
        margin-bottom: 50px; 
        display: flex; 
        align-items: center; /* Center Vertikal */
        gap: 25px; /* Jarak Logo dan Teks */
        border-bottom: 1px solid rgba(255,255,255,0.1);
        padding-bottom: 20px;
    }

    /* Logo Styling */
    .brand-logo-img {
        width: 100px; /* Ukuran Logo */
        height: auto;
        filter: drop-shadow(0 0 10px rgba(212, 175, 55, 0.3)); /* Glow Emas Halus */
    }

    .brand-text-col {
        display: flex; flex-direction: column;
    }

    .brand-title { 
        font-family: 'Teko', sans-serif; 
        font-size: 4rem; 
        line-height: 0.85; 
        font-weight: 700;
        text-transform: uppercase; 
        color: #fff;
        letter-spacing: 1px;
    }
    
    .brand-sub { 
        font-size: 1rem; 
        letter-spacing: 4px; 
        color: var(--accent-gold); 
        text-transform: uppercase; 
        font-weight: 600;
        margin-top: 5px; 
    }

    /* === AGENDA STYLING === */
    .agenda-container {
        flex: 1; display: flex; flex-direction: column; justify-content: center;
        position: relative;
    }
    
    .agenda-label { 
        font-size: 0.9rem; font-weight: 700; letter-spacing: 3px; color: #888; 
        text-transform: uppercase; margin-bottom: 30px; display: block;
        border-left: 3px solid var(--accent-gold); padding-left: 15px;
    }

    .ag-item { position: absolute; width: 100%; top: 15%; } 

    /* Tanggal yang menonjol */
    .date-badge {
        display: inline-flex;
        align-items: baseline;
        gap: 10px;
        margin-bottom: 10px;
    }
    .ag-date-big {
        font-family: 'Teko'; font-size: 8rem; line-height: 0.8; 
        color: var(--accent-gold); 
        text-shadow: 2px 2px 0px rgba(0,0,0,0.5);
    }
    .ag-date-month {
        font-size: 2.5rem; font-weight: 800; text-transform: uppercase; 
        color: rgba(255,255,255,0.8);
    }

    .ag-title {
        font-size: 2.8rem; font-weight: 700; line-height: 1.2; margin-bottom: 30px;
        color: #fff;
        /* Line clamp untuk membatasi text kepanjangan */
        display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;
    }
    
    .ag-meta {
        display: flex; gap: 40px; font-size: 1.2rem; color: #ccc; 
        background: rgba(255,255,255,0.05);
        padding: 15px 25px; border-radius: 8px;
        backdrop-filter: blur(5px);
        width: fit-content;
    }
    .ag-meta i { color: var(--accent-gold); margin-right: 10px; }

    /* Transitions */
    .slide-enter-active, .slide-leave-active { transition: all 0.8s cubic-bezier(0.2, 1, 0.3, 1); }
    .slide-enter-from { opacity: 0; transform: translateY(30px); }
    .slide-leave-to { opacity: 0; transform: translateY(-30px); }

    /* === RIGHT SIDE (FINANCE & STATS) === */
    .finance-row { display: flex; gap: 50px; margin-bottom: 60px; }
    
    .stat-card { flex: 1; }
    .stat-header { display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 10px; }
    .stat-label { font-size: 0.85rem; font-weight: 700; text-transform: uppercase; color: #999; letter-spacing: 1px; }
    .stat-value { font-family: 'Teko'; font-size: 5rem; font-weight: 500; line-height: 0.8; color: #222; }
    
    /* Progress Bar Modern */
    .bar-bg { width: 100%; height: 10px; background: #e0e0e0; border-radius: 20px; overflow: hidden; position: relative; }
    .bar-fill { height: 100%; background: linear-gradient(90deg, #222, #555); width: 0; transition: width 1.5s ease; border-radius: 20px; }
    .bar-fill.gold { background: linear-gradient(90deg, #D4AF37, #FDD835); }

    .stat-footer { margin-top: 10px; font-size: 1rem; color: #666; font-weight: 500; display: flex; justify-content: space-between;}

    /* Utility Widgets */
    .utility-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; }
    
    .clock-widget { border-left: 6px solid var(--accent-red); padding-left: 25px; }
    .clock-time { font-family: 'Teko'; font-size: 5.5rem; line-height: 0.8; color: #222; }
    .clock-date { font-size: 1.1rem; font-weight: 700; text-transform: uppercase; color: #666; margin-top: 5px; letter-spacing: 1px;}

    .weather-widget { display: flex; align-items: center; gap: 20px; }
    .temp-val { font-size: 3rem; font-weight: 800; color: #222; }
    .loc-val { font-weight: 600; text-transform: uppercase; color: #888; font-size: 0.9rem; }

    /* Sholat List */
    .sholat-list-mini {
        grid-column: 1 / -1; margin-top: 40px;
        display: flex; justify-content: space-between; 
        background: #fff; padding: 20px 30px; border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
    }
    .sl-item { text-align: center; opacity: 0.4; transition: 0.3s; position: relative;}
    .sl-item.active { opacity: 1; transform: translateY(-5px); }
    .sl-item.active .sl-name { color: var(--accent-red); font-weight: 800; }
    .sl-name { font-size: 0.8rem; text-transform: uppercase; margin-bottom: 5px; font-weight: 600; }
    .sl-time { font-family: 'Teko'; font-size: 1.8rem; line-height: 1; color: #222; }

    /* === TICKER (NEWS) === */
    .ticker-fixed {
        position: absolute; bottom: 0; left: 0; width: 100%; height: 70px;
        background: #000; color: white;
        display: flex; align-items: center; z-index: 50;
        border-top: 4px solid var(--accent-gold);
    }
    .ticker-lbl { 
        background: var(--accent-gold); color: #000; height: 100%; padding: 0 50px; 
        font-weight: 900; font-size: 1.4rem; display: flex; align-items: center;
        clip-path: polygon(0 0, 100% 0, 85% 100%, 0% 100%); 
        padding-right: 80px; z-index: 20; font-family: 'Teko'; letter-spacing: 2px;
    }
    .ticker-view { flex: 1; overflow: hidden; height: 100%; display: flex; align-items: center; }
    .ticker-txt { 
        white-space: nowrap; animation: marquee 35s linear infinite; 
        font-size: 1.2rem; font-weight: 500; text-transform: uppercase; letter-spacing: 1px;
    }
    @keyframes marquee { 0% { transform: translateX(0); } 100% { transform: translateX(-100%); } }

    /* RESPONSIVE */
    @media screen and (max-width: 1024px) {
        .wrapper { flex-direction: column; overflow-y: auto; height: auto; padding-bottom: 70px; }
        .layer-dark { width: 100%; clip-path: none; height: auto; min-height: 500px; padding: 40px; position: relative; }
        .layer-light { width: 100%; padding: 40px; position: relative; }
        .ag-item { position: relative; top: auto; }
        .brand-title { font-size: 2.5rem; }
        .ticker-fixed { position: fixed; bottom: 0; }
        .ag-date-big { font-size: 5rem; }
        .finance-row { flex-direction: column; gap: 30px; }
        .utility-grid { grid-template-columns: 1fr; }
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
                <div class="bar-bg">
                    <div class="bar-fill" :style="{ width: finance.persen + '%' }"></div>
                </div>
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
                <div class="bar-bg">
                    <div class="bar-fill gold" style="width: 35%;"></div> </div>
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
                <i class="wi wi-day-sunny text-warning" style="font-size: 5rem;"></i>
                <div>
                    <div class="temp-val">29°C</div>
                    <div class="loc-val"><i class="mdi mdi-map-marker"></i> JAKARTA SELATAN</div>
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
            <img src="<?= base_url('images/logo-kejaksaan.png') ?>" class="brand-logo-img" alt="Logo">
            <div class="brand-text-col">
                <div class="brand-title">BIRO KEUANGAN</div>
                <span class="brand-sub">KEJAKSAAN AGUNG REPUBLIK INDONESIA</span>
            </div>
        </div>

        <span class="agenda-label">AGENDA PRIORITAS HARI INI</span>

        <div class="agenda-container">
            <transition-group name="slide">
                <div v-if="dataAgenda.length > 0" :key="currentIndex" class="ag-item">
                    
                    <div class="date-badge">
                        <div class="ag-date-big">{{ getDayNum(currentAgenda.waktu_tanggal) }}</div>
                        <span class="ag-date-month">{{ getMonthName(currentAgenda.waktu_tanggal) }}</span>
                    </div>
                    
                    <div class="ag-title">
                        {{ currentAgenda.nama_agenda }} 
                    </div>

                    <div class="ag-meta">
                        <span><i class="mdi mdi-clock-outline"></i> {{ currentAgenda.waktu }} WIB</span>
                        <span style="border-left: 1px solid #555; padding-left: 20px; margin-left: -20px;"></span>
                        <span><i class="mdi mdi-map-marker"></i> {{ currentAgenda.tempat_agenda }}</span>
                    </div>
                </div>
                
                <div v-if="dataAgenda.length === 0" :key="'empty'" class="ag-item">
                    <div class="ag-title">TIDAK ADA JADWAL KEGIATAN</div>
                    <div class="ag-meta">Sistem Monitoring Aktif</div>
                </div>
            </transition-group>
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

    new Vue({
        el: '.wrapper',
        data: {
            jam: "", tanggal: "",
            dataNews: [], dataAgenda: [],
            finance: { pagu: 15000000000, realisasi: 8500000000, persen: 56 },
            pnbp: { total: 1300000000 },
            jadwalSholat: { Subuh: '04:12', Dzuhur: '11:51', Ashar: '15:15', Maghrib: '17:58', Isya: '19:12' },
            nextPrayer: 'Ashar',
            currentIndex: 0,
            currentAgenda: {}
        },
        created() {
            setInterval(this.updateTime, 1000);
            this.getNews(); 
            this.getAgenda();
        },
        mounted() {
            setInterval(() => this.getNews(), 60000); // 1 menit
            setInterval(() => this.getAgenda(), 60000);

            // Auto Slide Agenda
            setInterval(() => {
                if(this.dataAgenda.length > 0) {
                    this.currentIndex = (this.currentIndex + 1) % this.dataAgenda.length;
                    this.currentAgenda = this.dataAgenda[this.currentIndex];
                }
            }, 8000); // Sedikit diperlambat jadi 8 detik biar enak baca
        },
        methods: {
            formatRupiahShort(num) {
                if(num >= 1000000000) return (num/1000000000).toFixed(1) + ' M';
                if(num >= 1000000) return (num/1000000).toFixed(0) + ' Jt';
                return (num/1000).toFixed(0) + ' K';
            },
            updateTime() {
                const d = new Date();
                this.jam = `${addZero(d.getHours())}:${addZero(d.getMinutes())}`;
                const days = ["MINGGU", "SENIN", "SELASA", "RABU", "KAMIS", "JUMAT", "SABTU"];
                const m = ["JANUARI", "FEBRUARI", "MARET", "APRIL", "MEI", "JUNI", "JULI", "AGUSTUS", "SEPTEMBER", "OKTOBER", "NOVEMBER", "DESEMBER"];
                this.tanggal = `${days[d.getDay()]}, ${d.getDate()} ${m[d.getMonth()]} ${d.getFullYear()}`;
                
                // Logic Sholat highlight sederhana
                const h = d.getHours();
                if(h<4) this.nextPrayer='Subuh'; else if(h<12) this.nextPrayer='Dzuhur';
                else if(h<15) this.nextPrayer='Ashar'; else if(h<18) this.nextPrayer='Maghrib';
                else if(h<19) this.nextPrayer='Isya'; else this.nextPrayer='Subuh';
            },
            getDayNum(dateStr) { return dateStr ? new Date(dateStr).getDate() : new Date().getDate(); },
            getMonthName(dateStr) { 
                const m = ["JAN", "FEB", "MAR", "APR", "MEI", "JUN", "JUL", "AGS", "SEP", "OKT", "NOV", "DES"];
                return dateStr ? m[new Date(dateStr).getMonth()] : m[new Date().getMonth()]; 
            },
            getNews() { 
                // Ganti endpoint sesuai controller lo
                // axios.get('<?= base_url() ?>/api/news').then(res => { if(res.data.status) this.dataNews = res.data.data; });
                // Dummy Data
                this.dataNews = [
                    {id:1, text_news: "PEMBAHASAN RENCANA ANGGARAN TAHUN 2026 AKAN DILAKSANAKAN MINGGU DEPAN"},
                    {id:2, text_news: "MOHON UNTUK SELURUH PEGAWAI MELAKUKAN ABSENSI TEPAT WAKTU"}
                ];
            },
            getAgenda() { 
                // Ganti endpoint sesuai controller lo
                // axios.get('<?= base_url() ?>/api/agenda').then(res => ... );
                // Dummy Data buat preview
                const dummy = [
                    { nama_agenda: "Rapat Pembahasan Rencana Pembentukan UPT Rupbasan", waktu: "13:00", tempat_agenda: "Ruang Rapat Biro Perencanaan (403)", waktu_tanggal: "2025-12-04" },
                    { nama_agenda: "Kunjungan Kerja Jaksa Agung Muda Pembinaan", waktu: "09:00", tempat_agenda: "Aula Utama", waktu_tanggal: "2025-12-05" }
                ];
                this.dataAgenda = dummy;
                this.currentAgenda = dummy[0];
            },
        }
    });
</script>
<?php $this->endSection("js") ?>