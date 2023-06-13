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
<body class="vh-100 d-flex">
<section class="bg-primary-main p-4 rounded m-auto">
    <form action="/login" method="post" class="p-4">
        <div class="form-outline mb-2">
            <label class="form-label" for="login">Логин</label>
            <input type="text" id="login" name="login" class="form-control" value="<?= old('login') ?>"/>
            <span class="small text-danger"><?= error('login') ?></span>
        </div>

        <div class="form-outline mb-4">
            <label class="form-label" for="password">Пароль</label>
            <input type="password" id="password" name="password" class="form-control"/>
            <span class="small text-danger"><?= error('password') ?></span>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Войти</button>
    </form>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
</body>
</html>
