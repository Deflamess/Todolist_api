<?php

namespace App\Services;

use App\Lists;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;


class ListsService implements ListsServiceInterface
{
    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function get($id)
    {
        // return object lists with list_name by provided id
        $list = Lists::select('list_name')->where('id', '=', $id)->first();

/* training block */

        // return collection of one (lists) with todo's by provided id
        $data = Lists::with('todo')->where('id', '=', $id)->get();

        //return collection of many lists with todo's
        $data = Lists::with('todo')->get();

        dd($data);

        $assignTo = [];
        $data->each(function($value, $key) use ($assignTo) {
            $assignTo[] = $value->todo->each(function($value, $key)  {
                $assignTo[] = $value->assigned_to_id;
                dump($assignTo);
            });
        });
// достается массив после ич только через $this, а так пустой, хотя мы делаем use $assignTo
        dd($assignTo);


        /**************************/

        if ( empty($list) ) {
            return response()->json(
                ['error' => [
                    'message' => 'List not found'
                ]], Response::HTTP_NOT_FOUND
            );
        }


        return response()->json($list);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLists()
    {
        $lists = Lists::all('list_name');

        if ( empty($lists) ) {
            return response()->json(
                ['error' => [
                    'message' => 'Lists not found'
                ]], Response::HTTP_NOT_FOUND
            );
        }

        return response()->json($lists);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function save(Request $request)
    {
        // check content type
        $contentType = $request->header('content-type');


        if ( $contentType == 'application/json' )
        {
            //$id = $request->get('id');
            $listName = $request->get('list_name');
            $result = Lists::where('list_name','=', $listName)->first();

            if ( !empty($result) ) {
                return response()->json(
                    ['error' => [
                        'message' => 'List already exists'
                    ]], Response::HTTP_CONFLICT
                );
            }

            $listToSave = [
                'list_name' => $listName,
            ];

            /** Model variant*/
            $createdList = Lists::create($listToSave);
            return response(null, Response::HTTP_CREATED,
                ['Location' => '/list/' . $createdList->id]
            );

        } else {
            //if not json in request - return 409
            return response()->json(
                ['error' => [
                    'message' => 'Unsupported data'
                ]], Response::HTTP_CONFLICT
            );
        }
    }

    /**
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

            //update only by id received in request
            if($key != 'id') {
                $result = DB::update("UPDATE lists SET $key = '$value' WHERE id = $id");

                //if update didn't complete, list isn't in db or already updated
                    if (empty($result)) {
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
