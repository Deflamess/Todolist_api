<?php

namespace App\Services;

use App\Lists;
use App\ToDo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;


class ToDoService implements ToDoServiceInterface
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

    public function getAllLists()
    {
        $lists = Lists::all('list_name');
       // dd($lists);
        if ( empty($lists) ) {
            return response()->json(
                ['error' => [
                    'message' => 'Lists not found'
                ]], Response::HTTP_NOT_FOUND
            );
        }

        return response()->json($lists);

    }

    public function save(Request $request, $id)
    {
        // TODO: Implement save() method.
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    public function update(Request $request, $id)
    {
        // TODO: Implement update() method.
    }

}
