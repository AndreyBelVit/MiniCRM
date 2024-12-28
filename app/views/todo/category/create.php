<?php

$title = 'Create ToDo category';
ob_start();
?>

  <h1 class="mb-4">Create ToDo Category</h1>
    <form method="POST" action="<?= APP_BASE_PATH ?>/todo/category/store">
    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" id="title" name="title" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" id="description" name="description" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Create category</button>
    </form>

<?php $content = ob_get_clean(); 

include 'app/views/layout.php';
?>