<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class document extends Model
{
    use HasFactory;
    protected $fillable = ['servee_id', 'order_id', 'case_no', 'type', 's_no', 'd_t_u', 'd_title', 'document','s_d'];
}