<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FilachatConversation extends Model
{
    protected $fillable = ['senderable_id', 'senderable_type', 'receiverable_id', 'receiverable_type'];
 
    public function inquiries()
    {
        return $this->hasMany(Inquiry::class);
    }

}
