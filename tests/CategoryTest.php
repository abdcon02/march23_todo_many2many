<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Category.php";

    //$DB = new PDO('pgsql:host=localhost;dbname=to_do_test');

    class CategoryTest extends PHPUnit_Framework_TestCase
    {

        function testGetName()
        {
            //Arrange
            $name = "Dog Stuff";
            $test_category = new Category($name);

            //Act
            $result = $test_category->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        function testSetName()
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

        function testGetId()
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

        function testSetId()
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

    }

?>
