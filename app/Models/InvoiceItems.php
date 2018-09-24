<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceItems extends Model
{
    use SoftDeletes;

    protected $table = 'invoice_items';

    protected $primaryKey = 'id';

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];
}
