<?php
    if (isset($_GET['survey_ans'])) {
        foreach ($_GET['survey_ans'] as $val) {
            echo $val . ' ' ;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluate Employees</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <style>
        html, body {
            height: 100%;
        }
    </style>
</head>
<body class="text-center d-flex">

    <main class="m-auto border rounded-5 p-3 w-50">
        <form class="p-2" method="POST" action="<?= site_url('/evaluations') ?>">
            <h1 class="h3 mb-3 fw-normal">Evaluate Employee</h1>

            <input type="hidden" name="evaluator_id" value="<?= esc($auth_id) ?>">

            <div class="mb-3 row">
                <label for="evaluation_period_id" class="col-auto align-self-center"> Select Evaluation Period:</label>
                <select name="evaluation_period_id" class="form-select col" required>
                    <option selected disabled value="">Evaluation Periods ...</option>
                    <?php foreach($activePeriods as $period): ?>
                        <option value="<?= esc($period->evaluation_period_id) ?>">
                            <?= esc($period->evaluation_year) . ' - ' . esc($period->evaluation_period) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3 row">
                <label for="employee_id" class="col-auto align-self-center"> Select Employee:</label>
                <select name="employee_id" class="form-select col" required>
                    <option selected disabled value="">Employees ...</option>
                    <?php foreach($employees as $employee): ?>
                        <option value="<?= esc($employee->employee_id) ?>">
                            <?= esc($employee->employee_name). ' ('. esc($employee->employee_email) . ')' ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3 row">
                <div class="form-check col">
                    <input type="button" class="w-100 btn btn-lg btn-outline-primary" onclick="show('score')" value="Score"/>
                </div>
                <div class="form-check col">
                    <input type="button" class="w-100 btn btn-lg btn-outline-primary" onclick="show('survey')" value="Survey"/>
                </div>
            </div>

            <div class="mb-3 row justify-content-center" id="competency_score">
                <label for="score" class="form-label col-auto">Score:</label>
                <input type="number" class="col" name="score" id="score_input" min="1" max="5" required/>
            </div>

            <div class="mb-3 row" id="competency_survey" style="display:none;">
                <ul class="list-group col">
                    <input type="number" min="1" max="5" placeholder="Question 1" class="list-group-item" name="survey_ans[]"/>
                    <input type="number" min="1" max="5" placeholder="Question 2" class="list-group-item" name="survey_ans[]"/>
                    <input type="number" min="1" max="5" placeholder="Question 3" class="list-group-item" name="survey_ans[]"/>
                    <input type="number" min="1" max="5" placeholder="Question 4" class="list-group-item" name="survey_ans[]"/>
                    <input type="number" min="1" max="5" placeholder="Question 5" class="list-group-item" name="survey_ans[]"/>
                    <input type="number" min="1" max="5" placeholder="Question 6" class="list-group-item" name="survey_ans[]"/>
                </ul>
                <ul class="list-group col">
                    <input type="number" min="1" max="5" placeholder="Question 7" class="list-group-item" name="survey_ans[]"/>
                    <input type="number" min="1" max="5" placeholder="Question 8" class="list-group-item" name="survey_ans[]"/>
                    <input type="number" min="1" max="5" placeholder="Question 9" class="list-group-item" name="survey_ans[]"/>
                    <input type="number" min="1" max="5" placeholder="Question 10" class="list-group-item" name="survey_ans[]"/>
                    <input type="number" min="1" max="5" placeholder="Question 11" class="list-group-item" name="survey_ans[]"/>
                    <input type="number" min="1" max="5" placeholder="Question 12" class="list-group-item" name="survey_ans[]"/>
                </ul>
            </div>

            <div class="mb-3 row">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>

        </form>
    </main>
    <?php

    // foreach ($employees as $employee) {
    //     echo $employee->employee_name . ' | ';
    //         echo $employee->employee_email . ' | ';
    //         echo $employee->department . ' <br> ';
    // }
    ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
<script>    
    function show (id) {
        let score = document.getElementById('competency_score'),
            survey = document.getElementById('competency_survey'),
            score_input = document.getElementById('score_input'),
            questions = document.getElementsByClassName('list-group-item');
        
        if (id == 'survey') {
            score.style.display = 'none';
            survey.style.display = '';
            score_input.removeAttribute("required");
            score_input.value = '' ;
            [].forEach.call(questions, function (q) { q.setAttribute("required","required") });
        } 
        else if (id == 'score') {
            score.style.display = '';
            survey.style.display = 'none';
            score_input.setAttribute("required","required");
            [].forEach.call(questions, function (q) { q.removeAttribute("required"); q.value = '' });
        }
    }
</script>
</body>
</html>