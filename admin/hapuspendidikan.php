<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header('Location: login.php');
    exit;
}

include '../db/connection.php';

// Get the product ID from URL
$idpendidikan = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Delete the product from the database
if ($idpendidikan) {
    $query = "DELETE FROM pendidikan WHERE idpendidikan = $idpendidikan";
    if ($conn->query($query)) {
        header("Location: crudpendidikan.php");
        echo "Error deleting record: " . $conn->error;
    }
}