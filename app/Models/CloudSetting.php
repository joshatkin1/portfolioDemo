<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Company;

class CloudSetting extends Model
{
    use HasFactory;

    protected $table = 'cloud_settings';
    protected $primaryKey = 'id';

    protected $fillable = [
        'company_id',
        'modify_employees',
        'manage_storage',
        'create_global_chats',
        'run_schedule',
        'mfa_login',
        'fresh_password_period',
        'storage_limit_alert',
        'edit_employees',
        'create_company_chats',
        'create_tasks',
        'create_projects',
        'create_customers',
        'edit_customers',
        'view_customer_billing',
        'customer_account_mfa',
        'crm_term',
        'crm_transaction_term',
        'recruitment_access_level',
        'recruitment_connect_level',
        'manage_job_adverts',
        'cloud_chat_storage',
        'projects_storage',
        'document_storage',
        'supplier_access',
        'suppliers_managing',
    ];

    final public function company(){
        $this->belongsTo('App\Models\Company','company_id', 'company_id');
    }
}
