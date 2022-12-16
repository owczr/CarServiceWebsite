<?php

namespace App\Http\Controllers;

use App\Helpers\HasEnsure;
use App\Models\Book;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class BookController extends Controller
{
    use HasEnsure;

    public function index(): View
    {
        $books = Book::all();

        return view('books.index')->withBooks($books);
    }

    public function create(): View
    {
        return view('books.create');
    }

    private function updateAndSave(Book $book, Request $request): void
    {
        $book->isbn = $this->ensureIsString($request->isbn);
        $book->title = $this->ensureIsString($request->title);
        $book->description = $this->ensureIsString($request->description);
        $book->save();
    }

    /**
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'isbn' => 'required|digits:13',
            'title' => 'required',
            'description' => 'required'
        ]);

        $book = new Book();
        $this->updateAndSave($book, $request);

        return redirect()->route('books.show', $book);
    }

    public function show(Book $book): View
    {
        return view('books.show')->withBook($book);
    }

    public function edit(Book $book): View
    {
        return view('books.edit')->withBook($book);
    }

    /**
     * @throws ValidationException
     */
    public function update(Request $request, Book $book): RedirectResponse
    {
        $this->validate($request, [
            'isbn' => 'required|digits:13',
            'title' => 'required',
            'description' => 'required'
        ]);

        $this->updateAndSave($book, $request);

        return redirect()->route('books.show', $book);
    }

    public function destroy(Book $book): RedirectResponse
    {
        $book->delete();

        return redirect()->route('books.index');
    }
}
