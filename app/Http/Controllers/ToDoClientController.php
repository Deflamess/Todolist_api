<?php
/**
 * Created by PhpStorm.
 * User: Defla
 * Date: 12-Apr-19
 * Time: 21:20
 */

namespace App\Http\Controllers;


use App\Services\ToDoClientInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ToDoClientController extends Controller
{
    private $client;

    /**
     * Dependency Injection with ToDoClientInterface
     *
     * @param ToDoClientInterface $client
     */
    public function __construct(ToDoClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * Return list by id
     *
     * @param $id
     */
    public function getListById($id)
    {
       // try{
            return $this->client->get($id);
       /* } catch (\Exception $e) {
            return $e->getMessage() ."\n";
        }*/
    }

    /**
     * Stores todo_task in DB
     *
     * @param Request $request
     * @return mixed
     */
    public function saveClientToDo(Request $request)
    {
        return $this->client->post($request);
    }

    /**
     * Destroy todo_task by id
     *
     * @param $id
     * @return mixed
     */
    public function deleteClientToDo($id)
    {
        return $this->client->delete($id);
    }

    /**
     * Updates todo_task by provided values with put method
     *
     * @param Response $request
     * @return mixed
     */
    public function updateClientToDo(Request $request)
    {
        return $this->client->put($request);
    }
}