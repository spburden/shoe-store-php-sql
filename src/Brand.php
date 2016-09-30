<?php
    class Brand
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
                $new_brand = new Brand($id, $name);
                array_push($brands, $new_brand);
            }
            return $brands;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM shoes;");
            $GLOBALS['DB']->exec("DELETE FROM brands;");
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

        function updateBrand($edit_name)
        {
            $edit_name = ucwords(strtolower($edit_name));
            $GLOBALS['DB']->exec("UPDATE brands SET name = '{$edit_name}' WHERE id = {$this->getId()};");
            $this->setName($edit_name);
        }

        function deleteBrand()
        {
            $GLOBALS['DB']->exec("DELETE FROM shoes WHERE brand_id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM brands WHERE id = {$this->getId()};");
        }

        function findShoes()
        {
           $returned_shoes = $GLOBALS['DB']->query("SELECT * FROM shoes WHERE brand_id = {$this->getId()};");
           $shoes = array();
           foreach($returned_shoes as $shoe) {
               $id = $shoe['id'];
               $name = $shoe['name'];
               $brand_id = $shoe['brand_id'];
               $new_shoe = new Shoe($id, $name, $brand_id);
               array_push($shoes, $new_shoe);
           }
           return $shoes;
       }

       function deleteShoes()
       {
          $returned_shoes = $GLOBALS['DB']->query("DELETE FROM shoes WHERE brand_id = {$this->getId()};");
       }

    }
?>
