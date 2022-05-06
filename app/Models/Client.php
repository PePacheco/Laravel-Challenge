<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

     /**
     * Clients table
     *
     * @var string
     */
    protected $table = 'clients';

    protected $fillable = [
        'name',
        'address',
        'checked',
        'description',
        'interest',
        'dateOfBirth',
        'email',
        'account',
        'credit_card_id',
    ];

    public $timestamps = true;


    public function credit_card()
    {
        return $this->belongsTo(CreditCard::class);
    }
}
