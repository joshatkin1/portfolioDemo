<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Company;

class CloudSubscription extends Model
{
    use HasFactory;

    protected $table = 'cloud_subscriptions';
    protected $primaryKey = 'id';

    protected $fillable = [
        'company_id',
        'subscription_name',
    ];

    final public function company(){
        $this->belongsTo('App\Models\Company','company_id', 'company_id');
    }

}
