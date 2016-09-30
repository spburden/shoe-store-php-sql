<?php
    class Store
    {
        private $id;
        private $name;

        function __construct ($id = null, $name)
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
                $new_store = new Store($id, $name);
                array_push($stores, $new_store);
            }
            return $stores;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM shoes;");
            $GLOBALS['DB']->exec("DELETE FROM stores;");
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

        function updateStore($edit_name)
        {
            $edit_name = ucwords(strtolower($edit_name));
            $GLOBALS['DB']->exec("UPDATE stores SET name = '{$edit_name}' WHERE id = {$this->getId()};");
            $this->setName($edit_name);
        }

        function deleteStore()
        {
            $GLOBALS['DB']->exec("DELETE FROM shoes WHERE store_id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM stores WHERE id = {$this->getId()};");
        }

        function findShoes()
        {
           $returned_shoes = $GLOBALS['DB']->query("SELECT * FROM shoes WHERE store_id = {$this->getId()};");
           $shoes = array();
           foreach($returned_shoes as $shoe) {
               $id = $shoe['id'];
               $name = $shoe['name'];
               $store_id = $shoe['store_id'];
               $new_shoe = new Shoe($id, $name, $store_id);
               array_push($shoes, $new_shoe);
           }
           return $shoes;
       }

       function deleteShoes()
       {
          $returned_shoes = $GLOBALS['DB']->query("DELETE FROM shoes WHERE store_id = {$this->getId()};");
       }

    }
?>
