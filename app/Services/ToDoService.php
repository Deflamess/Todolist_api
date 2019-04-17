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
use Illuminate\Support\Facades\DB;

class ToDoService implements ToDoServiceInterface
{
    /**
     * Count if data was updated
     *
     * @var int
     */
    private $updated = 0;

    /**
     * Get todo_task by id
     *
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function get($id)
    {
        $list = ToDo::select('task_name', 'author_id', 'assigned_to_id', 'lists_id', 'is_done')
                ->where('id', '=', $id )
            ->first();

        //$list = ToDo::with('lists')->get();
        //dd($list);

        return response()->json($list);
    }

    /**
     * Store todo_task into DB
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function save(Request $request)
    {
        // check content type
        $contentType = $request->header('content-type');

        //if not json in request - return 400
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
        $dataToDestroy = ToDo::destroy($id);

        if (!$dataToDestroy) {
            return response()->json(
                ['error' => [
                    'message' => 'ToDo task not found'
                ]], Response::HTTP_NOT_FOUND
            );
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function update(Request $request)
    {
        $data = $request->all();
        $id = $request->get('id');

        //Eloquent method
        foreach ($data as $key => $value) {
                $this->result = ToDo::where('id', $id)
                    ->update([$key => $value]);

                //increments updated if data had updated
                if( !empty($this->result) )
                    $this->updated ++;
        }

        //Facade method
           /* foreach ($data as $key => $value) {

            //ignore id column
            if ( $key != 'id' ) {
                $this->result = DB::update("UPDATE to_dos SET $key = '$value' WHERE id = $id");

                //set updated to true if data had updated
                if( !empty($this->result) ) {
                    $this->updated++;
                }

            }}*/

            //if nothing updated response 404
            if ( $this->updated <= 1 ) {
                return response()->json(
                    ['error' => [
                        'message' => 'ToDo task not found or has the same value'
                    ]], Response::HTTP_NOT_FOUND
                );
            }



        return response(null, Response::HTTP_OK);
    }

}