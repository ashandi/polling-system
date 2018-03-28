<?php

namespace App\Models;

use System\Model;
use System\Validation\Validatable;

class Poll extends Model implements Validatable
{

    /**
     * @var string
     */
    public $table = 'polls';

    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $status;

    /**
     * Method defines order of saving exemplar of model in database
     */
    public function save(): void
    {
        $query = $this->newQuery();

        $result = $query->execute(
            "INSERT INTO {$this->table} (`name`, `status`) " .
            " VALUES ('{$this->name}', '{$this->status}')"
        );
        if ($result) {
            $this->id = $query->getLastInsertedId();

            if (!empty($this->questions)) {
                $this->saveQuestions($this->questions);
            }
        }
    }

    /**
     * Method deletes all related questions
     */
    private function deleteQuestions() : void
    {
        foreach ($this->questions() as $question) {
            $question->delete();
        }
    }

    /**
     * Method adds questions for this poll
     *
     * @param array $questions
     */
    public function saveQuestions(array $questions) : void
    {
        $this->deleteQuestions();

        foreach ($questions as $questionParams) {
            $question = Question::createFromArray($questionParams);
            $question->poll_id = $this->id;
            $question->is_required = isset($questionParams['is_required']);

            $question->save();
        }
    }

    /**
     * @return string
     */
    public static function getActiveStatusCode() : string
    {
        return 'active';
    }

    /**
     * @return string
     */
    public static function getClosedStatusCode() : string
    {
        return 'closed';
    }

    /**
     * @return string
     */
    public static function getDraftStatusCode() : string
    {
        return 'draft';
    }

    /**
     * @return bool
     */
    public function isActive() : bool
    {
        return $this->status == $this->getActiveStatusCode();
    }

    /**
     * @return bool
     */
    public function isClosed() : bool
    {
        return $this->status == $this->getClosedStatusCode();
    }

    /**
     * @return bool
     */
    public function isDraft() : bool
    {
        return $this->status == $this->getDraftStatusCode();
    }

    /**
     * Relation for questions of this poll
     *
     * @return array
     */
    public function questions() : array
    {
        return $this->hasMany(Question::class, 'poll_id');
    }

    /**
     * Relation of answer variants of questions of this poll
     *
     * @return array
     */
    public function answerVariants() : array
    {
        return $this->hasManyThrow(AnswerVariant::class, Question::class, 'poll_id', 'question_id');
    }

    /**
     * Method returns array of rules for validation
     *
     * @return array
     */
    public static function getRules(): array
    {
        return [
            'name' => [ 'required' => 'Название опроса не должно быть пустым.' ],
            'status' => [ 'required' => 'Не задан статус опроса' ],
            'questions' => [
                'min_count:1' => 'Должен быть минимум один вопрос.',
                'must_be_min:is_required,on' => 'Хотя бы один вопрос должен быть обязательным.'
            ],
            'questions.[]text' => [ 'required' => 'Текст вопроса не должен быть пустым.' ],
            'questions.[]type' => [ 'required' => 'Должен быть выбран тип вопроса.' ],
            'questions.[]answer_variants' => [ 'min_count:2' => 'Вариантов ответа должно быть минимум два.' ],
            'questions.[]answer_variants.[]text' => [ 'required' => 'Текст ответа не должен быть пустым.' ]
        ];
    }

    /**
     * Method returns codes of all possible statuses of poll
     *
     * @return array
     */
    public static function getStatuses() : array
    {
        return [
            self::getActiveStatusCode(),
            self::getDraftStatusCode(),
            self::getClosedStatusCode()
        ];
    }
}