<?php

namespace App\Providers;

use System\Provider;
use App\Repositories\Answers\AnswerRepository;
use App\Repositories\Answers\AnswerRepositoryImplementation;

class AnswersRepositoryProvider extends Provider
{

    public function register()
    {
        $this->bind(AnswerRepository::class, AnswerRepositoryImplementation::class);
    }
}