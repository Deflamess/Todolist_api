<?php

namespace App\Services;

use App\Lists;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;


class ListsService implements ListsServiceInterface
{
    /**
     * Get list by ID with tasks(todo's)
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function get($id)
    {
        // return object lists with list_name by provided id
        $list = Lists::select('list_name')->where('id', '=', $id)->first();

        // return collection of one (lists) with todo's by provided id
        $data = Lists::with('todo')->where('id', '=', $id)->get();

    /* training block */

        //return collection of many lists with todo's
        //$data = Lists::with('todo')->get();

        /* $responseData = [];
        $data->each(function($value, $key) use ($responseData) {
            $this->responseData[] = $value->list_name;
            $value->todo->each(function($value, $key) use ($responseData) {
                $this->responseData[] = $value->task_name;
                $this->responseData[] = $value->assigned_to_id;
                $this->responseData[] = $value->author_id;
            });
        });

     /**************************/

        //if list isn't in DB response 404
        if ( empty($list) ) {
            return response()->json(
                ['error' => [
                    'message' => 'List not found'
                ]], Response::HTTP_NOT_FOUND
            );
        }


        return response()->json($data);
    }

    /**
     * Return all Lists stored
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLists()
    {
        try {
            /** @var Collection $lists */
            $lists = Lists::all('id', 'list_name');

            if ($lists->isEmpty()) {
                return response()->json(
                    ['error' => [
                        'message' => 'Lists not found'
                    ]], Response::HTTP_NOT_FOUND
                );
            }

            return response()->json($lists);
        }catch (\Exception $e) {
            return $e->getMessage() ."\n";
        }
    }

    /**
     * Save new list
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function save(Request $request)
    {
        // check content type
        $contentType = $request->header('content-type');
        $method = $request->getMethod();
        if ( $method != "POST") {
            return response()->json(
                ['error' => [
                    'message' => 'Method not allowed'
                ]], Response::HTTP_METHOD_NOT_ALLOWED
            );
        }

        //if not json in request - return 409
        if ($contentType == 'application/json') {
            //$id = $request->get('id');
            $listName = $request->get('list_name');
            $result = Lists::where('list_name', '=', $listName)->first();

            //if list already in DB
            if (!empty($result)) {
                return response()->json(
                    ['error' => [
                        'message' => 'List already exists'
                    ]], Response::HTTP_CONFLICT
                );
            }

            $listToSave = [
                'list_name' => $listName,
            ];

            $createdList = Lists::create($listToSave);
            return response(null, Response::HTTP_CREATED,
                ['Location' => '/list/' . $createdList->id]
            );

        } else {
            return response()->json(
                ['error' => [
                    'message' => 'Unsupported data'
                ]], Response::HTTP_CONFLICT
            );
        }
    }

    /**
     * Delete list by ID
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse|Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function delete($id)
    {

        //$result = DB::delete("DELETE FROM lists WHERE id = $id");

        $result = Lists::destroy($id);

        if (!$result) {
            return response()->json(
                ['error' => [
                    'message' => 'List not found'
                ]], Response::HTTP_NOT_FOUND
            );
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Update list by id with array of data to be written/updated
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|Response|\Laravel\Lumen\Http\ResponseFactory
     * @throws \Exception
     */
    public function update(Request $request)
    {
        $dataToUpdate = $request->all();
        $id = $request->get('id');

        if ( ! $id )
            throw new \Exception('id not provided');

        foreach ($dataToUpdate as $key => $value ) {

            //ignore updating id column
            if($key != 'id') {
                $result = DB::update("UPDATE lists SET $key = '$value' WHERE id = $id");

                //if update didn't complete, list isn't in db or already updated
                    if ( empty($result) ) {
                    return response()->json(
                        ['error' => [
                            'message' => 'List not found or already has the same value'
                        ]], Response::HTTP_NOT_FOUND
                    );
                }
            }
        }

        return response(null, Response::HTTP_OK);
    }

}
