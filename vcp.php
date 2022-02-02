<?php
if (isset($_GET['vcpcid'])) {
    $channel_id = $_GET['vcpcid'];
	$url = "https://api.sunnxt.com/content/v3/media/".$channel_id;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERAGENT, 'okhttp/2.5.0');
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$headers = array(
	  'clientKey:ae0502d66312a7423d84bfe39d1f081b3a33ce31d4881650d4da25d02cd6a661','x-myplex-platform:AndroidTV'
	);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$response = curl_exec($ch);
	curl_close($ch);
	$decoded_json = json_decode($response, false);
	$encdata = $decoded_json->response;
	$url = "https://sunnxt.herokuapp.com/?encdata=".urlencode($encdata);
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/97.0.4692.71 Safari/537.36');
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$headers = array(
	  'Connection:keep-alive', 'Accept-Encoding:gzip,deflate', 'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9'
	);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$page = curl_exec($ch);
	$str_output = rtrim($page); 
	echo $str_output;
	if(!empty($str_output)){
		$result = (explode('"videos": ',$str_output))[1];
		$result = (explode(', "content": ',$result))[0];
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
