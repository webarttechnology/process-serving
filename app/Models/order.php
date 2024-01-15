<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class order extends Model
{
    use HasFactory;
    protected $fillable = ['ldmax_id', 'b_code', 'case_id', 'l_client', 'order_id', 'attempt_time', 'internal_reference_number', 'status', 'notification', 'attempt_type'];

    public function case()
    {
        return $this->belongsTo(ccase::class);
    }

    public function documents()
    {
        return $this->hasMany(document::class);
    }

    public function parties()
    {
        return $this->hasMany(party::class);
    }

    public function servees()
    {
        return $this->hasMany(serve::class);
    }
    public function serveAddress()
    {
        return $this->hasOne(serveAddress::class);
    }

    public function plaintiffParty()
    {
        return $this->hasOne(party::class)->where('role_type', 'plaintiff');
    }

    public function defendantParty()
    {
        return $this->hasOne(party::class)->where('role_type', 'defendant');
    }
}
