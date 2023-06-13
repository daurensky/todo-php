<?php

namespace App\Controllers;

use App\Lib\View;
use App\Lib\Response;

class LoginController extends Controller
{
    public static function index(): View|Response
    {
        if (isset($_SESSION['user'])) {
            return redirect('/admin');
        }

        return view('login');
    }

    public static function store()
    {
        $isValid = self::validate($_POST, [
            'login'    => fn($value) => [
                [(bool)$value, 'Обязательное поле'],
            ],
            'password' => fn($value) => [
                [(bool)$value, 'Обязательное поле'],
            ],
        ]);

        if (!$isValid) {
            return back()
                ->withOlds(['login' => $_POST['login']])
                ->withCode(422);
        }

        if ($_POST['login'] !== 'admin' || $_POST['password'] !== '123') {
            $_SESSION['flash']['errors']['password'] = 'Неправильные реквизиты доступа';

            return back()
                ->withOlds(['login' => $_POST['login']])
                ->withCode(422);
        }

        $_SESSION['user'] = [
            'name' => 'admin',
        ];

        return redirect('/admin');
    }

    public static function destroy(): Response
    {
        unset($_SESSION['user']);
        return redirect('/');
    }
}
