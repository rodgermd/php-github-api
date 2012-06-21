<?php

/**
 * Searching organizations, getting organization information
 * and managing authenticated organization account information.
 *
 * @link      http://develop.github.com/p/orgs.html
 * @author    Antoine Berranger <antoine at ihqs dot net>
 * @license   MIT License
 */
class Github_Api_Organization extends Github_Api
{
    const ADMIN = "admin";
    const PUSH = "push";
    const PULL = "pull";

    static $PERMISSIONS = array(
        self::ADMIN,
        self::PUSH,
        self::PULL
    );

    /**
     * Get extended information about an organization by its name
     * http://develop.github.com/p/orgs.html
     *
     * @param   string  $name             the organization to show
     * @return  array                     informations about the organization
     */
    public function show($name)
    {
        $response = $this->get('orgs/'.urlencode($name));

        return $response;
    }

    /**
     * List all repositories that you can access of that organizations 
     * http://develop.github.com/p/orgs.html
     *
     * @param   string  $name             the organization name
     * @return  array                     the repositories
     */
    public function getAllRepos($name)
    {
        $response = $this->get('orgs/'.urlencode($name).'/repos');

        return $response;
    }

    /**
     * List all public repositories of that organization
     * http://develop.github.com/p/orgs.html
     *
     * @param   string  $name             the organization name
     * @return  array                     the repositories
     */
    public function getPublicRepos($name)
    {
        $response = $this->get('orgs/'.urlencode($name).'/repos', array('type' => 'public'));

        return $response;
    }

    /**
     * List all public members of that organization
     * http://develop.github.com/p/orgs.html
     *
     * @param   string  $name             the organization name
     * @return  array                     the members
     */
    public function getPublicMembers($name)
    {
        $response = $this->get('orgs/'.urlencode($name).'/members');

        return $response;
    }

    /**
     * List all teams of that organization
     * http://develop.github.com/p/orgs.html
     *
     * @param   string  $name             the organization name
     * @return  array                     the teams
     */
    public function getTeams($name)
    {
        $response = $this->get('orgs/'.urlencode($name).'/teams');

        return $response;
    }

    /**
     * Add a team to that organization
     * http://develop.github.com/p/orgs.html
     *
     * @param   string  $organization     the organization name
     * @param   string  $team             name of the new team
     * @param   string  $permission       its permission [PULL|PUSH|ADMIN]
     * @param   array   $repositories     (optionnal) its repositories names
     *
     * @return  array                     the teams
     */
    public function addTeam($organization, $team, $permission, array $repositories = array())
    {
        if (!in_array($permission, self::$PERMISSIONS)) {
            throw new InvalidArgumentException("Invalid value for the permission variable");
        }

        $response = $this->post('orgs/'.urlencode($organization).'/teams', array(
            'name' => $team,
            'permission' => $permission,
            'repo_names' => $repositories
        ));

        return $response;
    }

}
