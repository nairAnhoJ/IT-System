<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemRequest extends Model
{
    use HasFactory;

    public function item() {
        return $this->belongsTo(ItemType::class, 'type_id');
    }

    public function req_by() {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function department() {
        return $this->belongsTo(User::class, 'requested_by_department');
    }

    public function req_site() {
        return $this->belongsTo(Site::class, 'site');
    }
}
