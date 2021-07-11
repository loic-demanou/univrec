<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'start_time', 'end_time', 'user_id', 'proposal_id'];

    public function proposals()
    {
        return $this->hasMany(Proposal::class);
    }
}
