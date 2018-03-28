<?php

use System\Handler;

return [
    'GET' => [
        '/' => new Handler(\App\Controllers\PollsController::class, 'index'),
        '/results' => new Handler(\App\Controllers\PollsController::class, 'showResults'),
        '/admin' => '/admin/polls', //Redirect
        '/admin/polls' => new Handler(\App\Controllers\Admin\PollsController::class, 'index'),
        '/admin/polls/create' => new Handler(\App\Controllers\Admin\PollsController::class, 'create'),
        '/admin/polls/edit' => new Handler(\App\Controllers\Admin\PollsController::class, 'edit'),
        '/admin/polls/change_status' => new Handler(\App\Controllers\Admin\PollsController::class, 'changeStatus'),
        '/admin/polls/delete' => new Handler(\App\Controllers\Admin\PollsController::class, 'delete'),
        '/admin/polls/results' => new Handler(\App\Controllers\Admin\PollsController::class, 'showResults')
   ],
    'POST' => [
        '/polls/save' => new Handler(\App\Controllers\PollsController::class, 'save'),
        '/admin/polls/create' => new Handler(\App\Controllers\Admin\PollsController::class, 'store'),
        '/admin/polls/edit' => new Handler(\App\Controllers\Admin\PollsController::class, 'update'),
        '/admin/polls/filter' => new Handler(\App\Controllers\Admin\PollsController::class, 'filter')
    ]
];