<?php
use App\Libraries\Settings;

$setting = new Settings();
$appname = $setting->info['nama_aplikasi'] ?? 'TRON System';
$logo = $setting->info['logo'] ?? 'logo.png';
$background = $setting->info['background'] ?? '';

// --- CEK STATUS LOGIN DI SISI SERVER (PHP) ---
$isLoggedIn = session()->get('isLoggedIn') ?? false;
$userFullname = session()->get('fullname') ?? 'ADMIN'; 
?>
<!DOCTYPE html>
<html>
<head>
    <!-- ... (Head tetap sama) ... -->
      <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
    <title><?= $title; ?> | <?= $appname; ?></title>
    
    <link rel="shortcut icon" href="<?= base_url() . "/" . $logo; ?>" type="image/x-icon">

    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@6.x/css/materialdesignicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.min.css" rel="stylesheet">
       <script src="https://cdn.jsdelivr.net/npm/vue@2.x/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vuetify@2.x/dist/vuetify.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.24.0/axios.min.js"></script>

    
    <link href="<?= base_url('assets/css/styles.css') ?>" rel="stylesheet">

    <style>
        /* ... (Styles tetap sama) ... */
    </style>
    
    <?php $this->renderSection("style"); ?>
</head>

<body>
    
    <!-- Struktur Preloader Utama -->
    <div id="preloader">
        <div class="loader-container-main">
            <!-- ... (Struktur Preloader tetap sama) ... -->
        </div>
    </div>

        <div id="app">
        <v-app>
            
            <v-navigation-drawer app v-model="drawer" class="bg-sidebar" dark width="280">
                <template v-slot:img="props">
                    <v-img v-bind="props" gradient="to top right, rgba(30,30,30,.9), rgba(10, 10, 10, .95)"></v-img>
                </template>
                
                <v-list-item two-line class="px-4">
                    <v-list-item-avatar>
                        <img src="<?= base_url() . "/" . $logo; ?>">
                    </v-list-item-avatar>
                    <v-list-item-content>
                        <v-list-item-title class="text-h6 font-weight-bold"><?= $appname; ?></v-list-item-title>
                        <v-list-item-subtitle class="caption"><?= $setting->info['alamat'] ?? ''; ?></v-list-item-subtitle>
                    </v-list-item-content>
                </v-list-item>

                <v-divider></v-divider>
                
                <v-list dense nav shaped>
                    <v-list-item link href="<?= base_url('home'); ?>">
                        <v-list-item-icon><v-icon color="blue lighten-2">mdi-view-dashboard</v-icon></v-list-item-icon>
                        <v-list-item-content><v-list-item-title>Dashboard</v-list-item-title></v-list-item-content>
                    </v-list-item>
                    
                    <v-list-item link @click="openLogin('sidang')">
                        <v-list-item-icon><v-icon color="red accent-2">mdi-gavel</v-icon></v-list-item-icon>
                        <v-list-item-content><v-list-item-title>Cetak Sidang</v-list-item-title></v-list-item-content>
                    </v-list-item>

                    <v-list-item link href="<?= base_url('display'); ?>" target="_blank">
                        <v-list-item-icon><v-icon color="green accent-3">mdi-monitor-dashboard</v-icon></v-list-item-icon>
                        <v-list-item-content><v-list-item-title>Display TV</v-list-item-title></v-list-item-content>
                    </v-list-item>

                    <v-list-item link @click="openLogin('tron_settings')">
                        <v-list-item-icon><v-icon color="grey lighten-1">mdi-cogs</v-icon></v-list-item-icon>
                        <v-list-item-content><v-list-item-title>Pengaturan</v-list-item-title></v-list-item-content>
                    </v-list-item>

                    <v-list-group prepend-icon="mdi-folder-multiple-image" no-action color="white">
                        <template v-slot:activator>
                            <v-list-item-content><v-list-item-title>Media & Konten</v-list-item-title></v-list-item-content>
                        </template>
                        <v-list-item link href="<?= base_url('galeri'); ?>">
                            <v-list-item-content><v-list-item-title>Galeri Foto</v-list-item-title></v-list-item-content>
                        </v-list-item>
                        <v-list-item link href="<?= base_url('video'); ?>">
                            <v-list-item-content><v-list-item-title>Video Playlist</v-list-item-title></v-list-item-content>
                        </v-list-item>
                        <v-list-item link href="<?= base_url('news'); ?>">
                            <v-list-item-content><v-list-item-title>Running Text</v-list-item-title></v-list-item-content>
                        </v-list-item>
                    </v-list-group>
                    
                    <v-list-item link href="<?= base_url('auth/logout'); ?>" class="mt-4">
                        <v-list-item-icon><v-icon color="grey darken-1">mdi-logout</v-icon></v-list-item-icon>
                        <v-list-item-content><v-list-item-title>Logout</v-list-item-title></v-list-item-content>
                    </v-list-item>
                </v-list>
            </v-navigation-drawer>

            <v-app-bar app elevate-on-scroll color="white" height="64">
                <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>
                <v-toolbar-title class="text-subtitle-1 text-uppercase font-weight-bold text--secondary ml-2">
                    <?= $title; ?>
                </v-toolbar-title>
                <v-spacer></v-spacer>
                </v-app-bar>

            <v-main class="grey lighten-4">
                <v-container fluid class="fill-height pa-0">
                    <?php $this->renderSection("content"); ?>
                </v-container>
            </v-main>

            <v-dialog v-model="showLoginDialog" max-width="400" overlay-color="black" overlay-opacity="0.85">
                <v-card color="#1e293b" dark class="rounded-xl pa-5 elevation-24">
                    <v-card-title class="justify-center text-h5 font-weight-black text-blue-lighten-3 mb-2 ls-1">
                        LOGIN DASHBOARD
                    </v-card-title>
                    <v-card-text class="text-center pb-0">
                        <div class="mb-6 d-flex justify-center">
                            <div style="width: 80px; height: 80px; border-radius:50%; background:rgba(56, 189, 248, 0.1); display:flex; align-items:center; justify-content:center;">
                                <v-icon size="40" color="#38bdf8">mdi-shield-account</v-icon>
                            </div>
                        </div>
                        
                        <v-form ref="formLogin" v-model="valid" @submit.prevent="loginProcess">
                            <v-text-field 
                                v-model="loginUsername" 
                                :rules="[rules.required]" 
                                label="Username" 
                                outlined dense rounded
                                color="light-blue lighten-3" 
                                prepend-inner-icon="mdi-account">
                            </v-text-field>
                            
                            <v-text-field 
                                v-model="loginPassword" 
                                :rules="[rules.required, rules.min]" 
                                :type="showPass ? 'text' : 'password'" 
                                label="Password" 
                                outlined dense rounded
                                color="light-blue lighten-3" 
                                prepend-inner-icon="mdi-lock"
                                :append-icon="showPass ? 'mdi-eye' : 'mdi-eye-off'"
                                @click:append="showPass = !showPass">
                            </v-text-field>

                            <v-alert v-if="errorMsg" type="error" dense text class="mt-2 text-caption text-left" icon="mdi-alert-circle">
                                {{ errorMsg }}
                            </v-alert>
                            
                            <v-btn block color="light-blue accent-3" class="black--text font-weight-bold mt-4 rounded-pill" :loading="loading" :disabled="!valid" type="submit" large elevation="0">
                                MASUK
                            </v-btn>
                        </v-form>
                    </v-card-text>
                    <v-card-actions class="justify-center mt-3">
                        <v-btn text small color="grey lighten-1" @click="showLoginDialog = false">Batal</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>

            <v-snackbar v-model="snackbar" :color="notifType" :timeout="4000" top right rounded="pill">
                <v-icon left>{{ notifType == 'success' ? 'mdi-check-circle' : 'mdi-alert' }}</v-icon>
                {{ snackbarMessage }}
                <template v-slot:action="{ attrs }">
                    <v-btn icon small v-bind="attrs" @click="snackbar = false"><v-icon>mdi-close</v-icon></v-btn>
                </template>
            </v-snackbar>

            <v-footer app color="white" class="justify-center caption grey--text text--darken-1 border-top">
                <span>&copy; <?= date('Y'); ?> <strong>TRON System</strong> - <?= $appname; ?></span>
            </v-footer>
        </v-app>
    </div>

    <div id="app">
        <v-app>
            <!-- ---------------------------------------------------- -->
            <!-- GRUP 1: PROFIL USER DAN LOGOUT (KANAN ATAS) -->
            <!-- ---------------------------------------------------- -->
            <v-toolbar class="transparent" flat dense>
                <v-spacer></v-spacer>
                <?php if ($isLoggedIn) : ?>
                <v-menu offset-y>
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn 
                            color="white" 
                            text 
                            v-bind="attrs" 
                            v-on="on" 
                            class="font-weight-bold"
                            style="text-transform: none;"
                        >
                            <v-icon left>mdi-account-circle</v-icon>
                            <?= esc($userFullname); ?>
                            <v-icon right>mdi-chevron-down</v-icon>
                        </v-btn>
                    </template>

                    <v-list dense>
                        <!-- Menu Tunggal: Logout -->
                        <v-list-item 
                            link 
                            @click="logoutUser" 
                            class="red--text text--lighten-1"
                        >
                            <v-list-item-icon><v-icon>mdi-logout</v-icon></v-list-item-icon>
                            <v-list-item-content>
                                <v-list-item-title>Logout</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list>
                </v-menu>
                <?php endif; ?>
            </v-toolbar>

            <v-main>
                <v-container fluid class="fill-height pa-0" style="margin-top: -64px;">
                    <?php $this->renderSection("content"); ?>
                    
                    <!-- ---------------------------------------------------- -->
                    <!-- GRUP 4: KOREKSI TOMBOL LOGIN ADMIN -->
                    <!-- KODE INI BERADA DI SECTION "content" DARI FRONTEND.PHP -->
                    <!-- KARENA LOKASINYA DI TENGAH, KODE INI HARUS DIKOREKSI DI VIEW UTAMA -->
                    <!-- KITA HANYA MENGATUR VISIBILITAS DI SINI -->
                    <!-- ---------------------------------------------------- -->
                </v-container>
            </v-main>

            <!-- ... (v-dialog dan script tetap sama) ... -->
        </v-app>
    </div>

    <!-- ... (Scripts Vue dan Logic JS lainnya) ... -->
    <script>
        // ... (Semua logic PRELOADER, VUE INSTANCE, dan methodsVue, termasuk logoutUser tetap di sini) ...
        var defaultMethods = {
            // ... (openLogin dan loginProcess tetap sama) ...
            
            // ===============================================
            // FUNGSI LOGOUT (FIXED REFERENCE ERROR)
            // ===============================================
            logoutUser: async function() {
                try {
                    // Panggil endpoint logout API
                    const response = await axios.get('<?= base_url('api/auth/logout'); ?>');
                    
                    if (response.data.status === true) {
                        const redirectUrl = response.data.data.url; // Akan berisi 'auth/loading'
                        window.location.href = redirectUrl;
                    } else {
                        window.location.href = '<?= base_url('auth/loading'); ?>';
                    }
                } catch (error) {
                    window.location.href = '<?= base_url('auth/loading'); ?>';
                }
            },
            // ===============================================
            
            toggleTheme() {
                this.$vuetify.theme.dark = !this.$vuetify.theme.dark;
            }
        };
        
        var methodsVue = { ...defaultMethods, ...(window.methodsVue || {}) };

        new Vue({
            el: '#app',
            vuetify: new Vuetify(),
            computed: computedVue,
            data: dataVue,
            mounted: mountedVue,
            created: createdVue,
            watch: watchVue,
            methods: methodsVue
        })
    </script>
    <style>
        /* ... (Styles tambahan) ... */
    </style>
</body>
</html>