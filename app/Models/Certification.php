<?php

namespace App\Models;

use Spatie\Tags\HasTags;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Certification extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasTags;

    protected $fillable = [
        'name',
        'short',
        'identifier',
        'issued_at',
        'expiration_at',
        'company_id',
        'file_path',
    ];

    protected $dates = ['issued_at', 'expiration_at'];

    /**
     * Get the company for the certification.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
