<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use function PHPSTORM_META\map;

class Manager extends BaseController
{
    public function getActiveEvaluationPeriods() {
        $db = db_connect();
        $query = $db->query('
            SELECT
                `evaluation_period_id`,
                `evaluation_period`,
                `evaluation_year`,
                `status`,
                `created_at`,
                `updated_at`
            FROM
                `evaluation_period_view`
            WHERE
                `status` = "Active"
        ');
        $activePeriods = $query->getResult();

        return $activePeriods;
    }

    public function index($id) {
        // return 
        // '<pre>'. 
        //     print_r($this->getEvaluatorsSubmissions($id))
        // .'</pre>';

        return $this->getEvaluatorsSubmissions($id);
    }
    
    public function getEvaluatorsSubmissions($id) {
        $db = db_connect();
        $sql = 'SELECT
                    evaluation_id,
                    employee_id,
                    employee_name,
                    employee_email,
                    evaluator_id,
                    evaluator_employee_id,
                    evaluator_name,
                    evaluator_email,
                    evaluation_score,
                    manager_id,
                    survey_ans,
                    evaluation_status,
                    eval_view.evaluation_period_id,
                    period.evaluation_period,
                    period.evaluation_year,
                    (
                    SELECT
                        FLOOR(AVG(evaluation_score))
                    FROM
                        `evaluation_view` report
                    WHERE
                        employee_id = eval_view.employee_id
                    GROUP BY
                        employee_id,
                        evaluation_period_id
                ) avg_score
                FROM
                    evaluation_view eval_view
                LEFT JOIN evaluation_period_view period ON
                    eval_view.evaluation_period_id = period.evaluation_period_id
                WHERE
                    manager_id = :id: AND evaluation_status = "Pending"
                ORDER BY
                    evaluation_period_id,
                    employee_id';
        $query = $db->query($sql, [ 'id' => $id ]);
        $evaluatorsSubmissions = $query->getResult();

        $groupedSubmissions = [] ;

        foreach ($evaluatorsSubmissions as $eval) {
            $groupedSubmissions[$eval->employee_id][$eval->evaluation_period_id][$eval->evaluation_id] = $eval ;
        }

        // print("<pre>".print_r($groupedSubmissions,true)."</pre>"
        //         "<pre>".print_r($evaluatorsSubmissions,true)."</pre>"
        // . '<br>'
        // . count($groupedSubmissions)
        // );

        return view('manager/show.php',[ 'groupedSubmissions' => $groupedSubmissions ]);
    }
}
