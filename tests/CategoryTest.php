<?php


    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Category.php";
    require_once "src/Task.php";

    $server = 'mysql:host=localhost;dbname=to_do_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class CategoryTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Category::deleteAll();
            Task::deleteAll();
        }

        function test_getName()
        {
            $name = "Kitchen chores";
            $test_category = new Category($name);

            $result = $test_category->getName();

            $this->assertEquals($name, $result);
        }

        function testSetName()
        {
            $name = "Kitchen chores";
            $test_category = new Category($name);

            $test_category->setName("Home chores");
            $result = $test_category->getName();

            $this->assertEquals("Home chores", $result);
        }

        function test_getId()
        {
            //Arrange
            $name = "Work stuff";
            $id = 1;
            $test_Category = new Category($name, $id);

            //Act
            $result = $test_Category->getId();

            //Assert
            $this->assertEquals(1, $result);
        }

        function test_save()
        {
            $name = "Work stuff";
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();

            $result = Category::getAll();

            $this->assertEquals($test_category, $result[0]);

        }

        function testUpdate()
        {
            $name = "Work stuff";
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();

            $new_name = "Home stuff";

            $test_category->update($new_name);

            $this->assertEquals("Home stuff", $test_category->getName());
        }

        function testDeleteCategory()
        {
            $name = "Work stuff";
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();

            $name2 = "Home stuff";
            $id2 = 2;
            $test_category2 = new Category($name2, $id2);
            $test_category2->save();

            $test_category->delete();

            $this->assertEquals([$test_category2], Category::getAll());
        }

        function test_getAll()
        {
            $name = "Work stuff";
            $id = 1;
            $name2 = "Home stuff";
            $id2 = 2;
            $test_category = new Category($name, $id);
            $test_category->save();
            $test_category2 = new Category($name2, $id2);
            $test_category2->save();

            $result = Category::getAll();

            $this->assertEquals([$test_category, $test_category2], $result);
        }

        function test_deleteAll()
        {
            $name = "Wash the dog";
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();

            $name2 = "Water the lawn";
            $id2 = 2;
            $test_category2 = new Category($name2, $id2);
            $test_category2->save();

            Category::deleteAll();

            $result = Category::getAll();
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            $name = "Wash the dog";
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();

            $name2 = "Home stuff";
            $id2 = 2;
            $test_category2 = new Category($name2, $id2);
            $test_category2->save();
            //Act
            $result = Category::find($test_category->getId());

            //Assert
            $this->assertEquals($test_category, $result);
        }

        function testAddTask()
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

            $test_category->addTask($test_task);

            $this->assertEquals($test_category->getTasks(), [$test_task]);
        }

        function testGetTasks()
        {
            $name = "Home stuff";
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Wash the dog";
            $id2 = 2;
            $due_date = "tomorrow";
            $test_task = new Task($description, $due_date, $id2);
            $test_task->save();

            $description2 = "Take out the trash";
            $id3 = 3;
            $due_date = "yesterday";
            $test_task2 = new Task($description2, $due_date, $id3);
            $test_task2->save();

            $test_category->addTask($test_task);
            $test_category->addTask($test_task2);

            $this->assertEquals($test_category->getTasks(), [$test_task, $test_task2]);
        }
    }

 ?>
