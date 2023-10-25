<?php

namespace Tvup\LaravelFejlvarp;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string $hash
 * @property string $subject
 * @property array|null $data
 * @property int $occurrences
 * @property Carbon $last_seen_at
 * @property Carbon|null $resolved_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Incident extends Model
{
    use HasFactory;

    protected $fillable = ['hash'];

    protected $primaryKey = 'hash';

    public $incrementing = false;

    /**
     * @var array<string, string>
     *
     * Casts for json-format
     */
    protected $casts = [
        'data' => 'array',
        'last_seen_at' => 'datetime',
        'resolved_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
