<?php
    class Brand
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
            $GLOBALS['DB']->exec("INSERT INTO brands (name) VALUES ('{$name}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }
        static function getAll()
        {
            $returned_brands = $GLOBALS['DB']->query("SELECT * FROM brands;");
            $brands = array();
            foreach ($returned_brands as $brand) {
                $id = $brand['id'];
                $name = $brand['name'];
                $new_brand = new Brand($name, $id);
                array_push($brands, $new_brand);
            }
            return $brands;
        }
        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM brands;");
            $GLOBALS['DB']->exec("DELETE FROM stores_brands;");
        }
        static function find($search_id)
        {
            $found_brand = null;
            $brands = Brand::getAll();
            foreach ($brands as $brand) {
                $brand_id = $brand->getId();
                if ($brand_id == $search_id) {
                    $found_brand = $brand;
                }
            }
            return $found_brand;
        }
        function update($edit_name)
        {
            $edit_name = ucwords(strtolower($edit_name));
            $GLOBALS['DB']->exec("UPDATE brands SET name = '{$edit_name}' WHERE id = {$this->getId()};");
            $this->setName($edit_name);
        }
        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM stores_brands WHERE store_id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM brands WHERE id = {$this->getId()};");
        }
        function addStore($new_store)
        {
           $GLOBALS['DB']->exec("INSERT INTO stores_brands (brand_id, store_id) VALUES ({$this->getId()}, {$new_store->getId()});");
        }
        function getStores()
        {
           $returned_stores = $GLOBALS['DB']->query("SELECT stores.* FROM brands
               JOIN stores_brands ON (stores_brands.brand_id = brands.id)
               JOIN stores ON (stores.id = stores_brands.store_id)
               WHERE brands.id = {$this->getId()};");
           $stores = array();
           foreach($returned_stores as $store) {
               $id = $store['id'];
               $name = $store['name'];
               $new_store = new Store($name, $id);
               array_push($stores, $new_store);
           }
           return $stores;
       }
       function deleteStores()
       {
          $GLOBALS['DB']->exec("DELETE FROM stores_brands WHERE brand_id = {$this->getId()};");
       }
       function deleteStore($delete_store)
       {
          $GLOBALS['DB']->exec("DELETE FROM stores_brands WHERE brand_id = {$this->getId()} AND store_id = {$delete_store->getId()};");
       }
       function notInStores()
       {
           $all_stores = Store::getAll();
           $brand_stores = $this->getStores();
           $not_in_stores = array();
           foreach($all_stores as $store) {
               if(!in_array($store, $brand_stores))
               {
                   $name = $store->getName();
                   $id = $store->getId();
                   $new_brand = new Store($name, $id);
                   array_push($not_in_stores, $new_brand);
               }
           }
           return $not_in_stores;
       }
    }
?>
