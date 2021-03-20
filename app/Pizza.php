<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Pizza extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'url'
    ];

    /**
     * The commands that belong to the pizza.
     */
    public function commands()
    {
        return $this->belongsToMany(Commande::class);
    }
}