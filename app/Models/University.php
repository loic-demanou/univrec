<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    use HasFactory;
    protected $fillable = ['phone', 'fax', 'postal_address', 'decrees_establishing', 'authorization_to_open',
    'web_site', 'region', 'department', 'location_site'];
}
