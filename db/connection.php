<?php
$host = "localhost:3308";
$username = "root";
$password = "";
$dbname = "phpportofoliobiodata";

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Pastikan variabel $conn didefinisikan dan berisi objek mysqli
?>