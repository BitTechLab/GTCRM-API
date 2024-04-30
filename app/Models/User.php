<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\Database\Filterable;
use App\Traits\Database\Loadable;
use App\Traits\Database\Sortable;
use App\Traits\ModelChangeEventLog;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, SoftDeletes;
    use Sortable;
    use Filterable;
    use Loadable;
    // use ModelChangeEventLog;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected array $sortable = ['id', 'name'];

    protected array $filterable = [
        // \App\Filters\Query\ByName::class,
        // \App\Filters\Query\ByEmail::class,
    ];

    protected array $loadable = [
        // \App\Filters\QueryLoad\Lead::class,
        // \App\Filters\QueryLoad\Addresses::class,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
