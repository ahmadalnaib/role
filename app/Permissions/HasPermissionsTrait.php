<?php


namespace App\Permissions;


use App\Models\Permission;
use App\Models\Role;

trait HasPermissionsTrait
{
    public function hasRole(...$roles)
    {
        foreach ($roles as $role)
        {
            if($this->roles->contains('name',$role))
            {
                return true;
            }
        }

        return  false;

    }

    public function roles()
    {
        return $this->belongsToMany(Role::class,'users_roles');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class,'users_permissions');
    }


    public function hasPermissionTo($permission)
    {
         //has permission through role
        return $this->hasPermission($permission);
    }

    protected  function  hasPermission($permission)
    {
     return (bool) $this->permissions()->where('name',$permission->name)->count();
    }




}
