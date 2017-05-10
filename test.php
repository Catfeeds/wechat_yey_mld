<?php

$str = 'abc'; 
$key = 'www.helloweba.com'; 
$token = encrypt($str, 'E', $key); 
echo '加密:'.encrypt($str, 'E', $key); 
echo '解密：'.encrypt($token, 'D', $key); 

function encrypt($string,$operation,$key=''){ 
     $key=md5($key); 
     $key_length=strlen($key); 
       $string=$operation=='D'?base64_decode($string):substr(md5($string.$key),0,8).$string; 
     $string_length=strlen($string); 
     $rndkey=$box=array(); 
     $result=''; 
     for($i=0;$i<=255;$i++){ 
            $rndkey[$i]=ord($key[$i%$key_length]); 
         $box[$i]=$i; 
     } 
     for($j=$i=0;$i<256;$i++){ 
         $j=($j+$box[$i]+$rndkey[$i])%256; 
         $tmp=$box[$i]; 
         $box[$i]=$box[$j]; 
         $box[$j]=$tmp; 
     } 
     for($a=$j=$i=0;$i<$string_length;$i++){ 
         $a=($a+1)%256; 
         $j=($j+$box[$a])%256; 
         $tmp=$box[$a]; 
         $box[$a]=$box[$j]; 
         $box[$j]=$tmp; 
         $result.=chr(ord($string[$i])^($box[($box[$a]+$box[$j])%256])); 
     } 
     if($operation=='D'){ 
         if(substr($result,0,8)==substr(md5(substr($result,8).$key),0,8)){ 
             return substr($result,8); 
         }else{ 
             return''; 
         } 
     }else{ 
         return str_replace('=','',base64_encode($result)); 
     } 
 } 
//file_put_contents('photo.jpg',file_get_contents("http://wx.mldyey.com/userdata/logo/logo.png"));
//echo(file_get_contents("http://wx.mldyey.com/userdata/logo/logo.png"));
exit();
$s_date = '2017-05-06 09:00:00';
$result = array ();
function read_all_dir($dir) {
	global $result;
	global $s_date;
	$handle = opendir ( $dir );
	if ($handle) {
		while ( ($file = readdir ( $handle )) !== false ) {
			if ($file != '.' && $file != '..') {
				$cur_path = $dir . DIRECTORY_SEPARATOR . $file;
				if (is_dir ( $cur_path )) {
					read_all_dir ( $cur_path );
				} else {
					if (strtotime ( date ( "Y-m-d H:i:s", filemtime ( $cur_path ) ) ) > strtotime ( $s_date )) {
						array_push($result, $cur_path);
					}
				}
			}
		}
		closedir ( $handle );
	}
	return $result;
}
echo (json_encode ( read_all_dir ( 'sub' ) ));
?>