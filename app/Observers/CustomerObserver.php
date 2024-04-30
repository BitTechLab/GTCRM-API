<?php

namespace App\Observers;

use App\Jobs\ProcessElasticsearchSync;
use App\Models\Customer;
use App\Traits\ElasticsearchSync;

class CustomerObserver
{
    use ElasticsearchSync;

    /**
     * Handle the Customer "created" event.
     */
    public function created(Customer $customer): void
    {
        ProcessElasticsearchSync::dispatch($customer);
    }

    /**
     * Handle the Customer "updated" event.
     */
    public function updated(Customer $customer): void
    {
        ProcessElasticsearchSync::dispatch($customer);
    }

    /**
     * Handle the Customer "deleted" event.
     */
    public function deleted(Customer $customer): void
    {
        //
    }

    /**
     * Handle the Customer "restored" event.
     */
    public function restored(Customer $customer): void
    {
        //
    }

    /**
     * Handle the Customer "force deleted" event.
     */
    public function forceDeleted(Customer $customer): void
    {
        //
    }
}
