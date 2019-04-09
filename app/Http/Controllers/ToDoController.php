<?php

namespace App\Http\Controllers;

use App\Services\ToDoServiceInterface;

class ToDoController extends Controller
{
    private $toDoList;

    public function __construct(ToDoServiceInterface $toDoList)
    {
        $this->toDoList = $toDoList;
    }

    public function getLists()
    {
        return $this->toDoList->getAllLists();
    }

    public function getList($id)
    {
        return $this->toDoList->get($id);
    }

}