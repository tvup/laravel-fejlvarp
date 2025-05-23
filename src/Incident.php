<?php

namespace Tvup\LaravelFejlvarp;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Tvup\LaravelFejlvarp\Database\Factories\IncidentFactory;

/**
 * @property string $hash
 * @property string $subject
 * @property array<string, int|string|array<string, string|array<string, string>>>|null $data
 * @property int $occurrences
 * @property Carbon $last_seen_at
 * @property Carbon|null $resolved_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Incident extends Model
{
    /** @use HasFactory<IncidentFactory> */
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
