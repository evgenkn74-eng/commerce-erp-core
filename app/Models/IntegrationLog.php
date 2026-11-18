<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntegrationLog extends Model
{
    public $timestamps = false;

    protected $fillable = ['service', 'endpoint', 'status_code', 'duration_ms', 'error'];
}
