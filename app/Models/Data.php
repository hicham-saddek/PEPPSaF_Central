<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Data extends Model
{
    use HasFactory, SoftDeletes;

    protected $appends = ["receptionDelay", "protocolDelay"];

    protected $fillable = [
        "name", "value", "hostname", "namespace", "identifier",
        "arrived_at", "sent_at", "received_at", "over"
    ];

    protected $casts = [
        "name" => 'string', 'value' => 'boolean',
        'hostname' => 'string', 'namespace' => 'integer',
        'identifier' => 'integer', 'arrived_at' => 'string',
        'sent_at' => 'string', 'received_at' => 'string', "over" => "string"
    ];

    /**
     * Data constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $attributes['received_at'] = now()->setTimezone("Europe/Paris")->toISOString();
        parent::__construct($attributes);
    }

    public function getReceptionDelayAttribute()
    {
        return (new Carbon($this->received_at))->diffInMicroSeconds(new Carbon($this->sent_at));
    }

    public function getProtocolDelayAttribute()
    {
        $builder = Data::where('arrived_at', $this->arrived_at)->where('hostname', $this->hostname)->where('identifier', $this->identifier)->where('namespace', $this->namespace);

        $sibling = $builder->first();
        if(!is_null($sibling)) return (new Carbon($sibling->received_at))->diffInMicroSeconds(new Carbon($this->received_at));
        return "Not received yet";
    }
}
