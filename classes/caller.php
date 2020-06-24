<?php
include "./includes/settings.php";
include "./cipher.class.php";
include "./special.class.php";
include "./functions/datetime.func.php";
	class Caller{
		private $app_id = "";
		private $app_key = "";
		private $app_code = "";
		private $api_url = ""; 

		function __construct($config){
			$this->app_id   = $config['app_id'];
			$this->app_key  = $config['app_key'];
			$this->app_code = $config['app_code'];
			$this->api_url  = $config['api_url'];
		}

		function apiCall($rparams){
            $debug =0;
			$cipher = 0;
			$curlerror = "";
			$params = array();

			if($cipher)
			{
				# Encrypt request data
				$cipher = new Cipher($this->app_key);
				$encrypted_data = $cipher->encrypt(json_encode($rparams));
				$params['enc_param'] = $encrypted_data;
			}
			else
			{
				$params = $rparams;
			}

			//var_dump($rparams);
		
			$params['api_appid'] = $this->app_id;
			$params['api_appcode'] = $this->app_code;

			//if($debug){var_dump($params); echo "<br>"; }
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $this->api_url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, count($params));
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
			$result = curl_exec($ch);
			if($debug){
				var_dump($result);
				echo "<br>";
				$curlerror = curl_error($ch); 
				var_dump($curlerror);
			}
			#$result = @json_decode($result);

			return $result;
		}

	}
?>