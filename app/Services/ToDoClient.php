<?php


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
        //$this->postData = $this->client->request();
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
         try{
            $requestedData = $this->client->request('GET','http://127.0.0.1:8000/list/'.$id);

            if ($requestedData->getStatusCode() != Response::HTTP_OK) {
                throw new \Exception('Error' . $requestedData->getStatusCode());
            }

            $content = $requestedData->getBody()->getContents();
            return json_decode($content, true);
        } catch (\Exception $e) {
            return $e->getMessage() ."\n";
        }
    }

    /**
     * Save todos into DB
     *
     * @param Request $request
     * @return Response|\Laravel\Lumen\Http\ResponseFactory|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function post(Request $request)
    {
            $data = $request->all();

            $postData = $this->client->request('POST','http://127.0.0.1:8000/todo',
               [
                   'json' => $data,
               ]
            );

            return response(null, Response::HTTP_CREATED, [
                "Location" => $postData->getHeaderLine('Location')
            ]);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse|Response|\Laravel\Lumen\Http\ResponseFactory|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete($id)
    {
        try{
            $data = $this->client->request('DELETE', 'http://127.0.0.1:8000/todo/' . $id);

            if(!$data){
                return response()->json(
                    ['error' => [
                        'message' => 'ToDo task not found'
                    ]], Response::HTTP_NOT_FOUND
                );
            };
            return response(null, Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return $e->getMessage() ."\n";
        }
    }

    /**
     * Updates client's request todo_task in DB
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|Response|\Laravel\Lumen\Http\ResponseFactory|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function put(Request $request)
    {
        try{
            //$id = $request->get('id');
            $data = $request->all();

            $result = $this->client->request('PUT', 'http://127.0.0.1:8000/todo/',
                [
                    'json' => $data
                ]
            );

            if(!$result){
                return response()->json(
                    ['error' => [
                        'message' => 'ToDo task not found'
                    ]], Response::HTTP_NOT_FOUND
                );
            };
            return response(null, Response::HTTP_OK);
        } catch (\Exception $e) {
            return $e->getMessage() ."\n";
        }
    }

}