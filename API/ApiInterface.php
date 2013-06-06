<?php

/**
 * This interface defines the methods required
 * by this bundle of any API implementation.
 */

namespace CiscoSystems\GitlabBundle\API;

use CiscoSystems\GitlabBundle\Client\HttpClientInterface;
use CiscoSystems\GitlabBundle\Entity\Access;
use CiscoSystems\GitlabBundle\Model\Issue;

interface ApiInterface
{
    /**
     * @param \CiscoSystems\GitlabBundle\Client\HttpClientInterface $client
     * @param \CiscoSystems\GitlabBundle\Entity\Access $access
     */
    public function __construct( HttpClientInterface $client, Access $access );

    /**
     * Authenticates the injected instance of CiscoSystems\GitlabBundle\Entity\Access
     *
     * @return \CiscoSystems\GitlabBundle\Entity\Access
     */
    public function authenticate();

    /**
     * Prepares URL (prepends prefixes etc.)
     *
     * @param string $url
     * @return string
     */
    public function prepareUrl( $url );

    /**
     * Retrieves the current user if $userId is null,
     * otherwise retrieves the requested user
     *
     * @param integer $userId
     * @return array
     */
    public function getUser( $userId = null );

    /**
     * Retrieves the current user's projects
     *
     * @return array
     */
    public function getProjects();

    /**
     * Retrieves a certain project
     *
     * @param mixed $projectId
     * @return array
     */
    public function getProject( $projectId );

    /**
     * Retrieves the current user's issues if $projectId
     * is null, otherwise retrieves the project's issues
     *
     * @param mixed $projectId
     * @return array
     */
    public function getIssues( $projectId = null );

    /**
     * Retrieves a project's issue
     *
     * @param mixed $projectId
     * @param integer $issueId
     * @return array
     */
    public function getIssue( $projectId, $issueId );

    /**
     * Deletes a project's issue
     *
     * @param mixed $projectId
     * @param integer $issueId
     * @return boolean
     */
    public function deleteIssue( $projectId, $issueId );

    /**
     * Creates an issue
     *
     * @param Issue $issue
     * @param array $data
     * @return boolean
     */
    public function createIssue( Issue $issue );

    /**
     * Updates an issue
     *
     * @param Issue $issue
     * @param array $data
     * @return boolean
     */
    public function editIssue( Issue $issue );
}
