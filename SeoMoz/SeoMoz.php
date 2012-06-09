<?php

namespace SeoMoz;

class SeoMoz
{
    
    private $accessID;
    private $secretKey;
    
    public function __construct($accessID, $secretKey)
    {
        $this->accessID = $accessID;
        $this->secretKey = $secretKey;
    }
    
    private function getSeoMozUrl($domain_name)
    {
        $expires = time() + 300;  // The request is good for the next 5 minutes, or 300 seconds from now.
        $stringToSign = $this->accessID."\n".$expires;

        // Get the "raw" or binary output of the hmac hash.
        $binarySignature = hash_hmac('sha1', $stringToSign, $this->secretKey, true);

        // We need to base64-encode it and then url-encode that.
        $urlSafeSignature = urlencode(base64_encode($binarySignature));

        return "http://lsapi.seomoz.com/linkscape/url-metrics/".urlencode($domain_name)."?AccessID=".$this->accessID."&Expires=".$expires."&Signature=".$urlSafeSignature;
    }
    
    private function fetchData($domain_name)
    {
        $curl_handle = curl_init();

        curl_setopt($curl_handle, CURLOPT_URL, $this->getSeoMozUrl($domain_name));
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_handle, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl_handle, CURLOPT_TIMEOUT,10);

        $buffer = curl_exec($curl_handle);
        curl_close($curl_handle);

        return $buffer;
    }
    
    public function getSeoMozData($domain_name)
    {
        $buffer = $this->fetchData($domain_name);
        if (empty($buffer)) {
            throw new SeoMozException('Empty result'); 
        } else {
            $result = json_decode($buffer);
            if (isset($result->status)) {
                if ("200" != $result->status) {
                    throw new SeoMozException($result->error_message);
                }
            }
        }

        return new SeoMozData($result);
    }

}

class SeoMozException extends \Exception {}