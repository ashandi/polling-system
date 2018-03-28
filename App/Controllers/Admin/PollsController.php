<?php

namespace App\Controllers\Admin;

use System\Request;
use App\Models\Poll;
use System\Redirect;
use System\Response;
use App\Models\Question;
use System\Validation\Validator;
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
     * Method displays all existing polls
     *
     * @return Response
     */
    public function index() : Response
    {
        $polls = $this->pollsRepository->getGroupedByStatus();

        return new Response('admin/index', compact('polls'));
    }

    /**
     * Method displays form for creating a new poll
     *
     * @return Response
     */
    public function create() : Response
    {
        $types = Question::getTypes();

        return new Response('admin/create', compact('types'));
    }

    /**
     * Method saves new poll
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request) : Response
    {
        $attributes = [
            'name' => $request->get('name'),
            'status' => Poll::getDraftStatusCode(),
            'questions' => $request->get('questions')
        ];

        $validator = new Validator();
        if (!$validator->validate($attributes, Poll::getRules())) {
            return redirect($request->getPreviousUrl(), $validator->getMessages());
        }

        $this->pollsRepository->create($attributes);

        return redirect('/admin/polls', 'Сохранение прошло успешно.');
    }

    /**
     * Method displays form to edit the poll
     *
     * @param Request $request
     * @return Response
     */
    public function edit(Request $request) : Response
    {
        $poll = $this->pollsRepository->getById($request->get('id'));
        $types = Question::getTypes();

        return new Response('admin/edit', compact('poll', 'types'));
    }

    /**
     * Method saves changes of the poll
     *
     * @param Request $request
     * @return Response
     */
    public function update(Request $request) : Response
    {
        $poll = $this->pollsRepository->getById($request->get('id'));
        if ($poll->status != Poll::getDraftStatusCode()) {
            return redirect($request->getPreviousUrl(), "Можно редактировать только опросы в статусе черновика!");
        }

        $attributes = [
            'name' => $request->get('name'),
            'status' => Poll::getDraftStatusCode(),
            'questions' => $request->get('questions')
        ];

        $validator = new Validator();
        if (!$validator->validate($attributes, Poll::getRules())) {
            return redirect($request->getPreviousUrl(), $validator->getMessages());
        }

        $this->pollsRepository->update($poll, $attributes);

        return redirect('/admin/polls', 'Изменения сохранены успешно.');
    }

    /**
     * Method deletes the poll
     *
     * @param Request $request
     * @return Response
     */
    public function delete(Request $request) : Response
    {
        $this->pollsRepository->delete( $request->get('id') );

        return redirect('/admin/polls', 'Опрос успешно удален.');
    }

    /**
     * Method changes status of the poll
     *
     * @param Request $request
     * @return Response
     */
    public function changeStatus(Request $request) : Response
    {
        $id = $request->get('id');
        $newStatus = $request->get('status');

        try {
            $this->pollsRepository->changeStatus($id, $newStatus);
            return redirect('/admin/polls', 'Статус успешно изменен.');
        } catch (\Exception $exception) {
            return redirect('/admin/polls', $exception->getMessage());
        }
    }


    /**
     * Method shows results of the poll
     *
     * @param Request $request
     * @return Response
     */
    public function showResults(Request $request) : Response
    {
        $poll = $this->pollsRepository->getById( $request->get('id') );

        $result = $this->answerRepository->getAllResults($poll);
        $total = $result['total'];
        $answers = $result['answers'];

        return new Response('/admin/results', compact('poll', 'total', 'answers'));
    }

    /**
     * Method shows results of the poll filtered by given conditions
     *
     * @param Request $request
     * @return Response
     */
    public function filter(Request $request) : Response
    {
        $poll = $this->pollsRepository->getById($request->get('poll_id'));
        $filters = $request->get('answers');

        $result = $this->answerRepository->getFilteredResults($poll, $filters);
        $total = $result['total'];
        $answers = $result['answers'];
        $filtersStr = $this->translateFiltersToString($poll, $filters);

        return new Response('/admin/results', compact('poll', 'total', 'answers', 'filtersStr'));
    }

    /**
     * Method translates given filters to array of their string representations
     *
     * @param Poll $poll
     * @param array $filters
     * @return array|null
     */
    private function translateFiltersToString(Poll $poll, array $filters) : ?array
    {
        if (count($filters) == 0) {
            return null;
        }

        $questions = $poll->questions();
        $answerVariants = $poll->answerVariants();

        $filterStr = [];
        foreach ($filters as $questionId => $answerIds) {
            $question = $this->getQuestion($questions, $questionId);
            $chosenAnswerVariants = $this->getAnswerVariants($answerVariants, $answerIds);

            $filterStr[] = $question->text . ": " . implode(" ИЛИ ", array_map(function ($item) {
                    return $item->text;
                }, $chosenAnswerVariants));;
        }

        return $filterStr;
    }

    /**
     * Method returns question by id
     *
     * @param array $questions
     * @param int $id
     * @return Question
     */
    private function getQuestion(array $questions, int $id) : Question
    {
        $array = array_filter($questions, function ($item) use ($id) {
            return $item->id == $id;
        });

        return array_shift($array);
    }

    /**
     * Method returns answer variants by given ids
     *
     * @param array $answerVariants
     * @param array $ids
     * @return array
     */
    private function getAnswerVariants(array $answerVariants, array $ids) : array
    {
        return array_filter($answerVariants, function ($item) use ($ids) {
            return in_array($item->id, $ids);
        });
    }

}