<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

include '../db/connection.php';

// Get the product ID from URL
$idmakanan = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Delete the product from the database
if ($idmakanan) {
    $query = "DELETE FROM Makanan WHERE idmakanan = $idmakanan";
    if ($conn->query($query)) {
        header("Location: crudmakanan.php"); // Redirect to product management page
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
