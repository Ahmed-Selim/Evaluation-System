<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Custom View</title>
</head>
<body>
    <?php
        // $db = db_connect();
        // $query = $db->query('SELECT * FROM employees LIMIT 1');
        // $results = $query->getResult();

        // foreach ($results as $row) {
        //     echo $row->title;
        //     echo $row->name;
        //     echo $row->email;
        // }

        foreach ($employees as $employee) {
            echo $employee->employee_name . ' | ';
            echo $employee->employee_email . ' | ';
            echo $employee->department . ' <br> ';
        }

    ?>
</body>
</html>