<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginLog extends Model
{
    protected $fillable = [
        'user_id',
        'email',
        'ip_address',
        'user_agent',
        'login_method',
        'is_successful',
        'failure_reason',
        'logged_in_at',
    ];

    protected $casts = [
        'is_successful'=> 'boolean',
        'logged_in_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
