<?php

namespace App\Models;

use App\Observers\CustomerObserver;
use App\Search\Searchable;
use App\Traits\Database\Sortable;
use App\Traits\Database\Filterable;
use App\Traits\Database\Loadable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[ObservedBy(CustomerObserver::class)]
class Customer extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'status'];
    protected $sortable = ['id', 'name', 'email', 'status'];

    protected array $filterable = [
        \App\Filters\Query\ByName::class,
        \App\Filters\Query\ByEmail::class,
        \App\Filters\Query\WithTrashed::class,
    ];

    protected array $loadable = [
        \App\Filters\QueryLoad\Lead::class,
        \App\Filters\QueryLoad\Addresses::class,
    ];

    public function addresses(): MorphMany {
        return $this->morphMany(Address::class, 'reference');
    }

    public function lead(): HasOne {
        return $this->hasOne(Lead::class);
    }
}
