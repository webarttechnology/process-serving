<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class serve extends Model
{
    use HasFactory;
    protected $fillable = ['role_type', 'order_id', 'p_t_serve', 'role', 'agent', 'status', 'address', 'business_name', 'type'];
}
