<?php
    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    //TO RUN TESTS IN TERMINAL:
    //export PATH=$PATH:./vendor/bin
    //phpunit tests

    require_once "src/Store.php";
    require_once "src/Brand.php";

    //ALTERNATIVE SERVER:
    // $server = 'mysql:host=localhost;dbname=shoes_test';
    $server = 'mysql:host=localhost:8889;dbname=shoes_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    class BrandTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Brand::deleteAll();
            Store::deleteAll();
        }

        function test_getId()
        {
            //Arrange
            $name = "Nike";
            $id = 1;
            $test_brand = new Brand($name, $id);

            //Act
            $output = $test_brand->getId();

            //Assert
            $this->assertEquals(1, $output);
        }

        function test_getName()
        {
            //Arrange
            $name = "Nike";
            $id = 1;
            $test_brand = new Brand($name, $id);

            //Act

            $output = $test_brand->getName();

            //Assert
            $this->assertEquals($name, $output);
        }

        function test_setName()
        {
            //Arrange
            $name = "Nike";
            $id = 1;
            $test_brand = new Brand($name, $id);
            $edit_name = "Big 5";

            //Act
            $test_brand->setName($edit_name);
            $output = $test_brand->getName();

            //Assert
            $this->assertEquals($edit_name, $output);
        }

        function test_save()
        {
            //Arrange
            $name = "Nike";
            $test_brand = new Brand($name);

            //Act
            $test_brand->save();
            $output = Brand::getAll();

            //Assert
            $this->assertEquals([$test_brand], $output);
        }

        function test_find()
        {
            //Arrange
            $name = "Nike";
            $test_brand = new Brand($name);
            $test_brand->save();

            //Act
            $output = Brand::find($test_brand->getId());

            //Assert
            $this->assertEquals($test_brand, $output);
        }

        function test_update()
        {
            //Arrange
            $name = "Nike";
            $test_brand = new Brand($name);
            $test_brand->save();
            $edit_name = "Adidas";

            //Act
            $test_brand->update($edit_name);
            $output = $test_brand->getName();

            //Assert
            $this->assertEquals($edit_name, $output);
        }

        function test_delete()
        {
            //Arrange
            $name1 = "Nike";
            $test_brand1 = new Brand($name1);
            $test_brand1->save();

            $name2 = "Adidas";
            $test_brand2 = new Brand($name2);
            $test_brand2->save();

            //Act
            $test_brand1->delete();
            $output = Brand::getAll();

            //Assert
            $this->assertEquals([$test_brand2], $output);
        }

        function test_addStore()
        {
            //Arrange
            $store_name = "Foot Locker";
            $test_store = new Store($store_name);
            $test_store->save();

            $brand_name = "Nike";
            $test_brand = new Brand($brand_name);
            $test_brand->save();

            //Act
            $test_brand->addStore($test_store);
            $output = $test_brand->getStores();

            //Assert
            $this->assertEquals([$test_store], $output);
        }

        function test_deleteStores()
        {
            //Arrange
            $store_name1 = "Foot Locker";
            $test_store1 = new Store($store_name1);
            $test_store1->save();

            $store_name2 = "Big 5";
            $test_store2 = new Store($store_name2);
            $test_store2->save();

            $brand_name = "Nike";
            $test_brand = new Brand($brand_name);
            $test_brand->save();
            $test_brand->addStore($test_store1);

            //Act
            $test_brand->deleteStores();
            $output = $test_brand->getStores();

            //Assert
            $this->assertEquals([], $output);
        }

        function test_deleteBrand()
        {
            //Arrange
            $store_name1 = "Foot Locker";
            $test_store1 = new Store($store_name1);
            $test_store1->save();

            $store_name2 = "Big 5";
            $test_store2 = new Store($store_name2);
            $test_store2->save();

            $brand_name = "Nike";
            $test_brand = new Brand($brand_name);
            $test_brand->save();
            $test_brand->addStore($test_store1);

            //Act
            $test_brand->deleteStore($test_store2);
            $output = $test_brand->getStores();

            //Assert
            $this->assertEquals([$test_store1], $output);
        }

        function test_notInStores()
        {
            //Arrange
            $store_name1 = "Foot Locker";
            $test_store1 = new Store($store_name1);
            $test_store1->save();

            $store_name2 = "Big 5";
            $test_store2 = new Store($store_name2);
            $test_store2->save();

            $brand_name = "Nike";
            $test_brand = new Brand($brand_name);
            $test_brand->save();

            $test_brand->addStore($test_store1);

            //Act
            $output = $test_brand->notInStores();

            //Assert
            $this->assertEquals([$test_store2], $output);
        }
    }
?>
