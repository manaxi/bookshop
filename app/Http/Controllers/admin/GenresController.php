<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Genre;
use Yajra\DataTables\Contracts\DataTable;

class GenresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Genre::select('*');
            return datatables()->of($data)
                ->addColumn('actions', function ($data) {
                    return '<button type="button" class="btn btn-success btn-sm" id="getEditGenreData" data-id="' . $data->id . '">Edit</button>
                    <button type="button" data-id="' . $data->id . '" data-toggle="modal" data-target="#DeleteGenreModal" class="btn btn-danger btn-sm" id="getDeleteId">Delete</button>';
                })
                ->rawColumns(['actions'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.genres.index');
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails())
            return response()->json(['errors' => $validator->errors()->all()]);

        Genre::create($request->all());
        return response()->json(['success' => 'Genre added successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $genre = Genre::find($id);
        $html = '<div class="form-group">
                    <label for="Title">Title:</label>
                    <input type="text" class="form-control" name="name" id="editTitle" value="' . $genre->name . '">
                </div>';

        return response()->json(['html' => $html]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Genre $genre)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails())
            return response()->json(['errors' => $validator->errors()->all()]);

        $genre->update($request->all());
        return response()->json(['success' => 'Genre updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Genre $genre)
    {
        if ($genre->books->count() > 0)
            return response()->json(['error' => 'Genre is in use']);
        else {
            $genre->delete();
            return response()->json(['success' => 'Genre deleted successfully']);
        }
    }
}
