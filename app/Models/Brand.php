<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Brand extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = ['brand_name', 'brand_logo', 'status','slug'];

    public function Sluggable(): array
    { {
            return [
                'slug' => [
                    'sourse' => 'brand_name'
                ]
            ];
        }
    }
}
