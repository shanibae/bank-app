<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected  $fillable = ['user_id', 'balance', 'amount', 'type_id', 'details'];

    /**
     * User relation
     *
     * @return mixed
     */
    function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * User relation
     *
     * @return mixed
     */
    function transactionType()
    {
        return $this->belongsTo(TransactionType::class, 'type_id');
    }
}
