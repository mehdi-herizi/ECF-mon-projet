<?php 
require 'config.php';
$stmt=$pdo->prepare("SELECT * FROM product ");
$stmt->execute();
$products=$stmt->fetchAll();

echo json_encode($products);


