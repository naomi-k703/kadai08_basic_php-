<?php

// POSTデータの内容を確認
var_dump($_POST);  // 送信されたデータを出力

// 1. POSTデータ取得
$username = isset($_POST["username"]) ? $_POST["username"] : '';
$employee_number = isset($_POST["employee_number"]) ? $_POST["employee_number"] : '';
$department = isset($_POST["department"]) ? $_POST["department"] : '';
$position = isset($_POST["position"]) ? $_POST["position"] : '';
$gender = isset($_POST["gender"]) ? $_POST["gender"] : '';
$email = isset($_POST["email"]) ? $_POST["email"] : '';

// optionsのチェック
if (isset($_POST['options'])) {
    $options = implode(",", $_POST['options']); // コンマで結合して文字列に変換
} else {
    $options = ''; // チェックが何も選択されなかった場合
}

// naiyouの取得（フォームに含まれている場合）
$naiyou = isset($_POST['naiyou']) ? $_POST['naiyou'] : ''; // POSTデータからnaiyouを取得

// 2. DB接続
try {
    $pdo = new PDO('mysql:dbname=your_database_name;charset=utf8;host=mysqlxxxx.db.sakura.ne.jp', 'your_user_name', 'your_password');
} catch (PDOException $e) {
    exit('DB_CONNECT_ERROR: ' . $e->getMessage());
}

try {
    $pdo = new PDO('mysql:dbname=gs_db;charset=utf8;host=localhost', 'root', '');
} catch (PDOException $e) {
    exit('DB_CONNECT_ERROR: ' . $e->getMessage());
}

// 3. データ登録SQL作成
$sql = "INSERT INTO gs_an_table_TEST (username,employee_number,department,position,gender,email,naiyou,options) VALUES (:username,:employee_number,:department,:position,:gender,:email,:naiyou,:options);";
$stmt = $pdo->prepare($sql);

$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$stmt->bindValue(':employee_number', $employee_number, PDO::PARAM_STR);
$stmt->bindValue(':department', $department, PDO::PARAM_STR);
$stmt->bindValue(':position', $position, PDO::PARAM_STR);
$stmt->bindValue(':gender', $gender, PDO::PARAM_STR);
$stmt->bindValue(':email', $email, PDO::PARAM_STR);
$stmt->bindValue(':naiyou', $naiyou, PDO::PARAM_STR);
$stmt->bindValue(':options', $options, PDO::PARAM_STR);

// 4. SQL実行
$status = $stmt->execute();

// 5. データ登録処理後
if ($status == false) {
    // SQL実行時にエラーがある場合
    $error = $stmt->errorInfo();
    exit("SQL_ERROR: " . $error[2]);
} else {
    // 成功した場合、select.phpにリダイレクト
    header("Location: select.php");
    exit();
}
?>

var_dump($_POST);

