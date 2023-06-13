<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Список задач</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body class="vh-100">
<section class="py-5">
    <div class="container">
        <div class="card bg-primary-main">
            <div class="card-body py-4 px-4 px-md-5">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2>Управление задачами</h2>
                    <div class="d-flex gap-2">
                        <a href="<?= env('APP_URL') ?>" class="btn btn-primary">На главную</a>
                        <form action="/logout" method="post">
                            <button type="submit" class="btn btn-primary">Выйти</button>
                        </form>
                    </div>
                </div>

                <form action="/admin/update-task" method="post">
                    <ul class="list-group gap-2 mb-4">
                        <?php foreach ($tasks['data'] as $task) { ?>
                            <li class="d-flex gap-2 bg-white p-2 rounded-2 border border-secondary-subtle">
                                <input type="checkbox" id="task-<?= $task['id'] ?>"
                                       name="tasks[<?= $task['id'] ?>][is_completed]"
                                    <?= $task['is_completed'] ? 'checked' : '' ?>
                                       class="form-check-input">
                                <div class="d-flex flex-column w-100">
                                    <label for="task-<?= $task['id'] ?>"
                                           class="small mb-3"><?= $task['user_name'] ?> <?= $task['email'] ?></label>
                                    <textarea name="tasks[<?= $task['id'] ?>][text]"
                                              class="whitespace-pre-line form-control w-100"
                                              rows="5"><?= $task['text'] ?></textarea>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                    <div class="d-flex justify-content-end mb-4">
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </div>
                </form>

                <?php if ($tasks['total_page'] > 1) { ?>
                    <nav class="d-flex justify-content-end">
                        <ul class="pagination">
                            <?php if ($tasks['prev_page']) { ?>
                                <li class="page-item">
                                    <a class="page-link"
                                       href="<?= url()->withParams(['page' => $tasks['prev_page']]) ?>">&laquo;</a>
                                </li>
                            <?php } ?>
                            <?php for ($i = 1 ; $i <= $tasks['total_page'] ; $i++) { ?>
                                <li class="page-item <?= (int)$tasks['current_page'] === $i ? 'active' : '' ?>">
                                    <a class="page-link"
                                       href="<?= url()->withParams(['page' => $i]) ?>">
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ($tasks['next_page']) { ?>
                                <li class="page-item">
                                    <a class="page-link"
                                       href="<?= url()->withParams(['page' => $tasks['next_page']]) ?>">&raquo;</a>
                                </li>
                            <?php } ?>
                        </ul>
                    </nav>
                <?php } ?>
            </div>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
</body>
</html>
