<?php

namespace App;

use App\Participant;
use App\NewsletterParticipant;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    protected $table = 'newsletter';
    public $timestamps = true;
    protected $fillable = ['name','mailable_name', 'active'];

    public function participants()
    {
        return $this->belongsToMany('\App\Participant', 'newsletter_participant')
                    ->withPivot([
                        'newsletter_id',
                        'participant_id',
                        'status'
                    ])
                    ->withTimestamps();
    }
}
