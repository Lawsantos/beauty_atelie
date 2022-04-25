<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'cost'];

    public function cost(): Attribute
    {
        return Attribute::make(
            get: fn($value) => number_format($value / 100 ,2 ,',', '.'),
            set: fn($value) => preg_replace("/\D+/", "", $value)
        );
    }

    public function reserves()
    {
        return $this->HasMany(Reserve::class);
    }
}
