<?php

    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Category.php";
    require_once __DIR__."/../src/Task.php";

    $DB = new PDO('pgsql:host=localhost;dbname=to_do');

    $app = new Silex\Application();
    $app['debug'] = true;

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path'=>__DIR__.'/../views'));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodparameterOverride();

    $app->get("/", function() use($app) {
        return $app['twig']->render('index.html.twig');
    });

// Renders Category 

    $app->get("/categories", function() use($app) {
        return $app['twig']->render('categories.html.twig', array('categories'=>Category::getAll()));
    });

    $app->post("/categories", function() use($app){
        $name = $_POST['name'];
        $new_category = new Category($name);
        $new_category->save();

        return $app['twig']->render('categories.html.twig', array('categories' =>Category::getAll()));
    });

    $app->post("/delete_categories", function() use($app){
        Category::deleteAll();
        return $app['twig']->render('categories.html.twig', array('categories' =>Category::getAll()));
    });

//
    $app->get("/tasks", function() use($app) {
        return $app['twig']->render('tasks.html.twig', array('tasks'=>Task::getAll(), 'categories'=>Category::getAll()));
    });

    $app->post("/tasks", function() use($app) {
        $description = $_POST['description'];
        $new_task = new Task($description);
        $new_task->save();
        return $app['twig']->render('tasks.html.twig', array('tasks'=>Task::getAll(), 'categories'=>Category::getAll()));
    });

    $app->post("/delete_tasks", function() use($app) {
        Task::deleteAll();
        return $app['twig']->render('tasks.html.twig', array('tasks'=>Task::getAll(), 'categories'=>Category::getAll()));
    });

    $app->get("/tasks/{id}", function($id) use($app) {

    });


    return $app;

?>
