<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditCard extends Model
{
    use HasFactory;

    /**
     * Credit Cards table
     *
     * @var string
     */
    protected $table = 'credit_cards';

    protected $fillable = [
        'type',
        'number',
        'name',
        'expiration_date_day',
        'expiration_date_month'
    ];

    public $timestamps = true;

    public function client()
    {
        return $this->hasOne(Client::class);
    }
}
