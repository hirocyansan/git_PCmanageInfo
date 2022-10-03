<?php


function dataWriteOrg($filename, $writedata){
		$fileObj = new SplFileObject($filename,"wb");
		$written = $fileObj->fwrite($writedata);
}

function dataWrite($filename, $writedata){
	$fp = fopen($filename,'wb');
	if(!flock($fp, LOCK_EX)) {
	  //ファイルをロックできない場合は、終了
		echo 'ファイルをロックできませんでした。';
  		return;
  	}
	fwrite($fp, $writedata);  //ファイルに書き込み
	fflush($fp);  // 出力をフラッシュ
	flock($fp, LOCK_UN);  // ロックを解放
	fclose($fp);  //ファイルをクローズ
	return;
}

function dataReadOrg($filename){
		$fileObj = new SplFileObject($filename,"rb");
		$readdata = $fileObj->fread($fileObj->getSize());
		return $readdata;
}

function dataRead($filename){
	if(file_exists($filename)){
		try{
			// fopenでファイルを開く（'r'は読み込みモードで開く）
			$fp = fopen($filename, 'r');
			// fgetsでファイルを読み込み、変数に格納
			$mergedData = fgets($fp);
			// fcloseでファイルを閉じる
			fclose($fp);
			return $mergedData;
		} catch (Exception $e){
			echo '読み込みエラー！';
			return;
		}
	}else{
		echo 'パラメーター設定ファイルがありません！';
		return;
	}
}

//function writeKwdSetStatus(){
//		$filename = "kwdSetStatus.txt";
//		dataWrite($filename, $GLOBALS['kwdSetStatus']);
//}

// 区切り文字（、,等）で文字列を分割して配列に格納

function setKwd($kwd){
//  echo "行番号:".__LINE__."<br />";
  if ($kwd === false){
// 	$errors[] = '検索キーワードが入力されていません。';
  }else{  	
//      echo "行番号:".__LINE__."<br />";
	  if (strpos($kwd,"、") != false){
//    	echo 'Detected the 「、」'; echo "<br/>\n";
  		$kwd = explode( "、" ,$kwd);  
// 		echo '入力されたkwd ='; var_dump($kwd); echo "<br/>\n";  	
		return $kwd;
  	  }else{
  		if(strpos($kwd,",") != false){
//    		echo 'Detected the 「,」'; echo "<br/>\n";
 			$kwd = explode( "," ,$kwd);  
// 			echo '入力されたkwd ='; var_dump($kwd); echo "<br/>\n";   
			return $kwd;
  	    }else{
  			if(strpos($kwd," ") != false){
//    			echo 'Detected the 「 」'; echo "<br/>\n";
  				$kwd = explode( " " ,$kwd);  
// 				echo '入力されたkwd ='; var_dump($kwd); echo "<br/>\n";
				return $kwd;
  	    	}else{
  				if(strpos($kwd,"　") != false){
//    				echo 'Detected the 「　」'; echo "<br/>\n";
  					$kwd = explode( "　" ,$kwd);  
// 					echo '入力されたkwd ='; var_dump($kwd); echo "<br/>\n";
					return $kwd;
  				}
  				else{
  					return $kwd;
  					}
			}
		}
	}
  }
}


//  同じレコードを除外して$temp_recordsに入れ直す

function reject_same_records($temp_records){
$i = 0; $j = 0;
  do{
	do{
		// echo '$i =',$i, '  $j = ',$j; echo "<br/>\n";
		// 同じレコード番号どうしの比較はスキップ
		if ($i === $j) {
//			echo 'skip the same records comparing ';echo "<br/>\n";
			$j ++;
			continue;
		}
		// 同じ社員番号(memberCode)が見つかったら片方を削除して配列を詰める--> $temp_records
		if ($temp_records[$i]['社員番号'] === $temp_records[$j]['社員番号']){
			$skipped_records[] =array_splice($temp_records, $j, 1);
 		//行番号を削減したのでポインタ($j)参照位置も戻す
			if ($j > 0) $j --;   
		}
		$j ++;
	}while(count($temp_records) - 1 >= $j);
  $i ++; 
  $j = 0;
  }while(count($temp_records) - 1 >= $i);
  return($temp_records);
}

function big2small($kwd){
  $kwd = mb_strtolower($kwd);  // アルファベット大文字→小文字変換
  $kwd = mb_convert_kana($kwd, 'rnk');  // 全角英字、数字、カナ　→　半角
  return $kwd;
}

  // 初期値でチェックするかどうか
function checked($value, $question){
    if (is_array($question)){
      // 配列のとき、値が含まれていればtrue
      $isChecked = in_array($value, $question);
    } else {
      // 配列ではないとき、値が一致すればtrue
      $isChecked = ($value===$question);
    }
    if ($isChecked) {
      // チェックする
      echo "checked";
    } else {
      echo "";
    }
  }

function selected($value, $question){
    if (is_array($question)){
      // 配列のとき、値が含まれていればtrue
      $isChecked = in_array($value, $question);
    } else {
      // 配列ではないとき、値が一致すればtrue
      $isChecked = ($value===$question);
    }
    if ($isChecked) {
      // チェックする
      echo "selected";
    } else {
      echo "";
    }
  }
?>
