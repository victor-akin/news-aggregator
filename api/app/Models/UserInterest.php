<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserInterest extends Model
{
    use HasFactory;

    protected $hidden = ['interest_type'];

    protected $guarded = [];

    public function parentInterest(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'interest_type', 'interest_id');
    }
}
