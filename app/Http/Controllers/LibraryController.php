<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::paginate();
        return view('book.index', compact('books'));
    }
    public function index2()
    {
        $books = Book::paginate();
        return view('book.index2', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('book.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $publication_date = Carbon::parse($request->input('start_date'))->format('Y-m-d');
        $request['publication_date'] = $publication_date;

        // Validate the request data
        $request->validate([
            'title' => 'required|string',
            'isbn' => 'required|string',
            'author' => 'required|string',
            'category' => 'required|string',
            'publication_date' => 'required|date',
            'description' => 'nullable|string',
           // 'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
/*
        // Handle the cover image (if provided)
        $coverImage = null;
        if ($request->hasFile('cover_image')) {
            $coverImage = $request->file('cover_image')->store('book_covers', 'public');
        }
*/

        // Create a new book with the validated data
        $book = Book::create([
            'title' => $request->input('title'),
            'isbn' => $request->input('isbn'),
            'author' => $request->input('author'),
            'category' => $request->input('category'),
            'publication_date' => $request->input('publication_date'),
            'description' => $request->input('description'),
           // 'cover_image' => $coverImage,
        ]);

        // Redirect back to the books list with a success message
        return redirect()->route('books.index')->with('success', 'Book created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $book = Book::findOrFail($id);
        return view('book.update', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $publication_date = Carbon::parse($request->input('start_date'))->format('Y-m-d');
        $request['publication_date'] = $publication_date;

        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'required|string',
            'isbn' => 'required|string',
            'author' => 'required|string',
            'category' => 'required|string',
            'publication_date' => 'required|date',
            'description' => 'nullable|string',
            // 'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        // Retrieve the book model
        $book = Book::findOrFail($id);

        // Update the book with the validated data
        $book->update($validatedData);
        // Redirect back to the book details page with a success message
        return redirect()->route('books.index', $book->id)->with('success', 'Book updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( $id)
    {
        /*
        // Delete the book and its cover image (if exists) from storage
        if ($book->cover_image) {
            \Storage::disk('public')->delete($book->cover_image);
        }
*/

        $book=Book::findOrfail($id);
        // Delete the book record from the database
        $book->delete();

        // Redirect back to the books list with a success message
        return redirect()->back()->with('success', 'Book deleted successfully!');
    }
}
