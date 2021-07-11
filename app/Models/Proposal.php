<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Proposal extends Model
{
    use HasFactory;
    use Notifiable;

    protected $fillable=['job_id', 'validated'];

    public static function boot()
    {
        parent::boot();
        static::creating(function($model){
            $model->user_id=auth()->user()->id;
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function job()
    {
        return $this->belongsTo('App\Models\Job');
    }

    public function coverLetter()
    {
        return $this->hasOne('App\Models\CoverLetter');
    }

    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

}
