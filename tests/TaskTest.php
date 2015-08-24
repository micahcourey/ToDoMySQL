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
        $due_date = "tomorrow";
        $test_task = new Task($description, $due_date);

        $result = $test_task->getDescription();

        $this->assertEquals($description, $result);

    }

    function testSetDescription()
    {
        $description = "Do dishes.";
        $due_date = "tomorrow";
        $test_task = new Task($description, $due_date);

        $test_task->setDescription("Drink coffee.");
        $result = $test_task->getDescription();

        $this->assertEquals("Drink coffee.", $result);
    }

    function test_getId()
    {
        $id = 1;
        $description = "Wash the dog";
        $due_date = "tomorrow";
        $test_task = new Task($description, $due_date, $id);

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
        $description = "Wash the dog";
        $id = 1;
        $test_task = new Task($description, $id);
        $test_task->save();

        $description2 = "Water the lawn";
        $id2 = 2;
        $test_task2 = new Task($description2, $id2);
        $test_task2->save();

        $result = Task::getAll();

        $this->assertEquals([$test_task, $test_task2], $result);
    }

    function test_deleteAll()
    {
        $description = "Wash the dog";
        $id = 1;
        $test_task = new Task($description, $id);
        $test_task->save();

        $description2 = "Water the lawn";
        $id2 = 2;
        $test_task2 = new Task($description2, $id2);
        $test_task2->save();

        Task::deleteAll();

        $result = Task::getAll();
        $this->assertEquals([], $result);
    }



    function test_find()
    {
        $description = "Wash the dog";
        $id = 1;
        $test_task = new Task($description, $id);
        $test_task->save();

        $description2 = "Water the lawn";
        $id2 = 2;
        $test_task2 = new Task($description2, $id2);
        $test_task2->save();

        $result = Task::find($test_task->getId());

        $this->assertEquals($test_task, $result);
    }

    function testUpdate()
    {
        $description = "Wash the dog";
        $id = 1;
        $test_task = new Task($description, $id);
        $test_task->save();

        $new_description = "Clean the dog";

        $test_task->update($new_description);

        $this->assertEquals("Clean the dog", $test_task->getDescription());
    }

    function testDeleteTask()
    {
        $description = "Wash the dog";
        $id = 1;
        $test_task = new Task($description, $id);
        $test_task->save();

        $description2 = "Water the lawn";
        $id2 = 2;
        $test_task2 = new Task($description2, $id2);
        $test_task2->save();

        $test_task->delete();

        $this->assertEquals([$test_task2], Task::getAll());
    }

    function testAddCategory()
    {

        $name = "Work stuff";
        $id = 1;
        $test_category = new Category($name, $id);
        $test_category->save();

        $description = "File reports";
        $id2 = 2;
        $test_task = new Task($description, $id2);
        $test_task->save();

        $test_task->addCategory($test_category);

        $this->assertEquals($test_task->getCategories(), [$test_category]);
    }

    function testGetCategories()
    {
        $name = "Work stuff";
        $id = 1;
        $test_category = new Category($name, $id);
        $test_category->save();

        $name2 = "Volunteer stuff";
        $id2 = 2;
        $test_category2 = new Category($name2, $id2);
        $test_category2->save();

        $description = "File reports";
        $id3 = 3;
        $test_task = new Task($description, $id3);
        $test_task->save();

        $test_task->addCategory($test_category);
        $test_task->addCategory($test_category2);

        $this->assertEquals($test_task->getCategories(), [$test_category, $test_category2]);

    }

    function testDelete()
    {
        $name = "Work stuff";
        $id = 1;
        $test_category = new Category($name, $id);
        $test_category->save();

        $description = "File reports";
        $id2 = 2;
        $due_date = "tomorrow";
        $test_task = new Task($description, $due_date, $id2);
        $test_task->save();

        $test_task->addCategory($test_category);
        $test_task->delete();

        $this->assertEquals([], $test_category->getTasks());
    }
}


?>
