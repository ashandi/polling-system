<?php

namespace App\Repositories\Polls;


use App\Models\Poll;

interface PollsRepository
{

    /**
     * @param int $id
     * @return Poll|null
     */
    public function getById(int $id) : ?Poll;

    /**
     * Returns array of all polls
     *
     * @return array
     */
    public function all() : array;

    /**
     * @return array
     */
    public function getGroupedByStatus() : array;

    /**
     * Creates new poll with given attributes
     *
     * @param array $attributes
     */
    public function create(array $attributes) : void;

    /**
     * Updates given poll
     *
     * @param Poll $poll
     * @param array $attributes
     */
    public function update(Poll $poll, array $attributes): void;

    /**
     * @return Poll|null
     */
    public function getActive() : ?Poll;

    /**
     * @param int $id
     */
    public function delete(int $id) : void;

    /**
     * @param int $id
     * @param string $newStatus
     * @throws \Exception
     */
    public function changeStatus(int $id, string $newStatus) : void;

}