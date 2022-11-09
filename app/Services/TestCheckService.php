<?php

namespace App\Services;

use App\Models\Question;
use App\Models\Test;

class TestCheckService
{
    private $userAnswersList;
    private $test;

    public function __construct(array $userAnswersList, Test $test)
    {
        $this->userAnswersList = $userAnswersList;
        $this->test = $test;
    }

    public function checkTest(): int
    {
        $sumOfCorrectAnswers = 0;

        if (count($this->userAnswersList) == 0) {
            return  $sumOfCorrectAnswers;
        }

        foreach ($this->userAnswersList as $key => $userAnswers) {
            $question_id = $this->userAnswersList[$key]['question_index'];

            // вопрос из теста (с правильным ответом)
            // исправлено в пользу итогового теста, который не связан со своими вопросами
            //$question = $this->test->questions->find($question_id);
            $question = Question::find($question_id);
            // список верных ответов на конкретный вопрос
            $correctAnswers = json_decode($question->correct);

            $questionCheckResult = $this->checkQuestion($userAnswers['answer'], $correctAnswers);

            if ($questionCheckResult) {
                $sumOfCorrectAnswers++;
            }
        }

        return $sumOfCorrectAnswers;
    }

    private function checkQuestion(array $userAnswers, array $correctAnswers): int
    {
        // сколько всего ответов в массиве ответов
        $total = count($correctAnswers);
        // количество верных ответов
        $correct = 0;

        // если количество ответов и верных ответов не совпадает - продолжаем
        if ($total != count($userAnswers)) {
            return $correct;
        }

        // цикл по всем ответам на вопрос
        foreach ($userAnswers as $index => $answer) {
            // правильный ответ
            $correctAnswer = $correctAnswers[$index]->result;
            // ответ пользователя
            $userAnswer = $answer['result'];
            // текуший ответ - правильный?
            $isCorrect = false;

            if (is_array($correctAnswer)) {
                $isCorrect = $this->checkOrderedArray($userAnswer, $correctAnswer);
            } else {
                $isCorrect = $this->checkString(strval($userAnswer), strval($correctAnswer));
            }

            if ($isCorrect) {
                $correct++;
            }
        }

        return $correct >= $total;
    }

    private function checkString(string $userString, string $correctString): bool
    {
        $correctString = mb_strtolower($correctString);
        $currentString = mb_strtolower($userString);
        $correctString = str_replace(".", "", $correctString);
        $currentString = str_replace(".", "", $currentString);
        $correctString = str_replace(" ", "", $correctString);
        $currentString = str_replace(" ", "", $currentString);

        if ($correctString == "") {
            return $currentString == $correctString;
        }

        $position = strpos($currentString, $correctString);

        return !($position === false);
    }

    private function checkOrderedArray($userArray, $correctArray): bool
    {
        $countCorrectItems = count($correctArray);
        $countCheckItems = 0;

        foreach ($correctArray as $key => $value) {
            if ($this->checkUnorderedArray($value, $userArray)) {
                $countCheckItems++;
            }
        }

        return $countCorrectItems == $countCheckItems;
    }

    private function checkUnorderedArray($needle, $haystack): bool
    {
        $search = str_replace(".", "", $needle);
        $search = str_replace(" ", "", $search);
        $data = array_map(function ($value) {
            return str_replace('.', '', $value);
        }, $haystack);
        $data = array_map(function ($value) {
            return str_replace(' ', '', $value);
        }, $data);
        return in_array(strtolower($search), array_map('strtolower', $data));
    }
}
