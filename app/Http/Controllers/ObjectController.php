<?php

namespace App\Http\Controllers;

use App\Object;
use Illuminate\Http\Request;
use JWTAuth;

class ObjectController extends Controller
{
	protected $user;
	 
	public function __construct()
	{
	    $this->user = JWTAuth::parseToken()->authenticate();
	}

	public function index()
	{
	    return $this->user
	        ->objects()
	        ->get(['name', 'price', 'address'])
	        ->toArray();
	}

	public function show($id)
	{
	    $object = $this->user->objects()->find($id);
	 
	    if (!$object) {
	        return response()->json([
	            'success' => false,
	            'message' => 'Sorry, object with id ' . $id . ' cannot be found'
	        ], 400);
	    }
	 
	    return $object;
	}

	public function store(Request $request)
	{
	    $this->validate($request, [
	        'name' => 'required',
	        'price' => 'required|integer',
	        'address' => 'required|string'
	    ]);
	 
	    $object = new Object();
	    $object->name = $request->name;
	    $object->price = $request->price;
	    $object->quantity = $request->quantity;
	 
	    if ($this->user->objects()->save($object))
	        return response()->json([
	            'success' => true,
	            'object' => $object
	        ]);
	    else
	        return response()->json([
	            'success' => false,
	            'message' => 'Sorry, object could not be added'
	        ], 500);
	}

	public function update(Request $request, $id)
	{
	    $object = $this->user->objects()->find($id);
	 
	    if (!$object) {
	        return response()->json([
	            'success' => false,
	            'message' => 'Sorry, object with id ' . $id . ' cannot be found'
	        ], 400);
	    }
	 
	    $updated = $object->fill($request->all())
	        ->save();
	 
	    if ($updated) {
	        return response()->json([
	            'success' => true
	        ]);
	    } else {
	        return response()->json([
	            'success' => false,
	            'message' => 'Sorry, object could not be updated'
	        ], 500);
	    }
	}

	public function destroy($id)
	{
	    $object = $this->user->objects()->find($id);
	 
	    if (!$object) {
	        return response()->json([
	            'success' => false,
	            'message' => 'Sorry, object with id ' . $id . ' cannot be found'
	        ], 400);
	    }
	 
	    if ($object->delete()) {
	        return response()->json([
	            'success' => true
	        ]);
	    } else {
	        return response()->json([
	            'success' => false,
	            'message' => 'Object could not be deleted'
	        ], 500);
	    }
	}

}
