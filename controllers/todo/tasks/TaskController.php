<?php


namespace controllers\todo\tasks;

use models\Check;
use models\todo\tasks\TaskModel;
use models\todo\tasks\TagsModel;
use models\todo\category\CategoryModel;

class TaskController
{
    private $check;
    private $tagsModel;

    public function __construct()
    {
        $userRole = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : null;
        $this->check = new Check($userRole);
        $this->tagsModel = new TagsModel();
    }

    public function index()
    {
        $this->check->requirePermission();
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

        $taskModel = new TaskModel();
        $tasks = $taskModel->getAllTasksByIdUser($user_id);
        $categoryModel = new CategoryModel();

        // Получение списка тегов для каждой записи в массиве
        foreach ($tasks as &$task) {
            $task['tags'] = $this->tagsModel->getTagsByTaskId($task['id']);
            $task['category'] = $categoryModel->getCategoryById($task['category_id']);
        }
        include 'app/views/todo/tasks/index.php';
    }

    public function completed()
    {
        $this->check->requirePermission();

        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

        $taskModel = new TaskModel();
        $completedTasks = $taskModel->getAllCompletedTasksByIdUser($user_id);

        $categoryModel = new CategoryModel();

        // Получение списка тегов для каждой записи в массиве
        foreach ($completedTasks as &$task) {
            $task['tags'] = $this->tagsModel->getTagsByTaskId($task['id']);
            $task['category'] = $categoryModel->getCategoryById($task['category_id']);
        }

        include 'app/views/todo/tasks/completed.php';
    }

    public function expired()
    {
        $this->check->requirePermission();

        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

        $taskModel = new TaskModel();
        $expiredTasks = $taskModel->getAllExpiredTasksByIdUser($user_id);

        $categoryModel = new CategoryModel();

        // Получение списка тегов для каждой записи в массиве
        foreach ($expiredTasks as &$task) {
            $task['tags'] = $this->tagsModel->getTagsByTaskId($task['id']);
            $task['category'] = $categoryModel->getCategoryById($task['category_id']);
        }

        include 'app/views/todo/tasks/expired.php';
    }

    public function create()
    {
        $this->check->requirePermission();
        $todoCategoryModel = new CategoryModel();
        $categories = $todoCategoryModel->getAllCategoriesWithUsability();
        include 'app/views/todo/tasks/create.php';
    }

    public function store()
    {
        $this->check->requirePermission();
        if (isset($_POST['title']) && isset($_POST['category_id']) && isset($_POST['finish_date'])) {
            $data['title'] = trim($_POST['title']);
            $data['category_id'] = trim($_POST['category_id']);
            $data['finish_date'] = trim($_POST['finish_date']);
            $data['user_id'] = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
            $data['status'] = 'new';
            $data['priority'] = 'low';

            $taskModel = new TaskModel();
            $taskModel->createTask($data);

        }
        $path = APP_BASE_PATH . '/todo/tasks';
        header("Location: $path");
    }

    public function edit($params)
    {
        $this->check->requirePermission();
        $taskModel = new TaskModel();
        $todoCategoryModel = new CategoryModel();
        $task = $taskModel->getTaskById($params['id']);
        $categories = $todoCategoryModel->getAllCategoriesWithUsability();


        if (!$task) {
            echo "Task not found";
            return;
        }
        $tags = $this->tagsModel->getTagsByTaskId($task['id']);
        include 'app/views/todo/tasks/edit.php';
    }


    public function update()
    {
        $this->check->requirePermission();
        if (isset($_POST['id']) && isset($_POST['title']) && isset($_POST['category_id']) && isset($_POST['finish_date'])) {
            $data['id'] = trim($_POST['id']);
            $data['title'] = trim($_POST['title']);
            $data['category_id'] = trim($_POST['category_id']);
            $data['finish_date'] = trim($_POST['finish_date']);
            $data['reminder_at'] = trim($_POST['reminder_at']);
            $data['status'] = trim($_POST['status']);
            $data['priority'] = trim($_POST['priority']);
            $data['description'] = trim($_POST['description']);
            $data['user_id'] = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

            // Обработка даты окончания и напоминания
            $finish_date_value = $data['finish_date'];
            $reminder_at_option = $data['reminder_at'];
            $finish_date = new \DateTime($finish_date_value);

            switch ($reminder_at_option) {
                case '30_minutes':
                    $interval = new \DateInterval('PT30M');
                    break;
                case '1_hour':
                    $interval = new \DateInterval('PT1H');
                    break;
                case '2_hours':
                    $interval = new \DateInterval('PT2H');
                    break;
                case '12_hours':
                    $interval = new \DateInterval('PT12H');
                    break;
                case '24_hours':
                    $interval = new \DateInterval('P1D');
                    break;
                case '7_days':
                    $interval = new \DateInterval('P7D');
                    break;
            }

            $reminder_at = $finish_date->sub($interval);
            $data['reminder_at'] = $reminder_at->format('Y-m-d\TH:i');

            // обновляем данные по задаче в базе
            $taskModel = new TaskModel();
            $taskModel->updateTask($data);
            // Обработка тегов
            $tags = explode(',', $_POST['tags']);
            $tags = array_map('trim', $tags);

            // Получение тегов с базы по задаче, которую редактируем
            $oldTags = $this->tagsModel->getTagsByTaskId($data['id']);

            // Удаление старых связей между тегами и задачей
            $this->tagsModel->removeAllTaskTags($data['id']);

            // Добавляем новые теги и связываем с задачей
            foreach ($tags as $tag_name) {
                $tag = $this->tagsModel->getTagByNameAndUserId($tag_name, $data['user_id']);
                if (!$tag) {
                    $tag_id = $this->tagsModel->addTag($tag_name, $data['user_id']);
                } else {
                    $tag_id = $tag['id'];
                }

                $this->tagsModel->addTaskTag($data['id'], $tag_id);
            }

            // Удаляем неиспользуемые теги
            foreach ($oldTags as $oldTag) {
                $this->tagsModel->removeUnusedTag($oldTag['id']);
            }


        }
        $path = APP_BASE_PATH . '/todo/tasks';
        header("Location: $path");
    }

    public function delete($params)
    {
        $this->check->requirePermission();
        $todoCategoryModel = new CategoryModel();
        $todoCategoryModel->deleteCategory($params['id']);

        $path = APP_BASE_PATH . '/todo/category';
        header("Location: $path");
    }
}