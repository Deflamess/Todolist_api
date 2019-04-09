<?php

namespace App\Services;

use App\Lists;
use App\ToDo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;


class ListsService implements ListsServiceInterface
{
    public function get($id)
    {
        $list = Lists::select('list_name')->where('id', '=', $id)->first();


        if ( empty($list) ) {
            return response()->json(
                ['error' => [
                    'message' => 'List not found'
                ]], Response::HTTP_NOT_FOUND
            );
        }


        return response()->json($list);
    }

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
    //TODO
    public function update(Request $request)
    {
        $dataToUpdate = $request->all();
        $id = $request->get('id');

        foreach ($dataToUpdate as $key => $value ) {
            //update only by id received in request
            if($key != 'id') {
                $result = DB::update("UPDATE lists SET $key = '$value' WHERE id = $id");

                    if (empty($result)) {
                    return response()->json(
                        ['error' => [
                            'message' => 'List not found'
                        ]], Response::HTTP_NOT_FOUND
                    );
                }
            }
        }

        return response(null, Response::HTTP_OK);
    }

}
