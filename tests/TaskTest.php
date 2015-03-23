<?php

    require_once "src/Task.php";
    require_once "src/Category.php";

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
            Category::deleteAll();
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

        function test_find()
        {
            //Arrange
            $description = "Find my pencil";
            $test_task = new Task($description);
            $test_task->save();

            $description2 = "Write a book";
            $test_description2 = new Task($description2);
            $test_description2->save();

            //Act
            $result = Task::find($test_task->getId());

            //Assert
            $this->assertEquals($test_task, $result);
        }

        function test_update()
        {
            //Arrange
            $description = "Find my pencil";
            $id = 1;
            $test_task = new Task($description, $id);
            $test_task->save();

            $new_description = "Plant ten trees";

            //Act
            $test_task->update($new_description);

            //Assert
            $this->assertEquals($new_description, $test_task->getDescription());

        }

        function test_delete()
        {
            //Arrange
            $description = "Find my pencil";
            $test_task = new Task($description);
            $test_task->save();

            $description2 = "Write a book";
            $test_description2 = new Task($description2);
            $test_description2->save();

            //Act
            $test_task->delete();
            $result = Task::getAll();

            //Assert
            $this->assertEquals([$test_description2], $result);
        }



        function testAddCategory()
        {
            //Arrange
            $name = "Work stuff";
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();
            $description = "File reports";
            $id2 = 2;
            $test_task = new Task($description, $id2);
            $test_task->save();
            //Act
            $test_task->addCategory($test_category);
            //Assert
            $this->assertEquals($test_task->getCategories(), [$test_category]);
        }

        function testGetCategories()
        {
            //Arrange
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
            //Act
            $test_task->addCategory($test_category);
            $test_task->addCategory($test_category2);
            //Assert
            $this->assertEquals($test_task->getCategories(), [$test_category, $test_category2]);
        }

        function testDelete()
        {
            //Arrange
            $name = "Work stuff";
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();
            $description = "File reports";
            $id2 = 2;
            $test_task = new Task($description, $id2);
            $test_task->save();
            //Act
            $test_task->addCategory($test_category);
            $test_task->delete();
            //Assert
            $this->assertEquals([], $test_category->getTasks());
        }




    }


 ?>
