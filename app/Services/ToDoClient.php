<?php
/**
 * Created by PhpStorm.
 * User: Defla
 * Date: 12-Apr-19
 * Time: 18:51
 */

namespace App\Services;


use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ToDoClient implements ToDoClientInterface
{
    protected $client;
    protected $postData;

    /**
     * Guzzlehttp client object
     */
    public function __construct()
    {
        $this->client = new Client();
        $this->postData = $this->client->request();
    }

    /**
     * Get list of todos by list id
     *
     * @param $id
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get($id)
    {
        $requestedData = $this->client->request('GET','http://127.0.0.1:8000/list/'.$id);

        if ($requestedData->getStatusCode() != Response::HTTP_OK) {
            throw new \Exception('Error' . $requestedData->getStatusCode());
        }

        $content = $requestedData->getBody()->getContents();
        return json_decode($content, true);
    }

    //??? чтобы записать tODO я передаю через газл клиент запрос пост с JSON объектом, перехожу на ссылку, где идет
    // запись в бд(ToDoService), данных из запроса, если такого tODO уже нет в БД.
    // как достать данные из клиента? обработать их в конструкторе и потом отдать в метод пост где и отправить пост
    // на ToDoService который уже пишет в БД?
    public function post(array $data)
    {
       $postData = $this->client->request('POST','http://127.0.0.1:8000/todo');

       $postContent = $postData->getBody()->getContents();
       return json_decode($postContent, true);
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    public function put($id, array $data)
    {
        // TODO: Implement put() method.
    }

}