<?php

namespace App\Controllers;

use System\Request;
use App\Models\Poll;
use System\Redirect;
use System\Response;
use App\Repositories\Polls\PollsRepository;
use App\Repositories\Answers\AnswerRepository;

class PollsController
{

    /**
     * @var PollsRepository
     */
    private $pollsRepository;

    /**
     * @var AnswerRepository
     */
    private $answerRepository;

    /**
     * @param PollsRepository $pollsRepository
     * @param AnswerRepository $answerRepository
     */
    public function __construct(PollsRepository $pollsRepository, AnswerRepository $answerRepository)
    {
        $this->pollsRepository = $pollsRepository;
        $this->answerRepository = $answerRepository;
    }


    /**
     * Method displays active poll
     *
     * @return Response
     */
    public function index() : Response
    {
        $activePoll = $this->pollsRepository->getActive();

        return new Response('index', compact('activePoll'));
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function save(Request $request) : Response
    {
        $poll = $this->pollsRepository->getById($request->get('poll_id'));
        $answers = $request->get('answers');
        if (!$this->validate($poll, $answers)) {
            return redirect($request->getPreviousUrl(), 'Выберите ответы для всех вопросов, помеченных звездочкой!');
        }

        $this->answerRepository->save($answers);

        return redirect("/results?id={$poll->id}", 'Ваши ответы сохранены.');
    }

    /**
     * Method validates given answers
     *
     * @param Poll $poll
     * @param array $answers
     * @return bool
     */
    private function validate(Poll $poll, array $answers)
    {
        foreach ($poll->questions() as $question) {
            if ($question->is_required && empty($answers[$question->id])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Method shows results of poll for user
     *
     * @param Request $request
     * @return Response
     */
    public function showResults(Request $request) : Response
    {
        $poll = $this->pollsRepository->getById($request->get('id'));

        $result = $this->answerRepository->getAllResults($poll);
        $total = $result['total'];
        $answers = $result['answers'];

        return new Response('results', compact('poll', 'total', 'answers'));
    }

}