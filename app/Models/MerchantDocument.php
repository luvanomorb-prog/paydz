<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Relations\BelongsTo;



class MerchantDocument extends Model
{


    use HasFactory;





    protected $fillable = [


        'merchant_id',

        'type',

        'file_path',

        'status',

        'reviewed_by',

        'reviewed_at',

        'rejection_reason'


    ];







    protected $casts = [


        'reviewed_at' => 'datetime'


    ];








    /*
    |--------------------------------------------------------------------------
    | Merchant
    |--------------------------------------------------------------------------
    */


    public function merchant(): BelongsTo
    {

        return $this->belongsTo(
            Merchant::class
        );

    }







    /*
    |--------------------------------------------------------------------------
    | Admin Reviewer
    |--------------------------------------------------------------------------
    */


    public function reviewer(): BelongsTo
    {

        return $this->belongsTo(
            User::class,
            'reviewed_by'
        );

    }



}
