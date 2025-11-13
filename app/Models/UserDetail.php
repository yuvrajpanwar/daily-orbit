<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class UserDetail extends Model
{
    protected $fillable = ['user_id', 'about', 'address', 'gender', 'age'];
    protected $primaryKey = 'user_id'; 
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
