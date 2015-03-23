<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Category.php";

    $DB = new PDO('pgsql:host=localhost;dbname=to_do_test');

    class CategoryTest extends PHPUnit_Framework_TestCase
    {

    }

?>
