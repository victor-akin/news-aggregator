<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Source extends Model
{
    use HasFactory;

    public function getApiHandler()
    {
        $handler = "App\\Services\\ApiHandlers\\{$this->handler}";

        if(class_exists($handler)) return new $handler;

        throw new \Exception('There is no handler or strategy for this source');
    }
}
