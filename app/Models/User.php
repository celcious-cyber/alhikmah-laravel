<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Filament\Models\Contracts\HasAvatar;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

#[Fillable(['name', 'email', 'password', 'role', 'title', 'phone', 'address', 'bio', 'avatar_url'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser, HasAvatar
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPenulis(): bool
    {
        return $this->role === 'penulis';
    }

    public function isCurriculumAdmin(): bool
    {
        return in_array($this->role, ['kmi', 'smp', 'ma', 'tpq']);
    }

    public function isKmi(): bool
    {
        return $this->role === 'kmi';
    }

    public function isSmp(): bool
    {
        return $this->role === 'smp';
    }

    public function isMa(): bool
    {
        return $this->role === 'ma';
    }

    public function isTpq(): bool
    {
        return $this->role === 'tpq';
    }

    public function isIkph(): bool
    {
        return $this->role === 'ikph';
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url ? '/storage/' . $this->avatar_url : null;
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
}
