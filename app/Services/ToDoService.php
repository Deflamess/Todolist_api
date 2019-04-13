<?php
/**
 * Created by PhpStorm.
 * User: Defla
 * Date: 10-Apr-19
 * Time: 13:44
 */

namespace App\Services;


use App\ToDo;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ToDoService implements ToDoServiceInterface
{

    public function get($id)
    {
        $list = ToDo::select('task_name', 'author_id', 'assigned_to_id', 'is_done')->where('id', '=', $id )->first();
        //$list = ToDo::with('lists')->get();
        //dd($list);

        return response()->json($list);
    }


    public function save(Request $request)
    {
        // check content type
        $contentType = $request->header('content-type');

        //if not json in request - return 409
        if ( $contentType == 'application/json' )
        {
            //$id = $request->get('id');
            $taskName = $request->get('task_name');
            $result = ToDo::where('task_name','=', $taskName)->first();

            //if ToDo already in DB
            if ( !empty($result) ) {
                return response()->json(
                    ['error' => [
                        'message' => 'Todo already exists'
                    ]], Response::HTTP_CONFLICT
                );
            }

            $toDoToSave = $request->all();

            $createdToDo = ToDo::create($toDoToSave);
            return response(null, Response::HTTP_CREATED,
                ['Location' => '/todo/' . $createdToDo->id]
            );

        } else {
            return response()->json(
                ['error' => [
                    'message' => 'Unsupported data'
                ]], Response::HTTP_BAD_REQUEST
            );
        }
    }

    public function delete($id)
    {
        // TODO: Implement delete() method.
    }

    public function update(Request $request)
    {
        // TODO: Implement update() method.
    }

}