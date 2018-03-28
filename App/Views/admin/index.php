<!doctype html>
<html lang="ru">
<head>

    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Все опросы</title>

    <link rel="stylesheet" href="/Assets/css/normalize.css">
    <link rel="stylesheet" href="/Assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/Assets/vendor/bootstrap/css/bootstrap-theme.min.css">

    <link rel="stylesheet" href="/Assets/css/common.css">

</head>

<body>

    <div class="container">

        <h1 class="text-center"> Управление опросами </h1>

        <div class="div-md-12 text-right">
            <a class="btn btn-default" href="/admin/polls/create">Создать новый опрос</a>
        </div>

        <h2 class="text-center"> Активный опрос </h2>
        <? if (empty($polls['active'])): ?>
            <p class="lead text-center">Нет активных опросов.</p>
        <? else: ?>
            <table class="table table-striped">
                <thead>
                    <tr class="row">
                        <th class="col-md-6 text-center">Название</th>
                        <th class="col-md-6 text-center">Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="row">
                        <td class="col-md-6 text-center"><? echo $polls['active'][0]->name; ?></td>
                        <td class="col-md-6 text-center">
                            <a class="btn btn-default" href="/admin/polls/results?id=<? echo $polls['active'][0]->id; ?>">Результаты</a>
                            <a class="btn btn-default" href="/admin/polls/change_status?<? echo "id={$polls['active'][0]->id}&status=closed"; ?>">Закрыть</a>
                            <a class="btn btn-default" href="/admin/polls/delete?id=<? echo $polls['active'][0]->id; ?>">Удалить</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        <? endif; ?>

        <h2 class="text-center"> Черновики опросов </h2>
        <table class="table table-striped">
            <thead>
            <tr class="row">
                <th class="col-md-6 text-center">Название</th>
                <th class="col-md-6 text-center">Действия</th>
            </tr>
            </thead>
            <tbody>
            <? foreach ($polls['draft'] as $draftPoll): ?>
            <tr class="row">
                <td class="col-md-6 text-center"><? echo $draftPoll->name; ?></td>
                <td class="col-md-6 text-center">
                    <a class="btn btn-default" href="/admin/polls/edit?id=<? echo $draftPoll->id; ?>">Редактировать</a>
                    <a class="btn btn-default" href="/admin/polls/change_status?<? echo "id={$draftPoll->id}&status=active"; ?>">Активировать</a>
                    <a class="btn btn-default" href="/admin/polls/delete?id=<? echo $draftPoll->id; ?>">Удалить</a>
                </td>
            </tr>
            <? endforeach; ?>
            </tbody>
        </table>

        <h2 class="text-center"> Завершенные опросы </h2>
        <table class="table table-striped">
            <thead>
            <tr class="row">
                <th class="col-md-6 text-center">Название</th>
                <th class="col-md-6 text-center">Действия</th>
            </tr>
            </thead>
            <tbody>
            <? foreach ($polls['closed'] as $closedPoll): ?>
                <tr class="row">
                    <td class="col-md-6 text-center"><? echo $closedPoll->name; ?></td>
                    <td class="col-md-6 text-center">
                        <a class="btn btn-default" href="/admin/polls/results?id=<? echo $closedPoll->id; ?>">Результаты</a>
                        <a class="btn btn-default" href="/admin/polls/change_status?<? echo "id={$closedPoll->id}&status=active"; ?>">Активировать</a>
                        <a class="btn btn-default" href="/admin/polls/delete?id=<? echo $closedPoll->id; ?>">Удалить</a>
                    </td>
                </tr>
            <? endforeach; ?>
            </tbody>
        </table>

    </div>

</body>

<script src="/Assets/vendor/jquery/jquery-3.2.0.min.js"></script>
<script src="/Assets/vendor/bootstrap/js/bootstrap.min.js"></script>

<? if(!empty($_SESSION['messages'])): ?>
    <script>
        var text = '';
        <? foreach ($_SESSION['messages'] as $message): ?>
        text += '<? echo $message ?>';
        text += "\r\n";
        <? endforeach; ?>

        alert(text);
    </script>
    <? unset($_SESSION['messages']); ?>
<? endif; ?>

</html>