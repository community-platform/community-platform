<?php

namespace CoreBundle\Commits;

use Lpdigital\Github\Entity\PullRequest;
use Lpdigital\Github\Entity\User;

interface RepositoryInterface
{
    /**
     * @param User $user
     *
     * @return \Lpdigital\Github\Entity\Commit[]|array
     */
    public function findAllByUser(User $user);

    /**
     * @param PullRequest $pullRequest
     *
     * @return \Lpdigital\Github\Entity\Commit[]|array
     */
    public function findAllByPullRequest(PullRequest $pullRequest);
}
