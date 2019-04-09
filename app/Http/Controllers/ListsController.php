<?php

namespace App\Http\Controllers;

use App\Services\ListsServiceInterface;
use Illuminate\Http\Request;

class ListsController extends Controller
{
    private $toDoList;

    public function __construct(ListsServiceInterface $toDoList)
    {
        $this->toDoList = $toDoList;
    }


    public function getAllLists()
    {
        return $this->toDoList->getLists();
    }


    public function getListById($id)
    {
        return $this->toDoList->get($id);
    }

    public function saveList(Request $request)
    {
        return $this->toDoList->save($request);
    }

    public function deleteList($id)
    {
        return $this->toDoList->delete($id);
    }

    public function updateList(Request $request)
    {
        return $this->toDoList->update($request);
    }

}