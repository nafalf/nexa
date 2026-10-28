<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Transaction extends Model { protected $fillable=['user_id','account_id','beneficiary_id','type','amount','status','description','reference','suspicious']; protected $casts=['amount'=>'decimal:2','suspicious'=>'boolean']; public function user(){return $this->belongsTo(User::class);} public function account(){return $this->belongsTo(Account::class);} public function beneficiary(){return $this->belongsTo(Beneficiary::class);} }
