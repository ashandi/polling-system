<?php

namespace App\Models;

use System\Model;

class Question extends Model
{

    /**
     * @var string
     */
    protected $table = 'questions';

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
    public $poll_id;

    /**
     * @var string
     */
    public $type;

    /**
     * @var bool
     */
    public $is_required;

    /**
     * Method defines order of saving exemplar of model in database
     */
    public function save(): void
    {
        $query = $this->newQuery();
        $isRequired = $this->is_required ? 'true' : 'false';

        $result = $query->execute(
            "INSERT INTO {$this->table} (`text`, `poll_id`, `type`, `is_required`) " .
            " VALUES ('{$this->text}', '{$this->poll_id}', '{$this->type}', $isRequired)");
        if ($result) {
            $this->id = $query->getLastInsertedId();

            if (!empty($this->answer_variants)) {
                $this->saveAnswerVariants($this->answer_variants);
            }
        }
    }

    /**
     * Method deletes all related answer variants
     */
    private function deleteAnswerVariants() : void
    {
        foreach ($this->answerVariants() as $answerVariant) {
            $answerVariant->delete();
        }
    }

    /**
     * Method adds answer variants for this question
     *
     * @param array $answerVariants
     */
    private function saveAnswerVariants(array $answerVariants) : void
    {
        $this->deleteAnswerVariants();

        foreach ($answerVariants as $answerVariantParams) {
            $answerVariant = AnswerVariant::createFromArray($answerVariantParams);
            $answerVariant->question_id = $this->id;

            $answerVariant->save();
        }
    }

    /**
     * Method returns array of possible question types
     * with their representations on human language
     *
     * @return array
     */
    public static function getTypes()
    {
        return [
            ['type' => 'single', 'text' => 'Один ответ'],
            ['type' => 'multiple', 'text' => 'Несколько ответов']
        ];
    }

    /**
     * Relation for answer variants
     *
     * @return array
     */
    public function answerVariants() : array
    {
        return $this->hasMany(AnswerVariant::class, 'question_id');
    }
}