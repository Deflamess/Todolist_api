<?php

namespace App\Services;

use Illuminate\Http\Request;

interface ToDoServiceInterface
{
    public function get($id);
    public function getAllLists();
    public function save(Request $request, $id);
    public function delete($id);
    public function update(Request $request, $id);
}