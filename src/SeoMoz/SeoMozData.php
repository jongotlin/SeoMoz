<?php

namespace SeoMoz;

class SeoMozData
{
    
    private $pageAuthority;
    private $domainAuthority;
    private $httpStatusCode;
    private $externalLinks;
    
    public function __construct(\stdClass $result)
    {
        if (isset($result->upa)) {
            $this->setPageAuthority($result->upa);
        }

        if (isset($result->pda)) {
            $this->setDomainAuthority($result->pda);
        }
        
        if (isset($result->us)) {
            $this->setHttpStatusCode($result->us);
        }

        if (isset($result->ueid)) {
            $this->setExternalLinks($result->ueid);
        }
        
    }
    
    public function setPageAuthority($pageAuthority)
    {
        $this->pageAuthority = $pageAuthority;
    }
    
    public function getPageAuthority()
    {
        return $this->pageAuthority;
    }
    
    public function setDomainAuthority($domainAuthority)
    {
        $this->domainAuthority = $domainAuthority;
    }
    
    public function getDomainAuthority()
    {
        return $this->domainAuthority;
    }
    
    public function setHttpStatusCode($httpStatusCode)
    {
        $this->httpStatusCode = $httpStatusCode;
    }
    
    public function getHttpStatusCode()
    {
        return $this->httpStatusCode;
    }
    
    public function setExternalLinks($externalLinks)
    {
        $this->externalLinks = $externalLinks;
    }
    
    public function getExternalLinks()
    {
        return $this->externalLinks; 
    }
}
