<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServerResponse extends Model
{
    public $timestamps = false;
    protected $fillable = ['url', 'http_code', 'total_time'];
    
    public function __construct(array $attributes = array()) { 
        parent::__construct($attributes);
    }
}
