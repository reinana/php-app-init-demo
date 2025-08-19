<?php
// コードベースのファイルのオートロード
spl_autoload_extensions(".php");
spl_autoload_register(function ($class) {
    $file = __DIR__ . '/'  . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) include($file);
});

// composerの依存関係のオートロード
require_once 'vendor/autoload.php';

use Helpers\RandomGenerator;

// クエリ文字列からパラメータを取得
$min = $_GET['min'] ?? 5;
$max = $_GET['max'] ?? 20;

// パラメータが整数であることを確認
$min = (int)$min;
$max = (int)$max;

// ユーザーの生成
$users = RandomGenerator::users($min, $max);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profiles</title>
    <link rel="stylesheet" href="css\styles.css">
</head>

<body>
    <h1>User Profiles</h1>

    <?php foreach ($users as $user): ?>

        <?php
        // User::toHTML() は <div class="user-card"> ... を返す想定
        echo $user->toHTML();
        ?>
    <?php endforeach; ?>

</body>

</html>