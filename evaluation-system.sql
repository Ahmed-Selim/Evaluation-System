create database 'evaluation-system' ;

-- use 'evaluation-system';

CREATE TABLE `evaluation-system`.`employees` ( 
    `employee_id` INT NOT NULL AUTO_INCREMENT , 
    `name` VARCHAR(50) NOT NULL , 
    `email` VARCHAR(150) NOT NULL , 
    `department_id` INT NOT NULL , 
    `manager_id` INT NULL , 
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
    PRIMARY KEY (`employee_id`), 
    UNIQUE (`email`)
) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE `evaluation-system`.`departments` ( 
    `department_id` INT NOT NULL AUTO_INCREMENT ,
    `name` VARCHAR(50) NOT NULL ,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
    PRIMARY KEY (`department_id`), 
    UNIQUE (`name`)
) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;


CREATE TABLE `evaluation-system`.`evaluators` ( 
    `evaluator_id` INT NOT NULL AUTO_INCREMENT , 
    `employee_id` INT NOT NULL , 
    `evaluation_period_id` INT NOT NULL ,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
    PRIMARY KEY (`evaluator_id`), 
    UNIQUE (`employee_id`, `evaluation_period_id`)
) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE `evaluation-system`.`competency_reports` ( 
    `competency_report_id` INT NOT NULL AUTO_INCREMENT ,
    `employee_id` INT NOT NULL ,
    `evaluator_id` INT NOT NULL ,
    `evaluation_period_id` INT NOT NULL ,
    `status_id` INT NOT NULL ,
    `score` TINYINT NOT NULL DEFAULT 1 CHECK (
        `score` >= 1 AND `score` <= 5
    ),
    `survey_ans` JSON NULL ,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
    PRIMARY KEY (`competency_report_id`)
) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE `evaluation-system`.`evaluation_periods` ( 
    `evaluation_period_id` INT NOT NULL AUTO_INCREMENT ,
    `evaluation_period` VARCHAR(50) NOT NULL ,
    `evaluation_year` YEAR NOT NULL ,
    `status_id` INT NOT NULL ,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
    PRIMARY KEY (`evaluation_period_id`), 
    UNIQUE (`evaluation_period`, `evaluation_year`)
) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE `evaluation-system`.`competency_report_statuses` ( 
    `status_id` INT NOT NULL AUTO_INCREMENT ,
    `status` VARCHAR(50) NOT NULL ,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
    PRIMARY KEY (`status_id`), 
    UNIQUE (`status`)
) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;

CREATE TABLE `evaluation-system`.`evaluation_period_statuses` ( 
    `status_id` INT NOT NULL AUTO_INCREMENT ,
    `status` VARCHAR(50) NOT NULL ,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
    `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP , 
    PRIMARY KEY (`status_id`), 
    UNIQUE (`status`)
) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;

ALTER TABLE `employees` 
    ADD FOREIGN KEY (`department_id`) 
    REFERENCES `departments`(`department_id`) 
    ON DELETE CASCADE ON UPDATE NO ACTION; 
ALTER TABLE `employees` 
    ADD FOREIGN KEY (`manager_id`) 
    REFERENCES `employees`(`employee_id`) 
    ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `evaluators` 
    ADD FOREIGN KEY (`employee_id`) 
    REFERENCES `employees`(`employee_id`) 
    ON DELETE CASCADE ON UPDATE NO ACTION; 
ALTER TABLE `evaluators` 
    ADD FOREIGN KEY (`evaluation_period_id`) 
    REFERENCES `evaluation_periods`(`evaluation_period_id`) 
    ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `evaluation_periods` 
    ADD FOREIGN KEY (`status_id`) 
    REFERENCES `evaluation_period_statuses`(`status_id`) 
    ON DELETE CASCADE ON UPDATE NO ACTION;

ALTER TABLE `competency_reports` 
    ADD FOREIGN KEY (`employee_id`) 
    REFERENCES `employees`(`employee_id`) 
    ON DELETE CASCADE ON UPDATE NO ACTION; 
ALTER TABLE `competency_reports` 
    ADD FOREIGN KEY (`evaluation_period_id`) 
    REFERENCES `evaluation_periods`(`evaluation_period_id`) 
    ON DELETE CASCADE ON UPDATE NO ACTION; 
ALTER TABLE `competency_reports` 
    ADD FOREIGN KEY (`evaluator_id`) 
    REFERENCES `evaluators`(`evaluator_id`) 
    ON DELETE CASCADE ON UPDATE NO ACTION; 
ALTER TABLE `competency_reports` 
    ADD FOREIGN KEY (`status_id`) 
    REFERENCES `competency_report_statuses`(`status_id`) 
    ON DELETE RESTRICT ON UPDATE NO ACTION;