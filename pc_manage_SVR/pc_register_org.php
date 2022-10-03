<?php
require_once("util.php");
require_once("function_em.php");
require_once("login_database.php");
setLocale(LC_ALL, 'English_United States.1252');

   
// echo "行番号:".__LINE__."<br />";
?>

<?php

// ----- $pageNumber=0にして他の設定値はそのまま書込（ファイルがなければデフォルト値設定） -----

// セッション開始
session_start();

// $filename = "..\parameters.txt";
$pageNumber = 0;
if (isset($_SESSION['parameters'])) {
	//$pageNumberのみ値変更して書き込み
//	$filename = "..\parameters.txt";
	$mergedData = $_SESSION['parameters'];
	$kwd = explode("#", $mergedData);
	$KwdSetStatus = $kwd[1];
	$searchType = $kwd[2];
	$kwdCompanyPrev = $kwd[3];
	$kwdOfficePrev = $kwd[4];
	$kwdRegisterNoPrev = $kwd[5];
	$kwdPlacePrev = $kwd[6];
	$kwdMakerPrev = $kwd[7];
	$kwdModelPrev = $kwd[8];
	$kwdCarryOutPrev = $kwd[9];
	$kwdRentalTerminationPrev = $kwd[10];
//	if ($orderType == null){ $orderType = 'orderAsc';} else { $orderType = $kwd[11];}
	$orderType = $kwd[11];
	$sortRule = $kwd[12];
} else{
// echo  "行番号:".__LINE__."<br />";
	$KwdSetStatus = 'kwdReset';
	$searchType = 'andSearch';
	$kwdCompanyPrev = "no_keyword";
	$kwdOfficePrev = "no_keyword";
	$kwdRegisterNoPrev = "no_keyword";
	$kwdPlacePrev = "no_keyword";
	$kwdMakerPrev = "no_keyword";
	$kwdModelPrev = "no_keyword";
	$kwdCarryOutPrev = "no_keyword";
	$kwdRentalTerminationPrev =  "no_keyword";
	$orderType = 'orderAsc';
	$sortRule = 'no_keyword';
}
$mergedData = $pageNumber.'#'.$KwdSetStatus.'#'.$searchType.'#'.$kwdCompanyPrev.'#'.$kwdOfficePrev.'#'.
              $kwdRegisterNoPrev.'#'.$kwdPlacePrev.'#'.$kwdMakerPrev.'#'.$kwdModelPrev.'#'.$kwdCarryOutPrev.'#'.
              $kwdRentalTerminationPrev.'#'.$orderType.'#'.$sortRule;
$_SESSION['parameters'] = $mergedData;


if($_SERVER['REQUEST_METHOD']=='POST') {

//	----- 検索結果を表示するページへ移行 -----  

	if (isset($_POST['startSearch'])){
		//  検索条件が入力されていない場合、トップに戻す
		if ((es($_POST["kwdCompany"]) !== "")||(es($_POST["kwdOffice"]) !== "")
//		if ((es($_POST["kwdCompany"]) !== "")
		||(es($_POST["kwdRegisterNo"]) !== "")||(es($_POST["kwdPlace"]) !== "")
		||(es($_POST["kwdMaker"]) !=="")||(es($_POST["kwdModel"]) !== "")
		||(es($_POST["kwdCarryOut"]) !== "")||(es($_POST["kwdRentalTermination"]) !== "")){

		//$pageNumberのみ値変更して書き込み
//			$filename = "..\parameters.txt";
 			
			$mergedData = $_SESSION['parameters'];
			$kwd = explode("#", $mergedData);
			$KwdSetStatus = $kwd[1];
			$searchType = $kwd[2];
			$kwdCompanyPrev = $kwd[3];
			$kwdOfficePrev = $kwd[4];
			$kwdRegisterNoPrev = $kwd[5];
			$kwdPlacePrev = $kwd[6];
			$kwdMakerPrev = $kwd[7];
			$kwdModelPrev = $kwd[8];
			$kwdCarryOutPrev = $kwd[9];
			$kwdRentalTerminationPrev = $kwd[10];
//			if ($orderType == ""){ $orderType = 'orderAsc';} else { $orderType = $kwd[11];}
			$orderType = $kwd[11];
			$sortRule = $kwd[12];

			$pageNumber = 1;
			$mergedData = $pageNumber.'#'.$KwdSetStatus.'#'.$searchType.'#'.$kwdCompanyPrev.'#'.$kwdOfficePrev.'#'.
	        	          $kwdRegisterNoPrev.'#'.$kwdPlacePrev.'#'.$kwdMakerPrev.'#'.$kwdModelPrev.'#'.$kwdCarryOutPrev.'#'.
	                      $kwdRentalTerminationPrev.'#'.$orderType.'#'.$sortRule;

			$_SESSION['parameters'] = $mergedData;
		}else{
			//$pageNumberのみ値変更して書き込み
//			$filename = "..\parameters.txt";
			$mergedData = $_SESSION['parameters'];
			$kwd = explode("#", $mergedData);
			$KwdSetStatus = $kwd[1];
			$searchType = $kwd[2];
			$kwdCompanyPrev = $kwd[3];
			$kwdOfficePrev = $kwd[4];
			$kwdRegisterNoPrev = $kwd[5];
			$kwdPlacePrev = $kwd[6];
			$kwdMakerPrev = $kwd[7];
			$kwdModelPrev = $kwd[8];
			$kwdCarryOutPrev = $kwd[9];
			$kwdRentalTerminationPrev = $kwd[10];
//			if ($orderType == ""){ $orderType = 'orderAsc';} else { $orderType = $kwd[11];}
			$orderType = $kwd[11];
			$sortRule = $kwd[12];
			
			$pageNumber = 2;
			$mergedData = $pageNumber.'#'.$KwdSetStatus.'#'.$searchType.'#'.$kwdCompanyPrev.'#'.$kwdOfficePrev.'#'.
	        	          $kwdRegisterNoPrev.'#'.$kwdPlacePrev.'#'.$kwdMakerPrev.'#'.$kwdModelPrev.'#'.$kwdCarryOutPrev.'#'.
	                      $kwdRentalTerminationPrev.'#'.$orderType.'#'.$sortRule;
			$_SESSION['parameters'] = $mergedData;

		// ワーニング表示
	  		$errors[] = '検索キーワードが入力されていません。';
  			foreach($errors as $row){
  				echo "<label>", $row,  "</label>";
  			}
    //<!-- 戻るボタンのフォーム -->
  			echo " <form method=\"POST\" action=\"employee_search.php\">";
  			echo "<input type=\"submit\" value=\"トップへ戻る\"　name=\"return2Top\">";
  			echo "</form>";
		}
	}
	
// ----- パラメータクリアボタンが押された場合 -----

	if (isset($_POST['parameterClear'])){
		$pageNumber = 0;
		$KwdSetStatus = 'kwdReset';
		$searchType = 'andSearch';
		$kwdCompanyPrev = "no_keyword";
		$kwdOfficePrev = "no_keyword";
		$kwdRegisterNoPrev = "no_keyword";
		$kwdPlacePrev = "no_keyword";
		$kwdMakerPrev = "no_keyword";
		$kwdModelPrev = "no_keyword";
		$kwdCarryOutPrev = "no_keyword";
		$kwdRentalTerminationPrev = "no_keyword";
		$orderType = 'orderAsc';
		$sortRule = 'no_keyword';

		$mergedData = $pageNumber.'#'.$KwdSetStatus.'#'.$searchType.'#'.$kwdCompanyPrev.'#'.$kwdOfficePrev.'#'.
	                  $kwdRegisterNoPrev.'#'.$kwdPlacePrev.'#'.$kwdMakerPrev.'#'.$kwdModelPrev.'#'.$kwdCarryOutPrev.'#'.
                      $kwdRentalTerminationPrev.'#'.$orderType.'#'.$sortRule;
		$_SESSION['parameters'] = $mergedData;

//		$filename = "..\parameters.txt";
		if(isset($_SESSION['parameters'])){
			$mergedData = $_SESSION['parameters'];
		}
	}

// ----- トップページへ戻る -----  

	if (isset($_POST['return2Top'])){

		$GLOBALS['pageNumber'] = 0;	
		//$kwdSetStatus、$pageNumberのみ値変更して書き込み
//		$filename = "..\parameters.txt";
		$mergedData = $_SESSION['parameters'];
		$kwd = explode("#", $mergedData);
		$searchType = $kwd[2];
		$kwdCompanyPrev = $kwd[3];
		$kwdOfficePrev = $kwd[4];
		$kwdRegisterNoPrev = $kwd[5];
		$kwdPlacePrev = $kwd[6];
		$kwdMakerPrev = $kwd[7];
		$kwdModelPrev = $kwd[8];
		$kwdCarryOutPrev = $kwd[9];
		$kwdRentalTerminationPrev = $kwd[10];
//		if ($orderType == ""){ $orderType = 'orderAsc';} else { $orderType = $kwd[10];}
		$orderType = $kwd[11];
		$sortRule = $kwd[12];

		$kwdSetStatus = 'kwdSet';
		$pageNumber = 0;
		$mergedData = $pageNumber.'#'.$KwdSetStatus.'#'.$searchType.'#'.$kwdCompanyPrev.'#'.$kwdOfficePrev.'#'.
   	    		      $kwdRegisterNoPrev.'#'.$kwdPlacePrev.'#'.$kwdMakerPrev.'#'.$kwdModelPrev.'#'.$kwdCarryOutPrev.'#'.
                      $kwdRentalTerminationPrev.'#'.$orderType.'#'.$sortRule;
		$_SESSION['parameters'] = $mergedData;
	}

// ----- 検索ソフト終了、設定クリア -----  

	if  (isset($_POST['return2Close'])){
		// 設定データクリア
		$pageNumber = 0;
		$KwdSetStatus = 'kwdReset';
		$searchType = 'andSearch';
		$kwdCompanyPrev = "no_keyword";
		$kwdOfficePrev = "no_keyword";
		$kwdRegisterNoPrev = "no_keyword";
		$kwdPlacePrev = "no_keyword";
		$kwdMakerPrev = "no_keyword";
		$kwdModelPrev = "no_keyword";
		$kwdCarryOutPrev = "no_keyword";
		$kwdRentalTerminationPrev = "no_keyword";
		$orderType = 'orderAsc';
		$sortRule = 'no_keyword';
		
		$mergedData = $pageNumber.'#'.$KwdSetStatus.'#'.$searchType.'#'.$kwdCompanyPrev.'#'.$kwdOfficePrev.'#'.
        	          $kwdRegisterNoPrev.'#'.$kwdPlacePrev.'#'.$kwdMakerPrev.'#'.$kwdModelPrev.'#'.$kwdCarryOutPrev.'#'.
                      $kwdRentalTerminationPrev.'#'.$orderType.'#'.$sortRule;
		$_SESSION['parameters'] = $mergedData;
		//　セッションのクリア
		unset($_SESSION['parameters']);		

		exit('処理を終了します。お疲れさまでした。');
	}
 }
?>

<?php

// parameters.txtファイルがあれば読み出し、なければ初期値を設定してファイル生成

// $filename = "..\parameters.txt";
if (isset($_SESSION['parameters'])) {
	$mergedData = $_SESSION['parameters'];
	$kwd = explode("#", $mergedData);
	$pageNumber = (int)$kwd[0];
	$kwdSetStatus = $kwd[1];
	$searchType = $kwd[2];
	$kwdCompanyPrev = $kwd[3];
	$kwdOfficePrev = $kwd[4];
	$kwdRegisterNoPrev = $kwd[5];
	$kwdPlacePrev = $kwd[6];
	$kwdMakerPrev = $kwd[7];
	$kwdModelPrev = $kwd[8];
	$kwdCarryOutPrev = $kwd[9];
	$kwdRentalTerminationPrev = $kwd[10];
//	if ($orderType == ""){ $orderType = 'orderAsc';} else { $orderType = $kwd[10];}
	$orderType = $kwd[11];
	$sortRule = $kwd[12];
}else{
	$pageNumber = 0;
	$kwdSetStatus = 'kwdReset';
	$searchType = 'andSearch';
	$kwdCompanyPrev = "no_keyword";
	$kwdOfficePrev = "no_keyword";
	$kwdRegisterNoPrev = "no_keyword";
	$kwdPlacePrev = "no_keyword";
	$kwdMakerPrev = "no_keyword";
	$kwdModelPrev = "no_keyword";
	$kwdCarryOutPrev = "no_keyword";
	$kwdRentalTerminationPrev = "no_keyword";
	$orderType = 'orderAsc';
	$sortRule = 'no_keyword';
	$mergedData = $pageNumber.'#'.$kwdSetStatus.'#'.$searchType.'#'.$kwdCompanyPrev.'#'.$kwdOfficePrev.'#'.
                  $kwdRegisterNoPrev.'#'.$kwdPlacePrev.'#'.$kwdMakerPrev.'#'.$kwdModelPrev.'#'.$kwdCarryOutPrev.'#'.
                  $kwdRentalTerminationPrev.'#'.$orderType.'#'.$sortRule;
	$_SESSION['parameters'] = $mergedData;
}


if ($GLOBALS['pageNumber'] == 0){
	titleDisplay();
	topListDisplay();
//	allListDisplay();

echo "</div>";
// echo  '<p align="right">&copy;Copyright ADVANTEC Grp.SYSTEM Div. All right reserved. REV1.0</p>';
echo "</body>";
echo "</html>";

}else{		// 以下、$pageNumber = 1の処理 ----------------------------
	if ($GLOBALS['pageNumber'] == 1){
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>検索結果の表示</title>
<link href="style_post.css" rel="stylesheet">
<!-- テーブル用のスタイルシート -->
<link rel="stylesheet" type="text/css" href="style2_org.css" >
</head>

<!--
<body>
<body onContextmenu="window.alert('右クリックは禁止です');return false" oncopy="window.alert('ctrl+cは禁止');return false;">
<style type="text/css">
/* ページ全体を印刷させない場合 */
@media print {
    body { display: none !important; }
}
</style> 
-->

<div>
<?php
    // フォーム入力の値を得る（keyword）、入力kwdの左右の空白を削除
  $errors = [];
  $GLOBALS['searchType'] = trim(es($_POST["searchType"]));
  $GLOBALS['orderType'] = trim(es($_POST["orderType"]));
  $GLOBALS['sortRule'] = trim(es($_POST["sortRule"]));


//  var_dump($GLOBALS['orderType']);
//  var_dump($GLOBALS['sortRule']);
 
  $kwdCompany = preg_replace('/^[ 　]+/u', '', es($_POST["kwdCompany"]));
  $kwdCompany = preg_replace('/[ 　]+$/u', '', $kwdCompany);
  $GLOBALS['kwdCompanyPrev'] = $kwdCompany;
  $kwdCompany = (array)setKwd($GLOBALS['kwdCompanyPrev']);
 $i = 0;
 do{
  	$kwdCompany[$i] = preg_replace('/^[ 　]+/u', '', $kwdCompany[$i]);
  	$kwdCompany[$i] = preg_replace('/[ 　]+$/u', '', $kwdCompany[$i]);
  	$i ++;
  } while ($i < count($kwdCompany));

// var_dump($kwdCompany);echo "<br/>\n";

  $kwdOffice = preg_replace('/^[ 　]+/u', '', es($_POST["kwdOffice"]));
  $kwdOffice = preg_replace('/[ 　]+$/u', '', $kwdOffice);
  $GLOBALS['kwdOfficePrev'] = $kwdOffice;
  $kwdOffice = (array)setKwd($GLOBALS['kwdOfficePrev']);
 $i = 0;
 do{
  	$kwdOffice[$i] = preg_replace('/^[ 　]+/u', '', $kwdOffice[$i]);
  	$kwdOffice[$i] = preg_replace('/[ 　]+$/u', '', $kwdOffice[$i]);
  	$i ++;
  } while ($i < count($kwdOffice));

  $kwdRegisterNo = preg_replace('/^[ 　]+/u', '', es($_POST["kwdRegisterNo"]));
  $kwdRegisterNo = preg_replace('/[ 　]+$/u', '', $kwdRegisterNo);
  $GLOBALS['kwdRegisterNoPrev'] = $kwdRegisterNo;
  $kwdRegisterNo = (array)setKwd($GLOBALS['kwdRegisterNoPrev']);
 $i = 0;
 do{
  	$kwdRegisterNo[$i] =preg_replace('/^[ 　]+/u', '', $kwdRegisterNo[$i]);
  	$kwdRegisterNo[$i] = preg_replace('/[ 　]+$/u', '', $kwdRegisterNo[$i]);
  	$i ++;
  } while ($i < count($kwdRegisterNo));

  $kwdPlace = preg_replace('/^[ 　]+/u', '', es($_POST["kwdPlace"]));
  $kwdPlace = preg_replace('/[ 　]+$/u', '', $kwdPlace);
  $GLOBALS['kwdPlacePrev'] = $kwdPlace;
  $kwdPlace = (array)setKwd($GLOBALS['kwdPlacePrev']);
 $i = 0;
 do{
  	$kwdPlace[$i] =preg_replace('/^[ 　]+/u', '', $kwdPlace[$i]);
  	$kwdPlace[$i] = preg_replace('/[ 　]+$/u', '', $kwdPlace[$i]);
  	$i ++;
  } while ($i < count($kwdPlace));

  $kwdMaker = preg_replace('/^[ 　]+/u', '', es($_POST["kwdMaker"]));
  $kwdMaker = preg_replace('/[ 　]+$/u', '', $kwdMaker);
  $GLOBALS['kwdMakerPrev'] = $kwdMaker;
  $kwdMaker = (array)setKwd($GLOBALS['kwdMakerPrev']);
 $i = 0;
 do{
  	$kwdMaker[$i] =preg_replace('/^[ 　]+/u', '', $kwdMaker[$i]);
  	$kwdMaker[$i] = preg_replace('/[ 　]+$/u', '', $kwdMaker[$i]);
  	$i ++;
  } while ($i < count($kwdMaker));

  $kwdModel = preg_replace('/^[ 　]+/u', '', es($_POST["kwdModel"]));
  $kwdModel = preg_replace('/[ 　]+$/u', '', $kwdModel);
  $GLOBALS['kwdModelPrev'] = $kwdModel;
  $kwdModel = (array)setKwd($GLOBALS['kwdModelPrev']);
 $i = 0;
 do{
  	$kwdModel[$i] =preg_replace('/^[ 　]+/u', '', $kwdModel[$i]);
  	$kwdModel[$i] = preg_replace('/[ 　]+$/u', '', $kwdModel[$i]);
  	$i ++;
  } while ($i < count($kwdModel));


  $kwdCarryOut = preg_replace('/^[ 　]+/u', '', es($_POST["kwdCarryOut"]));
  $kwdCarryOut = preg_replace('/[ 　]+$/u', '', $kwdCarryOut);
  $GLOBALS['kwdCarryOutPrev'] = $kwdCarryOut;
  $kwdCarryOut = (array)setKwd($GLOBALS['kwdCarryOutPrev']);
 $i = 0;
 do{
  	$kwdCarryOut[$i] =preg_replace('/^[ 　]+/u', '', $kwdCarryOut[$i]);
  	$kwdCarryOut[$i] = preg_replace('/[ 　]+$/u', '', $kwdCarryOut[$i]);
  	$i ++;
  } while ($i < count($kwdCarryOut));

  $kwdRentalTermination = preg_replace('/^[ 　]+/u', '', es($_POST["kwdRentalTermination"]));
  $kwdRentalTermination = preg_replace('/[ 　]+$/u', '', $kwdRentalTermination);
  $GLOBALS['kwdRentalTerminationPrev'] = $kwdRentalTermination;
  $kwdRentalTermination = (array)setKwd($GLOBALS['kwdRentalTerminationPrev']);
 $i = 0;
 do{
  	$kwdRentalTermination[$i] =preg_replace('/^[ 　]+/u', '', $kwdRentalTermination[$i]);
  	$kwdRentalTermination[$i] = preg_replace('/[ 　]+$/u', '', $kwdRentalTermination[$i]);
  	$i ++;
  } while ($i < count($kwdRentalTermination));

$originalkwdCompany = $kwdCompany; 
$originalkwdOffice = $kwdOffice; 
$originalkwdRegisterNo = $kwdRegisterNo; 
$originalkwdPlace = $kwdPlace; 
$originalkwdMaker = $kwdMaker; 
$originalkwdModel = $kwdModel; 
$originalkwdCarryOut = $kwdCarryOut; 
$originalkwdRentalTermination = $kwdRentalTermination;

// ----- 検索結果を表示する前に設定データをファイルへ保存 -----

    $kwdSetStatus = 'kwdSet';
	$mergedData = $pageNumber.'#'.$kwdSetStatus.'#'.$searchType.'#'.$kwdCompanyPrev.'#'.$kwdOfficePrev.'#'.
                  $kwdRegisterNoPrev.'#'.$kwdPlacePrev.'#'.$kwdMakerPrev.'#'.$kwdModelPrev.'#'.$kwdCarryOutPrev.'#'.
                  $kwdRentalTerminationPrev.'#'.$orderType.'#'.$sortRule;
                  
//    var_dump($mergedData);
	$_SESSION['parameters'] = $mergedData;

 echo ' <div class="Header1">';
 echo "<div>","<h1 align=\"center\">",'<font color ="444444">',"#### 検索結果 ####","</font></h1>","</div>"; 

   // 戻るボタンのフォーム 
   echo ' <form method="POST" action="">';

   echo '<ul>';
   echo "<nobr>",'<font color ="444444">',"■検索結果  (確認後)  ---->";

   // 入力したkwdは全てリセットをデフォルト設定

  echo '<input type="submit" class ="button1" value="トップへ戻る" name="return2Top">';
  echo '&nbsp;&nbsp;&nbsp;終了する場合は  ---->';echo '<input type="submit" class ="button1" value="終了" name="return2Close"></font></nobr>';
  echo '<ul><font color ="444444">';echo "<SPAN style=\"margin-left:-40px\">","■検索条件：  ";
  if ($GLOBALS['searchType'] ==="orSearch"){
  	echo 'ORサーチ'; 
  }else{
  	echo 'ANDサーチ';  
  }

if ($sortRule != 'no_keyword'){
	echo "&nbsp; &nbsp;&nbsp; &nbsp;◦並べ替え対象: $sortRule"; 
	if ($orderType == 'orderAsc'){ echo '&nbsp; &nbsp;◎昇順';} else { echo '&nbsp; &nbsp;◎降順';}
}
echo "</span>";echo "</li>";

   
//  入力されたキーワードの確認表示

if ($originalkwdCompany != 'no_keyword'){
  echo "<li>";echo "<span>"; echo  "検索キーワード(会社名)：　";	
  $i = 0;
  do{ echo $originalkwdCompany[$i], '&nbsp; &nbsp; &nbsp; ';$i ++;
  }while(count((array)$originalkwdCompany)> $i );
  echo "</span>";echo "</li>";
} else {
  echo  "<li>";echo "<span>"; echo  "検索キーワード(会社名):なし", "</span>";echo "</li>";		
}	

if ($originalkwdOffice != false){
  echo "<li>";echo "<span>"; echo  "検索キーワード(事業所)：　";
  $i = 0;
  do{ echo $originalkwdOffice[$i], '&nbsp; &nbsp; &nbsp; ';$i ++;
  }while(count((array)$originalkwdOffice)> $i );
  echo "</span>";echo "</li>";
} else {
  echo  "<li>";echo "<span>"; echo  "検索キーワード(事業所):なし","</span>";echo "</li>";	
}

if ($originalkwdRegisterNo != 'no_keyword'){
  echo "<li>";echo "<span>"; echo  "検索キーワード(台帳番号)：　";
  $i = 0;
  do{ echo $originalkwdRegisterNo[$i], '&nbsp; &nbsp; &nbsp; ';$i ++;
  }while(count((array)$originalkwdRegisterNo)> $i );
  echo "</span>";echo "</li>";
} else {
  echo  "<li>";echo "<span>"; echo  "検索キーワード(台帳番号):なし","</span>";echo "</li>";	
}

if ($originalkwdMaker != 'no_keyword'){
  echo "<li>";echo "<span>"; echo  "検索キーワード(メーカー)：　";
  $i = 0;
  do{ echo $originalkwdMaker[$i], '&nbsp; &nbsp; &nbsp; ';$i ++;
  }while(count((array)$originalkwdMaker)> $i );
  echo "</span>";echo "</li>";
} else {
  echo  "<li>";echo "<span>"; echo  "検索キーワード(メーカー):なし","</span>";echo "</li>";	
}

if ($originalkwdPlace != 'no_keyword'){
  echo "<li>";echo "<span>"; echo  "検索キーワード(設置場所)：　";
  $i = 0;
  do{ echo $originalkwdPlace[$i], '&nbsp; &nbsp; &nbsp; ';$i ++;
  }while(count((array)$originalkwdPlace)> $i );
  echo "</span>";echo "</li>";
} else {
  echo  "<li>";echo "<span>"; echo  "検索キーワード(設置場所):なし","</span>";echo "</li>";	
}

if ($originalkwdModel != 'no_keyword'){
  echo "<li>";echo "<span>"; echo  "検索キーワード(型式)：　";
  $i = 0;
  do{ echo $originalkwdModel[$i], '&nbsp; &nbsp; &nbsp; ';$i ++;
  }while(count((array)$originalkwdModel)> $i );
  echo "</span>";echo "</li>";
} else {
  echo  "<li>";echo "<span>"; echo  "検索キーワード(型式):なし","</span>";echo "</li>";	
}

if ($originalkwdCarryOut != 'no_keyword'){
  echo "<li>";echo "<span>"; echo  "検索キーワード(持出可否)：　";
  $i = 0;
  do{ echo $originalkwdCarryOut[$i], '&nbsp; &nbsp; &nbsp; ';$i ++;
  }while(count((array)$originalkwdCarryOut)> $i );
  echo "</span>";echo "</li>";
} else {
  echo  "<li>";echo "<span>"; echo  "検索キーワード(持出可否):なし","</span>";echo "</li>";	
}

if ($originalkwdRentalTermination != 'no_keyword'){
  echo "<li>";echo "<span>"; echo  "検索キーワード(レンタル終了)：　";
  $i = 0;
  do{ echo $originalkwdRentalTermination[$i], '&nbsp; &nbsp; &nbsp; ';$i ++;
  }while(count((array)$originalkwdRentalTermination)> $i );
  echo "</span>";echo "</li>";
} else {
  echo  "<li>";echo "<span>"; echo  "検索キーワード(レンタル終了):なし","</span>";echo "</li>";	
}
  echo '</font></ul>';

 
   // テーブルのタイトル行
   	echo "<br/>\n";
	echo "<table class=\"info2\">";
  	echo "<tr>";
   	echo "<th class=\"th00\">", "No.", "</th>";
   	echo "<th class=\"th0\">", "会社名", "</th>";
  	echo "<th class=\"th1\">", "事業所", "</th>";
  	echo "<th class=\"th2\">", "台帳番号", "</th>";
 	echo "<th class=\"th4\">", "メーカー", "</th>";  	
  	echo "<th class=\"th3\">", "設置場所", "</th>";
  	echo "<th class=\"th5\">", "型式", "</th>";
  	echo "<th class=\"th6\">", "持出可否", "</th>";
  	echo "<th class=\"th7\">", "レンタル終了", "</th>";
  	echo "</tr>";


 	echo "</table>"," </div>";
 	echo '<div class="Contents1">';
 	echo "<table class=\"info2\">";

	// SQLサーバに接続
  	list($pdo,$table_list) = connect2db(); 

$collateType = getCollateType();
if ($GLOBALS['searchType'] === "andSearch"){

	$sql = "";
    if ($kwdCompany[0] !== ""){
		foreach ($kwdCompany as $row) {
			 if ( $sql == "") { 
			 	$sql = " SELECT * FROM $table_list WHERE((会社名 COLLATE $collateType LIKE '%". $row ."%')";
			 	$positionIndicator = 1;
			 }else { 
			 	$sql = $sql."OR (会社名 COLLATE $collateType LIKE '%". $row ."%')"; 
	 		}
		} 
	 	if (substr_count($sql, '(') > substr_count($sql, ')')){ $sql = $sql. ')'; }
	 }
	$positionIndicator = 0;
    if ($kwdOffice[0] !== ""){
		foreach ($kwdOffice as $row) {
			 if ( $sql == "") { 
			 	$sql = " SELECT * FROM $table_list WHERE((事業所 COLLATE $collateType LIKE '%". $row ."%')";
			 	$positionIndicator = 1;
			 }else { 
			 	if ($positionIndicator == 1){
			 		$sql = $sql."OR (事業所 COLLATE $collateType LIKE '%". $row ."%')"; 
			 	} else{
			 		$sql = $sql."AND ((事業所 COLLATE $collateType LIKE '%". $row ."%')"; 
				 	$positionIndicator = 1;
			 	}
	 		}
		} 
 	if (substr_count($sql, '(') > substr_count($sql, ')')){ $sql = $sql. ')'; }
	}
    $positionIndicator = 0;
    if ($kwdRegisterNo[0] !== ""){
		foreach ($kwdRegisterNo as $row) {
			 if ( $sql == ""){ 
			 	$sql = " SELECT * FROM $table_list WHERE((台帳番号 COLLATE $collateType LIKE '%". $row ."%')";
			 	$positionIndicator = 1;
			 }else { 
			 	if ($positionIndicator == 1){
			 		$sql = $sql."OR (台帳番号 COLLATE $collateType LIKE '%". $row ."%')"; 
			 	} else{
			 		$sql = $sql."AND ((台帳番号 COLLATE $collateType LIKE '%". $row ."%')"; 
				 	$positionIndicator = 1;
			 	}
	 		}
		} 
 	if (substr_count($sql, '(') > substr_count($sql, ')')){ $sql = $sql. ')'; }
 	}
    $positionIndicator = 0;
    if ($kwdPlace[0] !== ""){
		foreach ($kwdPlace as $row) {
			 if ( $sql == "") { 
			 	$sql = " SELECT * FROM $table_list WHERE((設置場所 COLLATE $collateType LIKE '%". $row ."%')";
			 	$positionIndicator = 1;
			 }else { 
			 	if ($positionIndicator == 1){
			 		$sql = $sql."OR (設置場所 COLLATE $collateType LIKE '%". $row ."%')"; 
			 	} else{
			 		$sql = $sql."AND ((設置場所 COLLATE $collateType LIKE '%". $row ."%')"; 
				 	$positionIndicator = 1;
			 	}
	 		}
		}
 	if (substr_count($sql, '(') > substr_count($sql, ')')){ $sql = $sql. ')'; }
 	}
    $positionIndicator = 0;
    if ($kwdMaker[0] !== ""){
		foreach ($kwdMaker as $row) {
			 if ( $sql == "") { 
			 	$sql = " SELECT * FROM $table_list WHERE((メーカー COLLATE $collateType LIKE '%". $row ."%')";
			 	$positionIndicator = 1;
			 }else { 
			 	if ($positionIndicator == 1){
			 		$sql = $sql."OR (メーカー COLLATE $collateType LIKE '%". $row ."%')"; 
			 	} else{
			 		$sql = $sql."AND ((メーカー COLLATE $collateType LIKE '%". $row ."%')"; 
				 	$positionIndicator = 1;
			 	}
	 		}
		} 
 	if (substr_count($sql, '(') > substr_count($sql, ')')){ $sql = $sql. ')'; }
 	}
    $positionIndicator = 0;
    if ($kwdModel[0] !== ""){
		foreach ($kwdModel as $row) {
			 if ( $sql == "") { 
			 	$sql = " SELECT * FROM $table_list WHERE((型式 COLLATE $collateType LIKE '%". $row ."%')";
			 	$positionIndicator = 1;
			 }else { 
			 	if ($positionIndicator == 1){
			 		$sql = $sql."OR (型式 COLLATE $collateType LIKE '%". $row ."%')"; 
			 	} else{
			 		$sql = $sql."AND ((型式 COLLATE $collateType LIKE '%". $row ."%')"; 
				 	$positionIndicator = 1;
			 	}
	 		}
		} 	
 		if (substr_count($sql, '(') > substr_count($sql, ')')){ $sql = $sql. ')'; }
	}
    $positionIndicator = 0;
    if ($kwdCarryOut[0] != ""){
		foreach ($kwdCarryOut as $row) {
			 if ( $sql == "") { 
			 	$sql = " SELECT * FROM $table_list WHERE((持出可否 COLLATE $collateType LIKE '%". $row ."%')";
			 	$positionIndicator = 1;
			 }else { 
			 	if ($positionIndicator == 1){
			 		$sql = $sql."OR (持出可否 COLLATE $collateType LIKE '%". $row ."%')"; 
			 	} else{
			 		$sql = $sql."AND ((持出可否 COLLATE $collateType LIKE '%". $row ."%')"; 
				 	$positionIndicator = 1;
			 	}
	 		}
		} 
 		if (substr_count($sql, '(') > substr_count($sql, ')')){ $sql = $sql. ')'; }
 	}

    $positionIndicator = 0;
    if ($kwdRentalTermination[0] != ""){
		foreach ($kwdRentalTermination as $row) {
			 if ( $sql == "") { 
			 	$sql = " SELECT * FROM $table_list WHERE((レンタル終了 COLLATE $collateType LIKE '%". $row ."%')";
			 	$positionIndicator = 1;
			 }else { 
			 	if ($positionIndicator == 1){
			 		$sql = $sql."OR (レンタル終了 COLLATE $collateType LIKE '%". $row ."%')"; 
			 	} else{
			 		$sql = $sql."AND ((レンタル終了 COLLATE $collateType LIKE '%". $row ."%')"; 
				 	$positionIndicator = 1;
			 	}
	 		}
		} 
 		if (substr_count($sql, '(') > substr_count($sql, ')')){ $sql = $sql. ')'; }
 	}

}else{

 // ------------- OR検索 -----------------
	 // 大文字小文字/全角半角を区別しないで比較　https://qiita.com/kazu56/items/6af85ffcf8d3954455ad
	$sql = "";
	if ($kwdCompany[0] != ""){
		foreach ($kwdCompany as $row) {
			 if ( $sql == "") { 
			 	$sql = " SELECT * FROM $table_list WHERE(会社名 COLLATE $collateType LIKE '%". $row ."%')"; 
			 }else { 
			 	$sql = $sql."OR (会社名 COLLATE $collateType LIKE '%". $row ."%')";
			 }
		}
	}
	if ($kwdOffice[0] != ""){	
		foreach ($kwdOffice as $row) {
			 if ( $sql == "") { 
			 	$sql = " SELECT * FROM $table_list WHERE(事業所 COLLATE $collateType LIKE '%". $row ."%')"; 
			 }else { 
			 	$sql = $sql."OR (事業所 COLLATE $collateType LIKE '%". $row ."%')";
			 }
		}
	}
	if ($kwdRegisterNo[0] != ""){
		foreach ($kwdRegisterNo as $row) {
			 if ( $sql == "") { 
			 	$sql = " SELECT * FROM $table_list WHERE(台帳番号 COLLATE $collateType LIKE '%". $row ."%')"; 
			 }else { 
			 	$sql = $sql."OR (台帳番号 COLLATE $collateType LIKE '%". $row ."%')";
			 }
		}
	}
	if ($kwdPlace[0] != ""){
		foreach ($kwdPlace as $row) {
			 if ( $sql == "") { 
			 	$sql = " SELECT * FROM $table_list WHERE(設置場所 COLLATE $collateType LIKE '%". $row ."%')"; 
			 }else { 
			 	$sql = $sql."OR (設置場所 COLLATE $collateType LIKE '%". $row ."%')";
			 }
		}
	}
	if ($kwdMaker[0] != ""){
		foreach ($kwdMaker as $row) {
			 if ( $sql == "") { 
			 	$sql = " SELECT * FROM $table_list WHERE(メーカー COLLATE $collateType LIKE '%". $row ."%')"; 
			 }else { 
			 	$sql = $sql."OR (メーカー COLLATE $collateType LIKE '%". $row ."%')";
			 }
		}
	}
	if ($kwdModel[0] != ""){	
		foreach ($kwdModel as $row) {
			 if ( $sql == "") { 
			 	$sql = " SELECT * FROM $table_list WHERE(型式 COLLATE $collateType LIKE '%". $row ."%')"; 
			 }else { 
			 	$sql = $sql."OR (型式 COLLATE $collateType LIKE '%". $row ."%')";
			 }
		}
	}
	if ($kwdCarryOut[0] != ""){	
		foreach ($kwdCarryOut as $row) {
			 if ( $sql == "") { 
			 	$sql = " SELECT * FROM $table_list WHERE(持出可否 COLLATE $collateType LIKE '%". $row ."%')"; 
			 }else { 
			 	$sql = $sql."OR (持出可否 COLLATE $collateType LIKE '%". $row ."%')";
			 }
		}
	}
	
		if ($kwdRentalTermination[0] != ""){	
		foreach ($kwdRentalTermination as $row) {
			 if ( $sql == "") { 
			 	$sql = " SELECT * FROM $table_list WHERE(レンタル終了 COLLATE $collateType LIKE '%". $row ."%')"; 
			 }else { 
			 	$sql = $sql."OR (レンタル終了 COLLATE $collateType LIKE '%". $row ."%')";
			 }
		}
	}

	
}

//echo  "行番号:".__LINE__."<br />";
//echo '$sql =',$sql;echo "<br/\n>";
//echo '$sortRule =',$sortRule;echo "<br/\n>";
//echo '$orderType =',$orderType;echo "<br/\n>";

// 並べ替え　$sortRule(会社名、メーカー名等)、$orderType(昇順(ASC)降順(DESC))
if ($sortRule !== "") {
	if ($orderType == 'orderAsc') {
		$sql = $sql."ORDER BY $sortRule ASC";
	} else {
		$sql = $sql."ORDER BY $sortRule DESC";
	}
}
// var_dump($sql);

//	 $all_records = "SELECT * FROM $table_list";
    // プリペアドステートメントを作る
   	 $stm = $pdo->prepare($sql);
    // SQL文を実行する
   	 $stm->execute();
    // 結果の取得（連想配列で返す）、全てのレコード
    $temp_records = $stm->fetchAll(PDO::FETCH_ASSOC);



if ($GLOBALS['searchType'] === "orSearch"){


} else {

	// AND検索
	// 項目毎のOR検索
	$i = 1;
	do{
		$dummy_flag[$i] = 1;	$i ++; 
	} while($i < count($temp_records));
}

    // $selected_flag()=1）が含まれるレコードを表示
  foreach($temp_records as $key => $row){
   		echo "<tr>";
   		echo "<td class=\"th00\">", $key+1, "</td>";
   		echo "<td class=\"th0\">", es($row['会社名']), "</td>";
    	echo "<td class=\"th1\">", es($row['事業所']), "</td>";
    	echo "<td class=\"th2\">", es($row['台帳番号']), "</td>";
    	echo "<td class=\"th4\">", es($row['メーカー']), "</td>";
		echo "<td class=\"th3\">", es($row['設置場所']), "</td>";
    	echo "<td class=\"th5\">", es($row['型式']), "</td>";
    	echo "<td class=\"th6\">", es($row['持出可否']), "</td>";
//    	echo "<td class=\"th6\">", "<a href=",'"mailto:',es($row['持出可否']),'"',">",es($row['持出可否']),"</a>", "</td>";
    	echo "<td class=\"th7\">", es($row['レンタル終了']), "</td>";

   		echo "</tr>";
  }
  echo "</table>";
  if (!isset($key)){ 
  	echo "<br/>\n";echo "<br/>\n";
  	echo "<div>","<h3 align=\"center\">",'<font color ="3f5170">',"条件に合致する情報はヒットしませんでした。。。","</font></h3>","</div>"; }
	
 }  // line260

  }  // line173に対するカッコ

?>

</div>
<!-- <p align="right">&copy;Copyright ADVANTEC Grp.SYSTEM Div. All right reserved.</p> -->
</body>
</html>


<?php
function titleDisplay(){
?>

<!-- <body onContextmenu="window.alert('右クリックは禁止です');return false" oncopy="window.alert('ctrl+cは禁//止');return false;"> -->
<!-- <style type="text/css">
/* ページ全体を印刷させない場合 */
@media print {
    body { display: none !important; }
}
</style> -->
<?php
 	echo '<title>PC管理情報検索サービス</title>';
 	echo '<!-- テーブル用のスタイルシート -->';
 	echo '<link rel="stylesheet" type="text/css" href="style2_org.css" >'; 
 	echo '<form method="POST" action="" >';
 	echo '<label><div>Welcome to</div></label>';
 	echo '<div><h1 class="title">PC管理情報データ検索</h1>'; 
 	echo '<ul class="comment">';
        echo ' <li>検索キーワードとして複数の検索項目（会社名、事業所、・・・）を入力することができます。</li>';
        echo ' <li>検索項目夫々に複数入力（会社名なら「TRK、KTS」のように）が可能です。<br>';
        echo ' 【例１】「検索タイプ：◎ANDサーチ」「事業所：新潟工場、中条工場」「メーカー：Lenovo」を選択すると新潟工場ま<br>';
        echo '&emsp;&emsp;&emsp;&emsp;たは中条工場の全てのLenovo製PCが検索されます。<br>';

        echo ' 【例２】「検索タイプ：◎ORサーチ」いずれか１つの検索項目（会社名、事業所、・・・）にのみ検索キーワードを入力<br>';
        echo ' 　　　　して利用ください。「事業所：大阪営業所、京都営業所」を選択すると、両営業所の全PCが検索されます。';
        echo ' </li>';
  		echo ' <li>前回の検索条件が表示されている場合↓、修正・追記して再検索できます。</li>';
		echo ' <li>その他、詳しい使い方は<a href="https://advantec-group.ent.box.com/file/910260598484" target="_blank" ><font color="#0000FF">こちら</font></a>を参照ください。';
		echo ' </li>';
		echo '<li><span style="white-space: nowrap;">検索タイプ、並べ替え条件、キーワードを入力後 ->&nbsp;';
		echo '<input type="submit" class="button0" value="検索スタート！" name="startSearch">';
		echo '</span>';
  		echo '<span style="white-space: nowrap;">&emsp;検索条件をクリア ->&nbsp;</span>';
  		echo '<input type="submit" class="button0" value="検索条件全クリア" name="parameterClear">';
		echo '</span>';
		echo ' </li>';
  		echo ' </ul>';
}

function topListDisplay(){


// -- 検索タイプのデフォルト値設定 --
 echo '<table class="info">';
 echo '<tr align="center"><th>検索タイプ</th><td><label><input type="radio" name="searchType" value="andSearch"'; checked("andSearch", $GLOBALS['searchType']); echo ">AND サーチ &nbsp;&nbsp;</label>";
 echo '<label><input type="radio" name="searchType" value="orSearch"';checked("orSearch", $GLOBALS['searchType']); echo ">OR サーチ</label></td></tr>";


echo '<tr><th>並べ替え</th><td><select name="sortRule" style="border:none;font-size:20px;" ><font color ="444444"><option value="" align="center">&emsp;&emsp;並べ替え対象の選択&emsp;&emsp;</option>
<option value="会社名" align="center"';selected("会社名", $GLOBALS['sortRule']);echo '>会社名</option>
<option value="事業所" align="center"';selected("事業所", $GLOBALS['sortRule']);echo '>事業所</option>
<option value="台帳番号" align="center"';selected("台帳番号", $GLOBALS['sortRule']);echo '>台帳番号</option>
<option value="メーカー" align="center"';selected("メーカー", $GLOBALS['sortRule']);echo '>メーカー</option>
<option value="設置場所" align="center"';selected("設置場所", $GLOBALS['sortRule']);echo '>設置場所</option>
<option value="型式" align="center"';selected("型式", $GLOBALS['sortRule']);echo '>型式</option>
<option value="持出可否" align="center"';selected("持出可否", $GLOBALS['sortRule']);echo '>持出可否</option></font>
<option value="レンタル終了" align="center"';selected("レンタル終了", $GLOBALS['sortRule']);echo '>レンタル終了</option></font>';

echo '<label><input type="radio" name="orderType" value="orderAsc"';
checked("orderAsc", $GLOBALS['orderType']);echo '>昇順 &nbsp;&nbsp;</label>
          <label><input type="radio" name="orderType" value="orderDesc"'; 
checked("orderDesc", $GLOBALS['orderType']);echo '>降順</label></td></tr>';


if ($GLOBALS['kwdSetStatus'] != "kwdSet"){
 	echo '<tr><th>会社名</th><td><input type="text" name="kwdCompany" style="border:none;font-size:20px;" placeholder="ATK、KTS etc." size=40></td></tr>';
 	echo '<tr><th>事業所</th><td><input type="text" name="kwdOffice" style="border:none;font-size:20px;" placeholder="***営業所、海外営業部、大阪工場 etc." size=40></td></tr>';
 	echo '<tr><th>台帳番号</th><td><input type="text" name="kwdRegisterNo" style="border:none;font-size:20px;" placeholder="XX-XXXX" size=40></td></tr>';
 	echo '<tr><th>メーカー</th><td><input type="text" name="kwdMaker" style="border:none;font-size:20px;" placeholder="DELL、HP etc." size=40></td></tr>';
 	echo '<tr><th>設置場所</th><td><input type="text" name="kwdPlace" style="border:none;font-size:20px;" placeholder="濾紙実験室、本社 etc." size=40></td></tr>';
 	echo '<tr><th>型式</th><td><input type="text" name="kwdModel" style="border:none;font-size:20px;" placeholder="ThinkPad、Latitude etc." size=40></td></tr>';
 	echo '<tr><th>持出可否</th><td><input type="text" style="border:none;font-size:20px;" name="kwdCarryOut" placeholder="持出可 etc." size=40></td></tr>';
 	echo '<tr><th>レンタル終了</th><td><input type="text" style="border:none;font-size:20px;" name="kwdRentalTermination" placeholder="2025/3/31 etc." size=40></td></tr>';
} else { 
 	echo '<tr><th>会社名</th><td><input type="text" name="kwdCompany" style="border:none;font-size:20px;"size=40 value=',$GLOBALS['kwdCompanyPrev'],'></td></tr>'; 
 	echo '<tr><th>事業所</th><td><input type="text" name="kwdOffice" style="border:none;font-size:20px;"size=40 value=',$GLOBALS['kwdOfficePrev'],'></td></tr>'; 
 	echo '<tr><th>台帳番号</th><td><input type="text" name="kwdRegisterNo" style="border:none;font-size:20px;" size=40 value=',$GLOBALS['kwdRegisterNoPrev'],'></td></tr>';
 	echo '<tr><th>設置場所</th><td><input type="text" name="kwdPlace" style="border:none;font-size:20px;" size=40 value=',$GLOBALS['kwdPlacePrev'],'></td></tr>';
 	echo '<tr><th>メーカー</th><td><input type="text" name="kwdMaker" style="border:none;font-size:20px;" size=40 value=',$GLOBALS['kwdMakerPrev'],'></td></tr>';
 	echo '<tr><th>型式</th><td><input type="text" name="kwdModel" style="border:none;font-size:20px;" size=40 value=',$GLOBALS['kwdModelPrev'],'></td></tr>';
 	echo '<tr><th>持出可否</th><td><input type="text" style="border:none;font-size:20px;" name="kwdCarryOut" size=40 value=',$GLOBALS['kwdCarryOutPrev'],'></td></tr>';
 	echo '<tr><th>レンタル終了</th><td><input type="text" style="border:none;font-size:20px;" name="kwdRentalTermination" size=40 value=',$GLOBALS['kwdRentalTerminationPrev'],'></td></tr>';
}
 	echo '</table>';
 	echo '</form>';
}

function allListDisplay(){
//
// SQLから全レコードを読み出して表示する
//
//SQLサーバに接続する
  list($pdo,$table_list) = connect2db(); 
  try { 
    // SQL文を作る（全レコード）
    	$sql = "SELECT * FROM $table_list";
      // プリペアドステートメントを作る
    	$stm = $pdo->prepare($sql);
    // SQL文を実行する
    	$stm->execute();
    // 結果の取得（連想配列で返す）
    	$result = $stm->fetchAll(PDO::FETCH_ASSOC);

   // テーブルのタイトル行
   	echo "<br/>\n";echo "<br/>\n";echo "<br/>\n";
 	echo "<div>","<h1 align=\"center\">","全社員リスト","</h1>","</div>"; 
	echo "<table class=\"info2\">";
  	echo "<tr>";
   	echo "<th class=\"th00\">", "No.", "</th>";
   	echo "<th class=\"th0\">", "会社名", "</th>";
 	echo "<th class=\"th1\">", "事業所", "</th>";
  	echo "<th class=\"th2\">", "台帳番号", "</th>";
  	echo "<th class=\"th3\">", "設置場所", "</th>";
 	echo "<th class=\"th4\">", "メーカー", "</th>";  	
  	echo "<th class=\"th5\">", "型式", "</th>";
  	echo "<th class=\"th6\">", "持出可否", "</th>";
 	echo "<th class=\"th7\">", "レンタル終了", "</th>";
  	echo "</tr>","</table>";

  // 値を取り出して行に表示する
  	foreach ($result as $key => $row){
    // １行ずつテーブルに入れる
    	echo "<tr>";
    	
   		echo "<td class=\"th00\">", $key+1, "</td>";
   		echo "<td class=\"th0\">", es($row['会社名']), "</td>";
    	echo "<td class=\"th1\">", es($row['事業所']), "</td>";
    	echo "<td class=\"th2\">", es($row['台帳番号']), "</td>";
		echo "<td class=\"th3\">", es($row['設置場所']), "</td>";
    	echo "<td class=\"th4\">", es($row['メーカー']), "</td>";
    	echo "<td class=\"th5\">", es($row['型式']), "</td>";
    	echo "<td class=\"th6\">", es($row['持出可否']), "</td>";
    	echo "<td class=\"th7\">", es($row['レンタル終了']), "</td>";
   		echo "</tr>";
  	}
  	echo "</table>";
    	} catch (Exception $e) {
    		echo '<span class="error">エラーがありました。</span><br>';
    		echo $e->getMessage();
    		exit();
  	}
}

 echo "</div>";

?>


