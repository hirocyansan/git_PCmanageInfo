 <?php 
function getCollateType(){
  $MAMP = false;
  if ($MAMP === true){ 
		$collateType = "utf8_unicode_ci";
	} else{
		$collateType = "Japanese_CI_AI";
	}
	return $collateType;
}
function connect2db(){
//　実行環境　MAMP/Windowsサーバの切り替え設定
  $MAMP = false;
  if ($MAMP === true){ 
	$table_list = 'pc_management_table';   	              		
	$user = 'ichi';
	$password = 'ichizero';
// 利用するデータベース
	$dbName = 'pc_management_info2';
// MySQLサーバ
	$host = 'localhost:3306';
// MySQLのDSN文字列
	$dsn = "mysql:host={$host};dbname={$dbName};charset=utf8";
  }else{
	$table_list = 'pc_management_table';   	              		
	$user = 'sa';
	$password = 'Manager4763@';
// 利用するデータベース
	$dbName = 'pc_management_info';
// SQLサーバ
	$host = 'RSFL01\SQLEXPRESS';
// SQLのDSN文字列
//	echo '$dbName = ', $dbName; echo '  $host = ', $host; echo "<br/>\n";
	$dsn = "sqlsrv:server={$host};database={$dbName}";
  }
   //MySQLデータベースに接続する
    $pdo = new PDO($dsn, $user, $password);
 
    // プリペアドステートメントのエミュレーションを無効にする
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    // 例外がスローされる設定にする
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//    echo "データベース{$dbName}に接続しました。", "<br>";
//  return $pdo;
    return[$pdo,$table_list];
}
?>