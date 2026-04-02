<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory;
    protected $fillable = [
        'external_id',
        'province_id',
        'name',
    ];

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

     public function getApiResponseAttribute()
    {
        return [
            'uuid' => $this->uuid,
            'name' => $this->name,
            'province' => $this->province->only('uuid', 'name'),
            'external_id' => $this->external_id,
        ];
    }
}
