<?php
/**
 * Created by PhpStorm.
 * User: Defla
 * Date: 12-Apr-19
 * Time: 18:49
 */

namespace App\Services;

use \Illuminate\Http\Request;


interface ToDoClientInterface
{
    public function get($id);
    public function post(array $data);
    public function delete($id);
    public function put($id, array $data);
}