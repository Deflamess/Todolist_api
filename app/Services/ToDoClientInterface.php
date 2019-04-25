<?php

namespace App\Services;

use \Illuminate\Http\Request;


interface ToDoClientInterface
{
    public function get($id);
    public function post(Request $request);
    public function delete($id);
    public function put($id, Request $request);
}
