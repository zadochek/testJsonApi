<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\UuidInterface;

/**
 * @property UuidInterface $id
 * @property false|string $payload
 * @property string $status
 */
class Document extends Model
{
    protected $fillable = [
        'id',
        'status',
        'payload',
    ];

    /**
     * Disable autoincrementing id
     * @var
     */
    public $incrementing = false;
}
