<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Beneficiary extends Model { use SoftDeletes; protected $fillable=['user_id','name','bank','number']; public function user(){return $this->belongsTo(User::class);} }
