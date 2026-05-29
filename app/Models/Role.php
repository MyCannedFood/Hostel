<?php
// FILE: app/Models/Role.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'permissions'];

    protected $casts = [
        // Otomatis encode/decode JSON ↔ PHP array
        'permissions' => 'array',
    ];

    /* ── Relasi ── */
    public function admins()
    {
        return $this->hasMany(Admin::class);
    }

    /* ── Semua permission key yang tersedia di sistem ── */
    public const PERMISSIONS = [
        'dashboard'          => 'Dashboard',
        'room_bed'           => 'Room & Bed',
        'reservation'        => 'Reservation',
        'article'            => 'Article',
        'budgeting_report'   => 'Budgeting & Report',
        'settings'           => 'Settings',
        'finance_accounting' => 'Finance Accounting',
        'experience'         => 'Experience',
    ];
}