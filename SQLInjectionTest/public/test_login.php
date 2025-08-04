<?php 
set_include_path(get_include_path() . PATH_SEPARATOR . realpath(__DIR__ . '/..'));
spl_autoload_extensions(".php");
spl_autoload_register(function($class) {
    $file = realpath(__DIR__ . '/..') . '/'  . str_replace('\\', '/', $class). '.php';
    if (file_exists(stream_resolve_include_path($file))) include($file);
});

use Database\MySQLWrapper;

$mysqli = new MySQLWrapper();
$charset = $mysqli->get_charset();
if($charset === null) throw new Exception('Charset could be read');

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
// 【危険なコード】ユーザー入力をそのままSQL文に埋め込む
// $query = "SELECT * FROM test_users WHERE username = '$username' AND password = '$password';";
// $result = $mysqli->query($query);

// 安全なコード
// 1. SQL文の「骨格」を ? を使って準備する
$stmt = $mysqli->prepare("SELECT * FROM test_users WHERE username = ? AND password = ?");

// 2. ユーザー入力を「データ」として紐付ける ("ss"は2つとも文字列(string)の意味)
$stmt->bind_param("ss", $username, $password);

// 3. 実行する
$stmt->execute();

// 4. 結果を取得する
$result = $stmt->get_result();

$userData = $result->fetch_assoc();

if ($userData) {
    $login_username = $userData["username"];
    $login_email = $userData["email"];
    $login_role = $userData["role"];

    echo "ログイン成功<br/>";
    echo "こんにちは、$login_username<br/>";
    if ($login_role == 'admin') {
        echo "role: admin でログインしています。<br/>";
        echo "password: $password<br/>";
    }
} else {
    echo "ログイン失敗<br/>";
}
?>