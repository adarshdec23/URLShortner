<?php
//Class for url shortening
class Url {
	
	private $parameter = [];
	function __construct() {
		$this->parameter['key'] = ''; //Use your API key
	}
	
	private function buildUrl(){
		$finalUrl = "https://www.googleapis.com/urlshortener/v1/url?";
		$getParams = http_build_query($this->parameter);
		$finalUrl .= $getParams;
		return $finalUrl;
	}


	public function shorten($url) {
		$address = $this->buildUrl();
		$data = array("longUrl" => $url);
		$options = array(
				'http' => array(
				'header'  => "Content-Type: application/json\r\n",
				'method'  => 'POST',
				'content' => json_encode($data)
			)
		);
		$context  = stream_context_create($options);
		$result = @file_get_contents($address, false, $context);
		if(!$result)
			return FALSE;
		$json = json_decode($result);
		return $json->id;
	}

}
?>

