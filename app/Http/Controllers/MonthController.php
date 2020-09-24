<?php

namespace App\Http\Controllers;

use App\Month;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Month as MonthResource;

class MonthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        return response()->json([
            'month' => MonthResource::collection($user->months->sortByDesc('date')),
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => ['required'],
            'start_date' => ['required', 'after:yesterday'],
            'end_date' => ['required', 'after:start_date'],

        ]);
        $date = Carbon::createFromFormat('Y-m-d', $request->start_date);

        $daysToAdd = 31;
        $date = $date->addDays($daysToAdd)->format('Y-m-d');

        $request->validate([

            'end_date' => ['required', 'after:$date'],

        ]);

        $month = new Month();
        $month->name = $request->name;
        $month->start_date = $request->start_date;
        $month->end_date = $request->end_date;
        $month->user_id = Auth::user()->id;
        $month->save();
        error_log($month);
        return response()->json([
            "month" => $month
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $month = Month::find($id);
        if (!$month) {
            return response()->json([
                'Message' => 'Item Not Found'
            ], 400);
        }
        return response()->json([
            'success' => true,
            'month' => $month
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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

        $request->validate([
            'name' => ['required'],
            'start_date' => ['required', 'after:yesterday'],
            'end_date' => ['required', 'after:start_date'],

        ]);

        $month = Month::find($id);
        if (is_null($month)) {
            return response()->json([
                'Not Found', 400
            ]);
        } else {
            $month->update($request->all());
            return response()->json([
                'month' => $month
            ], 200);
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

        $month =  Month::find($id);
        if (is_null($month)) {
            return response()->json('Item Not Found', 404);
        }
        $month->delete();
        return response()->json("Deleted Successfully!!", 200);
    }

    //============================================================================



}
