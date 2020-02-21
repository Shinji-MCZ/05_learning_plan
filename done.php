<?php

require_once('config.php');
require_once('functions.php');

$dbh = connectDb();

$id = $_GET['id'];

$sql = "update plans set status = 'done' where id = :id";

$stmt = $dbh->prepare($sql);
$stmt->bindParam(":id", $id);
$stmt->execute();

header('Location: index.php');
exit;
