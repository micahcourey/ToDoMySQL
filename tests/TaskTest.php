<?php

    function test_save()
    {
        //Arrange
        $description = "Wash the dog";
        $test_task = new Task($description);

        //Act
        $test_task->save();

        //Assert
        $result = Task::getAll();
        $this->assertEquals($test_task, $result[0]);
    }

    function test_getAll()
    {
        //Arrange
        $description = "Wash the dog";
        $description2 = "Water the lawn";
        $test_Task = new Task($decription);
        $test_Task->save();
        $test_Task2 = new Task($decription2);
        $test_Task2->save();

        //Act
        $result = Task::getAll();

        //Assert
        $this->assertEquals([$test_Task, $test_Task2], $result);
    }

?>
