<?php

namespace App\Repositories\Answers;


use App\Models\Poll;

interface AnswerRepository
{

    /**
     * @param array $answers
     */
    public function save(array $answers) : void;

    /**
     * @param Poll $poll
     * @return array
     */
    public function getAllResults(Poll $poll) : array;

    /**
     * @param Poll $poll
     * @param array $filters
     * @return array
     */
    public function getFilteredResults(Poll $poll, array $filters) : array;
}