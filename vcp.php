<?php
if (isset($_GET['vcpcid'])) {
    $channel_id = $_GET['vcpcid'];
	$command_exec = escapeshellcmd('vcplk.py '.$channel_id.' joesmiches@gmail.com colombo2022'); 
	$str_output = rtrim(shell_exec($command_exec)); 
	if(!empty($str_output)){
		$result = (explode('"videos":',$str_output))[1];
		$result = (explode('}],"request_id":"',$result))[0];
		$decoded_json = json_decode($result, false);
		$arr = $decoded_json->values;
		if(!empty($arr)){
			$url = $arr[0]->link;
			$link_1 = (explode(".m3u8?",$url))[0];
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
			curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");     
			$response = curl_exec($ch);
			curl_close($ch);
			$array = array_filter(preg_split("/\r\n|\n|\r/", $response));
			$final_url = $link_1.end($array);
			header('Location: '.$final_url);
		}else {
			header('HTTP/1.0 403 Forbidden');
			echo 'Invalid Login!!';
		}
	}else {
			header('HTTP/1.0 403 Forbidden');
			echo 'Login Failed!!';
	}
} else {
	header('HTTP/1.0 403 Forbidden');
	echo 'Unauthorized Access.. Access Forbidden!!';
}
?>