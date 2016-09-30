<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Brand.php";
    require_once __DIR__."/../src/Shoe.php";

    date_default_timezone_set('America/Los_Angeles');

    use Symfony\Component\Debug\Debug;
    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    Debug::enable();

    $app = new Silex\Application();

    $app['debug'] = true;

    // //ALTERNATIVE SERVER:
    $server = 'mysql:host=localhost;dbname=shoe_store';
    // $server = 'mysql:host=localhost:8889;dbname=shoe_store';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views'
    ));

    $app->register(new Silex\Provider\UrlGeneratorServiceProvider());

    $app->get("/", function() use ($app) {
        $brands = Brand::getAll();
        return $app['twig']->render('index.html.twig', array('brands' => $brands));
    });

    return $app;
?>
