<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Employee extends BaseController
{
    public function index() {
        //
    }

    public function Employees($evaluator_id = '') {
        $db = db_connect();
        $sql = 'SELECT
                    emp.*
                FROM
                    `employee_view` emp
                LEFT JOIN `employee_view` mang ON
                    emp.manager_id = mang.employee_id
                WHERE
                    mang.employee_id IS NOT NULL AND emp.employee_id <> :id: ';
        $query = $db->query($sql, [ 'id' => $evaluator_id ]);
        $employees = $query->getResult();

        return $employees;
        // return view('custom_view', [ 'employees' => $employees ]);
    }

    public function getDepartmentEmployees ($evaluator_id = '') {
        $db = db_connect();
        $sql = 'SELECT
                    emp.*
                FROM
                    `employee_view` emp
                LEFT JOIN `employee_view` mang ON
                    emp.manager_id = mang.employee_id
                WHERE
                    mang.employee_id IS NOT NULL AND emp.employee_id <>(
                    SELECT
                        evaluators.employee_id
                    FROM
                        evaluators
                    WHERE
                        evaluators.evaluator_id = :id:
                ) AND emp.department =(
                    SELECT
                        department
                    FROM
                        employee_view
                    WHERE
                        employee_id =(
                        SELECT
                            evaluators.employee_id
                        FROM
                            evaluators
                        WHERE
                            evaluators.evaluator_id = :id:
                    )
                )';
        $query = $db->query($sql, [ 'id' => $evaluator_id ]);
        $employees = $query->getResult();
        return $employees;
    }
}
