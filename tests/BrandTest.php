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

    class BrandTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Brand::deleteAll();
        }

        function test_save_toDatabase()
        {
            //Arrange
            $new_name = "Joe Dirt";
            $shoe_id = 3;
            $test_client = new Brand($id = null, $new_name, $shoe_id);

            //Act
            $test_client->save();
            $output = client::getAll();

            //Assert
            $this->assertEquals([$test_client], $output);
        }
    }
?>
