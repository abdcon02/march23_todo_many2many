<?php

    class Task
    {
        private $description;
        private $id;

        function __construct($description, $id = null)
        {
            $this->description = $description;
            $this->id = $id;
        }

        function getDescription()
        {
            return $this->description;
        }

        function setDescription($new_description)
        {
            $this->description = (string) $new_description;
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
            $statement = $GLOBALS['DB']->query("INSERT INTO tasks (description) VALUES ('{$this->getDescription()}') RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);
        }

        static function getAll()
        {
            $all_tasks = $GLOBALS['DB']->query("SELECT * FROM tasks;");
            $returned_tasks = array();
            foreach($all_tasks as $task){
                $description = $task['description'];
                $id = $task['id'];
                $new_task = new Task($description, $id);
                array_push($returned_tasks, $new_task);
            }
            return $returned_tasks;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM tasks *;");

        }



    }

 ?>
