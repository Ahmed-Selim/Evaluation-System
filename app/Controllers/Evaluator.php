<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Evaluator extends BaseController
{
    public function index($evaluator_id) {
        // echo $evaluator_id;
        return view('evaluator/evaluate_employee', [
            'auth_id' => $evaluator_id,
            'employees' => (new Employee())->getDepartmentEmployees($evaluator_id),
            'activePeriods' => (new Manager())->getActiveEvaluationPeriods()
        ]) ;
    }
}
