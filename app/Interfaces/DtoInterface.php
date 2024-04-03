<?php

namespace App\Interfaces;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;


interface DtoInterface
{
    static function fromRequest(RequestInterface $request);
}
