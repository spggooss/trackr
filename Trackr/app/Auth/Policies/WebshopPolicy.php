<?php

namespace App\Auth\Policies;
use App\Models\Role\RolesRepository;
use App\Models\User\User;
use App\Models\Webshop\Webshop;

class WebshopPolicy
{
   public function readWebshopUsers(User $user, Webshop $webshop)
   {
       $permissions = $user->role->permissions;
       foreach ($permissions as $permission) {
           if ($permission->name === 'read webshop users' && $user->webshop_id === $webshop->id) {
               return true;
           }
       }
       return false;
   }

public function createWebshopUsers(User $user, Webshop $webshop)
   {
       $permissions = $user->role->permissions;
       foreach ($permissions as $permission) {
           if ($permission->name === 'create webshop users' && $user->webshop_id === $webshop->id) {
               return true;
           }
       }
       return false;
   }

public function editWebshopUsers(User $user, Webshop $webshop)
   {
       $permissions = $user->role->permissions;
       foreach ($permissions as $permission) {
           if ($permission->name === 'edit webshop users' && $user->webshop_id === $webshop->id) {
               return true;
           }
       }
       return false;
   }

public function deleteWebshopUsers(User $user, Webshop $webshop)
   {
       $permissions = $user->role->permissions;
       foreach ($permissions as $permission) {
           if ($permission->name === 'delete webshop users' && $user->webshop_id === $webshop->id) {
               return true;
           }
       }
       return false;
   }

public function editPackagesPostCompany(User $user)
   {
       $permissions = $user->role->permissions;
       foreach ($permissions as $permission) {
           if ($permission->name === 'edit packages post company') {
               return true;
           }
       }
       return false;
   }

public function massImportPackages(User $user)
   {
       $permissions = $user->role->permissions;
       foreach ($permissions as $permission) {
           if ($permission->name === 'mass import packages') {
               return true;
           }
       }
       return false;
   }

public function getPackageLabels(User $user)
   {
       $permissions = $user->role->permissions;
       foreach ($permissions as $permission) {
           if ($permission->name === 'get package labels') {
               return true;
           }
       }
       return false;
   }

   public function readPackages(User $user)
   {
       $permissions = $user->role->permissions;
       foreach ($permissions as $permission) {
           if ($permission->name === 'read packages') {
               return true;
           }
       }
       return false;
   }
   public function editPackages(User $user)
   {
       $permissions = $user->role->permissions;
       foreach ($permissions as $permission) {
           if ($permission->name === 'edit packages') {
               return true;
           }
       }
       return false;
   }
    public function deletePackages(User $user)
    {
         $permissions = $user->role->permissions;
         foreach ($permissions as $permission) {
              if ($permission->name === 'delete packages') {
                return true;
              }
         }
         return false;
    }
    public function createPackages(User $user)
    {
         $permissions = $user->role->permissions;
         foreach ($permissions as $permission) {
              if ($permission->name === 'create packages') {
                return true;
              }
         }
         return false;
    }
    public function editPackagePickupDate(User $user)
    {
         $permissions = $user->role->permissions;
         foreach ($permissions as $permission) {
              if ($permission->name === 'edit package pickup date') {
                return true;
              }
         }
         return false;
    }

}
