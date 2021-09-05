<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'ip_address', 'created_by', 'updated_by'
    ];

    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}
