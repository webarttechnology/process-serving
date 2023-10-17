<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ccase extends Model
{
    use HasFactory;
    protected $fillable = ['order_id', 'case_no', 'case_title', 'jurisdiction', 'attorney'];
}
