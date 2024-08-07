<?php

namespace App\Models;

use App\Search\Searchable;
use App\Traits\Database\Sortable;
use App\Traits\Database\Filterable;
use App\Traits\Database\Loadable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model
{
    use HasFactory;
    use SoftDeletes;
    // use Searchable;
    use Sortable;
    use Loadable;
    use Filterable;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setPerPage(config('repository.defaults.limit'));
    }

    // protected $fillable = [];

    // protected $sortable = [];

    // protected array $filterable = [];

    // protected array $loadable = [];

}
