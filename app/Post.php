<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Scout\Searchable;

class Post extends Authenticatable
{
    use Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'content',
        'active',
    ];

    /**
     * @var array
     */
    protected $mapping = [
        'properties' => [
            'id' => [
                'type' => 'integer',
                'index' => 'not_analyzed'
            ],
            'name' => [
                'type' => 'text',
                'analyzer' => 'english',
                'fielddata' => true
            ],
            'content' => [
                'type' => 'text',
                'analyzer' => 'english'
            ],
            'active' => [
                'type' => 'integer',
                'index' => 'not_analyzed'
            ],
            'created_at' => [
                'type' => 'integer',
                'index' => 'not_analyzed',
                'fielddata' => true
            ],
        ]
    ];

    /**
     * The attributes that can be casted to a type.
     *
     * @var array
     */
    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Filter records containing the keyword in title or content.
     *
     * @param Builder $query
     * @param string $keyword
     */
    public function scopeWhereLike(Builder $query, string $keyword) : void
    {
        $query->where(function ($q) use ($keyword) {
            $q->where('name', 'like', "%$keyword%")->orWhere('content', 'like', "%$keyword%");
        });
    }

    /**
     * Filter records to show only active ones.
     *
     * @param Builder $query
     */
    public function scopeOnlyActive(Builder $query) : void
    {
        $query->where('active', true);
    }

    /**
     * Filter records to show only active ones.
     *
     * @param Builder $query
     */
    public function scopeOnlyInactive(Builder $query) : void
    {
        $query->where('active', false);
    }

    /**
     * Sort records in alphabetical order.
     *
     * @param Builder $query
     */
    public function scopeInAlphabeticalOrder(Builder $query) : void
    {
        $query->orderBy('name');
    }

    /**
     * Get the index name for the model.
     *
     * @return string
     */
    public function searchableAs()
    {
        return config('scout.prefix') . 'posts';
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return $this->toArray();
    }
}
