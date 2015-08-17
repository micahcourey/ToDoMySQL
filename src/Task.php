<?php

    class Task
    {
        /**
        * @backupGlobals disabled
        * @backupStaticAttributes disabled
        */

        require_once "src/Task.php";

        $server = 'mysql:host=localhost;dbname=to_do_test';
        $username = 'root';
        $password = 'root';
        $DB = new PDO($server, $username, $password);

        class TaskTest extends PHPUnit_Framework_TestCase
        {

            function save()
            {
                $GLOBALS['DB']->exec("INSERT INTO tasks (description)
                VALUES ('{$this->getDescription()}')");
            }

            static function getAll()
            {
                $returned_tasks = $GLOBALS['DB']->query("SELECT * FROM tasks;");
                $tasks = array();
                foreach($returned_tasks as $task) {
                    $description = $task['description'];
                    $new_task = new Task($description);
                    array_push($task, $new_task);
                }
                return $tasks;
            }


        }
    }
 ?>
