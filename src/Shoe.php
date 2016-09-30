<?php
    class Shoe
    {
        private $id;
        private $name;
        private $brand_id;

        function __construct ($id = null, $name, $brand_id)
        {
            $this->id = $id;
            $this->name = $name;
            $this->brand_id = $brand_id;
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

        function setBrandId($new_brand_id)
        {
            $this->brand_id = $new_brand_id;
        }

        function getBrandId()
        {
            return $this->brand_id;
        }

        function save()
        {
            $name = $this->getName();
            $name = ucwords(strtolower($name));
            $brand_id = $this->getBrandId();
            $GLOBALS['DB']->exec("INSERT INTO shoes (name, brand_id) VALUES ('{$name}', {$brand_id});");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_shoes = $GLOBALS['DB']->query("SELECT * FROM shoes;");
            $shoes = array();
            foreach ($returned_shoes as $shoe) {
                $id = $shoe['id'];
                $name = $shoe['name'];
                $brand_id = $shoe['brand_id'];
                $new_shoe = new Shoe($id, $name, $brand_id);
                array_push($shoes, $new_shoe);
            }
            return $shoes;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM shoes;");
        }

        static function find($search_id)
        {
            $found_shoe = null;
            $shoes = Shoe::getAll();
            foreach ($shoes as $shoe) {
                $shoe_id = $shoe->getId();
                if ($shoe_id == $search_id) {
                    $found_shoe = $shoe;
                }
            }
            return $found_shoe;
        }

        function updateShoe($edit_name)
        {
            $edit_name = ucwords(strtolower($edit_name));
            $GLOBALS['DB']->exec("UPDATE shoes SET name = '{$edit_name}' WHERE id = {$this->getId()};");
            $this->setName($edit_name);
        }

        function deleteShoe()
        {
            $GLOBALS['DB']->exec("DELETE FROM shoes WHERE id = {$this->getId()};");
        }
    }
?>
