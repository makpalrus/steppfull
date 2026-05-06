<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Event extends Model
{
    protected $fillable = ['title', 'description', 'date', 'location', 'type'];
    protected $casts = ['date' => 'datetime'];
}