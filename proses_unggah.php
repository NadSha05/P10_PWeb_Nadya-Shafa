<?php 
// 1. Menampung pesan kesalahan 
$errors = []; 
 
// 2. Mengambil data dari formulir 
$nim = trim($_POST["nim"] ?? ""); 
$nama = trim($_POST["nama_mahasiswa"] ?? ""); 
$matkul = trim($_POST["matkul"] ?? ""); 
 
// 3. Memvalidasi kolom wajib 
if ($nim === "") { 
    $errors[] = "NIM wajib diisi."; 
} 
 
if ($nama === "") { 
    $errors[] = "Nama mahasiswa wajib diisi."; 
} 
 
if ($matkul === "") { 
    $errors[] = "Mata kuliah wajib diisi."; 
} 

// 4. Memeriksa status unggahan berkas 
$file = $_FILES["file_ujian"] ?? null; 
 
if ($file === null || $file["error"] === UPLOAD_ERR_NO_FILE) { 
    $errors[] = "Berkas jawaban wajib diunggah."; 
} elseif ($file["error"] !== UPLOAD_ERR_OK) { 
    $errors[] = "Terjadi kesalahan saat mengunggah berkas."; 
}

// 5. Memvalidasi Ekstensi dan Ukuran Berkas 
if ($file !== null && $file["error"] === UPLOAD_ERR_OK) { 
    $ekstensi = strtolower( 
        pathinfo($file["name"], PATHINFO_EXTENSION) 
    ); 
 
    $ekstensi_diizinkan = ["pdf", "jpg", "jpeg", "png"]; 
 
    if (!in_array($ekstensi, $ekstensi_diizinkan)) { 
        $errors[] = "Format berkas harus PDF, JPG, JPEG, atau PNG."; 
    } 
 
    $ukuran_maksimal = 1 * 1024 * 1024;  
 
    if ($file["size"] > $ukuran_maksimal) { 
        $errors[] = "Ukuran berkas maksimal adalah 1 MB."; 
    } 
} 

// 6. Menampilkan hasil validasi setelah semua pemeriksaan selesai
if (!empty($errors)) { 
    echo "<h2>Pengajuan Tidak Dapat Diproses</h2>"; 
    echo "<ul>"; 
 
    foreach ($errors as $error) { 
        echo "<li>" . 
            htmlspecialchars($error, ENT_QUOTES, "UTF-8") . 
            "</li>"; 
    } 
 
    echo "</ul>"; 
    exit; 
} 
// Menampilkan data yang diterima jika berhasil diunggah 
if ($file !== null && $file["error"] === UPLOAD_ERR_OK) { 
    echo "<h2>Pengajuan Berhasil Diterima</h2>"; 
    echo "<p>"; 
    echo "NIM: " . htmlspecialchars($nim, ENT_QUOTES, "UTF-8") . "<br>"; 
    echo "Nama: " . htmlspecialchars($nama, ENT_QUOTES, "UTF-8") . "<br>"; 
    echo "Mata Kuliah: " . htmlspecialchars($matkul, ENT_QUOTES, "UTF-8") . "<br>"; 
    echo "Nama Berkas: " . htmlspecialchars($file["name"], ENT_QUOTES, "UTF-8") . "<br>"; 
    echo "Ukuran Berkas: " . $file["size"] . " byte<br>"; 
    echo "Tipe Berkas: " . htmlspecialchars($file["type"], ENT_QUOTES, "UTF-8") . "<br>"; 
    echo "Kode Unggah: " . $file["error"] . "<br>"; 
    echo "</p>"; 
}
?>
