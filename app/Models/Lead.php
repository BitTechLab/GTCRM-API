<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lead extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'customer_id', 'source', 'status'];
    protected $sortable = ['id', 'name', 'email', 'customer_id', 'status'];

    protected array $filterable = [
        \App\Filters\Query\ByName::class,
        \App\Filters\Query\ByEmail::class,
        \App\Filters\Query\ByCustomer::class,
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
