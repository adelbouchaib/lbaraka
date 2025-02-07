<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FilachatMessage extends Model
{
    protected $fillable = [
        'filachat_conversation_id',
        'message',
        'senderable_id',
        'senderable_type',
        'receiverable_id',
        'receiverable_type',
    ];
}
