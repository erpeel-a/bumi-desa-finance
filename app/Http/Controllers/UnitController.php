<?php

namespace App\Http\Controllers;

use App\DataTables\UnitDataTable;
use App\Models\Report;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Unit::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="dropdown">
                                    <button class="btn btn-outline-secondary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <button id="detail-unit" class="dropdown-item" onclick="OpenDetailUnit(' . $row->id . ')">Edit</button>
                                        <button id="delete-unit" class="dropdown-item" onclick="destroyUnit(' . $row->id . ')">Delete</button>
                                    </div>
                                </div>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('unit.index', $this->data);
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
            'name' => 'required|unique:units'
        ]);

        $id = request()->input('id');

        if ($is_valid->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $is_valid->errors()
            ]);
        }
        if ($id) {
            $data = Unit::where('id', $id)->update([
                'name' => $request->name,
                'slug' => Str::slug($request->name, '-'),
                'updated_by' => auth()->user()->name,
                'ip_address' => $request->ip()
            ]);
        } else {
            $data = Unit::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name, '-'),
                'created_by' => auth()->user()->name,
                'updated_by' => auth()->user()->name,
                'ip_address' => $request->ip()
            ]);
        }

        return response()->json([
            'success' => true,
            'result' => 'success',
            'data' => $data
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $id = request()->input('id');
        $data = Unit::findOrfail($id);
        return response()->json([
            'success' => true,
            'result' => 'success',
            'data' => $data
        ]);
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

    public function unit(Request $request, Unit $unit)
    {
        $this->unit = $unit;
        if ($request->ajax()) {
            $data = Report::where('unit_id', $unit->id)->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('date', function ($row) {
                    return Carbon::parse($row->date)->format('d M Y');
                })
                ->editColumn('income', function ($row) {
                    return "Rp " . number_format($row->income, 2, ',', '.');
                })
                ->editColumn('expense', function ($row) {
                    return "Rp " . number_format($row->expense, 2, ',', '.');
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<div class="dropdown">
                                    <button class="btn btn-outline-secondary" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        <button id="detail-unit" class="dropdown-item" onclick="OpenDetailUnit(' . $row->id . ')">Edit</button>
                                        <button id="delete-unit" class="dropdown-item" onclick="destroyUnit(' . $row->id . ')">Delete</button>
                                    </div>
                                </div>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('unit.unit', $this->data);
    }

    public function unitCreate(Unit $unit)
    {
        $this->unit = $unit;
        return view('unit.unit-create', $this->data);
    }
    
    public function UnitStore(Request $request, Unit $unit)
    {
        $request->validate([
            'date' => 'required|date|unique:reports',
            'income' => 'numeric',
            'expense' => 'numeric'
        ]);
        
        Report::create([
            'unit_id' => $unit->id,
            'description' => $request->description,
            'date' => $request->date,
            'income' => $request->income,
            'expense' => $request->expense,
            'ip_address' => $request->ip(),
            'created_by' => auth()->user()->name,
            'updated_by' => auth()->user()->name
        ]);

        return redirect()->route('unit.index', $unit->slug)->with('success', 'Berhasil input data unit.');
    }
}
