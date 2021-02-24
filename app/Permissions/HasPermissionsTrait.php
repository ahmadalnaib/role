<?php


namespace App\Permissions;


use App\Models\Permission;
use App\Models\Role;
use Illuminate\Support\Arr;

trait HasPermissionsTrait
{

  public function givePermissionTo(...$permissions)
  {
    $permissions=$this->getAllPermissions(Arr::flatten($permissions));

    if($permissions === null)
    {
        return $this;
    }

    $this->permissions()->saveMany($permissions);
    return  $this;
  }


    public function withdrawPermissionTo(...$permissions)
    {
        $permissions=$this->getAllPermissions(Arr::flatten($permissions));


        $this->permissions()->detach($permissions);
        return $this;

    }



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




    public function hasPermissionTo($permission)
    {
         //has permission through role
        return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
    }

    public function hasPermissionThroughRole($permission)
    {
      foreach($permission->roles as $role)
      {
          if($this->roles->contains($role))
          {
              return true;
          }
      }
      return  false;
    }

    protected  function  hasPermission($permission)
    {
     return (bool) $this->permissions()->where('name',$permission->name)->count();
    }

    protected function getAllPermissions(array $permission)
    {
           return Permission::whereIn('name',$permission)->get();
    }


    public function roles()
    {
        return $this->belongsToMany(Role::class,'users_roles');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class,'users_permissions');
    }

}
