<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminInfo extends Model
{
    use HasFactory;

    protected $table = 'admin_info';

    protected $fillable = [
        'admin_id',
        'type_of_account',
        'address',
        'account_name',
        'address',
        'billing_name',
        'billing_email',
        'billing_phone',
        'billing_code_on_invoice',
        'payment_token',
        'stax_customer_id',
        'billing_state',
        'billing_city',
        'referral',
        'referral_other'
    ];
}