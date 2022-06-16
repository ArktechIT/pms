<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    use HasFactory;
    // use \Znck\Eloquent\Traits\BelongsToThrough;

    protected $table = 'cadcam_parts';
    protected $primaryKey = 'partId';

    function customer()
    {
        return $this->hasOne(Customer::class,'customerId','customerId');
    }

    function materialSpec()
    {
        return $this->hasOne(MaterialSpec::class,'materialSpecId','materialSpecId');
    }

    function materialType()
    {
        return $this->hasOneThrough(MaterialType::class, MaterialSpec::class,'materialSpecId','materialTypeId','materialSpecId','materialTypeId');
    }
}
