<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Banner extends Model
{
    use Searchable;
    protected $fillable = [
        'name',
        'sizes',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'sizes' => 'array',
        ];
    }

    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'sizes' => $this->sizes,
        ];
    }
}
