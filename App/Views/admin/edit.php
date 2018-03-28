<!doctype html>
<html lang="ru">
<head>

    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Редактирование опроса</title>

    <link rel="stylesheet" href="/Assets/css/normalize.css">
    <link rel="stylesheet" href="/Assets/vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/Assets/vendor/bootstrap/css/bootstrap-theme.min.css">

    <link rel="stylesheet" href="/Assets/css/common.css">

</head>

<body>

    <div class="container">

        <h1 class="text-center"> Редактирование опроса </h1>

        <form action="/admin/polls/edit" method="POST">
            <input type="hidden" name="id" value="<? echo $poll->id; ?>">

            <div class="form-group">
                <label for="name">Название опроса</label>
                <input type="text" class="form-control" name="name" value="<? echo $poll->name; ?>" required>
            </div>

            <div class="form-group" id="questions-form">
                <label for="questions">Вопросы</label>

                <question-form v-for="(question, index) in questions"
                    :question=question
                    :number=index
                    :key="index"
                    v-on:remove="questions.splice(index, 1)"
                ></question-form>

                <div class="text-right">
                    <input type="button" class="btn btn-default" v-on:click="addQuestionForm" value="Добавить ещё вопрос">
                </div>

            </div>

            <input type="submit" class="btn btn-default" value="Сохранить">
            <a class="btn btn-default" href="/admin/polls">Отмена</a>

        </form>

    </div>

</body>

<script src="/Assets/vendor/jquery/jquery-3.2.0.min.js"></script>
<script src="/Assets/vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="/Assets/vendor/vuejs/vue.min.js"></script>

<script type="x-template" id="question-form">
    <div class="panel panel-default b-poll-form__panel" :id="'question' + number">
        <p class="text-right text-muted b-question-form__delete" v-on:click="$emit('remove')">Удалить</p>
        <h2>Вопрос №{{number + 1}}</h2>
        <div class="form-group">
            <label>Текст вопроса</label>
            <input type="text" class="form-control"
                   :name="'questions[' + number + '][text]'"
                   v-model="question.text" required>
        </div>
        <div class="form-group">
            <label>Тип вопроса</label>
            <select class="form-control"
                    :name="'questions[' + number + '][type]'">
                <? foreach ($types as $option): ?>
                    <option v-if="question.type == '<? echo $option['type'] ?>'" value="<? echo $option['type'] ?>" selected><? echo $option['text'] ?></option>
                    <option v-else value="<? echo $option['type'] ?>"><? echo $option['text'] ?></option>
                <? endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label>Вопрос обязателен для ответа</label>
            <input v-if="question.is_required" type="checkbox" checked
                   :name="'questions[' + number + '][is_required]'">
            <input v-else type="checkbox"
                   :name="'questions[' + number + '][is_required]'">
        </div>

        <div class="form-group">
            <label>Варианты ответов</label>

            <answer-variant-form v-for="(answerVariant, index) in answerVariants"
                           :answerVariant=answerVariant
                           :answerNumber=index
                           :questionNumber="number"
                           :key="answerVariant"
                           v-on:remove="answerVariants.splice(index, 1)"
            ></answer-variant-form>

            <div class="text-right">
                <input type="button" class="btn btn-default" v-on:click="addAnswerVariantForm" value="Добавить ещё вариант ответа">
            </div>

        </div>
    </div>
</script>

<script type="x-template" id="answer-variant-form">
    <div class="panel panel-default b-poll-form__panel">
        <p class="text-right text-muted b-question-form__delete" v-on:click="$emit('remove')">Удалить</p>
        <div class="form-group">
            <p class="lead text-muted">Вариант ответа {{answerNumber + 1}}</p>
            <input type="text" class="form-control"
                   :name="'questions[' + questionNumber + '][answer_variants][][text]'"
                   v-model="answerVariant.text" required>
        </div>
    </div>
</script>

<script>
    var AnswerVariant = {
        template: '#answer-variant-form',
        props: ['answerNumber', 'answerVariant', 'questionNumber']
    };

    var Question = {
        template: '#question-form',
        props: ['number', 'question'],
        data: function () {
            var answerVariants = this.question.answer_variants;
            return {
                answerVariants:  answerVariants
            }
        },
        methods: {
            addAnswerVariantForm: function () {
                this.answerVariants.push({text:''});
            }
        },
        components: {
            'answer-variant-form': AnswerVariant
        }
    };

    new Vue({
        el: '#questions-form',
        components: {
            'question-form': Question
        },
        data: function () {
            return this.getQuestions()
        },
        methods: {
            addQuestionForm: function () {
                this.questions.push({text:'', type:'', is_required:false, answer_variants:[{text:''}, {text:''}]});
            },
            getQuestions: function () {
                var questions = [];
                <? foreach ($poll->questions() as $question): ?>
                    var answerVariants = [];
                    <? foreach ($question->answerVariants() as $answerVariant): ?>
                        answerVariants.push({
                            text: '<? echo $answerVariant->text ?>'
                        });
                    <? endforeach; ?>

                    questions.push({
                            text: '<? echo $question->text ?>',
                            type: '<? echo $question->type ?>',
                            is_required: <? echo $question->is_required ?>,
                            answer_variants: answerVariants
                        });
                <? endforeach; ?>

                return { questions: questions };
            }
        }
    })
</script>

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