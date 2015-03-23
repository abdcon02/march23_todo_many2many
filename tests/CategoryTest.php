<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Category.php";
    require_once "src/Task.php";

    $DB = new PDO('pgsql:host=localhost;dbname=to_do_test');

    class CategoryTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Category::deleteAll();
            Task::deleteAll();
        }

        function test_GetName()
        {
            //Arrange
            $name = "Dog Stuff";
            $test_category = new Category($name);

            //Act
            $result = $test_category->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        function test_SetName()
        {
            //Arrange
            $name = "Home Stuff";
            $test_category = new Category($name);
            $new_name = "Work Stuff";

            //Act
            $test_category->setName($new_name);
            $result = $test_category->getName();

            //Assert
            $this->assertEquals($new_name, $result);
        }

        function test_GetId()
        {
            //Arrange
            $name = "Home Stuff";
            $id = 1;
            $test_category = new Category($name, $id);

            //Act
            $result = $test_category->getId();

            //Assert
            $this->assertEquals($id, $result);
        }

        function test_SetId()
        {
            //Arrange
            $name = "Home Stuff";
            $id = 1;
            $test_category = new Category($name, $id);
            $new_id = 2;

            //Act
            $test_category->setId($new_id);
            $result = $test_category->getId();

            //Assert
            $this->assertEquals($new_id, $result);
        }

        function test_save()
        {
            //Arrange
            $name = "Home Stuff";
            $id = 1;
            $test_category = new Category($name, $id);

            //Act
            $test_category->save();
            $result = Category::getAll();

            //Assert
            $this->assertEquals($test_category, $result[0]);

        }

        function test_getAll()
        {
            //Arrange
            $name = "Home Stuff";
            $id = 1;
            $test_category1 = new Category($name, $id);
            $test_category1->save();

            $name2 = "Work Stuff";
            $id2 = 2;
            $test_category2 = new Category($name2, $id2);
            $test_category2->save();

            //Act
            $result = Category::getAll();

            //Assert
            $this->assertEquals([$test_category1, $test_category2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $name = "Home Stuff";
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();

            //Act
            Category::deleteAll();
            $result = Category::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $name = "Home Stuff";
            $test_category = new Category($name);
            $test_category->save();

            $name2 = "Work Stuff";
            $test_category2 = new Category($name2);
            $test_category2->save();

            //Act
            $result = Category::find($test_category->getId());

            //Assert
            $this->assertEquals($test_category, $result);
        }

        function test_update()
        {
            //Arrange
            $name = "Home Stuff";
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();

            $new_name = "Garden Stuff";

            //Act
            $test_category->update($new_name);

            //Assert
            $this->assertEquals($new_name, $test_category->getName());

        }

        function test_delete()
        {
            //Arrange
            $name = "Home Stuff";
            $test_category = new Category($name);
            $test_category->save();

            $name2 = "Work Stuff";
            $test_category2 = new Category($name2);
            $test_category2->save();

            //Act
            $test_category->delete();
            $result = Category::getAll();

            //Assert
            $this->assertEquals([$test_category2], $result);
        }

        function testAddTask()
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
            $test_category->addTask($test_task);
            //Assert
            $this->assertEquals($test_category->getTasks(), [$test_task]);
        }

        function testGetTasks()
        {
            //Arrange
            $name = "Home stuff";
            $id = 1;
            $test_category = new Category($name, $id);
            $test_category->save();

            $description = "Wash the dog";
            $id2 = 2;
            $test_task = new Task($description, $id2);
            $test_task->save();
            $description2 = "Take out the trash";
            $id3 = 3;
            $test_task2 = new Task($description2, $id3);
            $test_task2->save();
            //Act

            $test_category->addTask($test_task);
            $test_category->addTask($test_task2);
            //Assert

            $this->assertEquals($test_category->getTasks(), [$test_task, $test_task2]);
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
            $test_category->addTask($test_task);
            $test_category->delete();
            //Assert
            $this->assertEquals([], $test_task->getCategories());


        }
    }

?>
