<?php
class EncryptionWrapper extends \Eloquent
{
    /**
     * Encrytion wrapper for data compatibility between Laravel <=> Ruby
     * By Kenneth Kapundi
     */
    protected $encrypted;
    
    public static function encrypt($str)
    {
		$password = $password = trim(file_get_contents(base_path("app/config/key")));
		$cipher_method = 'AES-256-CBC';
		$iv_length = openssl_cipher_iv_length($cipher_method);
		$iv = mcrypt_create_iv($iv_length, MCRYPT_RAND);
		$str = $iv.$str;
		$val = openssl_encrypt($str, $cipher_method, $password, 0, $iv);
		
		return str_replace(array('+', '/'), array('-', '_'), $val);
    }
    
    public static function decrypt($str)
    {
		$password = $password = trim(file_get_contents(base_path("app/config/key")));
		$cipher_method = 'AES-256-CBC';
		$val = str_replace(array('-', '_'), array('+', '/'), $str);
		$data = base64_decode($val);
		$iv_length = openssl_cipher_iv_length($cipher_method);
		$body_data = substr($data, $iv_length);
		$iv = substr($data, 0, $iv_length);
		$base64_body_data = base64_encode($body_data);
		try{
			return openssl_decrypt($base64_body_data, $cipher_method, $password, 0, $iv);
		}catch(Exception $e){
			return null;
		}
    }
    
    public function getAttribute($key)
    {
        if (array_key_exists($key, array_flip($this->encrypted)))
        {
            return $this->decrypt(parent::getAttribute($key));
        }

        return parent::getAttribute($key);
    }

    public function setAttribute($key, $value)
    {
        if (array_key_exists($key, array_flip($this->encrypted)))
        {
			if($key == "name"){
				$name = explode(' ', $value);
				$f_name_code = isset($name[0]) ? Soundex::encode($name[0])  : null;
				$l_name_code = isset($name[1]) ? Soundex::encode($name[sizeof($name)-1])  : null;
				parent::setAttribute("first_name_code", $f_name_code);
				parent::setAttribute("last_name_code", $l_name_code);
			}
			
            parent::setAttribute($key, $this->encrypt($value));
            return;
        }

        parent::setAttribute($key, $value);
    }
}
