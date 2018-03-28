<?php

namespace System\Validation;

use System\Validation\ValidationHandlers\ValidationHandler;

class Validator
{

    /**
     * @var array
     */
    private $messages = [];

    /**
     * Method validates given data by given rules
     *
     * @param array $data
     * @param array $rules
     * @return bool
     */
    public function validate(array $data, array $rules) : bool
    {
        $result = true;

        foreach ($rules as $fields => $rulesForField) {
            $splittedFields = $this->splitFields($fields);
            $topField = $splittedFields[0];
            $topFieldData = $data[$topField] ?? null;

            $internalFields = $splittedFields[1] ?? null;
            if (!empty($internalFields)) {
                $internalResult = $this->validateInternalFields($internalFields, $topFieldData, $rulesForField);
                $result = $this->writeResult($result, $internalResult);
                continue;
            }

            $validationResult = $this->validateProperty($topFieldData, $rulesForField);
            $result = $this->writeResult($result, $validationResult);
        }

        return $result;
    }

    /**
     * Method splits fields by dot
     *
     * @param string $fields
     * @return array
     */
    private function splitFields(string $fields) : array
    {
        $dotPos = strpos($fields, '.');
        if ($dotPos === false) {
            return [ $fields ];
        }

        return [
            substr($fields, 0, $dotPos),
            substr($fields, $dotPos + 1)
        ];
    }

    /**
     * Method validates internal fields recursively
     *
     * @param $internalFields
     * @param array $topFieldData
     * @param array $rules
     * @return bool
     */
    private function validateInternalFields($internalFields, array $topFieldData, array $rules) : bool
    {
        if ($this->isArrayField($internalFields)) {
            $internalFields = substr($internalFields, 2);

            $result = true;
            foreach ($topFieldData as $fieldData) {
                $recursiveResult = $this->validate($fieldData, [$internalFields => $rules]);
                $result = $this->writeResult($result, $recursiveResult);
            }

            return $result;
        }

        return $this->validate($topFieldData, [$internalFields => $rules]);
    }

    /**
     * Method returns result of validation
     * If result already false, not necessary to change it
     *
     * @param $result
     * @param bool $newResult
     * @return bool
     */
    private function writeResult($result, bool $newResult) {
        if ($result == false) {
            return $result;
        }

        return $newResult;
    }

    /**
     * Method checks that internal field is array
     *
     * @param string $field
     * @return bool
     */
    private function isArrayField(string $field) : bool
    {
        return substr($field, 0, 2) == '[]';
    }

    /**
     * Method validates given value by given rules
     * using by ValidationHandlers
     *
     * @param $value
     * @param array $rules
     * @return bool
     */
    private function validateProperty($value, array $rules) :bool
    {
        $result = true;
        foreach ($rules as $ruleData => $message) {
            $splittedRuleData = $this->splitRule($ruleData);
            $rule = $splittedRuleData[0];
            $args = $splittedRuleData[1] ?? [];

            /** @var ValidationHandler $handler */
            $handler = ValidatorsFactory::getHandler($rule);

            if(!empty($handler) && !$handler->validate($value, $args)) {
                $this->messages[] = $message;
                $result = false;
            }
        }

        return $result;
    }

    /**
     * Method splits rules by colons and commas
     *
     * @param string $ruleData
     * @return array
     */
    private function splitRule(string $ruleData) : array
    {
        $pos = strpos($ruleData, ':');
        if ($pos === false) {
            return [ $ruleData ];
        }

        return [
            substr($ruleData, 0, $pos),
            explode(',', substr($ruleData, $pos + 1))
        ];
    }

    /**
     * Method returns all messages of rules which didn't pass the validation
     *
     * @return array
     */
    public function getMessages() :array
    {
        return $this->messages;
    }

}