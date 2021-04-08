<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CloudAccount extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $fillable = [
        "active_subscription",
        "storage_amount",
        "subscribed_date",
        "subscription_cost",
    ];
}
