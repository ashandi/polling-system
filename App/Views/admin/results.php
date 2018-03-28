<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Результаты опроса</title>

    <link rel="stylesheet" href="/Assets/css/normalize.css">
    <link rel="stylesheet" href="/Assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/Assets/vendor/bootstrap/css/bootstrap-theme.min.css">

    <link rel="stylesheet" href="/Assets/css/common.css">

</head>
<body>

    <div class="container">

        <h1 class="text-center"> <? echo $poll->name ?> </h1>

        <? if(!empty($filtersStr)): ?>
            <p class="lead text-muted text-bold">Выборка по пользователям:</p>

            <ul class="list-group">
                <? foreach ($filtersStr as $str): ?>
                    <li class="list-group-item"><? echo $str ?></li>
                <? endforeach; ?>
            </ul>
        <? endif; ?>

        <? foreach ($poll->questions() as $question): ?>

            <p class="lead"><? echo $question->text ?></p>

            <? foreach ($question->answerVariants() as $answerVariant): ?>
                <p class="text-muted"><? echo $answerVariant->text ?></p>

                <div class="progress">
                    <div class="progress-bar" role="progressbar"
                         aria-valuenow="<? echo $answers[$question->id][$answerVariant->id]; ?>"
                         aria-valuemin="0" aria-valuemax="<? echo $total; ?>"
                         style="width:<? echo ($answers[$question->id][$answerVariant->id] / $total) * 100 ?>%">
                        <? echo $answers[$question->id][$answerVariant->id] . ' / ' . $total; ?>
                    </div>
                </div>
            <? endforeach; ?>

        <? endforeach; ?>

        <h2 class="text-center">Фильтры</h2>

        <form action="/admin/polls/filter" method="POST">
            <input type="hidden" name="poll_id" value="<? echo $poll->id; ?>">
            <? foreach ($poll->questions() as $question): ?>
                <div class="form-group">
                    <p class="lead"><? echo $question->text ?></p>

                    <? foreach ($question->answerVariants() as $answerVariant): ?>
                        <label>
                            <input type="checkbox"
                                   name="answers[<? echo $question->id; ?>][]"
                                   value="<? echo $answerVariant->id; ?>">
                            <? echo $answerVariant->text ?>
                        </label>
                        <br>
                    <? endforeach; ?>
                </div>
            <? endforeach; ?>

            <div class="form-group">
                <input type="submit" class="btn btn-default" value="Посмотреть результаты">
            </div>

        </form>

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