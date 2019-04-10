<?php
/**
 * Created by PhpStorm.
 * User: Defla
 * Date: 10-Apr-19
 * Time: 14:24
 */

namespace App\Http\Controllers;


use App\Services\ToDoServiceInterface;

class ToDoController
{
    protected $toDo;

    public function __construct(ToDoServiceInterface $toDo)
    {
        $this->toDo = $toDo;
    }

    public function get($id)
    {
        return $this->toDo->get($id);
    }
}