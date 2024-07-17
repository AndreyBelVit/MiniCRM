<?php

$title = "Create new user";

ob_start();
?>

<h1>Create new user</h1>

<form action="index.php?page=users&action=store" method="post">

  <div class="form-group">
    <label for="login">Login</label>
    <input type="text" class="form-control" name="login" id="login" required>
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" class="form-control" name="password" id="password" required>
  </div>
  <div class="form-group">
    <label for="confirm_password">Confirm Password</label>
    <input type="password" class="form-control" name="confirm_password" id="confirm_password" required>
  </div>
  <div class="form-group">
    <label for="admin">You are admin?</label>
    <select class="form-control" name="admin" id="admin">
      <option value="0">No</option>
      <option value="1">Yes</option>
    </select>
    <button type="submit" class="btn btn-primary mt-2">Create</button>

  </div>

</form>

<?php $content = ob_get_clean();
include 'app/views/layout.php';
?>