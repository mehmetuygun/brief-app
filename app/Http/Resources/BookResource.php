<?php

namespace App\Http\Resources;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var Book $book */
        $book = $this;

        return [
            'id' => $book->id,
            'title' => $book->title,
            'status' => $book->status,
            'borrowed_by' => $book?->user?->name
        ];
    }
}
