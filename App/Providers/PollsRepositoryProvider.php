<?php

namespace App\Providers;

use System\Provider;
use App\Repositories\Polls\PollsRepository;
use App\Repositories\Polls\PollsRepositoryImplementation;

class PollsRepositoryProvider extends Provider
{

    public function register()
    {
        $this->bind(PollsRepository::class, PollsRepositoryImplementation::class);
    }
}