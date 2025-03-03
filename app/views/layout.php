<?php
$user_email = isset($_SESSION['user_email']) ? $_SESSION['user_email'] : 'no-name';
$user_role = isset($_SESSION['user_role']) ? $_SESSION['user_role'] : false;
?>
<!DOCTYPE html>
<html>
<head>
    <title><?= $title ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= APP_BASE_PATH ?>/app/css/style.css">
    <script src="https://kit.fontawesome.com/6e56039614.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="/app/libs/flatpickr/node_modules/flatpickr/dist/flatpickr.min.css">
    <script src="/app/libs/flatpickr/node_modules/flatpickr/dist/flatpickr.min.js"></script>
    <script src="/app/libs/calendar/node_modules/fullcalendar/index.global.min.js"></script>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="sidebar col-md-3">
            <div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="min-height: 100vh;">
                <a href="/<?= APP_BASE_PATH ?>"
                   class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <svg class="bi me-2" width="40" height="32">
                        <use xlink:href="#bootstrap"></use>
                    </svg>
                    <span class="fs-4">Система CRM</span>
                </a>
                <hr>
                <ul class="nav nav-pills flex-column mb-auto">
                    <?php if($user_role == 5): ?>
                    <li class="nav-item">
                        <a href="/<?= APP_BASE_PATH ?>" class="nav-link text-white <?= is_active('/' . APP_BASE_PATH) ?>" aria-current="page">
                            <svg class="bi me-2" width="16" height="16">
                                <use xlink:href="/<?= APP_BASE_PATH ?>"></use>
                            </svg>
                            Главная
                        </a>
                    </li>
                    <li>
                        <a href="<?= APP_BASE_PATH ?>/users" class="nav-link text-white <?= is_active( APP_BASE_PATH . '/users') ?>">
                            <svg class="bi me-2" width="16" height="16">
                                <use xlink:href="<?= APP_BASE_PATH ?>/users"></use>
                            </svg>
                            Пользователи
                        </a>
                    </li>
                    <li>
                        <a href="<?= APP_BASE_PATH ?>/roles" class="nav-link text-white <?= is_active( APP_BASE_PATH . '/roles') ?>">
                            <svg class="bi me-2" width="16" height="16">
                                <use xlink:href="<?= APP_BASE_PATH ?>/roles"></use>
                            </svg>
                            Роли
                        </a>
                    </li>
                    <li>
                        <a href="<?= APP_BASE_PATH ?>/pages" class="nav-link text-white <?= is_active( APP_BASE_PATH . '/pages') ?>">
                            <svg class="bi me-2" width="16" height="16">
                                <use xlink:href="<?= APP_BASE_PATH ?>/pages"></use>
                            </svg>
                            Страницы
                        </a>
                    </li>
                    <hr/>
                    <?php endif ?>
                    <h4 class="fs-4">ToDo List</h4>
                    <li>
                        <a href="<?= APP_BASE_PATH ?>/todo/category" class="nav-link text-white <?= is_active( APP_BASE_PATH . '/todo/category') ?>">
                            <svg class="bi me-2" width="16" height="16">
                                <use xlink:href="<?= APP_BASE_PATH ?>/todo/category"></use>
                            </svg>
                            Категории
                        </a>
                    </li>
                    <li>
                        <a href="<?= APP_BASE_PATH ?>/todo/tasks" class="nav-link text-white <?= is_active( APP_BASE_PATH . '/todo/tasks') ?>">
                            <svg class="bi me-2" width="16" height="16">
                                <use xlink:href="<?= APP_BASE_PATH ?>/todo/tasks"></use>
                            </svg>
                            Задачи (актуальные)
                        </a>
                    </li>
                    <li>
                        <a href="<?= APP_BASE_PATH ?>/todo/tasks/completed" class="nav-link text-white <?= is_active( APP_BASE_PATH . '/todo/tasks/completed') ?>">
                            <svg class="bi me-2" width="16" height="16"><use xlink:href="<?= APP_BASE_PATH ?>/todo/tasks/completed"></use></svg>
                            Задачи (завершенные)
                        </a>
                    </li>
                    <li>
                        <a href="<?= APP_BASE_PATH ?>/todo/tasks/expired" class="nav-link text-white <?= is_active( APP_BASE_PATH . '/todo/tasks/expired') ?>">
                            <svg class="bi me-2" width="16" height="16"><use xlink:href="<?= APP_BASE_PATH ?>/todo/tasks/expired"></use></svg>
                            Задачи (просроченные)
                        </a>
                    </li>
                    <li>
                        <a href="<?= APP_BASE_PATH ?>/todo/tasks/create" class="nav-link text-white <?= is_active( APP_BASE_PATH . '/todo/tasks/create') ?>">
                            <svg class="bi me-2" width="16" height="16"><use xlink:href="<?= APP_BASE_PATH ?>/todo/tasks/create"></use></svg>
                            Создать задачу
                        </a>
                    </li>
                </ul>
                <hr>
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
                       id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                        <strong><?=$user_email?></strong>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
<!--                        <li><a class="dropdown-item" href="#">Новый проект...</a></li>-->
<!--                        <li><a class="dropdown-item" href="#">Настройки</a></li>-->
<!--                        <li><a class="dropdown-item" href="#">Профиль</a></li>-->
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="<?= APP_BASE_PATH ?>/auth/logout">Выйти</a></li>
                        <li><a class="dropdown-item" href="<?= APP_BASE_PATH ?>/auth/login">Войти</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="article col-md-9">
            <div class="container mt-4">
                <?php echo $content; ?>
            </div>
        </div>
    </div>
</div>

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
<script src="<?= APP_BASE_PATH ?>/app/js/my.js"></script>

</body>
</html>
