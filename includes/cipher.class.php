<?php
class Cipher 
{
    private $securekey="", $iv="";
    function __construct($textkey) {
        $this->securekey = hash('sha256',$textkey,TRUE);
        $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
        $this->iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    }

    function encrypt($params) 
    {
        $enc_param = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $this->securekey, $params, MCRYPT_MODE_ECB,$this->iv));
        $enc_param .= '.__.'.base64_encode($this->iv);
        return rawurlencode($enc_param);
    }
    
    function decrypt($params)
    {
        $iv = "";
        $params = explode('.__.', $params); # extract IV
        if(isset($params[1])) $iv = rawurldecode(base64_decode($params[1]));
        if($iv == "" || $iv == NULL || empty($iv)) { die('{"Error":"IV not found."}'); }
        $params = rawurldecode($params[0]);
        $params = base64_decode($params);
        $params = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $this->securekey, $params, MCRYPT_MODE_ECB, $this->iv));
        $params = json_decode($params, TRUE);
        return $params;
    }
}
?>