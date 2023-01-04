<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use App\Http\Requests\BookRequest;


class BookController extends Controller
{
    //
    public function list()
    {
        $items = Book::orderBy('name', 'asc')->get();
        return view(
            'book.list',
            [
                'title' => 'Grāmatas',
                'items' => $items
            ]
        );
    }
    public function create()
    {
        $authors = Author::orderBy('name', 'asc')->get();
        $categories = Category::orderBy('name', 'asc')->get();
        return view(
            'book.form',
            [
                'title' => 'Pievienot grāmatu',
                'book' => new Book(),
                'authors' => $authors,
                'categories' => $categories,
            ]
        );
    }
    private function saveBookData(Book $book, BookRequest $request)
    {
        $validatedData = $request->validated();
        $book->fill($validatedData);
        $book->display = (bool) ($validatedData['display'] ?? false);
        if ($request->hasFile('image')) {
            $uploadedFile = $request->file('image');
            $extension = $uploadedFile->clientExtension();
            $name = uniqid();
            $book->image = $uploadedFile->storePubliclyAs(
                '/',
                $name . '.' . $extension,
                'uploads'
            );
        }
        $book->save();
    }
    public function put(BookRequest $request)
    {
        $book = new Book();
        $this->saveBookData($book, $request);
        return redirect('/books');
    }
    public function patch(Book $book, BookRequest $request)
    {
        $this->saveBookData($book, $request);
        return redirect('/books/update/' . $book->id);
    }
    public function update(Book $book)
    {
        $authors = Author::orderBy('name', 'asc')->get();
        $categories = Category::orderBy('name', 'asc')->get();
        return view(
            'book.form',
            [
                'title' => 'Rediģēt grāmatu',
                'book' => $book,
                'authors' => $authors,
                'categories' => $categories,
            ]
        );
    }
    public function delete(Book $book)
    {
        $book->delete();
        return redirect('/books');
    }
}
