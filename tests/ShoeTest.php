<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    //TO RUN TESTS IN TERMINAL:
    //export PATH=$PATH:./vendor/bin
    //phpunit tests

    require_once "src/Shoe.php";
    require_once "src/Brand.php";

    //ALTERNATIVE SERVER:
    $server = 'mysql:host=localhost;dbname=shoe_store_test';
    // $server = 'mysql:host=localhost:8889;dbname=shoe_store_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class ShoeTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Shoe::deleteAll();
        }

        function test_getId()
        {
            //Arrange
            $new_name = "Jennifer Jones";
            $id = 1;
            $test_shoe = new Shoe($id, $new_name);

            //Act
            $output = $test_shoe->getId();

            //Assert
            $this->assertEquals(1, $output);
        }
    }
?>
