<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Fee;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LibraryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $searchQuery = $request->input('search');

        $books = Book::
            when($searchQuery, function ($query, $searchQuery) {
                return $query->where(function ($subQuery) use ($searchQuery) {
                    $subQuery->where('title', 'like', '%' . $searchQuery . '%')
                        ->orWhere('isbn', 'like', '%' . $searchQuery . '%');
                });
            })
            ->paginate(6);
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
            'isbn' => 'required|string|unique:books',
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


    public function borrowForm (string $id)
    {
        $book = Book::findOrFail($id);
        return view('student.library.borrow', compact('book'));
    }

    public function borrow(Request $request, $id)
    {

        $startDate = Carbon::parse($request->input('start_date'))->format('Y-m-d');
        $endDate = Carbon::parse($request->input('end_date'))->format('Y-m-d');
        $request['start_date'] = $startDate;
        $request['end_date'] = $endDate;
        // Validate the request data
        $request->validate([
            'start_date' => ['required', 'date', 'after_or_equal:' . Carbon::now()->format('Y-m-d')],
            'end_date' => ['required', 'date', 'after:start_date'],
        ]);

        // Find the book by its ID
        $book = Book::findOrFail($id);

        // Check if the book is available
        if ($book->isAvailable()) {
            // Attach the book to the user with the start date and end date
            auth()->user()->books()->attach($book, [
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
            ]);

            return redirect()->route('student.books.index')->with('success', 'Book borrowed successfully!');
        } else {
            return redirect()->route('student.books.index')->with('error', 'The book is not available for borrowing.');
        }
    }


    public function return(Request $request, $bookId)
    {
        try {
            DB::beginTransaction();

            // Step 1: Get the book for which the fee needs to be calculated
            $book = Book::findOrFail($bookId);

            // Step 2: Check if the book is currently borrowed by the user
            $user = auth()->user();
            if (!$book->isBorrowedBy($user)) {
                throw new \Exception('Book is not borrowed by the user.');
            }

            // Step 3: Get the borrowing details for the book and user
            $borrowDetails = $book->users()->where('user_id', $user->id)->first();
            // Step 4: Get the end_date from the borrowing details
            $endDate = $borrowDetails->pivot->end_date;

            // Step 5: Check if the return date (now) is greater than the end_date
            if (Carbon::now()->greaterThan($endDate)) {
                // Step 6: Calculate the number of days the book was overdue
                $endDate = Carbon::parse($endDate);
                $numberOfDaysOverdue = $endDate->diffInDays(Carbon::now()->endOfDay());

                // Step 7: Calculate the fee amount (you can adjust the fee calculation logic as needed)
                $feeAmount = $numberOfDaysOverdue * 5;

                // Step 8: Create a new fee record
                $fee = Fee::create([
                    'facility' => 'Library',
                    'amount' => $feeAmount,
                    'description' => 'Library fee for overdue book (' . $numberOfDaysOverdue . ' days).',
                    'updated_at' => now(),
                    'created_at' => now(),
                ]);


                // Step 9: Assign the fee to the user in the pivot table fee_user
                $user->fees()->attach($fee->id);
            }

            // Step 10: Return the book by calling the returnBook method
            $book->returnBook($user);

            DB::commit();

            return redirect()->back()->with('success', 'Library fee calculated and assigned successfully!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Failed to calculate and assign library fee: ' . $e->getMessage());
        }
    }
}
