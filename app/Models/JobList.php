<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobList extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'company_id',
        'user_id',
        'job_url',
        'tags',
        'job_location',
        'employment_type_id',
        'salary',
        'available',
    ];
}
