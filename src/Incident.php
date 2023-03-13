<?php

namespace Tvup\LaravelFejlVarp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $hash
 * @property string $subject
 * @property string $data
 * @property int $occurrences
 * @property Carbon $last_seen_at
 * @property Carbon $resolved_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Incident extends Model
{
    use HasFactory;

    protected $fillable = ['hash'];

    protected $connection = 'app_api_no_prefix';

    protected $primaryKey = 'hash';

    public $incrementing = false;

    protected $casts = ['data' => 'array'];
}
