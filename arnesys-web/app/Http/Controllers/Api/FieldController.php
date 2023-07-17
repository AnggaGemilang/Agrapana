<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Field;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    public function index()
    {
        return Field::latest()->paginate(5);
    }

    public function store(Request $request)
    {
        return Field::create($request->all());
    }

    public function show(Field $field)
    {
        return $field;
    }

    public function update(Request $request, Field $field)
    {
        $field->update($request->all());
        $field->refresh();
        return $field;
    }

    public function destroy(Field $field)
    {
        return $field->delete();
    }
}
