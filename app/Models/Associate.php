<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Associate
 *
 * @property int $id
 * @property int $library_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Associate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Associate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Associate query()
 * @method static \Illuminate\Database\Eloquent\Builder|Associate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Associate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Associate whereLibraryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Associate whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Associate whereUserId($value)
 * @mixin \Eloquent
 */
class Associate extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'library_id'];
}
