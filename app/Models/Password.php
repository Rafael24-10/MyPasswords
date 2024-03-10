<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Password extends Model
{
    use HasFactory;

    protected $primaryKey = 'password_id';

    protected $fillable = [
        'password_name',
        'password_value',
        'user_id'   
    ];

    public function users(){
        return $this->belongsToMany(User::class);
     }
}
