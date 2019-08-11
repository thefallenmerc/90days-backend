<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Validator;
use App\Resolution;


class ResolutionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(['success' => Auth::user()->resolutions()->latest()->get()], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "title" => "required|string",
            "description" => "required|string",
            "deadline" => "required|date",
            "completed" => "required|in:1,2,3",
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();
        $data['user_id'] = Auth::user()->id;
        $data['deadline'] = \Carbon\Carbon::parse($request->deadline)->format("Y-m-d") . " 00:00:00";
        $resolution = Resolution::create($data);
        // $resolution->completed = (int) $request->completed;
        return response()->json(['success' => $resolution], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            "title" => "required|string",
            "description" => "required|string",
            "completed" => "required|in:1,2,3",
        ]);
        if (($resolution = Auth::user()->resolutions()->whereId($id)->first()) != null) {
            $resolution->update($validator->validated());
            return response()->json(['success' => $resolution], 200);
        } else {
            return response()->json(['errors' => 'Resolution not found!'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $resolution = Auth::user()->resolutions()->whereId($id)->first();
        $response = $resolution->toArray();
        $resolution->delete();
        return response()->json(['success' => $resolution], 200);
    }
}
