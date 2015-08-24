<?php


/**
* @backupGlobals disabled
* @backupStaticAttributes disabled
*/

require_once "src/Task.php";
require_once "src/Category.php";

$server = 'mysql:host=localhost;dbname=to_do_test';
$username = 'root';
$password = 'root';
$DB = new PDO($server, $username, $password);

class TaskTest extends PHPUnit_Framework_TestCase
{

    protected function tearDown()
    {
        Task::deleteAll();
        Category::deleteAll();
    }

    function testGetDescription()
    {
        $description = "Do dishes.";
        $test_task = new Task($description);

        $result = $test_task->getDescription();

        $this->assertEquals($description, $result);

    }

    function testSetDescription()
    {
        $description = "Do dishes.";
        $test_task = new Task($description);

        $test_task->setDescription("Drink coffee.");
        $result = $test_task->getDescription();

        $this->assertEquals("Drink coffee.", $result);
    }

    function test_getId()
    {
        $id = 1;
        $description = "Wash the dog";
        $test_task = new Task($description, $id);

        $result = $test_task->getId();

        $this->assertEquals(1, $result);
    }


    function test_save()
    {

        $description = "Wash the dog";
        $id = 1;
        $test_task = new Task($description, $id);

        $test_task->save();

        $result = Task::getAll();
        $this->assertEquals($test_task, $result[0]);

    }

    function testSaveSetsId()
    {
            $description = "Wash the dog";
            $id = 1;
            $test_task = new Task($description, $id);

            $test_task->save();

            $this->assertEquals(true, is_numeric($test_task->getId()));
    }



    function test_getAll()
    {
        
    }

    function test_deleteAll()
    {
        //Arrange
        $name = "Home stuff";
        $id = null;
        $test_category = new Category($name, $id);
        $test_category->save();

        $description = "Wash the dog";
        $due_date = 1989-12-12;
        $category_id = $test_category->getId();
        $test_task = new Task($description, $due_date, $id, $category_id);
        $test_task->save();

        $description2 = "Water the lawn";
        $due_date2 = 1989-12-12;
        $test_task2 = new Task($description2, $due_date2, $id, $category_id);
        $test_task2->save();

        //Act
        Task::deleteAll();

        //Assert
        $result = Task::getAll();
        $this->assertEquals([], $result);
    }



    function test_find()
    {
        //Arrange
        $name = "Home stuff";
        $id = null;
        $test_category = new Category($name, $id);
        $test_category->save();

        $description = "Wash the dog";
        $due_date = 191989-12-12;
        $category_id = $test_category->getId();
        $test_task = new Task($description, $due_date, $id, $category_id);
        $test_task->save();

        $description2 = "Water the lawn";
        $due_date2 = "tomorrow";
        $test_task2 = new Task($description2, $due_date2, $id, $category_id);
        $test_task2->save();

        //Act
        $result = Task::find($test_task->getId());

        //Assert
        $this->assertEquals($test_task, $result);
    }
}


?>
