<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class attorny extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'email', 'phone', 'b_id', 'firm_name', 'street_address', 'city', 'state', 'zip'];
}