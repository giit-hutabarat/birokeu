<?php

// NAMESPACE BARU: Mengikuti struktur HMVC yang sudah disepakati (App\Modules\Sidang)
namespace App\Modules\Sidang\Controllers; 

use App\Controllers\BaseController;
use App\Modules\Sidang\Models\SidangModel;
use App\Modules\Sidang\Models\SidangAdminModel; 
use App\Libraries\Settings;
use Google\Client;
use Google\Service\Sheets;
use PhpOffice\PhpWord\TemplateProcessor;
use OTPHP\TOTP;
use App\Models\UserModel; 
use CodeIgniter\HTTP\ResponseInterface;

class SidangController extends BaseController
{
    protected $sidangModel;
    protected $sidangAdminModel;
    protected $setting;

    public function __construct()
    {
        $this->sidangModel = new SidangModel();
        $this->setting = new Settings(); 
        $this->sidangAdminModel = new SidangAdminModel(); 
    }

    /**
     * Helper untuk membersihkan nama terdakwa dari Als, Bin, Alias, Dkk, dsb.
     */
    private function cleanNamaTerdakwa(string $rawName): string
    {
        $keywords = [' als ', ' alias ', ' bin ', ' dkk '];
        $cleanName = $rawName;
        $lowerName = strtolower($rawName);
        $foundPos = false;

        foreach ($keywords as $keyword) {
            $pos = strpos($lowerName, $keyword); 
            if ($pos !== false) {
                 if ($foundPos === false || $pos < $foundPos) {
                     $foundPos = $pos;
                 }
            }
        }
        
        if ($foundPos !== false) {
            $cleanName = substr($rawName, 0, $foundPos);
        }
        
        return trim($cleanName);
    }
    
    /**
     * HELPER: KONEKSI KE GOOGLE SHEET
     * Kode ini berasal dari file upload Anda yang terpotong.
     */
    private function fetchSheet($range)
    {
        $client = new Client();
        $client->setAuthConfig(WRITEPATH . '/kredensial-google.json');
        $client->addScope(Sheets::SPREADSHEETS_READONLY);
        $service = new Sheets($client);
        
        // ⚠️ GANTI ID SHEET LO DISINI
        $spreadsheetId = '1Jlsbx5HxKzQDmfNFIBkw1TTmDBKXpIxKAtb_zhaLLfo'; 
        
        $response = $service->spreadsheets_values->get($spreadsheetId, $range);
        return $response->getValues();
    }


    public function accessForm()
    {
        if (session()->get('isLoggedInSidang')) {
            return redirect()->to(site_url('sidang'));
        }

        $data = [
            'title' => 'Akses Menu Cetak Sidang',
            'nama_instansi' => $this->setting->info['nama_instansi'],
        ];
        return view('\App\Modules\Sidang\Views\access_form', $data); 
    }

    // app/Modules/Sidang/Controllers/SidangController.php

public function verifyOtp()
{
    $nip = $this->request->getPost('nip'); 
    $otp_code = $this->request->getPost('otp_code');
    
    // 1. Cek Input
    if (empty($nip) || empty($otp_code)) {
        // Ganti redirect->back() menjadi JSON error
        return $this->response->setJSON(['status' => false, 'message' => 'NIP dan Kode OTP wajib diisi.']);
    }

    $adminUser = $this->sidangAdminModel->findByNip($nip);

    // 2. Cek User
    if (!$adminUser || empty($adminUser['sidang_2fa_secret']) || $adminUser['is_active'] == 0) {
        // Ganti redirect->back() menjadi JSON error
        return $this->response->setJSON(['status' => false, 'message' => 'NIP tidak terdaftar untuk akses sidang atau belum dikonfigurasi.']);
    }

    $secret_key = $adminUser['sidang_2fa_secret'];

    try {
        $otp = TOTP::create($secret_key); 

        // 3. Verifikasi OTP
        if ($otp->verify($otp_code, null, 1)) {
        
            session()->set([
                'isLoggedInSidang' => true, 
                'sidang_nip' => $adminUser['nip'],
                'userId' => $adminUser['id'] 
            ]);
            // ✅ GANTI DENGAN JSON SUKSES (Mengandung URL Redirect)
            return $this->response->setJSON([
                'status' => true, 
                'redirect' => site_url('sidang'), 
                'message' => 'Akses berhasil.'
            ]); 

        } else {
            // Ganti redirect->back() menjadi JSON error
            return $this->response->setJSON(['status' => false, 'message' => 'Kode OTP tidak valid atau sudah kadaluarsa. Coba lagi.']);
        }
    } catch (\Throwable $e) {
         // Ganti redirect->back() menjadi JSON error
         return $this->response->setJSON(['status' => false, 'message' => 'Kesalahan Sistem Verifikasi.']);
    }
}


    /**
     * HALAMAN UTAMA (INDEX) - MEMERLUKAN FILTER 'sidang_auth'
     */
    public function index()
    {
        // Cek redundan login
        if (!session()->get('isLoggedInSidang')) {
             return redirect()->to(site_url('sidang/access'));
        }
        
        // 1. Ambil Semua Tanggal Unik yang Ada (untuk Dropdown)
        $queryTanggal = $this->sidangModel->select('tanggal_sidang')->distinct()->orderBy('tanggal_sidang', 'DESC')->findAll();
        
        $listTanggal = [];
        $latestDate = null; 

        foreach ($queryTanggal as $row) {
            $rawDate = $row['tanggal_sidang']; 

            if (!empty($rawDate) && $rawDate !== '0000-00-00') {
                try {
                    $formattedDate = date('d-m-Y', strtotime($rawDate)); 
                    if ($latestDate === null) {
                        $latestDate = $rawDate; 
                    }
                    $listTanggal[] = $formattedDate; 
                } catch (\Exception $e) {
                    continue; 
                }
            }
        }
        
        // 2. Data dikirim KOSONG SECARA DEFAULT
        $cleanedData = []; 

        // 3. Kirim Data ke View 
        $data = [
            'title'         => 'Cetak Sidang - ' . $this->setting->info['nama_aplikasi'],
            'nama_instansi' => $this->setting->info['nama_instansi'],
            'alamat'        => $this->setting->info['alamat'],
            'opt_tanggal'   => $listTanggal, 
            // Kirim data kosong
            'all_data'      => $cleanedData, 
            'nip_user'      => session()->get('sidang_nip'),
            // 🛑 KOREKSI: Set ke null agar View JS bisa menampilkan placeholder
            'selected_date' => null 
        ];

        return view('\App\Modules\Sidang\Views\sidang_view', $data);
    }
    
    /**
     * API: Mengambil data sidang full.
     * Dapat difilter berdasarkan tanggal_sidang (DD-MM-YYYY)
     */
    public function apiData(): ResponseInterface
    {
        // Tanggal diterima dari JS dalam format DD-MM-YYYY
        $tanggalFilter = $this->request->getGet('tanggal');
        
        $query = $this->sidangModel->orderBy('tanggal_sidang', 'ASC');

        // Jika tidak ada filter tanggal, return data kosong (seperti yang diminta JS)
        if (empty($tanggalFilter)) {
            return $this->response->setJSON(['status' => 200, 'total' => 0, 'data' => []]);
        }

        // 🛑 KOREKSI: Konversi tanggal dari DD-MM-YYYY ke Database YYYY-MM-DD
        try {
            $dbFormatDate = \DateTime::createFromFormat('d-m-Y', $tanggalFilter)->format('Y-m-d');
            if ($dateObj !== false) { // ✅ CEK APAKAH PARSING BERHASIL
                $dbFormatDate = $dateObj->format('Y-m-d');
            } else {
                // Tangani jika format tanggal salah/kosong
                return $this->response->setJSON(['status' => 400, 'message' => 'Format tanggal filter tidak valid.']);
            }
            $query->where('tanggal_sidang', $dbFormatDate);
        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => 400, 'message' => 'Format tanggal tidak valid.']);
        }


        // Ambil semua data sesuai filter
        $allData = $query->findAll();

        $cleanedData = [];

        foreach ($allData as $row) {
            $row['nama_bersih'] = $this->cleanNamaTerdakwa($row['nama_terdakwa']);
            $row['data_full'] = json_decode($row['data_full'], true);
            
            // Tambahkan tanggal_sidang_format untuk memudahkan debug di frontend
            $row['tanggal_sidang_format'] = $tanggalFilter; 

            $cleanedData[] = $row;
        }

        // Kembalikan respons dalam format JSON
        return $this->response->setJSON(['status' => 200, 'total' => count($cleanedData), 'data' => $cleanedData]);
    }

    /**
     * FITUR SINKRONISASI (SYNC) - MEMERLUKAN FILTER 'sidang_auth'
     */
    public function sync()
    {
        // 1. Ambil Data Mentah dari Google Sheet
        try {
            $sidangSheet = $this->fetchSheet('SIDANG HARI INI!A1:G100');
            $masterSheet = $this->fetchSheet('DATA_MASTER!A1:G100');
        } catch (\Throwable $e) {
            return redirect()->to('sidang')->with('error', "Gagal koneksi ke Google Sheet. Cek kredensial-google.json dan ID Spreadsheet. Pesan: " . $e->getMessage());
        }

        // 2. Buat Kamus Data Master (Kunci: Nomor Perkara / Index 0)
        $masterMap = [];
        if (!empty($masterSheet)) {
            foreach ($masterSheet as $mRow) {
                $key = isset($mRow[0]) ? trim($mRow[0]) : '';
                if ($key) $masterMap[$key] = $mRow;
            }
        }

        $countInsert = 0;
        $countUpdate = 0;

        // 3. Proses Simpan ke Database
        if (!empty($sidangSheet)) {
            foreach ($sidangSheet as $rowS) {
                // Bersihkan data
                $noPerkara = isset($rowS[0]) ? trim(preg_replace('/\s+/', ' ', $rowS[0])) : '';
                $nama      = isset($rowS[1]) ? trim(preg_replace('/\s+/', ' ', $rowS[1])) : '';
                
                // Filter Ghost Rows (Data Kosong/Sampah)
                if ($noPerkara == '' || strlen($noPerkara) < 5 || stripos($noPerkara, 'Nomor') !== false) continue;

                // Cari Biodata di Master
                $rowM = $masterMap[$noPerkara] ?? [];

                // Gabungkan Biodata ke dalam JSON
                $dataFull = [
                    'tempat_lahir'    => $rowM[3] ?? '-',
                    'tgl_lahir'       => $rowM[4] ?? '-',
                    'umur'            => $rowM[5] ?? '-',
                    'jenis_kelamin'   => $rowM[6] ?? '-',
                    'kewarganegaraan' => $rowM[7] ?? 'Indonesia',
                    'alamat'          => $rowM[8] ?? '-',
                    'agama'           => $rowM[9] ?? '-',
                    'pekerjaan'       => $rowM[10] ?? '-',
                    'pendidikan'      => $rowM[11] ?? '-',
                    'nama_ortu'       => $rowM[12] ?? '-',
                    'agenda_raw'      => $rowS[3] ?? '-', // Simpan agenda asli
                    'hari_raw'        => $rowS[6] ?? '-', // Simpan hari asli
                ];

                // Tanggal Sidang (Asumsi format string di sheet konsisten)
                $tglSidang = $rowS[6] ?? date('Y-m-d'); 

                // Cek apakah data sudah ada di DB?
                $existing = $this->sidangModel->where('nomor_perkara', $noPerkara)->first();

                $saveData = [
                    'tanggal_sidang' => $tglSidang, 
                    'nomor_perkara'  => $noPerkara,
                    'nama_terdakwa'  => $nama,
                    'jpu'            => $rowS[4] ?? '-',
                    'data_full'      => json_encode($dataFull), // Simpan biodata sbg JSON
                ];

                if ($existing) {
                    $this->sidangModel->update($existing['id'], $saveData);
                    $countUpdate++;
                } else {
                    $this->sidangModel->insert($saveData);
                    $countInsert++;
                }
            }
        }

        return redirect()->to('sidang')->with('success', "Sinkronisasi Selesai! Data Baru: $countInsert, Update: $countUpdate");
    }

    /**
     * FITUR PROSES CETAK - MEMERLUKAN FILTER 'sidang_auth'
     */
    public function proses()
    {
        // 1. Ambil Input User
        $selectedNoPerkara = $this->request->getPost('pilih_data');
        $docTypes = $this->request->getPost('jenis_dokumen');
        $mode = $this->request->getPost('mode_cetak');
        $tanggalTerpilih = $this->request->getPost('tanggal_terpilih');

        // 2. Setup Folder Backup
        $hariIni = date('Y-m-d');
        $pathArsip = WRITEPATH . 'arsip_sidang';
        $folderBackup = $pathArsip . DIRECTORY_SEPARATOR . $hariIni;

        if (!is_dir($pathArsip)) mkdir($pathArsip, 0777, true);
        if (!is_dir($folderBackup)) mkdir($folderBackup, 0777, true);

        $generatedFiles = [];
        $targetData = [];

        // 3. Ambil Data Target dari Database
        if ($mode == 'full_p38') {
            // Mode Tombol Hijau: Ambil semua data tanggal tsb
            $dbFormatDate = \DateTime::createFromFormat('d-m-Y', $tanggalTerpilih)->format('Y-m-d');
            $targetData = $this->sidangModel->where('tanggal_sidang', $dbFormatDate)->findAll();
            $docTypes = ['p38']; 
        } else {
            // Mode Tombol Kuning: Ambil sesuai checklist
            if(empty($selectedNoPerkara)) return redirect()->back()->with('error', 'Pilih data dulu!');
            if(empty($docTypes)) return redirect()->back()->with('error', 'Pilih jenis dokumen!');
            
            $targetData = $this->sidangModel->whereIn('nomor_perkara', $selectedNoPerkara)->findAll();
        }

        if (empty($targetData)) {
            return redirect()->back()->with('error', 'Data tidak ditemukan di database. Coba Sync dulu!');
        }

        // 4. Generate Word
        foreach ($targetData as $row) {
            // Decode JSON biodata
            $details = json_decode($row['data_full'], true);

            $dataRow = [
                'nomor_perkara'   => $row['nomor_perkara'],
                'nama_terdakwa'   => $this->cleanNamaTerdakwa($row['nama_terdakwa']), 
                'jpu'             => $row['jpu'],
                'hari_sidang'     => $row['tanggal_sidang'], 
                'agenda'          => $details['agenda_raw'] ?? '-',
                'tanggal_surat'   => date('d F Y'), 

                // Data Biodata
                'tempat_lahir'    => $details['tempat_lahir'] ?? '-',
                'tgl_lahir'       => $details['tgl_lahir'] ?? '-',
                'umur'            => $details['umur'] ?? '-',
                'jenis_kelamin'   => $details['jenis_kelamin'] ?? '-',
                'kewarganegaraan' => $details['kewarganegaraan'] ?? '-',
                'alamat'          => $details['alamat'] ?? '-',
                'agama'           => $details['agama'] ?? '-',
                'pekerjaan'       => $details['pekerjaan'] ?? '-',
                'pendidikan'      => $details['pendidikan'] ?? '-',
                'nama_ortu'       => $details['nama_ortu'] ?? '-',
                'nip_jpu'         => session()->get('sidang_nip') ?? '...................',
            ];

            // Bersihkan nama file
            $cleanName = preg_replace('/[^A-Za-z0-9 \-]/', '', $row['nama_terdakwa']);
            $cleanName = substr($cleanName, 0, 50);

            // Generate P-37
            if (in_array('p37', $docTypes)) {
                $this->generateDoc('template_p37.docx', $dataRow, "P37_{$cleanName}.docx", $folderBackup, $generatedFiles);
            }
            // Generate P-38
            if (in_array('p38', $docTypes)) {
                $this->generateDoc('template_p38.docx', $dataRow, "P38_{$cleanName}.docx", $folderBackup, $generatedFiles);
            }
        }

        // 5. Packing & Download
        $totalFiles = count($generatedFiles);
        if ($totalFiles === 0) return redirect()->back()->with('error', 'Gagal generate file.');

        if ($totalFiles === 1) {
            $singleFile = reset($generatedFiles);
            return $this->response->download($singleFile, null)->setFileName(basename($singleFile));
        } 
        else {
            $zip = new \ZipArchive();
            $zipName = $folderBackup . DIRECTORY_SEPARATOR . 'Berkas_Sidang_' . time() . '.zip';

            if ($zip->open($zipName, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
                foreach ($generatedFiles as $fname => $fpath) {
                    if (file_exists($fpath)) $zip->addFile($fpath, $fname);
                }
                $zip->close();
            }
            
            if (file_exists($zipName)) {
                return $this->response->download($zipName, null);
            } else {
                return redirect()->back()->with('error', 'Gagal membuat file ZIP.');
            }
        }
    }

    // Helper Generate Doc
    private function generateDoc($tpl, $data, $outName, $path, &$filesArr) {
        $tplPath = WRITEPATH . 'templates/' . $tpl;
        if (file_exists($tplPath)) {
            $proc = new TemplateProcessor($tplPath);
            $proc->setValues($data);
            
            // Auto numbering nama file biar gak bentrok
            $finalName = $outName;
            $c = 1;
            while(file_exists($path . DIRECTORY_SEPARATOR . $finalName)) {
                $finalName = pathinfo($outName, PATHINFO_FILENAME) . "_($c)." . pathinfo($outName, PATHINFO_EXTENSION);
                $c++;
            }
            
            $saveP = $path . DIRECTORY_SEPARATOR . $finalName;
            $proc->saveAs($saveP);
            $filesArr[$finalName] = $saveP;
        }
    }
}