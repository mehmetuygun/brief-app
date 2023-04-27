<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        return response()->json([
            'books' => BookResource::collection(
                Book::paginate($request->page ?? 100)
            )
        ]);
    }

    public function show(Book $book): JsonResponse
    {
        return response()->json([
            'book' => BookResource::make($book)
        ]);
    }
}
