<?php 
$nama = $_GET["nama"] ?? "Belum diisi"; 
 
echo "Nama mahasiswa: " . 
     htmlspecialchars($nama, ENT_QUOTES, "UTF-8"); 
?> 