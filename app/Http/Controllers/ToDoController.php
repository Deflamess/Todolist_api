<?php
/**
 * Created by PhpStorm.
 * User: Defla
 * Date: 10-Apr-19
 * Time: 14:24
 */

namespace App\Http\Controllers;


use App\Services\ToDoServiceInterface;
use Illuminate\Http\Request;

class ToDoController extends Controller
{
    protected $toDo;

    /**
     * ToDoController constructor.
     * @param ToDoServiceInterface $toDo
     */
    public function __construct(ToDoServiceInterface $toDo)
    {
        $this->toDo = $toDo;
    }

    /**
     * Get todo_task by id
     *
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        return $this->toDo->get($id);
    }

    /**
     * Store todo_task by post request
     *
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function saveToDo(Request $request)
    {
        $this->validate($request, [
            'task_name' => 'required',
            'author_id' => 'required',
            'assigned_to_id' => 'required',
            'lists_id' => 'required',
            'is_done' => 'required'
        ]);

        return $this->toDo->save($request);
    }

    /**
     * Delete todo_task by id
     *
     * @param $id
     * @return mixed
     */
    public function deleteToDo($id)
    {
        return $this->toDo->delete($id);
    }

    /**
     * Update todo_task by put request
     *
     * @param Request $request
     * @return mixed
     */
    public function updateToDo(Request $request)
    {
        return $this->toDo->update($request);
    }
}