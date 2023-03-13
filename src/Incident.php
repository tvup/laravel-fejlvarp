<?php

namespace Tvup\LaravelFejlVarp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory;

    protected $connection = 'app_api_no_prefix';

    protected $primaryKey = 'hash';

    public $incrementing = false;

    protected $casts = ['data' => 'array'];
}
