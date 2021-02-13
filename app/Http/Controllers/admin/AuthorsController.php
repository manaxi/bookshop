<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Author;
use Datables;

class AuthorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = Author::select('*');
            return datatables()->of($data)
                ->addColumn('actions', function ($data) {
                    return '<button type="button" class="btn btn-success btn-sm" id="getEditAuthorData" data-id="' . $data->id . '">Edit</button>
                    <button type="button" data-id="' . $data->id . '" data-toggle="modal" data-target="#DeleteAuthorModal" class="btn btn-danger btn-sm" id="getDeleteId">Delete</button>';
                })
                ->rawColumns(['actions'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.authors.index');
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

        Author::create($request->all());
        return response()->json(['success' => 'Author added successfully']);
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
        $author = Author::find($id);
        $html = '<div class="form-group">
                    <label for="Title">Title:</label>
                    <input type="text" class="form-control" name="name" id="editTitle" value="' . $author->name . '">
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
    public function update(Request $request, Author $author)
    {
        $validator = \Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails())
            return response()->json(['errors' => $validator->errors()->all()]);

        $author->update($request->all());
        return response()->json(['success' => 'Author updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Author $author)
    {
        if ($author->books->count() > 0)
            return response()->json(['error' => 'Author is in use']);
        else {
            $author->delete();
            return response()->json(['success' => 'Author deleted successfully']);
        }
    }
}
