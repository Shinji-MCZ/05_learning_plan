<?php

require_once('config.php');
require_once('functions.php');

$errors = array();

$id = $_GET['id'];

$dbh = connectDb();

$sql = "select * from plans where id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindParam(":id", $id);
$stmt->execute();

$plans = $stmt->fetch(PDO::FETCH_ASSOC);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $title = $_POST['title'];
  $due_date = $_POST['due_date'];

  if ($title === $plans['title']) {
    $errors['title'] = '学習内容が変更されてません';
  }
  if ($due_date === $plans['due_date']) {
    $errors['due_date'] = '期限が変更されてません';
  }
  if (empty($errors)){
    $sql = "update plan set title = :title, due_date = :due_date where id = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(":title", $title);
    $stmt->bindParam(":due_date", $due_date);
    $stmt->bindParam(":id", $id);
    $stmt->execute();
    header('Location: index.php');
    exit;
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
  <?php if (count($errors) > 0) : ?>
    <ul class="error">
      <?php foreach ($errors as $error) : ?>
      <li>
        <?php echo h($error); ?>
      </li>
      <? endforeach; ?>
    </ul>
  <?php endif; ?>
  <form action="" method="post">
    <p>
      <label for="title">学習内容:
        <input type="text" name="title" id="" value=<?php echo h($plans['title']); ?>>
      </label>
      <label for="due_date">期限日:
        <input type="date" name="due_date" id='' value=<?php echo h($plans['due_date']); ?>>
      </label>
      <input type="submit" value="編集">
    </p>
  </form>
</body>
</html>