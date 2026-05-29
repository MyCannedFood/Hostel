<?php
// FILE: app/Models/Admin.php  (ganti seluruh isi file lama)

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'admins';

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /* ── Relasi ── */
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /* ── Scope ── */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /* ──────────────────────────────────────────────────
       hasPermission($key)
       — Cek apakah admin boleh akses fitur tertentu.
       — Kalau role_id null (owner/superadmin lama) → true.
       — Kalau role ada → cek array permissions-nya.
    ────────────────────────────────────────────────── */
    public function hasPermission(string $key): bool
    {
        // Admin tanpa role = akses penuh (backward compatibility)
        if (! $this->role_id) {
            return true;
        }

        return in_array($key, $this->role->permissions ?? []);
    }

    /* ── Helper: inisial untuk avatar ── */
    public function getInitialsAttribute(): string
    {
        $parts = explode(' ', trim($this->name));
        $first = strtoupper(substr($parts[0] ?? '', 0, 1));
        $last  = strtoupper(substr($parts[1] ?? '', 0, 1));
        return $first . $last;
    }

    /* ── Helper: warna avatar berdasarkan role ── */
    public function getAvatarColorAttribute(): string
    {
        return match(strtolower($this->role->name ?? '')) {
            'finance'      => 'orange',
            'receptionist' => 'teal',
            'staff'        => 'green',
            default        => 'gray',   // owner / null
        };
    }
}