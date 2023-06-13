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
                    <h2>Список задач</h2>
                    <a href="/login" class="btn btn-primary">Вход для администратора</a>
                </div>

                <div class="pb-2">
                    <div class="card">
                        <form action="/task" method="post" class="card-body d-flex flex-column align-items-start gap-2">
                            <div class="d-flex gap-2">
                                <div>
                                    <input type="text" name="user_name" id="user_name" placeholder="Ваше имя..."
                                           class="form-control w-auto" value="<?= old('user_name') ?>">
                                    <span
                                        class="small text-danger"><?= error('user_name') ?></span>
                                </div>
                                <div>
                                    <input type="text" name="email" id="email" placeholder="Ваше электронная почта..."
                                           class="form-control w-auto" value="<?= old('email') ?>">
                                    <span class="small text-danger"><?= error('email') ?></span>
                                </div>
                            </div>
                            <div class="d-flex align-items-start gap-2 w-100">
                                <div class="w-100">
                                    <textarea type="text" name="text" class="form-control" rows="5"
                                              placeholder="Описание задачи"><?= old('text') ?></textarea>
                                    <span class="small text-danger"><?= error('text') ?></span>
                                </div>
                                <button type="submit" class="btn btn-primary">Добавить</button>
                            </div>
                        </form>
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end align-items-center gap-4 mb-4 pt-2 pb-3">
                    <form method="get" class="d-flex align-items-center gap-2">
                        <label for="sort" class="small text-muted m-0 text-nowrap">Сортировка</label>
                        <select name="sort" id="sort" class="form-select">
                            <option <?= $selectedSort === 'created_at' ? 'selected' : '' ?> value="">
                                По дате создания
                            </option>
                            <option <?= $selectedSort === 'user_name' ? 'selected' : '' ?> value="user_name">
                                Имя пользователя
                            </option>
                            <option <?= $selectedSort === 'email' ? 'selected' : '' ?> value="email">
                                Электронная почта
                            </option>
                            <option <?= $selectedSort === 'is_completed' ? 'selected' : '' ?> value="is_completed">
                                Выполнение
                            </option>
                        </select>
                        <select name="sort-direction" id="sort-direction" class="form-select">
                            <option <?= $selectedSortDirection === 'desc' ? 'selected' : '' ?> value="desc">
                                По убыванию
                            </option>
                            <option <?= $selectedSortDirection === 'asc' ? 'selected' : '' ?> value="asc">
                                По возрастанию
                            </option>
                        </select>
                        <button type="submit" class="btn btn-primary">Сортировать</button>
                    </form>
                </div>

                <ul class="list-group gap-2 mb-4">
                    <?php foreach ($tasks['data'] as $task) { ?>
                        <li class="d-flex gap-2 bg-white p-2 rounded-2 border border-secondary-subtle">
                            <input type="checkbox" <?= $task['is_completed'] ? 'checked' : '' ?>
                                   class="form-check-input pe-none">
                            <div class="d-flex flex-column">
                                <p class="small">
                                    <?= $task['user_name'] ?> <?= $task['email'] ?>
                                    <?php if ($task['text_updated']) { ?>
                                        <i class="small text-secondary">Отредактировано администратором</i>
                                    <?php } ?>
                                </p>
                                <p class="whitespace-pre-line"><?= $task['text'] ?></p>
                            </div>
                        </li>
                    <?php } ?>
                </ul>

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
