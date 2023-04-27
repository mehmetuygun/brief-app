<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Library
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Book> $books
 * @property-read int|null $books_count
 * @method static \Database\Factories\LibraryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Library newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Library newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Library query()
 * @method static \Illuminate\Database\Eloquent\Builder|Library whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Library whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Library whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Library whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Library extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
