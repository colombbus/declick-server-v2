<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Circuit;
use App\CircuitNode;

class CircuitController extends Controller
{
    public function index()
    {
        return Circuit::all();
    }

    public function create(Request $request)
    {
        $values = array_only($request->input(), [
            'name',
            'short_description',
            'description'
        ]);

        $circuit = Circuit::create($values);

        $rootNode = $circuit->nodes()->create([
            'name' => null,
            'link' => null
        ]);

        $circuit->rootNode()->associate($rootNode);

        $circuit->save();

        return response($circuit, 201, [
            'Location' => route('circuits', ['id' => $circuit->id])
        ]);
    }

    public function show($id)
    {
        return Circuit::findOrFail($id);
    }

    public function delete($id)
    {
        $circuit = Circuit::findOrFail($id);

        $circuit->delete();

        return response('', 204);
    }
}
