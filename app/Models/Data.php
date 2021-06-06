<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Data extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $appends = ["delay"];

    protected $fillable = [
        "name", "value", "hostname", "namespace", "identifier",
        "arrived_at", "sent_at", "received_at"
    ];

    protected $casts = [
        "name" => 'string', 'value' => 'boolean',
        'hostname' => 'string', 'namespace' => 'integer',
        'identifier' => 'integer', 'arrived_at' => 'datetime',
        'sent_at' => 'datetime', 'received_at' => 'datetime'
    ];

    /**
     * Data constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $attributes['received_at'] = $attributes['received_at'] ?? now();
        parent::__construct($attributes);
    }

    public function getDelayAttribute()
    {
	return $this->received_at->diffInSeconds($this->sent_at);
    }
}
