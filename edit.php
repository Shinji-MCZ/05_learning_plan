<?php

require_once('config.php');
require_once('functions.php');

$id = $_GET['id'];

$dbh = connectDb();

$sql = "select * from plans where id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(":id", $id);
$stmt->execute();

$post = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  
  $title = $_POST['title'];
  $due_date = $_POST['due_date'];

  $errors = [];

  if ($title === $plans['title']) {
    $errors['title'] = 'タスク名が変更されてません';
  }

  if ($due_date === $plans['due_date']) {
    $errors['due_date'] = '日付が変更されてません';
  }

  if (empty($errors)){
  $sql = "update plans set title = :title, " . "due_date = :due_date where id = :id";
  $stmt = $dbh->prepare($sql);
  $stmt->bindParam(":title", $title);
  $stmt->bindParam(":due_date", $due_date);
  $stmt->bindParam(":id", $id);
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
  <title>編集画面</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>編集</h1>
  <?php if ($errors) : ?>
    <ul class="expired">
      <?php foreach ($errors as $error) : ?>
        <li>
          <?php echo h($error); ?>
        </li>
      <? endforeach; ?>
    </ul>
  <?php endif; ?>
    </ul>
  <form action="" method="post">
    <p>
      <label for="title">学習内容:</label>
      <input type="text" name="title" id="" value=<?php echo h($post['title']); ?>>
      <label for="due_date">期限日:</label>
      <input type="date" name="due_date" id='' value=<?php echo h($post['due_date']); ?>>
      <input type="submit" value="編集">
    </p>
  </form>
</body>
</html>