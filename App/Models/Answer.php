<?php

namespace App\Models;

use System\Model;

class Answer extends Model
{

    /**
     * @var string
     */
    public $table = 'answers';

    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $question_id;

    /**
     * @var int
     */
    public $user_id;

    /**
     * @var int
     */
    public $answer_variant_id;

    /**
     * Method defines order of saving exemplar of model in database
     */
    public function save(): void
    {
        $query = $this->newQuery();

        $result = $query->execute(
            "INSERT INTO {$this->table} (`question_id`, `answer_variant_id`, `user_id`) " .
            " VALUES ('{$this->question_id}', '{$this->answer_variant_id}', '{$this->user_id}')");
        if ($result) {
            $this->id = $query->getLastInsertedId();
        }
    }

}