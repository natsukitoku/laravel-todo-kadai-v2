<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Goal $goal)
    {
        $request->validate([
            'content' => 'required',
            'description' => 'required',
        ]);

        $todo = new Todo();
        $todo->content = $request->input('content');
        $todo->description = $request->input('description');
        $todo->user_id = Auth::id();
        $todo->goal_id = $goal->id;
        $todo->done = false;
        $todo->save();

        $todo->tags()->sync($request->input('tag_ids'));

        return redirect()->route('goals.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Goal $goal, Todo $todo)
    {
        $request->validate([
            'content' => 'required',
            'description' => 'required',
        ]);

        $todo->content = $request->input('content');
        $todo->description = $request->input('description');
        $todo->user_id = Auth::id();
        $todo->goal_id = $goal->id;
        $todo->done = $request->boolean('done', $todo->done);
        $todo->save();

        // ｢完了」と｢未完了」の切替え時でない時(通常の編集時)にのみタグを変更する
        // 'done'というname属性を持つinputタグの値がフォームから送信されなかった時に処理が実行
        if (!$request->has('done')) {
            $todo->tags()->sync($request->input('tag_ids'));
        };

        return redirect()->route('goals.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     *
     */
    public function destroy(Goal $goal, Todo $todo)
    {
        $todo->delete();

        return redirect()->route('goals.index');
    }
}
