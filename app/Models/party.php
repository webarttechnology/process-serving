<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class party extends Model
{
    use HasFactory;
    protected $fillable = ['order_id', 'case_no', 'type', 'role', 'name', 'sfx', 'l_client', 'b_code'];
}
