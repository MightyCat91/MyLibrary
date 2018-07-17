<?php

namespace App\Http\Controllers;

use App\Http\Requests\SelectionAddRequest;
use App\Selections;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Validator;

class SelectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('selections.index', Selections::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("selections.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), SelectionAddRequest::rules(), SelectionAddRequest::messages());
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }
            $selection = new Selections();
            $selection->book_id = $request->book_id;
            $selection->user_id = auth()->id();
            $selection->name = $request->name;
            $selection->description = $request->description;
            $selection->save();
            foreach ($request->books as $bookID) {
                $selection->books()->attach($bookID);
            }
            return response()->json([
                'type' => 'success',
                'message' => 'Спасибо за составленную подборку.'
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Selections  $selections
     * @return \Illuminate\Http\Response
     */
    public function show(Selections $selections)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Selections  $selections
     * @return \Illuminate\Http\Response
     */
    public function edit(Selections $selections)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Selections  $selections
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Selections $selections)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Selections  $selections
     * @return \Illuminate\Http\Response
     */
    public function destroy(Selections $selections)
    {
        //
    }
}
