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

class ToDoClientController
{
    protected $client;

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
     */
    public function getListById($id)
    {
        try{
            return $this->client->get($id);
        } catch (\Exception $e) {
            echo $e->getMessage() ."\n";
        }
    }


    public function saveToDo(array $data)
    {
        return $this->client->post($data);
    }
}