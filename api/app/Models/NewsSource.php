<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NewsSource extends Model
{
    use HasFactory;

    protected $hidden = ['created_at', 'updated_at'];

    protected $guarded = [];

    public function userInterest(): MorphOne
    {
        return $this->morphOne(UserInterest::class, 'interest');
    }
}
