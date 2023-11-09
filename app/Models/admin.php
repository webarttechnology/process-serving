<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\AdminInfo;

class admin extends Model
{
    use HasFactory;

    protected $fillable = [
        'organization_name',
        'password',
        'name',
        'email',
        'phone',
        'role',
        'attorney',
        'email_verify_code'
    ];

    public function admininfo()
    {
        return $this->hasMany(AdminInfo::class);
    }

    public function admin_info_single()
    {
        return $this->hasOne(AdminInfo::class);
    }

    public function attorney_info()
    {
        return $this->hasOne(attorny::class);
    }
}
