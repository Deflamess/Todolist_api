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

class ToDoController
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

    public function get($id)
    {
        return $this->toDo->get($id);
    }

    public function saveToDo(Request $request)
    {
        return $this->toDo->save($request);
    }
}