<?php
// Koneksi ke database
$localhost = '127.0.0.1'; // Sesuaikan dengan host database Anda
$user = 'root'; // Sesuaikan dengan username database Anda
$pass = 'root'; // Sesuaikan dengan password database Anda
$db = 'komentar_db'; // Nama database yang telah kita buat

$connect = mysqli_connect ($localhost, $user, $pass, $db);


// Cek koneksi
if ($connect->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $connect->real_escape_string($_POST['nama']);
    $email = $connect->real_escape_string($_POST['email']);
    $isi_komentar = $connect->real_escape_string($_POST['isi_komentar']);
    
    // Insert ke database
    $sql = "INSERT INTO komentar (nama, email, isi_komentar) VALUES ('$nama', '$email', '$isi_komentar')";
    if ($connect->query($sql) === TRUE) {
        echo "<p>Komentar berhasil ditambahkan!</p>";
    } else {
        echo "<p>Terjadi kesalahan: " . $connect->error . "</p>";
    }
}

// Ambil semua komentar dari database
$sql = "SELECT * FROM komentar ORDER BY waktu DESC";
$result = $connect->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Komentar Sederhana</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 20px auto; }
        .komentar-form { margin-bottom: 30px; }
        .komentar-form input, .komentar-form textarea { width: 100%; padding: 10px; margin: 5px 0; }
        .komentar-form input[type="submit"] { width: auto; }
        .komentar { border-bottom: 1px solid #ddd; margin-bottom: 20px; padding-bottom: 10px; }
        .komentar .nama { font-weight: bold; }
        .komentar .waktu { color: #777; }
    </style>
</head>
<body>
    <h1>Sistem Komentar Sederhana</h1>
    
    <div class="komentar-form">
        <form method="POST" action="">
            <input type="text" name="nama" placeholder="Nama" required>
            <input type="email" name="email" placeholder="Email" required>
            <textarea name="isi_komentar" placeholder="Tulis komentar Anda..." required></textarea>
            <input type="submit" value="Kirim Komentar">
        </form>
    </div>
    
    <h2>Komentar:</h2>
    <?php
    // Tampilkan komentar jika ada
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='komentar'>";
            echo "<div class='nama'>" . htmlspecialchars($row['nama']) . "</div>";
            echo "<div class='waktu'>" . $row['waktu'] . "</div>";
            echo "<div class='isi_komentar'>" . nl2br(htmlspecialchars($row['isi_komentar'])) . "</div>";
            echo "</div>";
        }
    } else {
        echo "<p>Belum ada komentar.</p>";
    }
    ?>

</body>
</html>

<?php
// Tutup koneksi
$connect->close();
?>

