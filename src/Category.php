<?php

    class Category
    {

        private $name;
        private $id;

        function __construct($name, $id = null)
        {
            $this->name = $name;
            $this->id = $id;
        }

        function getName()
        {
            return $this->name;
        }

        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function getId()
        {
            return $this->id;
        }

        function setId($new_id)
        {
            $this->id = (int) $new_id;
        }

        function save()
        {
            $statement = $GLOBALS['DB']->query("INSERT INTO categories (name) VALUES ('{$this->getName()}') RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);
        }

        static function getAll()
        {
            $statement = $GLOBALS['DB']->query("SELECT * FROM categories;");
            $all_categories = array();
            foreach($statement as $category){
                $name = $category['name'];
                $id = $category['id'];
                $new_category = new Category($name, $id);
                array_push($all_categories, $new_category);
            }
            return $all_categories;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM categories *;");
        }

        static function find($search_id)
        {
            $found_category = null;
            $categories = Category::getAll();
            foreach($categories as $category){
                $category_id = $category->getId();
                if ($category_id == $search_id) {
                    $found_category = $category;
                }
            }
            return $found_category;
        }

        function update($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE categories SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM categories WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM categories_tasks WHERE categories_id = {$this->getId()};");
        }

        function getTasks()
        {
            $query = $GLOBALS['DB']->query("SELECT tasks_id FROM categories_tasks WHERE categories_id = {$this->getId()};");
            $task_ids = $query->fetchAll(PDO::FETCH_ASSOC);

            $tasks = array();
            foreach($task_ids as $id){
                $tasks_id = $id['tasks_id'];

                $result = $GLOBALS['DB']->query("SELECT*FROM tasks WHERE id = {$tasks_id};");
                $returned_task = $result->fetchAll(PDO::FETCH_ASSOC);

                $description = $returned_task[0]['description'];
                $id = $returned_task[0]['id'];

                $new_task = new Task($description, $id);
                array_push($tasks, $new_task);
            }
            return $tasks;
        }

        function addTask($task)
        {
            $GLOBALS['DB']->exec("INSERT INTO categories_tasks (categories_id, tasks_id) VALUES ({$this->getId()}, {$task->getId()});");
        }



    }

?>
