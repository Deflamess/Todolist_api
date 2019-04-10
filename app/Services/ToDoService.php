<?php
/**
 * Created by PhpStorm.
 * User: Defla
 * Date: 10-Apr-19
 * Time: 13:44
 */

namespace App\Services;


use App\ToDo;
use Illuminate\Http\Request;

class ToDoService implements ToDoServiceInterface
{

    public function get($id)
    {
        $list = ToDo::select('task_name', 'author_id', 'is_done')->where('id', '=', $id )->first();
        //$list = ToDo::with('lists')->get();
        dd($list);
        return response()->json($list);
    }

    public function save(Request $request)
    {
        // TODO: Implement save() method.
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    public function update(Request $request)
    {
        // TODO: Implement update() method.
    }

}