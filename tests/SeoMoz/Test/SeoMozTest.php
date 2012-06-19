<?php

namespace SeoMoz\Test;

use SeoMoz\SeoMoz;

class SeoMozTest extends \PHPUnit_Framework_TestCase
{
    private $seoMoz;

    protected function setUp()
    {
        $this->seoMoz = new SeoMoz('foo', 'bar');
    }

    public function testSettingDomainName()
    {
        $url = $this->seoMoz->getSeoMozUrl('github.com');
        $this->assertStringStartsWith('http://lsapi.seomoz.com/linkscape/url-metrics/github.com', $url);
    }


}
