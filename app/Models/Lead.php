<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Database\Sortable;
use App\Traits\Database\Filterable;
use App\Traits\Database\Loadable;

class Lead extends BaseModel
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
        \App\Filters\Query\ByStatus::class,
        \App\Filters\Query\WithTrashed::class,
    ];

    protected array $loadable = [
        \App\Filters\QueryLoad\Customer::class,
    ];

    public function customer(): BelongsTo {
        return $this->belongsTo(Customer::class);
    }
}
