<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'subscription_type_id', 'renewed_at', 'expired_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function subscriptionType()
    {
        return $this->belongsTo(SubscriptionType::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'user_id', 'user_id');
    }
}
