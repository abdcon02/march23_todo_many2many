<?php

    require_once "src/Task.php";

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    $DB = new PDO('pgsql:host=localhost;dbname=to_do_test');

    Class TaskTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Task::deleteAll();
        }

        function test_setDescription()
        {

            //Arrange
            $description = "Walk the cat";
            $id = 1;
            $test_task = new Task($description, $id);
            $new_description = "Walk the chinchilla";

            //Act
            $test_task->setDescription($new_description);
            $result = $test_task->getDescription();

            //Assert
            $this->assertEquals($new_description, $result);
        }

        function test_setId()
        {
            //Arrange
            $description = "Walk the cat";
            $id = 4;
            $test_task = new Task($description, $id);
            $new_id = 1;

            //Act
            $test_task->setDescription($new_id);
            $result = $test_task->getDescription();

            //Assert
            $this->assertEquals($new_id, $result);
        }

        function test_save()
        {
            //Arrange
            $description = "Paint the kitchen";
            $new_task = new Task($description);

            //Act
            $new_task->save();
            $result = Task::getAll();


            //Assert
            $this->assertEquals($new_task, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $description = "Catch the mouse";
            $new_task = new Task($description);
            $new_task->save();

            $description2 = "Put the mouse in neighbors yard";
            $new_task2 = new Task($description2);
            $new_task2->save();

            //Act
            $result = Task::getAll();

            //Assert
            $this->assertEquals([$new_task, $new_task2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $description = "Switch the plant";
            $new_task = new Task($description);
            $new_task->save();

            $description2 = "Water the plant";
            $new_task2 = new Task($description2);
            $new_task2->save();

            //Act
            Task::deleteAll();
            $result = Task::getAll();

            //Assert
            $this->assertEquals([], $result);
        }


    }


 ?>
