<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function roles(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function hasRole($role)
    {
        $roles = $this->getCachedRoles();
        if (is_string($role)) {
            return $roles->contains($role);
        }

        return $roles->contains($role->name);
    }

    public function hasPermission($permission)
    {
        return in_array($permission, $this->getCachedPermissions(), true) || $this->hasRole('Super Admin');
    }


    public function assignRole($role)
    {
        $role = Role::where('name', $role)->firstOrFail();
        $this->roles()->syncWithoutDetaching($role->id);
        $this->clearPermissionsCache();
    }

    public function givePermissionTo($permission)
    {
        if (is_string($permission)) {
            $permission = Permission::where('name', $permission)->firstOrFail();
        }
        $this->permissions()->syncWithoutDetaching($permission);
        $this->clearPermissionsCache();
    }

    public function getCachedRoles()
    {
        return Cache::remember("user_roles_{$this->id}", 3600, function () {
            return $this->roles()->pluck('name');
        });
    }

    public function getCachedPermissions()
    {
        return Cache::remember("user_permissions_{$this->id}", 3600, function () {
            $this->loadMissing('roles.permissions');

            $permissions = $this->permissions->pluck('name');

            $rolePermissions = $this->roles->flatMap(function ($role) {
                return $role->permissions->pluck('name');
            });

            return $permissions->merge($rolePermissions)->unique()->toArray();
        });
    }

    public function clearPermissionsCache()
    {
        Cache::forget("user_roles_{$this->id}");
        Cache::forget("user_permissions_{$this->id}");
    }

    protected function getRoleId($role)
    {
        if (is_numeric($role)) {
            return $role;
        }
        return Role::where('name', $role)->firstOrFail()->id;
    }

    protected function getPermissionId($permission)
    {
        if (is_numeric($permission)) {
            return $permission;
        }
        return Permission::where('name', $permission)->firstOrFail()->id;
    }

    public function clearCacheData()
    {
        Cache::forget('user_roles_'.$this->id);
        Cache::forget('user_permissions_'.$this->id);
        Cache::forget('auth_user_'.$this->id);
    }
}
