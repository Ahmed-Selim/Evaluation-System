<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Direct Manager Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <style>
        html, body {
            height: 100%;
        }
    </style>
</head>
<body class="text-center">
    <h1> Direct Manager Page </h1>
    <main class="m-auto border rounded-5 p-3">
        <caption>Submitted Evaluations</caption>
        <table class="table table-striped table-inverse table-responsive table-bordered">
            <thead class="thead-inverse">
                <tr>
                    <th>Employee</th>
                    <th>Average Score</th>
                    <th>Evaluator</th>
                    <th>Evaluation Period</th>
                    <th> Competency Score </th>
                    <th> Survey Answers </th>
                    <th> Action </th>
                </tr>
                </thead>
                <tbody class="align-middle">
                    
                    <?php foreach ($groupedSubmissions as $employee_id => $eval_periods): ?>
                        <?php foreach ($eval_periods as $eval_period_id => $evaluations): ?>
                            <?php $flag = True ?>
                            <?php foreach ($evaluations as $eval): ?>
                                <tr>
                                    <?php if ($flag): ?>
                                        <td rowspan="<?= count($evaluations) ?>">
                                            <?=
                                            esc($eval->employee_name)
                                                . ' (' . esc($eval->employee_email) . ')'
                                            ?>
                                        </td>
                                        <td rowspan="<?= count($evaluations) ?>">
                                            <?=
                                            esc($eval->avg_score)
                                            ?>
                                        </td>
                                    <?php endif; $flag = false?>
                                    <td>
                                        <?=
                                            esc($eval->evaluator_name).' ('.esc($eval->evaluator_email).')'
                                        ?>
                                    </td>
                                    <td>
                                        <?=
                                            esc($eval->evaluation_year).' - ' .esc($eval->evaluation_period)
                                        ?>
                                    </td>
                                    <td>
                                        <?=
                                            esc($eval->evaluation_score)
                                        ?>
                                    </td>
                                    <td>
                                        <?=
                                            esc($eval->survey_ans) ?? '-'
                                        ?>
                                    </td>
                                    <td>
                                        <form class="d-flex justify-content-between" action="<?= site_url('/evaluations/'.$eval->evaluation_id) ?>" method="POST">
                                            <input type="hidden" name="manager_id" value="<?= $eval->manager_id ?>">
                                            <button type="submit" class="btn btn-outline-success" name='action' value='Accepted'>Approve</button>
                                            <button type="submit" class="btn btn-outline-danger" name='action' value='Rejected'>Reject</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </tbody>
        </table>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
</body>
</html>