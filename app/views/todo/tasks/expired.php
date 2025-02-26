<?php

$title = 'Todo list expired';
ob_start();
?>

<h1 class="mb-4">Просроченные задачи</h1>
<div class="d-flex justify-content-around row filter-priority">
    <a data-priority="low" class="btn mb-3 col-2 sort-btn" style="background: #A9A9A9">Low</a>
    <a data-priority="medium" class="btn mb-3 col-2 sort-btn" style="background: #AFEEEE">Medium</a>
    <a data-priority="high" class="btn mb-3 col-2 sort-btn" style="background: #00BFFF">High</a>
    <a data-priority="urgent" class="btn mb-3 col-2 sort-btn" style="background: #FF0000">Urgent</a>
</div>

<div class="accordion" id="tasks-accordion">
    <?php foreach ($expiredTasks as $oneTask): ?>
        <?php
        $priorityColor = '';
        switch ($oneTask['priority']) {
            case 'low':
                $priorityColor = '#A9A9A9';
                break;
            case 'medium':
                $priorityColor = '#AFEEEE';
                break;
            case 'high':
                $priorityColor = '#00BFFF';
                break;
            case 'urgent':
                $priorityColor = '#FF0000';
                break;
        }
        ?>
        <div class="accordion-item mb-2">
            <div class="accordion-header d-flex justify-content-between align-items-center row"
                 id="task-<?php echo $oneTask['id']; ?>">
                <h2 class="accordion-header col-12 col-md-6">
                    <button style="background: <?= $priorityColor ?>;" class="accordion-button collapsed" type="button"
                            data-bs-toggle="collapse" data-bs-target="#task-collapse-<?php echo $oneTask['id']; ?>"
                            aria-expanded="false" aria-controls="task-collapse-<?php echo $oneTask['id']; ?>"
                            data-priority="<?php echo $oneTask['priority']; ?>">
                        <span class="col-12 col-md-5"><i
                                    class="fa-solid fa-square-up-right"></i> <strong><?php echo $oneTask['title']; ?> </strong></span>
                        <span class="col-5 col-md-3"><i
                                    class="fa-solid fa-person-circle-question"></i> <?php echo $oneTask['priority']; ?> </span>
                        <span class="col-5 col-md-3"><i class="fa-solid fa-hourglass-start"></i><span
                                    class="due-date"><?php echo $oneTask['finish_date']; ?></span></span>
                    </button>
                </h2>
            </div>
            <div id="task-collapse-<?php echo $oneTask['id']; ?>" class="accordion-collapse collapse row"
                 aria-labelledby="task-<?php echo $oneTask['id']; ?>" data-bs-parent="#tasks-accordion">
                <div class="accordion-body">
                    <p><strong><i class="fa-solid fa-layer-group"></i>
                            Category:</strong> <?php echo htmlspecialchars($oneTask['category_name'] ?? 'N/A'); ?></p>
                    <p><strong><i class="fa-solid fa-battery-three-quarters"></i>
                            Status:</strong> <?php echo htmlspecialchars($oneTask['status']); ?></p>
                    <p><strong><i class="fa-solid fa-person-circle-question"></i>
                            Priority:</strong> <?php echo htmlspecialchars($oneTask['priority']); ?></p>
                    <p><strong><i class="fa-solid fa-hourglass-start"></i> Due
                            Date:</strong> <?php echo htmlspecialchars($oneTask['finish_date']); ?></p>
                    <p><strong><i class="fa-solid fa-file-prescription"></i>
                            Description:</strong> <?php echo htmlspecialchars($oneTask['description'] ?? ''); ?></p>
                    <div class="d-flex justify-content-start action-task">
                        <form action="<?= APP_BASE_PATH ?>/todo/tasks/update-status/<?php echo $oneTask['id']; ?>"
                              method="POST" class="me-2">
                            <input type="hidden" name="status" value="cancelled">
                            <button type="submit"
                                    class="btn <?= $oneTask['status'] == 'cancelled' ? 'btn-warning' : 'btn-secondary'; ?>">
                                Cancelled
                            </button>
                        </form>
                        <form action="<?= APP_BASE_PATH ?>/todo/tasks/update-status/<?php echo $oneTask['id']; ?>"
                              method="post" class="me-2">
                            <input type="hidden" name="status" value="new">
                            <button type="submit"
                                    class="btn <?= $oneTask['status'] == 'new' ? 'btn-warning' : 'btn-secondary'; ?>">
                                New
                            </button>
                        </form>
                        <form action="<?= APP_BASE_PATH ?>/todo/tasks/update-status/<?php echo $oneTask['id']; ?>"
                              method="post" class="me-2">
                            <input type="hidden" name="status" value="in_progress">
                            <button type="submit"
                                    class="btn <?= $oneTask['status'] == 'in_progress' ? 'btn-warning' : 'btn-secondary'; ?>">
                                In progress
                            </button>
                        </form>
                        <form action="<?= APP_BASE_PATH ?>/todo/tasks/update-status/<?php echo $oneTask['id']; ?>"
                              method="post" class="me-2">
                            <input type="hidden" name="status" value="on_hold">
                            <button type="submit"
                                    class="btn <?= $oneTask['status'] == 'on_hold' ? 'btn-warning' : 'btn-secondary'; ?>">
                                On hold
                            </button>
                        </form>
                        <form action="<?= APP_BASE_PATH ?>/todo/tasks/update-status/<?php echo $oneTask['id']; ?>"
                              method="post" class="me-2">
                            <input type="hidden" name="status" value="completed">
                            <button type="submit"
                                    class="btn <?= $oneTask['status'] == 'completed' ? 'btn-warning' : 'btn-secondary'; ?>">
                                Completed
                            </button>
                        </form>
                        <a href="<?= APP_BASE_PATH ?>/todo/tasks/edit/<?php echo $oneTask['id']; ?>" class="btn btn-primary me-2">Edit</a>
                        <a href="<?= APP_BASE_PATH ?>/todo/tasks/delete/<?php echo $oneTask['id']; ?>" class="btn btn-danger me-2">Delete</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>


<script>
    function updateRemainingTime() {
        const dueDateElements = document.querySelectorAll('.due-date');
        const now = new Date();

        dueDateElements.forEach((element) => {
            const dueDate = new Date(element.textContent);
            const timeDiff = dueDate - now;

            if (timeDiff > 0) {
                const days = Math.floor(timeDiff / (1000 * 60 * 60 * 24));
                const hours = Math.floor((timeDiff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((timeDiff % (1000 * 60 * 60)) / (1000 * 60));

                element.textContent = `Days: ${days} Hours: ${hours}`;
            } else {
                element.textContent = 'Time is up';
            }
        });
    }

    updateRemainingTime();
    setInterval(updateRemainingTime, 60000); // Update every minute
</script>

<?php $content = ob_get_clean();

include 'app/views/layout.php';
?>
