<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Evaluation extends BaseController
{
    public function index() {
        //
    }

    public function store() {
        $competency = $this->getScore($this->request);
        $request = [
            'evaluator_id' => intval($this->request->getVar('evaluator_id')) ,
            'evaluation_period_id' => intval($this->request->getVar('evaluation_period_id')) ,
            'employee_id' => intval($this->request->getVar('employee_id')) ,
            'score' => $competency['score'] ,
            'survey_ans' => json_encode($competency['survey_ans'])
        ];

        // var_dump($request);

        $db = db_connect();
        $sql = 'INSERT INTO `competency_reports`(
                    `employee_id`,
                    `evaluator_id`,
                    `evaluation_period_id`,
                    `status_id`,
                    `score`,
                    `survey_ans`
                )
                VALUES(
                    :employee_id:,
                    :evaluator_id:,
                    :evaluation_period_id:,
                    3,
                    :score:,
                    :survey_ans:
                )';
        $db->query($sql, [ 
            'employee_id' => $request['employee_id'] ,
            'evaluator_id' => $request['evaluator_id'] ,
            'evaluation_period_id' => $request['evaluation_period_id'] ,
            'score' => $request['score'] ,
            'survey_ans' => $request['survey_ans'] 
        ]);

        return (new Evaluator())->index($request['evaluator_id']);
    }

    public function update($evaluation_id) {
        $db = db_connect();
        $sql = 'UPDATE
                    `competency_reports`
                SET
                    `status_id` =(
                    SELECT
                        stat.status_id
                    FROM
                        competency_report_statuses stat
                    WHERE
                        stat.status = :status:
                ),
                `updated_at` = CURRENT_TIMESTAMP()
                WHERE
                    competency_report_id = :id:';
        $db->query($sql, [ 
            'id' => $evaluation_id,
            'status' => $this->request->getVar("action")
        ]);

        return (new Manager())->getEvaluatorsSubmissions($this->request->getVar("manager_id"));
    }



    public function getScore ($request) {
        $score = 0; $ans = NULL ;
        if ($request->getVar('survey_ans') != ["","","","","","","","","","","",""]) {
            $ans = array_map('intval', $request->getVar('survey_ans')) ;
            foreach ($ans as $val) {
                $score += $val;
            }
            $score = intval($score/12) ;
        } else {
            $score = intval($request->getVar('score')) ;
        }

        return [
            'score' => $score,
            'survey_ans' => $ans
        ];
    }
}
