<?php

namespace CiscoSystems\GitlabBundle\API;

use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Doctrine\Common\Persistence\ObjectManager;
use CiscoSystems\GitlabBundle\Client\HttpClientInterface;
use CiscoSystems\GitlabBundle\Entity\Access;
use CiscoSystems\GitlabBundle\API\Gitlab\APIv2;
use CiscoSystems\GitlabBundle\API\Gitlab\APIv3;

class ApiManager
{
    protected $om;
    protected $tokenStorage;
    protected $client;
    protected $api;
    protected $userId;

    public function __construct( ObjectManager $om, TokenStorageInterface $tokenStorage, HttpClientInterface $client )
    {
        $this->om = $om;
        $this->tokenStorage = $tokenStorage;
        $this->client = $client;
    }

    /**
     * Obtain an object implementing the ApiInterface
     *
     * @param Access $access
     * @return \CiscoSystems\GitlabBundle\ApiInterface
     * @throws \InvalidArgumentException
     */
    public function getApi( Access $access )
    {
        switch ( $access->getApiType() )
        {
            ////////////
            // Gitlab //
            ////////////
            case Access::TYPE_GITLAB:
                switch ( $access->getApiVersion() )
                {
                    case 'v2': return new APIv2( $this->client, $access );
                    case 'v3': return new APIv3( $this->client, $access );
                }
                break;
            ////////////
            // Github //
            ////////////
            case Access::TYPE_GITHUB:
                switch ( $access->getApiVersion() )
                {
                    // case 'v3':
                    //     // not implemented yet
                    //     break;
                }
                break;
        }
        throw new \InvalidArgumentException( 'Requested API version not implemented yet.' );
    }

    /**
     * Get credentials dataset(s)
     *
     * Returns either a Doctrine Collection of CiscoSystems\GitlabBundle\Entity\Access instances
     * or a single CiscoSystems\GitlabBundle\Entity\Access instance
     *
     * @param integer $accessId
     * @return mixed
     */
    public function getAccessData( $accessId = null )
    {
        if ( null !== $accessId )
        {
            return $this->om->getRepository( 'CiscoSystemsGitlabBundle:Access' )
                            ->findOneBy( array(
                                'userId' => $this->getUserId(),
                                'id' => $accessId,
                            ));
        }
        return $this->om->getRepository( 'CiscoSystemsGitlabBundle:Access' )
                        ->findBy( array( 'userId' => $this->getUserId() ) );
    }

    /**
     * Creates an instance of CiscoSystems\GitlabBundle\Entity\Access and presets
     * it with the User ID obtained from the current security context
     *
     * @return \CiscoSystems\GitlabBundle\Entity\Access
     */
    public function createAccessObject()
    {
        $access = new Access();
        $access->setUserId( $this->getUserId() );
        return $access;
    }

    /**
     * Obtain the User ID from the current security context.
     * Your User object must implement a getId() method.
     *
     * @return integer
     * @throws \Exception
     */
    public function getUserId()
    {
        if ( null === $this->userId )
        {
            $user = $this->tokenStorage->getToken()->getUser();
            if ( $user && gettype( $user ) == 'object' && method_exists( $user, 'getId' ) )
            {
                $this->userId = $user->getId();
            }
            else throw new \Exception( 'Your User object must implement a getId() method.' );
        }
        return $this->userId;
    }
}
