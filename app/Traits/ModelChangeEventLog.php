<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait ModelChangeEventLog
{
    public static function boot()
    {
        parent::boot();

        static::creating(function ($item) {
            Log::info('Creating event call: ' . $item);
        });

        static::created(function ($item) {
            Log::info('Created event call: ' . $item);
        });

        static::updating(function ($item) {
            Log::info('Updating event call: ' . $item);
        });

        static::updated(function ($item) {
            Log::info('Updated event call: ' . $item);
        });

        static::deleted(function ($item) {
            Log::info('Deleted event call: ' . $item);
        });
    }
}
