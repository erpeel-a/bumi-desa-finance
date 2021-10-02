<?php

namespace App\Http\Controllers;

use App\DataTables\UnitDataTable;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UnitDataTable $dataTable)
    {
        return $dataTable->render('unit.index', $this->data);
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
        $is_valid = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if ($is_valid->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $is_valid->errors()
            ]);
        }

        $unit = new Unit();
        $unit->name = $request->name;
        $unit->slug = Str::slug($request->name, '-');
        $unit->ip_address = $request->ip();
        $unit->created_by = auth()->user()->name;
        $unit->updated_by = auth()->user()->name;
        $unit->save();

        return response()->json([
            'success' =>true,
            'name' => $unit->name
        ]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Unit::destroy($id);
        return response()->json([
            'success' => true,
        ]);
    }
}
