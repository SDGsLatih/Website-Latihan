<?php

header('Content-Type: text/html; charset=UTF-8');
header('FORM RESULT');

function saveFormDataToJson($data) {

    // Menentukan path untuk penyimpanan data ke file JSON
    $file = 'form-data.json';

    // Cek apakah direktorinya sudah ada atau belum, jika belum maka akan langsung membuat direktorinya
    $dir = dirname($file);
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
    }

    // Cek apakah file tersebut ada, jika tidak maka akan langsung dibuat dengan array kosong
    if (!file_exists($file)) {
        file_put_contents($file, json_encode([]));
    }

    // Mendapatkan data yang ada dari file JSON
    $existingData = file_get_contents($file);

    // Decode data yang ada ke dalam array
    $existingDataArray = json_decode($existingData, true);

    // Menambahkan data baru ke array yang ada
    $existingDataArray[] = $data;

    // Mengencode array yang update kembali ke JSON
    $jsonData = json_encode($existingDataArray, JSON_PRETTY_PRINT);

    // Menulis kembali data JSON ke file
    if (file_put_contents($file, $jsonData)) {
        return true; // Data berhasil disimpan
    } else {
        return false; // Data gagal disimpan
    }
}

// Cek apakah form sudah di POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Menentukan array untuk menampung data formulir
    $formData = array(
        'nama' => $_POST['nama'],
        'email' => $_POST['email'],
        'subject' => $_POST['subject'],
        'pesan' => $_POST['pesan']
    );

    // Mensave data ke file JSON
    if (saveFormDataToJson($formData)) {
        
    }
    
    else {
        echo "Gagal untuk menyimpan Form Data.";
    }
}

// Mengambil data file JSON yang sudah di POST
$file = 'form-data.json';
$data = json_decode(file_get_contents($file), true);
$dataTerbaru = end($data); // Mengambil data terbaru dari arraynya

echo "Nama: " . $dataTerbaru['nama'] . "<br />";
echo "Email: " . $dataTerbaru['email'] . "<br />";
echo "Subject: " . $dataTerbaru['subject'] . "<br />";
echo "Pesan: " . $dataTerbaru['pesan'];

?>