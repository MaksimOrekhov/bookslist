<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Book;
use App\Http\Resources\Book as BookResource;

class BooksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get books
        $books = Book::orderBy('created_at', 'asc')->paginate(5);

        // Return collection of books as a resource
        return BookResource::collection($books);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $book = $request->isMethod('put') ? Book::findOrFail($request->book_id) : new Book;

        $book->id = $request->input('book_id');
        $book->name = $request->input('name');
        $book->author = $request->input('author');
        $book->page_number = $request->input('page_number');

        if ($book->save()) {
            return new BookResource($book);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get book
        $book = Book::findOrFail($id);

        // Return single book as a resource
        return new BookResource($book);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Get book
        $book = Book::findOrFail($id);

        if ($book->delete()) {
            return new BookResource($book);
        }
    }
}
