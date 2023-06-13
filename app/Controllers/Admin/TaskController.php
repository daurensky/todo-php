<?php

namespace App\Controllers\Admin;

use App\Lib\View;
use App\Models\Task;
use App\Lib\Response;
use App\Controllers\Controller;

class TaskController extends Controller
{
    public static function index(): Response|View
    {
        if (!isset($_SESSION['user'])) {
            return redirect('/login');
        }

        $tasks = Task::query()
            ->orderBy('created_at DESC')
            ->paginate(
                currentPage: $_GET['page'] ?? 1,
                perPage: 10,
            );

        return view('admin')
            ->withVariables(compact('tasks'));
    }

    public static function update(): Response
    {
        if (!isset($_SESSION['user'])) {
            return redirect('/login');
        }

        $taskIds = array_keys($_POST['tasks']);
        $taskPlaceholders = implode(',', array_map(fn() => '?', $taskIds));

        $tasks = Task::query()
            ->select(['id', 'text'])
            ->where(
                'id IN (' . $taskPlaceholders . ')',
                $taskIds,
            )
            ->get();

        $taskTextById = [];

        foreach ($tasks as $task) {
            $taskTextById[$task['id']] = $task['text'];
        }

        foreach ($_POST['tasks'] as $id => $task) {
            $columns = [
                'is_completed' => (int)isset($task['is_completed']),
                'text'         => $task['text'],
            ];

            if ($taskTextById[$id] !== $task['text']) {
                $columns['text_updated'] = 1;
            }

            Task::query()
                ->where('id = ?', [$id])
                ->update($columns);
        }

        return redirect('/admin');
    }
}
