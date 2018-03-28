<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Опрос</title>

    <link rel="stylesheet" href="/Assets/css/normalize.css">
    <link rel="stylesheet" href="/Assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/Assets/vendor/bootstrap/css/bootstrap-theme.min.css">

    <link rel="stylesheet" href="/Assets/css/common.css">

</head>
<body>

    <div class="container">

        <? if (empty($activePoll)): ?>
            <p class="lead text-center">Нет доступного опроса.</p>
        <? else: ?>
            <h1 class="text-center"> <? echo $activePoll->name ?> </h1>

            <form action="/polls/save" method="POST">
                <input type="hidden" name="poll_id" value="<? echo $activePoll->id; ?>">
                <? foreach ($activePoll->questions() as $question): ?>
                    <div class="form-group">
                        <p class="lead"><? echo $question->text ?> <? if ($question->is_required) echo '*'; ?></p>

                        <? foreach ($question->answerVariants() as $answerVariant): ?>
                            <? if ($question->type == 'single'):?>
                                <label>
                                    <input type="radio"
                                           name="answers[<? echo $question->id; ?>]"
                                           value="<? echo $answerVariant->id; ?>">
                                    <? echo $answerVariant->text ?>
                                </label>
                            <? else: ?>
                                <label>
                                    <input type="checkbox"
                                           name="answers[<? echo $question->id; ?>][]"
                                           value="<? echo $answerVariant->id; ?>">
                                    <? echo $answerVariant->text ?>
                                </label>
                            <? endif; ?>
                            <br>
                        <? endforeach; ?>
                    </div>
                <? endforeach; ?>

                <input type="submit" class="btn btn-default" value="Сохранить результаты">

            </form>
        <? endif; ?>
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