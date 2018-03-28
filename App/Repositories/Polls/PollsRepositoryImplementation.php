<?php

namespace App\Repositories\Polls;

use App\Models\Poll;

class PollsRepositoryImplementation implements PollsRepository
{
    /**
     * @var Poll
     */
    private $poll;

    /**
     * PollsRepositoryImplementation constructor.
     * @param Poll $poll
     */
    public function __construct(Poll $poll)
    {
        $this->poll = $poll;
    }

    /**
     * @param int $id
     * @return Poll|null
     */
    public function getById(int $id) : ?Poll
    {
        return $this->poll
            ->executeOne("SELECT * FROM {$this->poll->table} WHERE id=$id");
    }

    /**
     * Returns array of all polls
     *
     * @return array
     */
    public function all(): array
    {
        return $this->poll
            ->executeArray("SELECT * FROM {$this->poll->table}");
    }

    /**
     * Method returns all polls grouped by status code
     *
     * @return array
     */
    public function getGroupedByStatus() : array
    {
        $polls = $this->all();

        $groupedPolls = [];

        $statuses = $this->poll->getStatuses();
        foreach ($statuses as $status) {
            $groupedPolls[$status] = [];
        }

        foreach ($polls as $poll) {
            $groupedPolls[$poll->status][] = $poll;
        }

        return $groupedPolls;
    }

    /**
     * Creates new poll with given attributes
     *
     * @param array $attributes
     */
    public function create(array $attributes): void
    {
        $poll = Poll::createFromArray($attributes);
        $poll->save();
    }

    /**
     * Updates given poll
     *
     * @param Poll $poll
     * @param array $attributes
     */
    public function update(Poll $poll, array $attributes): void
    {
        $this->poll
            ->execute(
                "UPDATE {$this->poll->table} SET `name` = '{$attributes['name']}', " .
                "`status` = '{$attributes['status']}' WHERE id = {$poll->id}"
            );

        $poll->saveQuestions($attributes['questions']);
    }

    /**
     * Method deletes poll by given id
     *
     * @param int $id
     */
    public function delete(int $id) : void
    {
        $this->getById($id)->delete();
    }

    /**
     * Returns current active poll
     *
     * @return Poll|null
     */
    public function getActive() : ?Poll
    {
        return $this->poll
            ->executeOne(
                "SELECT * FROM {$this->poll->table} " .
                "WHERE `status` = '{$this->poll->getActiveStatusCode()}' LIMIT 1"
            );
    }

    /**
     * Method changes status of given poll
     *
     * @param int $id
     * @param string $newStatus
     * @throws \Exception
     */
    public function changeStatus(int $id, string $newStatus) : void
    {
        if (!in_array($newStatus, $this->poll->getStatuses())) {
            throw new \Exception('Неизвестный статус опроса.');
        }

        if ($newStatus == $this->poll->getActiveStatusCode() && !empty($this->getActive())) {
            throw new \Exception('Активный опрос может быть только один.');
        }

        $this->poll
            ->execute("UPDATE {$this->poll->table} SET `status` = '$newStatus' WHERE id = $id");
    }

}