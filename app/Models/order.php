<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;
    protected $fillable = ['b_code', 'case_id', 'l_client','order_id', 'attempt_time', 'internal_reference_number', 'status', 'notification', 'attempt_type'];

    public function case()
    {
        return $this->belongsTo(ccase::class);
    }
}