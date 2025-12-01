<?php

namespace App\Modules\Sidang\Controllers;

use App\Controllers\BaseController;
use App\Modules\Sidang\Models\SidangAdminModel;

// Import library yang dibutuhkan
use OTPHP\TOTP; 
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;

class AdminSetupController extends BaseController
{
    protected $sidangAdminModel;

    public function __construct()
    {
        // Inisialisasi Model
        try {
            $this->sidangAdminModel = new SidangAdminModel();
        } catch (\Throwable $e) {
            // Error handling model/DB
        }
    }
    
    // --- 1. Fungsi setupIndex: Dipanggil oleh rute 'admin/sidang/setup' ---
    // Menampilkan daftar NIP yang sudah terdaftar dan form tambah/edit.
    public function setupIndex()
    {
        // Pastikan model sudah terinisialisasi
        if (!$this->sidangAdminModel) {
            return redirect()->back()->with('error', 'Gagal memuat data administrasi. Cek koneksi database.');
        }

        $listAdmins = $this->sidangAdminModel->findAll();

        $data = [
            'title' => 'Manajemen Kunci OTP Pegawai Sidang',
            'list_admins' => $listAdmins
        ];
        
        // Panggil view admin/setting_otp
        return view('\App\Modules\Setting\Views\setting_otp', $data);
    }
    
    // --- 2. Fungsi saveNip: Dipanggil oleh rute 'admin/sidang/save-nip' (POST) ---
    public function saveNip()
    {
        $input = $this->request->getPost();

        // 1. Validasi Input (NIP dan Nama Pegawai wajib diisi)
        if (!$this->validate(['nip' => 'required|min_length[5]', 'nama_pegawai' => 'required'])) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }

        $data = [
            'nip' => $input['nip'],
            'nama_pegawai' => $input['nama_pegawai'],
            // Saat pertama kali disimpan, secret key dikosongkan/di-null
            'sidang_2fa_secret' => null, 
            'is_active' => 0
        ];

        try {
            // Jika ada ID, lakukan Update (Edit NIP), jika tidak, lakukan Insert (Tambah NIP)
            if (!empty($input['id'])) {
                $this->sidangAdminModel->update($input['id'], $data);
                $message = 'Data NIP berhasil diupdate.';
            } else {
                $this->sidangAdminModel->insert($data);
                $message = 'Data NIP berhasil ditambahkan. Lakukan "Generate QR Code" untuk mengaktifkan OTP.';
            }
            return redirect()->back()->with('success', $message);
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan data: ' . $e->getMessage());
        }
    }
    
    // --- 3. Fungsi generateQr: Dipanggil oleh rute 'admin/sidang/generate/(:num)' ---
    public function generateQr(int $id)
    {
        // 1. Ambil data user dari database
        $adminUser = $this->sidangAdminModel->find($id);

        if (!$adminUser) {
            return redirect()->back()->with('error', 'NIP tidak ditemukan.');
        }
        
        // 2. Tentukan Secret Key (Ambil yang sudah ada atau buat yang baru)
        $secretKey = $adminUser['sidang_2fa_secret'];

        try {
            // Jika secret key kosong, buat yang baru
            if (empty($secretKey)) {
                // Buat Secret Key baru dengan OTPHP\\TOTP
                $totp = TOTP::generate();
                $secretKey = $totp->getSecret();

                // Simpan Secret Key baru ke database
                $this->sidangAdminModel->update($id, [
                    'sidang_2fa_secret' => $secretKey,
                    'is_active' => 1 // Aktifkan user karena sudah punya secret key
                ]);
            }

            // Label untuk aplikasi Authenticator (misal Google Authenticator)
            $label = $adminUser['nip'] . ' - ' . $adminUser['nama_pegawai'];
            $issuer = 'TRON Sidang'; // Nama Aplikasi Anda

            // Buat objek TOTP
            $totp = TOTP::create($secretKey, 30, 'sha1', 6, $issuer);
            $provisioningUri = $totp->getProvisioningUri($label);

            // Buat QR Code (menggunakan Endroid/QrCode)
            $result = Builder::create()
                ->writer(new PngWriter())
                ->writerOptions([])
                ->data($provisioningUri)
                ->encoding(new Encoding('UTF-8'))
                ->errorCorrectionLevel(new ErrorCorrectionLevelHigh())
                ->size(300)
                ->margin(10)
                ->labelText($label)
                ->labelFont(new \Endroid\QrCode\Label\Font\NotoSans(18))
                ->build();

            // Ubah gambar QR Code menjadi base64 URI
            $qrCodeImage = $result->getDataUri();
            $errorMessage = '';

        } catch (\Throwable $e) {
            // 3. Tangani error pembuatan OTP/QR Code
            $errorMessage = 'Gagal membuat gambar QR Code: ' . $e->getMessage() . '. Harap gunakan Kunci Manual.';
            // Placeholder transparan 1x1 GIF
            $qrCodeImage = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7'; 
        }
        
        // 4. Tampilkan QR Code / Kunci Manual ke View
        $data = [
            'title' => 'Setup Kunci OTP Pegawai',
            'user' => $adminUser,
            'secretKey' => $secretKey, 
            'qrCodeImage' => $qrCodeImage,
            'errorMessage' => $errorMessage
        ];
        
        return view('\App\Modules\Sidang\Views\admin\admin_qr_view', $data);
    }
}