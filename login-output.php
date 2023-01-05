<!-- ログイン成功、ログイン失敗時の表示画面 -->
<?php session_start(); ?>

<?php require 'menu.php'; ?>

<?php
//unsetで、既にログイン中の同名ユーザーがいたら削除する
unset($_SESSION['customer']);

//PHPとデータベースを接続
$pdo=new PDO('mysql:host=localhost;dbname=shop;charset=utf8', 
	'staff', 'password');

//selecto以降で、loginとpasswordの組み合わせを検索する
$sql=$pdo->prepare('select * from customer where login=? and password=?');

//$_REQUEST['login'], $_REQUEST['password' の配列を
//execute　に渡す
$sql->execute([$_REQUEST['login'], $_REQUEST['password']]);

//sqlをexecuteメゾッドの実行結果を、foreach文でループ処理
foreach ($sql as $row) {
	$_SESSION['customer']=[
		//$row[]で,[]内の値を取得
		'id'=>$row['id'], 
		'name'=>$row['name'], 
		'address'=>$row['address'], 
		'login'=>$row['login'], 
		'password'=>$row['password']];
}

//ログイン結果の表示
if (isset($_SESSION['customer'])) {
	echo 'いらっしゃいませ、', $_SESSION['customer']['name'], 'さん。';
} else {
	echo 'ログイン名またはパスワードが違います。';
}
?>

