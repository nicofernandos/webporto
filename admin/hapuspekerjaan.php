<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

include '../db/connection.php';

// Get the product ID from URL
$idpekerjaan = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Delete the product from the database
if ($idpekerjaan) {
    $query = "DELETE FROM pekerjaan WHERE idpekerjaan = $idpekerjaan";
    if ($conn->query($query)) {
        header("Location: crudpekerjaan.php");
        echo "Error deleting record: " . $conn->error;
    }
}