<?php 
include ('connect.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM data WHERE no='$id'";

    if (mysqli_query($connect, $sql)) {
        header("Location: index.php");
        exit();
    } else {
        echo 'Error: ' . mysqli_error($connect);
    }
} else {
    die('Id Data tidak diberikan...');
}
?>