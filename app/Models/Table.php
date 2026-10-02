<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $table = 'tables';

    protected $fillable = ['outlet_id', 'table_number', 'capacity'];
    public function outlet()
    {
        return $this->belongsTo(Outlet::class);
    }
}
