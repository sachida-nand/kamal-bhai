<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catagorie extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = ['catagorie_logo', 'catagorie_name', 'status','slug'];


    public function Sluggable(): array{
        {
            return[
                'slug' => [
                    'sourse' => 'catagorie_name'
                ]
             ];
        }
    }


}
