<?php
    class Store
    {
        private $id;
        private $name;

        function __construct ($name, $id = null)
        {
            $this->id = $id;
            $this->name = $name;
        }

        function getId()
        {
            return $this->id;
        }

        function setName($new_name)
        {
            $this->name = $new_name;
        }

        function getName()
        {
            return $this->name;
        }

        function save()
        {
            $name = $this->getName();
            $name = ucwords(strtolower($name));
            $GLOBALS['DB']->exec("INSERT INTO stores (name) VALUES ('{$name}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_stores = $GLOBALS['DB']->query("SELECT * FROM stores;");
            $stores = array();
            foreach ($returned_stores as $store) {
                $id = $store['id'];
                $name = $store['name'];
                $new_store = new Store($name, $id);
                array_push($stores, $new_store);
            }
            return $stores;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM stores;");
            //$GLOBALS['DB']->exec("DELETE FROM stores_brands WHERE store_id = {$this->getId()};");
        }

        static function find($search_id)
        {
            $found_store = null;
            $stores = Store::getAll();
            foreach ($stores as $store) {
                $store_id = $store->getId();
                if ($store_id == $search_id) {
                    $found_store = $store;
                }
            }
            return $found_store;
        }

        function update($edit_name)
        {
            $edit_name = ucwords(strtolower($edit_name));
            $GLOBALS['DB']->exec("UPDATE stores SET name = '{$edit_name}' WHERE id = {$this->getId()};");
            $this->setName($edit_name);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM stores_brands WHERE store_id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM stores WHERE id = {$this->getId()};");
        }

        function addBrand($new_brand)
        {
           $GLOBALS['DB']->exec("INSERT INTO brands_shoes (brand_id, store_id) VALUES ({$new_brand->getId()}, $this->getId()};");
        }

        function getBrands()
        {
           $returned_brands = $GLOBALS['DB']->query("SELECT brands *. FROM stores
               JOIN stores_brands ON (stores_brands.store_id = stores.id)
               JOIN brands ON (brands.id = stores_brands.brand_id)
               WHERE stores.id = {$this->getId()};");
           $brands = array();
           foreach($returned_brands as $brand) {
               $id = $brand['id'];
               $name = $brand['name'];
               $store_id = $brand['store_id'];
               $new_brand = new Brand($name, $id);
               array_push($brands, $new_brand);
           }
           return $brands;
       }

       function deleteBrands()
       {
          $GLOBALS['DB']->exec("DELETE FROM brands_shoes WHERE store_id = {$this->getId()};");
       }

    }
?>
