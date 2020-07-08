# Flux Role Permission
Library for managing user permissions in Laravel applications.

# Requirements
* Laravel >= 6.0

# Installation

* Run the command below at the project root to add the package to the Laravel application:

```php 
    composer require doc88/flux-role-permission
```

* In the *providers* list in the *config/app.php* file add:

```php     
    'providers' => [
        ...
        Doc88\FluxRolePermission\FluxRolePermissionServiceProvider::class,
    ]
```

* Run the command below at the root of your project to publish the new provider:

```php 
    php artisan vendor:publish
```

* Run migrations

```php 
    php artisan migrate
```

* In your User Model add the following lines:

```php     
    use Doc88\FluxRolePermission\Traits\HasRolePermissions;

    class User {
        use HasRolePermissions;
    }
```
# Usage

## Doc88\FluxRolePermission\Permission Class
Class used to List, Register, Verify and Revoke permissions.

* **List All Permissions**
```php
    // All Registered Permissions
    Permission::all();

    // Return (array):
    [
        [
            "id" => 3
            "name" => "List Companies"
            "slug" => "list-companies"
        ],
        [
            "id" => 4
            "name" => "Delete Companies"
            "slug" => "delete-companies"
        ]
    ]
```

* **List a Permission**
```php
    // Get the Permission
    Permission::get('list-users');

    // Return (array):    
    [
        "id" => 3
        "name" => "List Users"
        "slug" => "list-users"
    ]
```

* **Create a Permission**
```php
    // Creating a new Permission
    Permission::create('create-companies');

    // Return (boolean): 
    true or false    
```

* **Delete a Permission**
```php
    // Deleting a Permission
    Permission::delete('list-companies');

    // Return (boolean): 
    true or false
```

* **List User’s Permissions**
```php
    // List all the User's Permissions
    Permission::list($user);

    // Return (array):
    [
        [
            "id" => 3
            "name" => "List Companies"
            "slug" => "list-companies"
        ],
        [
            "id" => 4
            "name" => "Delete Companies"
            "slug" => "delete-companies"
        ],
        [
            "id" => 5
            "name" => "Create Company"
            "slug" => "create-companies"
        ]
    ]
    
```

* **Checks a User’s Permission**
```php    
    // Checking if the user has permission
    Permission::has(auth()->user(), 'list-companies');
    
    // Return (boolean): 
    true or false
```

* **Records permission to an User**
```php    
    // Grants permission for the User
    Permission::register(auth()->user(), 'list-companies');
    
    // Return (boolean): 
    true or false
```

* **Revokes a permission**
```php    
    // Revokes permission
    Permission::revoke(auth()->user(), 'list-companies');

    // Return (boolean): 
    true or false
    
```

## Using the User Model
It is possible to List, Register, Verify and Revoke permissions using the User class.

* **List User Permissions**
```php
    $user = User::find(1);
    
    // User's Permissions
    $user->listPermissions();

    // Return (array):
    [
        [
            "id" => 3
            "name" => "List Companies"
            "slug" => "list-companies"
        ],
        [
            "id" => 4
            "name" => "Delete Companies"
            "slug" => "delete-companies"
        ],
        [
            "id" => 5
            "name" => "Create Company"
            "slug" => "create-companies"
        ]
    ]
```
* **Checks User Permission**
```php
    $user = User::find(1);
    
    // Checking if the user has permission
    $user->hasPermission('list-companies');
    
    // Return (boolean):
    true or false
```
* **Records permission to an User**
```php
    $user = User::find(1);
    
    // Grants permission to the User
    $user->registerPermission('list-companies');
    
    // Return (boolean):
    true or false
```

* **Revokes permission**
```php    
    $user = User::find(1);
    
    // Revokes permission
    $user->revokePermission('list-companies');

    // Return (boolean):
    true or false    
```

## Doc88\FluxRolePermission\Role Class
Class used to List, Register, Verify and Revoke roles.

* **List All Roles**
```php
    // All Registered Roles
    Role::all();

    // Return (array):
    [
        [
            "id" => 3
            "name" => "Companies"
            "slug" => "companies"
        ],
        [
            "id" => 4
            "name" => "Users"
            "slug" => "users"
        ]
    ]
```

* **List a Role**
```php
    // Get the role
    Role::get('users');

    // Return (array):
    [
        "id" => 5
        "name" => "Users"
        "slug" => "users"
        "permissions" => {
            [
                0 => array:3 [
                    "id" => 3
                    "name" => "List Users"
                    "slug" => "list-users"
                ],
                1 => array:3 [
                    "id" => 4
                    "name" => "Delete Users"
                    "slug" => "delete-users"
                ],
                2 => array:3 [
                    "id" => 5
                    "name" => "Create Users"
                    "slug" => "create-users"
                ]
            ]
        }
    ]
```

* **Create a Role**
```php
    // Creating a new Role
    Role::create('Users');

    // Creating a new Role with permissions
    Role::create('users', ['list-users', 'create-users', 'delete-users']);

    // Return (array): 
    [
        "id": 7,
        "name": "Users",
        "slug": "users"
    ]  
```

* **Update a Role**
```php
    // Updating a Role
    Role::update('users', ['slug' => 'new-slug', 'permissions' => ['list-users', 'create-users']]);

    // Return (array): 
    [
        "id" => 4
        "name" => "New Slug"
        "slug" => "new-slug"
        "permissions" => {
            [
                "id" => 7
                "name" => "List Users"
                "slug" => "list-users"
            ],
            [
                "id" => 8
                "name" => "Create Users"
                "slug" => "create-users"
            ]
        }
    ]
```

* **Add Permission to a Role**
```php
    // Deleting a Role
    Role::addPermission('sales', 'list-sales');

    // Return (boolean): 
    true or false
```

* **Remove Permission from a Role**
```php
    // Deleting a Role
    Role::removePermission('sales', 'list-sales');

    // Return (boolean): 
    true or false
```

* **Delete a Role**
```php
    // Deleting a Role
    Role::delete('sales');

    // Return (boolean): 
    true or false
```

* **List User’s Roles**
```php
    // List all the User's Roles
    Role::list($user);

    // Return (array):
    [
        [
            "id" => 3
            "name" => "Companies"
            "slug" => "companies"
        ],
        [
            "id" => 4
            "name" => "Sales"
            "slug" => "sales"
        ]
    ]
    
```

* **Checks a User’s Role**
```php    
    // Checking if the user has role
    Role::has(auth()->user(), 'companies');
    
    // Return (boolean): 
    true or false
```

* **Records Role to an User**
```php    
    // Grants role for the User
    Role::register(auth()->user(), 'companies');
    
    // Return (boolean): 
    true or false
```

* **Revokes a Role**
```php    
    // Revokes role
    Role::revoke(auth()->user(), 'companies');

    // Return (boolean): 
    true or false    
```

## Using the User Model
It is possible to List, Register, Verify and Revoke roles using the User class.

* **List User Roles**
```php
    $user = User::find(1);
    
    // User's Roles
    $user->listRoles();

    // Return (array):
    [
        [
            "id" => 3
            "name" => "Companies"
            "slug" => "companies"
        ],
        [
            "id" => 4
            "name" => "Sales"
            "slug" => "sales"
        ]
    ]
```
* **Checks User Role**
```php
    $user = User::find(1);
    
    // Checking if the user has role
    $user->hasRole('companies');
    
    // Return (boolean):
    true or false
```
* **Records role to an User**
```php
    $user = User::find(1);
    
    // Grants role to the User
    $user->registerRole('companies');
    
    // Return (boolean):
    true or false
```

* **Revokes role**
```php    
    $user = User::find(1);
    
    // Revokes role
    $user->revokeRole('companies');

    // Return (boolean):
    true or false    
```
# Middleware

* In the *$routeMiddleware* array in the *app\Http\Kernel.php* file add:

```php     
    protected $routeMiddleware = [
        ...
        'permissions' => Doc88\FluxRolePermission\Http\Middleware\FluxRolePermission::class,
        ...
    ]
```
* Middleware Usage:

```php
    // routes/web.php

    Route::get('list-companies', 'CompanyController@index')->middleware('permissions:list-companies');
    // or
    Route::group(['middleware' => 'permissions:list-companies'], function () {
        Route::get('list-companies', 'CompanyController@index');
    });
```
