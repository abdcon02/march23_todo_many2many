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

// Renders Category pages

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

// Renders Task pages

    $app->get("/tasks", function() use($app) {
        return $app['twig']->render('tasks.html.twig', array('tasks'=>Task::getAll(), 'categories'=>Category::getAll()));
    });

    $app->post("/tasks", function() use($app) {
        $description = $_POST['description'];
        $new_task = new Task($description);
        $new_task->save();

        if(isset($_POST['task_categories'])){
            foreach($_POST['task_categories'] as $category_id) {
                $category = Category::find($category_id);
                $category->addTask($new_task);

            }
        }


        return $app['twig']->render('tasks.html.twig', array('tasks'=>Task::getAll(), 'categories'=>Category::getAll()));
    });

    $app->post("/delete_tasks", function() use($app) {
        Task::deleteAll();
        return $app['twig']->render('tasks.html.twig', array('tasks'=>Task::getAll(), 'categories'=>Category::getAll()));
    });


// Renders invidual category pages

    $app->get("/categories/{id}", function($id) use($app){

        $category = Category::find($id);
        $category_tasks = $category->getTasks();


        return $app['twig']->render('category.html.twig', array('category' => $category, 'tasks' => $category_tasks));
    });

    $app->post("/category_tasks/{id}", function($id) use($app){

        $category = Category::find($id);
        $task = $_POST['description'];
        $new_task = new Task($task);
        $new_task->save();
        $category->addTask($new_task);
        $category_tasks = $category->getTasks();

        return $app['twig']->render('category.html.twig', array('category' => $category, 'tasks' => $category_tasks));
    });


// Renders indivdual task pages

    $app->get("/task_edit/{id}", function($id) use($app) {
        $task = Task::find($id);
        return $app['twig']->render('task_edit.html.twig', array('task' => $task));
    });

// Patch and Update pages

    $app->get("/categories_edit/{id}", function($id) use($app){
        $category = Category::find($id);

        return $app['twig']->render('category_edit.html.twig', array('category' => $category));
    });

    $app->patch("/categories_edit/{id}", function($id) use($app) {
        $category = Category::find($id);
        $category->update($_POST['name']);

        return $app['twig']->render('categories.html.twig', array('categories' => Category::getAll()));
    });

    $app->delete("/categories_edit/{id}", function($id) use($app){
        $category = Category::find($id);
        $category->delete();

        return $app['twig']->render('categories.html.twig', array('categories' => Category::getAll()));
    });



    return $app;

?>
