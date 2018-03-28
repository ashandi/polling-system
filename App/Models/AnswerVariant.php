<?php

namespace App\Models;

use System\Model;

class AnswerVariant extends Model
{

    /**
     * @var string
     */
    protected $table = 'answer_variants';

    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $text;

    /**
     * @var int
     */
    public $question_id;

    /**
     * Method defines order of saving exemplar of model in database
     */
    public function save(): void
    {
        $query = $this->newQuery();

        $result = $query->execute(
            "INSERT INTO {$this->table} (`text`, `question_id`) " .
            " VALUES ('{$this->text}', '{$this->question_id}')");
        if ($result) {
            $this->id = $query->getLastInsertedId();
        }
    }

}