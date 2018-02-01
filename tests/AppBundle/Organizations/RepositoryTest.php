<?php

namespace tests\AppBundle\Organizations;

use AppBundle\Organizations\Repository;
use PHPUnit\Framework\TestCase;

/**
 * @author Mickaël Andrieu <andrieu.travail@gmail.com>
 */
class RepositoryTest extends TestCase
{
    const USER_NAME = 'loveOSS';

    const REPO_NAME = 'test';

    private $repository;

    public function setUp()
    {
        $organizationApi = $this->getMockBuilder('Github\Api\Organization')
            ->disableOriginalConstructor()
            ->getMock();

        $this->repository = new Repository($organizationApi, self::USER_NAME, self::REPO_NAME);
    }

    public function testGetTeams()
    {
        $this->markTestIncomplete();
    }

    public function testGetTeam()
    {
        $this->markTestIncomplete();
    }

    public function testGetTeamMembers()
    {
        $this->markTestIncomplete();
    }
}
