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

    class StoreTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Store::deleteAll();
            Brand::deleteAll();
        }

        function test_getId()
        {
            //Arrange
            $name = "Foot Locker";
            $id = 1;
            $test_store = new Store($name, $id);

            //Act
            $output = $test_store->getId();

            //Assert
            $this->assertEquals(1, $output);
        }

        function test_getName()
        {
            //Arrange
            $name = "Foot Locker";
            $id = 1;
            $test_store = new Store($name, $id);

            //Act

            $output = $test_store->getName();

            //Assert
            $this->assertEquals($name, $output);
        }

        function test_setName()
        {
            //Arrange
            $name = "Foot Locker";
            $id = 1;
            $test_store = new Store($name, $id);
            $edit_name = "Big 5";

            //Act
            $test_store->setName($edit_name);
            $output = $test_store->getName();

            //Assert
            $this->assertEquals($edit_name, $output);
        }

        function test_save()
        {
            //Arrange
            $name = "Foot Locker";
            $test_store = new Store($name);

            //Act
            $test_store->save();
            $output = Store::getAll();

            //Assert
            $this->assertEquals([$test_store], $output);
        }

        function test_find()
        {
            //Arrange
            $name = "Foot Locker";
            $test_store = new Store($name);
            $test_store->save();

            //Act
            $output = Store::find($test_store->getId());

            //Assert
            $this->assertEquals($test_store, $output);
        }

        function test_update()
        {
            //Arrange
            $name = "Foot Locker";
            $test_store = new Store($name);
            $test_store->save();
            $edit_name = "Big 5";

            //Act
            $test_store->update($edit_name);
            $output = $test_store->getName();

            //Assert
            $this->assertEquals($edit_name, $output);
        }

        function test_delete()
        {
            //Arrange
            $name1 = "Foot Locker";
            $test_store1 = new Store($name1);
            $test_store1->save();

            $name2 = "Big 5";
            $test_store2 = new Store($name2);
            $test_store2->save();

            //Act
            $test_store1->delete();
            $output = Store::getAll();

            //Assert
            $this->assertEquals([$test_store2], $output);
        }

        function test_addBrand()
        {
            //Arrange
            $store_name = "Foot Locker";
            $test_store = new Store($store_name);
            $test_store->save();

            $brand_name = "Nike";
            $test_brand = new Brand($brand_name);
            $test_brand->save();

            //Act
            $test_store->addBrand($test_brand);
            $output = $test_store->getBrands();

            //Assert
            $this->assertEquals([$test_brand], $output);
        }

        function test_deleteBrands()
        {
            //Arrange
            $store_name = "Foot Locker";
            $test_store = new Store($store_name);
            $test_store->save();

            $brand_name1 = "Nike";
            $test_brand1 = new Brand($brand_name1);
            $test_brand1->save();
            $test_store->addBrand($test_brand1);

            $brand_name2 = "Adidas";
            $test_brand2 = new Brand($brand_name2);
            $test_brand2->save();
            $test_store->addBrand($test_brand2);

            //Act
            $test_store->deleteBrands();
            $output = $test_store->getBrands();

            //Assert
            $this->assertEquals([], $output);
        }

        function test_deleteBrand()
        {
            //Arrange
            $store_name = "Foot Locker";
            $test_store = new Store($store_name);
            $test_store->save();

            $brand_name1 = "Nike";
            $test_brand1 = new Brand($brand_name1);
            $test_brand1->save();
            $test_store->addBrand($test_brand1);

            $brand_name2 = "Adidas";
            $test_brand2 = new Brand($brand_name2);
            $test_brand2->save();
            $test_store->addBrand($test_brand2);

            //Act
            $test_store->deleteBrand($test_brand2);
            $output = $test_store->getBrands();

            //Assert
            $this->assertEquals([$test_brand1], $output);
        }


    }
?>
