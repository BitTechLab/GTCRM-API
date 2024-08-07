<?php

use Illuminate\Foundation\Testing\DatabaseTruncation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
 
uses(TestCase::class, DatabaseTruncation::class)->in('Feature', 'Unit'); 
