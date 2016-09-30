<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Brand.php";
    require_once __DIR__."/../src/Store.php";

    date_default_timezone_set('America/Los_Angeles');

    use Symfony\Component\Debug\Debug;
    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    Debug::enable();

    $app = new Silex\Application();

    $app['debug'] = true;

    // //ALTERNATIVE SERVER:
    //$server = 'mysql:host=localhost;dbname=shoes';
    $server = 'mysql:host=localhost:8889;dbname=shoes';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'
    ));

    $app->register(new Silex\Provider\UrlGeneratorServiceProvider());

    $app->get("/", function() use ($app) {
        $brands = Brand::getAll();
        $stores = Store::getAll();
        return $app['twig']->render('index.html.twig', array('brands' => $brands, 'stores' => $stores));
    });

    $app->post("/add_brand", function() use ($app) {
          $new_brand = $_POST['new_brand'];
          $new_brand = new Brand($new_brand);
          $new_brand->save();
          return $app->redirect("/");
    });

    $app->post("/add_store", function() use ($app) {
          $new_store = $_POST['new_store'];
          $new_store = new Store($new_store);
          $new_store->save();
          return $app->redirect("/");
    });

    $app->post("/delete_brands", function() use ($app) {
          Brand::deleteAll();
          return $app->redirect("/");
    });

    $app->post("/delete_stores", function() use ($app) {
          Store::deleteAll();
          return $app->redirect("/");
    });

    $app->get("/store/{id}", function($id) use ($app) {
        $store = Store::find($id);
        $all_brands = Brand::getAll();
        $store_brands = $store->getBrands();
        return $app['twig']->render('store.html.twig', array('all_brands' => $all_brands, 'store' => $store, 'store_brands' => $store_brands));
    })
    ->bind('store');

    $app->post("/store/{id}/add_brand", function($id) use ($app) {
        $store = Store::find($id);
        $brand_id = $_POST['new_store_brands_id'];
        $brand = Brand::find($brand_id);
        $store->addBrand($brand);
        return $app->redirect($app['url_generator']->generate('store', array('id' => $id)));
    });

    $app->patch("/store/{id}/edit_name", function($id) use ($app) {
        $store = Store::find($id);
        $store->update($_POST['edit_name']);
        return $app->redirect($app['url_generator']->generate('store', array('id' => $id)));
    });


    return $app;
?>
