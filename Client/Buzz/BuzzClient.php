<?php

namespace CiscoSystems\GitlabBundle\Client\Buzz;

use Buzz\Browser;

use CiscoSystems\GitlabBundle\Client\HttpClientInterface;
use CiscoSystems\GitlabBundle\Client\HttpResponse;

class BuzzClient implements HttpClientInterface
{
    protected $browser;

    public function __construct()
    {
        $this->browser = new Browser();
    }

    public function get( $url )
    {
        $response = $this->browser->get( $url );
        return new HttpResponse( $response->getContent(), $response->getStatusCode() );
    }

    public function post( $url, $jsonData = ''  )
    {
        $response = $this->browser->post( $url, array(), $jsonData );
        return new HttpResponse( $response->getContent(), $response->getStatusCode() );
    }

    public function patch( $url, $jsonData = '' )
    {
        $response = $this->browser->patch( $url, array(), $jsonData );
        return new HttpResponse( $response->getContent(), $response->getStatusCode() );
    }

    public function put( $url, $jsonData = ''  )
    {
        $response = $this->browser->put( $url, array(), $jsonData );
        return new HttpResponse( $response->getContent(), $response->getStatusCode() );
    }

    public function delete( $url )
    {
        $response = $this->browser->delete( $url );
        return new HttpResponse( $response->getContent(), $response->getStatusCode() );
    }
}
