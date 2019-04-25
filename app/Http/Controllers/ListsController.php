<?php

namespace App\Http\Controllers;

use App\Services\ListsServiceInterface;
use Illuminate\Http\Request;

class ListsController extends Controller
{
    /**
     * @var ListsServiceInterface
     */
    private $toDoList;

    public function __construct(ListsServiceInterface $toDoList)
    {
        $this->toDoList = $toDoList;
    }

    /**
     * Show All lists in DB
     * @return mixed
     */
    public function getAllLists()
    {
        return $this->toDoList->getLists();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getListById($id)
    {
        return $this->toDoList->get($id);
    }

    /**
     * Save list
     *
     * @param Request $request
     * @return mixed
     */
    public function saveList(Request $request)
    {
        return $this->toDoList->save($request);
    }

    /**
     * Delete list
     *
     * @param $id
     * @return mixed
     */
    public function deleteList($id)
    {
        return $this->toDoList->delete($id);
    }


    // todo  check if(правильно так ловить исключения? объявил в сервисах, словил в контроллере?)
    /**
     * Update list
     *
     * @param Request $request
     * @return mixed
     */
    public function updateList(Request $request)
    {
        try{
            return $this->toDoList->update($request);
        } catch (\Exception $e){
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }

}