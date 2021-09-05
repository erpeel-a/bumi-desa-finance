<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'unit_id', 'description', 'date', 'income', 'expense', 'balance', 'ip_address', 'created_by', 'updated_by'
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
