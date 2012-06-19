<?php

namespace SeoMoz;

use SeoMoz\Exception\BadCredentialsException;
use SeoMoz\Exception\InvalidSeoMozFormatException;
use SeoMoz\Exception\InvalidDomainNameException;

class SeoMoz
{
    private $accessId;
    private $secretKey;
    
    /**
     * @param string $accessId SeoMoz access id
     * @param string $secretKey SeoMoz secret key
     */
    public function __construct($accessId, $secretKey)
    {
        $this->accessId = $accessId;
        $this->secretKey = $secretKey;
    }

    /**
     * @param string $domainName Domain name to get SeoMoz data for
     * @return string SeoMoz-url
     */
    public function getSeoMozUrl($domainName)
    {
        $expires = time() + 300;
        $stringToSign = $this->accessId."\n".$expires;

        $binarySignature = hash_hmac('sha1', $stringToSign, $this->secretKey, true);
        $urlSafeSignature = urlencode(base64_encode($binarySignature));

        return "http://lsapi.seomoz.com/linkscape/url-metrics/".urlencode($domainName)."?AccessID=".$this->accessId."&Expires=".$expires."&Signature=".$urlSafeSignature;
    }
    
    /**
     * @param string $result SeoMoz result from http request
     * @return SeoMozData
     */
    public function getSeoMozData($result)
    {
        error_log($result);
        if (empty($result)) {
            throw new InvalidSeoMozFormatException('Empty result'); 
        } else {
            $json = json_decode($result);
            if (isset($json->status)) {
                if ("200" != $json->status) {
                    throw new BadCredentialsException($json->error_message);
                }
            }
        }

        return new SeoMozData($json);
    }

}