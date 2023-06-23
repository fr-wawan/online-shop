<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticable;
use Laravel\Passport\HasApiTokens;

class Customer extends Authenticable
{
    use HasFactory, HasApiTokens;

    protected $guarded = [];

    protected $hidden = [
        'password'
    ];

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    protected function avatar(): Attribute
    {
        $name = str_replace(' ', '+', $this->first_name . ' ' . $this->last_name);
        return Attribute::make(
            get: fn ($value) => $value != '' ? asset('/storage/customers/' . $value) : 'https://ui-avatars.com/api/?name=' . str_replace(' ', '+', $name) . '&background=4e73df&color=ffffff&size=100',
        );
    }
}
