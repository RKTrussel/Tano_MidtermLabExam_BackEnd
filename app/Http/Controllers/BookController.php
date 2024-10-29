<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::all();
        return response()->json([
            'status' => 200,
            'books' => $books,
        ]);
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
        try {
            $validatedData = $request->validate([
                'title' => ['required', 'max:255'],
                'author' => ['required', 'max:255'],
                'published_year' => ['required', 'numeric'],
                'genre' => ['required', 'max:255'],
                'description' => ['required'],
            ], [
                'title.required' => 'Please enter a title of the book.',
                'title.max' => 'The title must not exceed 255 characters.',
                'published_year.required' => 'Please enter the published year of the book.',
                'published_year.numeric' => 'The year must be a numerical value.',
                'genre.required' => 'Please enter the genre of the book',
                'genre.max' => 'The genre of the book must not exceed 255 characters.',
                'description.required' => 'Please enter a description of the book.',
            ]);

            Book::create($validatedData);
            return response()->json($validatedData, 200);

        } catch(ValidationException $e) {
            return response()->json([
                'validationErrors' => $e->errors(),
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $viewBook = Book::find($id);

        return response()->json($viewBook, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
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
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'title' => ['required', 'max:255'],
                'author' => ['required', 'max:255'],
                'published_year' => ['required', 'numeric'],
                'genre' => ['required', 'max:255'],
                'description' => ['required'],
            ], [
                'title.required' => 'Please enter a title of the book.',
                'title.max' => 'The title must not exceed 255 characters.',
                'author.required' => "Please enter the author of the book. ",
                'author.max' => "The name of the author must not exceced 255 characters. ",
                'published_year.required' => 'Please enter the published year of the book.',
                'published_year.numeric' => 'The year must be a numerical value.',
                'genre.required' => 'Please enter the genre of the book',
                'genre.max' => 'The genre of the book must not exceed 255 characters.',
                'description.required' => 'Please enter a description of the book.',
            ]);

            $updateItem = Book::find($id);
            $updateItem->title = $validatedData['title'];
            $updateItem->author = $validatedData['author'];
            $updateItem->published_year = $validatedData['published_year'];
            $updateItem->genre = $validatedData['genre'];
            $updateItem->description = $validatedData['description'];
            $updateItem->save();

            return response()->json($updateItem, 200);

        } catch(ValidationException $e) {
            return response()->json([
                'validationErrors' => $e->errors(),
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bookToDelete = Book::find($id);
        $bookToDelete->delete();

        return response()->json(200);
    }
}
