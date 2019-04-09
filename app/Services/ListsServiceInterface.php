<?php

namespace App\Services;

use Illuminate\Http\Request;

interface ListsServiceInterface
{
    public function get($id);
    public function getLists();
    public function save(Request $request);
    public function delete($id);
    public function update(Request $request);
}