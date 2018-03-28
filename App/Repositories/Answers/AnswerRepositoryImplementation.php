<?php

namespace App\Repositories\Answers;

use App\Models\Poll;
use App\Models\Answer;

class AnswerRepositoryImplementation implements AnswerRepository
{

    /**
     * @var Answer
     */
    private $answer;

    /**
     * @param Answer $answer
     */
    public function __construct(Answer $answer)
    {
        $this->answer = $answer;
    }

    /**
     * Method saves $answers on the poll in database
     *
     * @param array $answers
     */
    public function save(array $answers) : void
    {
        $userId = $this->getLastUserId() + 1;

        foreach ($answers as $questionId => $answer) {
            if (is_array($answer)) {
                foreach ($answer as $answerVariantId) {
                    $this->createAnswer($questionId, $answerVariantId, $userId);
                }
                continue;
            }

            $this->createAnswer($questionId, $answer, $userId);
        }
    }

    /**
     * Method returns last inserted user_id
     *
     * @return int
     */
    private function getLastUserId() : int
    {
        return $this->answer->execute(
            "SELECT MAX(`user_id`) FROM {$this->answer->table}"
        )->fetchColumn() ?? 0;
    }

    /**
     * Method creates record in answers table
     *
     * @param int $questionId
     * @param int $answerVariantId
     * @param int $userId
     */
    private function createAnswer(int $questionId, int $answerVariantId, int $userId) : void
    {
        $answer = $this->answer->createFromArray([
            'question_id' => $questionId,
            'answer_variant_id' => $answerVariantId,
            'user_id' => $userId]);
        $answer->save();
    }

    /**
     * Method returns all results of given poll
     *
     * @param Poll $poll
     * @return array
     */
    public function getAllResults(Poll $poll) : array
    {
        $answers = $this->answer->executeArray(
                "SELECT {$this->answer->table}.* FROM {$this->answer->table}" .
                " JOIN questions ON questions.id = answers.question_id WHERE questions.poll_id = {$poll->id}"
            );

        return $this->calcAnswers($answers);
    }

    /**
     * Method calculates total users count and answers counts grouped by answers variants
     *
     * @param array $answers
     * @return array
     */
    private function calcAnswers(array $answers)
    {
        $users = [];
        $results = [];

        foreach ($answers as $answer) {
            if (!in_array($answer->user_id, $users)) {
                $users[] = $answer->user_id;
            }

            $count = $results[ $answer->question_id ][ $answer->answer_variant_id ] ?? 0;
            $results[ $answer->question_id ][ $answer->answer_variant_id ] = $count + 1;
        }

        return [
            'total' => count($users),
            'answers' => $results
        ];
    }

    /**
     * Method returns results of given poll filtered by given conditions
     *
     * @param Poll $poll
     * @param array $filters
     * @return array
     */
    public function getFilteredResults(Poll $poll, array $filters) : array
    {
        if (count($filters) == 0) {
            return $this->getAllResults($poll);
        }

        $userIds = $this->filterUserIds($filters);

        $userIdsStr = implode($userIds, ', ');
        $answers = $this->answer->executeArray(
            "SELECT {$this->answer->table}.* FROM {$this->answer->table}" .
            " JOIN questions ON questions.id = answers.question_id WHERE questions.poll_id = {$poll->id}" .
            " AND {$this->answer->table}.user_id IN ($userIdsStr)"
        );

        return $this->calcAnswers($answers);
    }

    /**
     * Returns array of user's ids which fit the given filters
     *
     * @param array $filters
     * @return array
     */
    private function filterUserIds(array $filters) : array
    {
        $sampleName = 'answers';
        $counter = 1;
        $baseAlias = $sampleName . $counter;

        $query = "SELECT DISTINCT $baseAlias.user_id FROM ";

        $subQuery = "";
        foreach ($filters as $questionId => $answerVariantIds) {
            if($subQuery != "") {
                $subQuery .= " INNER JOIN ";
            }

            $variantsSubQuery = "";
            foreach ($answerVariantIds as $answerVariantId) {
                if($variantsSubQuery != "") {
                    $variantsSubQuery .= " OR ";
                }

                $variantsSubQuery .= "`answer_variant_id` = $answerVariantId";
            }

            $subQuery .= "(SELECT user_id FROM {$this->answer->table} WHERE question_id = $questionId AND $variantsSubQuery) as $sampleName$counter";
            if ($baseAlias != $sampleName . $counter) {
                $subQuery .= " ON $baseAlias.user_id = $sampleName$counter.user_id";
            }

            $counter++;
        }

        $query .= $subQuery;

        return $this->answer->execute($query)->fetchAll(\PDO::FETCH_COLUMN);
    }
}