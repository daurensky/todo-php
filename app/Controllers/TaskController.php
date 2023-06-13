<?php

namespace App\Controllers;

use App\Lib\View;
use App\Models\Task;

class TaskController extends Controller
{
    public static function index(): View
    {
        $sorts = [
            'user_name',
            'email',
            'is_completed',
        ];
        $sortDirections = ['asc', 'desc'];

        $selectedSort = in_array(@$_GET['sort'], $sorts)
            ? $_GET['sort']
            : 'created_at';
        $selectedSortDirection = in_array(@$_GET['sort-direction'], $sortDirections)
            ? $_GET['sort-direction']
            : 'desc';

        $tasks = Task::query()
            ->orderBy("{$selectedSort} {$selectedSortDirection}")
            ->paginate(
                currentPage: $_GET['page'] ?? 1,
                perPage: 3,
            );

        return view('index')
            ->withVariables(compact('tasks', 'selectedSort', 'selectedSortDirection'));
    }

    public static function store()
    {
        $isValid = self::validate($_POST, [
            'user_name' => fn($value) => [
                [(bool)$value, 'Обязательное поле'],
                [strlen($value) <= 30, 'Слишком длинное имя'],
            ],
            'email'     => fn($value) => [
                [(bool)$value, 'Обязательное поле'],
                [filter_var($value, FILTER_VALIDATE_EMAIL), 'Неверный формат'],
                [strlen($value) <= 255, 'Слишком длинная почта'],
            ],
            'text'      => fn($value) => [
                [(bool)$value, 'Обязательное поле'],
                [strlen($value) <= 1000, 'Слишкмо длинный текст'],
            ],
        ]);

        if (!$isValid) {
            return back()
                ->withOlds($_POST)
                ->withCode(422);
        }

        Task::query()->create([
            'user_name'    => trim($_POST['user_name']),
            'email'        => trim($_POST['email']),
            'text'         => trim($_POST['text']),
            'is_completed' => 0,
        ]);

        return redirect('/');
    }
}
