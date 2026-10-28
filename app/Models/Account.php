<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Account extends Model { protected $fillable=['user_id','name','number','balance','type']; protected $casts=['balance'=>'decimal:2']; public function user(){return $this->belongsTo(User::class);} public function transactions(){return $this->hasMany(Transaction::class);} }
