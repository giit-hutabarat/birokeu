<?php $this->section("style"); ?>
<link href="https://fonts.googleapis.com/css2?family=Teko:wght@300;400;600;700&family=Roboto+Condensed:wght@400;700&display=swap" rel="stylesheet">
<style>
    /* --- RESET & VARS --- */
    :root {
        --sidebar-w: 350px;
        --gold: #FFD700;
        --dark-glass: rgba(0, 0, 0, 0.85);
        --light-glass: rgba(255, 255, 255, 0.05);
        --danger: #d50000;
        --success: #00c853;
    }
    
    html, body {
        height: 100vh; margin: 0; padding: 0; overflow: hidden;
        background: #000;
        font-family: 'Roboto Condensed', sans-serif;
        color: white;
    }

    /* --- LAYOUT UTAMA (SPLIT SCREEN) --- */
    .smart-container {
        display: flex; height: 100vh; width: 100vw;
        background: radial-gradient(circle at 70% 50%, #1a202c 0%, #000 100%);
        position: relative;
    }

    /* --- KIRI: SMART SIDEBAR (350px) --- */
    .sidebar {
        width: var(--sidebar-w);
        height: 100%;
        background: var(--dark-glass);
        backdrop-filter: blur(15px);
        border-right: 3px solid var(--gold);
        display: flex; flex-direction: column;
        padding: 30px 20px;
        z-index: 100;
        box-shadow: 10px 0 30px rgba(0,0,0,0.8);
    }

    /* 1. Header Jam */
    .clock-box { text-align: center; margin-bottom: 40px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 20px; }
    .jam-big { font-family: 'Teko', sans-serif; font-size: 5rem; line-height: 0.9; font-weight: 600; text-shadow: 0 0 20px rgba(255,255,255,0.2); }
    .tgl-small { font-size: 1.1rem; color: var(--gold); text-transform: uppercase; letter-spacing: 2px; margin-top: 5px; }

    /* 2. Info List (Scroll Vertical) */
    .info-scroller { 
        flex: 1; overflow: hidden; position: relative; 
        background: var(--light-glass); border-radius: 10px; padding: 10px;
        margin-bottom: 20px;
    }
    .info-list-anim { list-style: none; padding: 0; margin: 0; animation: scrollUpInfo 40s linear infinite; }
    .info-item { 
        padding: 15px 10px; border-bottom: 1px solid rgba(255,255,255,0.1); 
        margin-bottom: 5px; 
    }
    .info-date { font-size: 0.8rem; color: var(--gold); display: block; margin-bottom: 3px; }
    .info-text { font-size: 1rem; line-height: 1.3; font-weight: 400; }
    
    @keyframes scrollUpInfo { 0% { transform: translateY(0); } 100% { transform: translateY(-50%); } }

    /* 3. Boss Booster (Pulse) */
    .boss-booster {
        height: 60px; background: rgba(0,0,0,0.5); border-radius: 8px;
        display: flex; align-items: center; justify-content: space-between; padding: 0 15px;
        border: 1px solid rgba(255,255,255,0.1);
    }
    .pulse-dot {
        width: 15px; height: 15px; border-radius: 50%;
        box-shadow: 0 0 10px currentColor;
        animation: pulse 1.5s infinite;
    }
    .status-ok { color: var(--success); background: var(--success); }
    .status-alert { color: var(--danger); background: var(--danger); animation-duration: 0.5s; }
    
    @keyframes pulse { 0% { opacity: 1; transform: scale(1); } 50% { opacity: 0.5; transform: scale(1.4); } 100% { opacity: 1; transform: scale(1); } }

    /* --- KANAN: MAIN CONTENT (FLEX) --- */
    .main-content {
        flex: 1; display: flex; flex-direction: column;
        padding: 0; position: relative;
    }

    /* 1. Header Running Text (Top) */
    .top-marquee {
        height: 60px; background: #b71c1c; /* Merah Kejaksaan */
        display: flex; align-items: center; overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.5); z-index: 50;
    }
    .marquee-text { 
        font-size: 1.5rem; font-weight: bold; white-space: nowrap; 
        padding-left: 100%; animation: marquee 30s linear infinite; 
    }
    @keyframes marquee { 0% { transform: translate(0, 0); } 100% { transform: translate(-100%, 0); } }

    /* 2. Dynamic Zone (Grid) */
    .content-grid {
        flex: 1; padding: 30px;
        display: grid; 
        grid-template-columns: 2fr 1.2fr; /* Kiri Gede (Video/Galeri), Kanan Kecil (Sidang) */
        grid-template-rows: 1fr;
        gap: 30px;
        height: calc(100% - 60px);
    }

    /* Box Styles */
    .glass-box {
        background: rgba(255,255,255,0.03);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 15px;
        overflow: hidden;
        display: flex; flex-direction: column;
        position: relative;
    }
    .box-header {
        padding: 15px 20px; background: rgba(0,0,0,0.4);
        font-family: 'Teko', sans-serif; font-size: 1.8rem; letter-spacing: 1px;
        text-transform: uppercase; border-bottom: 2px solid var(--gold);
        display: flex; align-items: center; gap: 10px;
    }

    /* Video/Galeri Area */
    .media-area { position: relative; flex: 1; }
    .media-area iframe, .media-area video, .media-area img { width: 100%; height: 100%; object-fit: cover; }

    /* Sidang List */
    .sidang-list { list-style: none; padding: 0; margin: 0; animation: scrollUpSidang 60s linear infinite; }
    .sidang-item {
        padding: 15px 20px; border-bottom: 1px solid rgba(255,255,255,0.1);
        background: rgba(0,0,0,0.2); transition: background 0.3s;
    }
    .sidang-item:nth-child(odd) { background: rgba(255,255,255,0.02); }
    .agenda-text { color: var(--gold); font-weight: bold; font-size: 1.1rem; margin-bottom: 5px; display: block; }
    .terdakwa-text { font-size: 1rem; color: #fff; display: block; }
    .detail-text { font-size: 0.85rem; color: #aaa; margin-top: 5px; display: block; }
    
    @keyframes scrollUpSidang { 0% { transform: translateY(0); } 100% { transform: translateY(-50%); } }

    /* Instansi Logo Overlay */
    .logo-overlay {
        position: absolute; bottom: 30px; right: 30px;
        display: flex; align-items: center; gap: 15px; opacity: 0.8;
    }
    .instansi-name { text-align: right; }
    .h-instansi { font-size: 1.5rem; font-weight: bold; line-height: 1; margin: 0; color: white; display: block;}
    .h-alamat { font-size: 0.9rem; color: var(--gold); margin: 0; display: block;}

</style>
<?php $this->endSection("style") ?>

<div class="smart-container">
    
    <div class="sidebar">
        <div class="clock-box">
            <div class="jam-big">{{jam}}</div>
            <div class="tgl-small">{{tanggal}}</div>
        </div>

        <div style="margin-bottom: 10px; font-weight: bold; color: #aaa; text-transform: uppercase; font-size: 0.9rem;">
            <i class="mdi mdi-information-outline"></i> Info Terkini
        </div>
        <div class="info-scroller">
            <ul v-if="dataInfo.length > 0" class="info-list-anim">
                <li v-for="item in dataInfo" :key="item.id" class="info-item">
                    <span class="info-date">{{ item.tgl_news }}</span>
                    <span class="info-text">{{ item.text_news }}</span>
                </li>
                <li v-for="item in dataInfo" :key="'dup-'+item.id" class="info-item">
                    <span class="info-date">{{ item.tgl_news }}</span>
                    <span class="info-text">{{ item.text_news }}</span>
                </li>
            </ul>
            <div v-else class="text-center p-3 text-muted">Memuat Info...</div>
        </div>

        <div class="boss-booster">
            <div style="font-size: 0.9rem; font-weight: bold;">
                <i class="mdi mdi-server-network"></i> SYSTEM STATUS
            </div>
            <div class="pulse-dot status-ok"></div> 
        </div>
    </div>

    <div class="main-content">
        
        <div class="top-marquee">
            <div class="marquee-text">
                <span v-for="item in dataNews" :key="item.id">
                    <i class="mdi mdi-newspaper"></i> {{ item.text_news }} &nbsp;&nbsp;&bull;&nbsp;&nbsp; 
                </span>
                <span v-for="item in dataNews" :key="'d-'+item.id">
                    <i class="mdi mdi-newspaper"></i> {{ item.text_news }} &nbsp;&nbsp;&bull;&nbsp;&nbsp; 
                </span>
            </div>
        </div>

        <div class="content-grid">
            
            <div class="glass-box media-area">
                <div v-if="showVideoMode" style="width:100%; height:100%;">
                    <?php 
                        // Copas Logic Pembersih ID Youtube lo
                        $finalVideoId = $videoId;
                        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $videoId, $match)) { $finalVideoId = $match[1]; }
                        $finalVideoId = trim($finalVideoId);
                        if (empty($finalVideoId) || $finalVideoId == '0') { $finalVideoId = 'r3wW21ddf9U'; }
                    ?>
                    <?php if ($video_youtube == 'no') { ?>
                         <video id="myplayer" muted autoplay loop style="width:100%; height:100%; object-fit:cover;"></video>
                    <?php } else { ?>
                        <iframe width="100%" height="100%" src="https://www.youtube.com/embed/<?= $finalVideoId; ?>?autoplay=1&mute=1&loop=1&playlist=<?= $finalVideoId; ?>&controls=0&showinfo=0" frameborder="0" allow="autoplay; encrypted-media"></iframe>
                    <?php } ?>
                    
                    <div style="position:absolute; top:0; left:0; padding:10px 20px; background:rgba(0,0,0,0.6); color:var(--gold); font-weight:bold;">
                        <i class="mdi mdi-video"></i> VIDEO PROFIL
                    </div>
                </div>

                <div v-else style="width:100%; height:100%;">
                    <div id="carouselGaleri" class="carousel slide h-100" data-bs-ride="carousel">
                        <div class="carousel-inner h-100">
                            <div class="carousel-item h-100" v-for="(item, i ) in dataGaleri" :key="i" :class="{ active: i==0 }">
                                <img :src="'<?= base_url(); ?>' + '/' + item.image_url" style="width:100%; height:100%; object-fit:cover;" alt="...">
                                <div class="carousel-caption d-none d-md-block" style="background:rgba(0,0,0,0.5);">
                                    <h5>KEGIATAN BIRO</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="glass-box">
                <div class="box-header text-white">
                    <i class="mdi mdi-gavel text-warning"></i> JADWAL SIDANG
                </div>
                <div style="flex:1; overflow:hidden; position:relative;">
                    <div v-if="!loadingSidang && dataSidang.length === 0" class="d-flex align-items-center justify-content-center h-100 text-muted">
                        Tidak ada jadwal sidang hari ini.
                    </div>
                    
                    <ul v-else class="sidang-list">
                        <li v-for="(row, index) in dataSidang" :key="index" class="sidang-item">
                            <span class="agenda-text">{{ row.agenda_sidang }}</span>
                            <span class="terdakwa-text">{{ row.nama_terdakwa }}</span>
                            <span class="detail-text">
                                <i class="mdi mdi-file-document"></i> {{ row.nomor_perkara }} <br>
                                <i class="mdi mdi-account-tie"></i> JPU: {{ row.jpu }}
                            </span>
                        </li>
                        <li v-for="(row, index) in dataSidang" :key="'d-'+index" class="sidang-item">
                             <span class="agenda-text">{{ row.agenda_sidang }}</span>
                            <span class="terdakwa-text">{{ row.nama_terdakwa }}</span>
                            <span class="detail-text">
                                <i class="mdi mdi-file-document"></i> {{ row.nomor_perkara }} <br>
                                <i class="mdi mdi-account-tie"></i> JPU: {{ row.jpu }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>

        </div>

        <div class="logo-overlay">
            <div class="instansi-name">
                <span class="h-instansi"><?= $nama_instansi; ?></span>
                <span class="h-alamat"><?= $alamat; ?></span>
            </div>
            <img src="<?php echo base_url('/' . ($logo == "" ? 'logo.png' : $logo)); ?>" width="80" />
        </div>

    </div>
</div>

<?php $this->section("js") ?>
<script>
    function addZeroBefore(n) { return (n < 10 ? '0' : '') + n; }

    dataVue = {
        ...dataVue,
        tanggal: "", jam: "",
        dataNews: [], dataInfo: [], dataAgenda: [], dataVideo: [], dataGaleri: [],
        loadingSidang: false, headersSidang: [], dataSidang: [],
        
        // Variable Tambahan buat Layout ini
        showVideoMode: true // Buat switch Video/Galeri
    }

    createdVue = function() {
        this.getDate(); this.getTime();
        setInterval(this.getDate, 1000); setInterval(this.getTime, 1000);
        setTimeout(() => {
            this.getVideo(); this.getNews(); this.getInfo(); this.getGaleri(); this.getDataSidang();
        }, 500);
    }

    mountedVue = function() {
        setInterval(() => this.getNews(), <?= $news_refresh; ?> * 1000);
        setInterval(() => this.getInfo(), <?= $news_refresh; ?> * 1000);
        setInterval(() => this.getGaleri(), <?= $slide_refresh; ?> * 1000);
        setInterval(() => this.getDataSidang(), 60000); // 1 Menit sekali cek sidang

        // INOVASI: Auto Switch Video <-> Galeri setiap 30 detik
        // Biar layar gak bosenin (Video terus atau Gambar terus)
        setInterval(() => {
            this.showVideoMode = !this.showVideoMode;
            // Kalo balik ke video, play ulang logic videonya (opsional)
            if(this.showVideoMode) {
                 setTimeout(() => { 
                     // Logic re-init video player kalo pake local mp4
                     <?php if ($video_youtube == 'no') : ?> 
                        if(document.getElementById("myplayer")) this.playVideo(); 
                     <?php endif; ?>
                 }, 500);
            }
        }, 30000);
    }

    methodsVue = {
        ...methodsVue,
        getDate: function() {
            try {
                const w = ["MINGGU", "SENIN", "SELASA", "RABU", "KAMIS", "JUMAT", "SABTU"];
                const months = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Ags", "Sep", "Okt", "Nov", "Des"];
                const t = new Date();
                this.tanggal = w[t.getDay()] + ', ' + t.getDate() + ' ' + months[t.getMonth()] + ' ' + t.getFullYear();
            } catch(e){}
        },
        getTime: function() {
            try {
                const t = new Date();
                this.jam = addZeroBefore(t.getHours()) + ":" + addZeroBefore(t.getMinutes()) + ":" + addZeroBefore(t.getSeconds());
            } catch(e){}
        },
        
        // API Calls (Sama persis kayak layout 9 lo)
        getNews: function() { axios.get('<?= base_url() ?>/api/news/news').then(res => { if(res.data.status) this.dataNews = res.data.data; }).catch(e=>{}); },
        getInfo: function() { axios.get('<?= base_url() ?>/api/news/info').then(res => { if(res.data.status) this.dataInfo = res.data.data; }).catch(e=>{}); },
		getGaleri: function() { axios.get('<?= base_url() ?>/api/display/galeri').then(res => { if(res.data.status) this.dataGaleri = res.data.data; }).catch(e=>{}); },
        
        getVideo: function() {
            axios.get('<?= base_url(); ?>/api/video/display').then(res => {
                if (res.data.status && res.data.data) {
                    this.dataVideo = res.data.data;
                    <?php if ($video_youtube == 'no') : ?> 
                        if(this.showVideoMode) this.playVideo(); 
                    <?php endif; ?>
                }
            }).catch(e=>{});
        },
        playVideo: function() {
            try {
                var p = document.getElementById("myplayer"); if(!p) return;
                var i = 0; var src = this.dataVideo; if(!src || src.length===0) return;
                var count = src.length;
                p.src = src[0]; p.autoplay = true; p.load();
                function play(n) { if(src[n]) { p.src = src[n]; p.load(); p.play().catch(e=>{}); } }
                p.addEventListener('ended', function() { i = (i == count - 1) ? 0 : i+1; play(i); }, false);
            } catch(e){}
		},
        getDataSidang: function() {
            this.loadingSidang = true;
            axios.get(`<?= base_url(); ?>/datasidang`).then(res => {
                this.loadingSidang = false;
                if (res.data.status) { this.headersSidang = res.data.headers; this.dataSidang = res.data.rows; }
            }).catch(e => { this.loadingSidang = false; });
        },
    }
</script>
<?php $this->endSection("js") ?>