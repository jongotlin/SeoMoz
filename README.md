SeoMoz
======

Get URL metrics from SeoMoz 
http://apiwiki.seomoz.org/w/page/13991153/URL%20Metrics%20API

Feel free to contribute!

Usage
-----

    use SeoMoz;
    
    $accessId = 'xxx';
    $secretKey = 'yyy';
    
    $seoMoz = new SeoMoz($accessId, $secretKey);
    $seoMozData = $seoMoz->getSeoMozData(file_get_contents($seoMoz->getSeoMozUrl('www.github.com')));
    echo $seoMozData->getDomainAuthority();