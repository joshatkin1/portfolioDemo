<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CloudInvitations extends Model
{
    use HasFactory;

    protected $table = 'cloud_invitations';

    protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id',
        'user_id',
        'responsed',
        'response',
        'response_sent',
    ];

    public function company()
    {
        return $this->belongsTo('App\Models\Company', 'company_id', 'company_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
