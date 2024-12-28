<?php

namespace controllers\pages;

use models\pages\PageModel;
use models\roles\Role;
use models\Check;

class PageController
{

    private $check;

    public function __construct()
    {
        $userRole = $_SESSION['user_role'] ?? null;
        $this->check = new Check($userRole);
    }

    public function index()
    {
        $this->check->requirePermission();

        $pageModel = new PageModel();
        $pages = $pageModel->getAllPages();

        include 'app/views/pages/index.php';
    }

    public function create()
    {
        $this->check->requirePermission();
        $roleModel = new Role();
        $roles = $roleModel->getAllRoles();
        include 'app/views/pages/create.php';
    }

    public function store()
    {
        $this->check->requirePermission();
        if (isset($_POST['title']) && isset($_POST['slug']) && isset($_POST['roles'])) {
            $title = trim($_POST['title']);
            $slug = trim($_POST['slug']);
            $roles = implode(',', $_POST['roles']);

            if (empty($title) || empty($slug) || empty($roles)) {
                echo "Title and Slug or Roles fields are required!";
                return;
            }

            $pageModel = new PageModel();
            $pageModel->createPage($title, $slug, $roles);
        }
        $path = APP_BASE_PATH . '/pages';
        header("Location: $path");
    }

    public function edit($params)
    {
        $this->check->requirePermission();
        $roleModel = new Role();
        $roles = $roleModel->getAllRoles();
        $pageModel = new PageModel();
        $page = $pageModel->getPageById($params['id']);

        if (!$page) {
            echo "Page not found";
            return;
        }

        include 'app/views/pages/edit.php';
    }

    public function update($params)
    {
        $this->check->requirePermission();
        if (isset($_POST['role'])) {
            $newRole = $_POST['role'];
            if ($this->check->isCurrentUserRole($newRole)) {
                $path = APP_BASE_PATH . '/auth/logout';
                header("Location: $path");
                exit();
            }
        }

        if (isset($params['id']) && isset($_POST['title']) && isset($_POST['slug']) && isset($_POST['roles'])) {
            $id = trim($params['id']);
            $title = trim($_POST['title']);
            $slug = trim($_POST['slug']);
            $roles = implode(',', $_POST['roles']);

            if (empty($title) || empty($slug) || empty($roles)) {
                echo "Title and Slug or Roles fields are required!";
                return;
            }

            $pageModel = new PageModel();
            $pageModel->updatePage($id, $title, $slug, $roles);
        }
        $path = APP_BASE_PATH . '/pages';
        header("Location: $path");
    }

    public function delete($params)
    {
        $this->check->requirePermission();
        $pageModel = new PageModel();
        $pageModel->deletePage($params['id']);

        $path = APP_BASE_PATH . '/pages';
        header("Location: $path");
    }

}