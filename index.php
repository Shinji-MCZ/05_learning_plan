<?php
require_once('config.php');
require_once('functions.php');

$dbh = connectDb();
//未完了
$sql = "select * from plans where status 'notyet'";
$stmt = $dbh->prepare($sql);
$stmt->execute();
$notyet_plans = $stmt->fetchAll(PDO::FETCH_ASSOC);

//完了
$sql2 = "select * from plans where status 'done'";
$stmt = $dbh->prepare($sql2);
$stmt->execute();
$done_plans = $stmt->fetchAll(PDO::FETCH_ASSOC);

//タスク追加
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
  $study = $_POST['study'];

  $errors = [];
  if ($study == '') {
  $errors['study'] = 'タスク名を入力してください';
  }
  if (empty($errors)){
  $sql = "insert into plans (study, created_at, updated_at) values (:study, now(), now())";
  $stmt = $dbh->prepare($sql);
  $stmt->bindParam(":study", $study);
  $stmt->execute();
  }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
  $deadline = $_POST['deadline'];

  $errors = [];
  if ($deadline == '') {
  $errors['deadline'] = '期限を入力してください';
  }
  if (empty($errors)){
  $sql2 = "insert into plans (deadline, created_at, updated_at) values (:deadline, now(), now())";
  $stmt = $dbh->prepare($sql2);
  $stmt->bindParam(":deadline", $deadline);
  $stmt->execute();
  }
}



?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>学習管理アプリ</title>
</head>
<body>
  <h1>学習管理アプリ</h1>
    <form action="" method="post">
      学習内容: <input type="text"><br>
      期限日: <input type="date"><input type="submit" value="追加"><br>
      <ul>
        <li class="error">
          <?php echo h($errors['study']) ; ?>
          <?php echo h($errors['deadline']) ; ?>
        </li>
      </ul>
    </from>
    
    <h2>未達成</h2>
      <ul>
      <?php foreach ($notyet_plans as $plan) : ?>
        <li>
          <?php echo h($plan['study']); ?>
        </li>
      <?php endforeach; ?>
      </ul>
    <hr>
    <h2>達成済み</h2>
</body>
</html>