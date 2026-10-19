<?php 
require_once 'config/db.php';
$delete_pro=$_POST['delete_id'];
$stmt=$pdo->prepare("DELETE FROM products WHERE ID =?");
$stmt->execute([$delete_pro]);
header("location:dashboard.php");
exit();
?>