<?php

namespace App\Auth;

abstract class Gates
{
    const VIEW_ADMIN_USERS = 'view-admin-users';
    const CREATE_ADMIN_USERS = 'create-admin-users';
    const EDIT_ADMIN_USERS = 'edit-admin-users';
    const DELETE_ADMIN_USERS = 'delete-admin-users';
    const READ_WEBSHOP_USERS = 'read-webshop-users';
    const CREATE_WEBSHOP_USERS = 'create-webshop-users';
    const EDIT_WEBSHOP_USERS = 'edit-webshop-users';
    const DELETE_WEBSHOP_USERS = 'delete-webshop-users';
    const EDIT_PACKAGES_POST_COMPANY = 'edit-packages-post-company';
    const MASS_IMPORT_PACKAGES = 'mass-import-packages';
    const GET_PACKAGE_LABELS = 'get-package-labels';
    const READ_PACKAGES = 'read-packages';
    const EDIT_PACKAGES = 'edit-packages';
    const DELETE_PACKAGES = 'delete-packages';
    const CREATE_PACKAGES = 'create-packages';

    const EDIT_PACKAGE_PICKUP_DATE = 'edit-package-pickup-date';

}
