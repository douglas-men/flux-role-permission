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
            "name" => "Listar Empresas"
            "slug" => "listar-empresas"
        ],
        [
            "id" => 4
            "name" => "Excluir Empresas"
            "slug" => "excluir-empresas"
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
    Permission::create('cadastrar-empresas');

    // Return (boolean): 
    true or false    
```

* **Delete a Permission**
```php
    // Deleting a Permission
    Permission::delete('listar-empresas');

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
            "name" => "Listar Empresas"
            "slug" => "listar-empresas"
        ],
        [
            "id" => 4
            "name" => "Excluir Empresas"
            "slug" => "excluir-empresas"
        ],
        [
            "id" => 5
            "name" => "Cadastrar Empresas"
            "slug" => "cadastrar-empresas"
        ]
    ]
    
```

* **Checks a User’s Permission**
```php    
    // Checking if the user has permission
    Permission::has(auth()->user(), 'listar-empresas');
    
    // Return (boolean): 
    true or false
```

* **Records permission to an User**
```php    
    // Grants permission for the User
    Permission::register(auth()->user(), 'listar-empresas');
    
    // Return (boolean): 
    true or false
```

* **Revokes a permission**
```php    
    // Revokes permission
    Permission::revoke(auth()->user(), 'listar-empresas');

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
            "name" => "Listar Empresas"
            "slug" => "listar-empresas"
        ],
        [
            "id" => 4
            "name" => "Excluir Empresas"
            "slug" => "excluir-empresas"
        ],
        [
            "id" => 5
            "name" => "Cadastrar Empresas"
            "slug" => "cadastrar-empresas"
        ]
    ]
```
* **Checks User Permission**
```php
    $user = User::find(1);
    
    // Checking if the user has permission
    $user->hasPermission('listar-empresas');
    
    // Return (boolean):
    true or false
```
* **Records permission to an User**
```php
    $user = User::find(1);
    
    // Grants permission to the User
    $user->registerPermission('listar-empresas');
    
    // Return (boolean):
    true or false
```

* **Revokes permission**
```php    
    $user = User::find(1);
    
    // Revokes permission
    $user->revokePermission('listar-empresas');

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
            "name" => "Empresas"
            "slug" => "empresas"
        ],
        [
            "id" => 4
            "name" => "Usuarios"
            "slug" => "usuarios"
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
    Role::create('financeiro');

    // Creating a new Role with permissions
    Role::create('financeiro', ['listar-contas', 'cadastrar-contas', 'excluir-contas']);

    // Return (array): 
    [
        "id": 7,
        "name": "Companies",
        "slug": "companies"
    ]  
```

* **Update a Role**
```php
    // Updating a Role
    Role::update('financeiro', ['slug' => 'users', 'permissions' => ['list-users', 'create-users']]);

    // Return (array): 
    [
        "id" => 4
        "name" => "Usuarios Editado"
        "slug" => "usuarios-editado"
        "permissions" => {
            [
                "id" => 7
                "name" => "List Users"
                "slug" => "list-users"
            ],
            [
                "id" => 7
                "name" => "Create Users"
                "slug" => "create-users"
            ]
        }
    ]
```

* **Add Permission to a Role**
```php
    // Deleting a Role
    Role::addPermission('financeiro', 'listar-contas');

    // Return (boolean): 
    true or false
```

* **Remove Permission from a Role**
```php
    // Deleting a Role
    Role::removePermission('financeiro', 'listar-contas');

    // Return (boolean): 
    true or false
```

* **Delete a Role**
```php
    // Deleting a Role
    Role::delete('listar-empresas');

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
            "name" => "Empresas"
            "slug" => "empresas"
        ],
        [
            "id" => 4
            "name" => "Financeiro"
            "slug" => "financeiro"
        ]
    ]
    
```

* **Checks a User’s Role**
```php    
    // Checking if the user has role
    Role::has(auth()->user(), 'empresas');
    
    // Return (boolean): 
    true or false
```

* **Records Role to an User**
```php    
    // Grants role for the User
    Role::register(auth()->user(), 'empresas');
    
    // Return (boolean): 
    true or false
```

* **Revokes a Role**
```php    
    // Revokes role
    Role::revoke(auth()->user(), 'empresas');

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
            "name" => "Empresas"
            "slug" => "empresas"
        ],
        [
            "id" => 4
            "name" => "Financeiro"
            "slug" => "financeiro"
        ]
    ]
```
* **Checks User Role**
```php
    $user = User::find(1);
    
    // Checking if the user has role
    $user->hasRole('empresas');
    
    // Return (boolean):
    true or false
```
* **Records role to an User**
```php
    $user = User::find(1);
    
    // Grants role to the User
    $user->registerRole('empresas');
    
    // Return (boolean):
    true or false
```

* **Revokes role**
```php    
    $user = User::find(1);
    
    // Revokes role
    $user->revokeRole('empresas');

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
