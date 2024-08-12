<?php
return[
[
'icon'=>'nav-icon fas fa-tachometer-alt',
'route'=>'dashboard',
'title'=>'Dashboard',
'active'=>'dashboard'
],
[
'icon'=>'far fa-circle nav-icon',
'route'=>'category.index',
'title'=>'category',
'badge'=>'New',
'active'=>'category.*',
'ability' => 'categories.view',

],
[
'icon'=>'far fa-circle nav-icon',
'route'=>'product.index',
'title'=>'product',
'active'=>'product.*',
'ability' => 'products.view',

],
[
'icon'=>'far fa-circle nav-icon',
'route'=>'checkout',
'title'=>'order',
'active'=>'order.*',
'ability' => 'orders.view',

],
[
    'icon' => 'fas fa-shield nav-icon',
    'route' => 'roles.index',
    'title' => 'Roles',
    'active' => 'roles.*',
    'ability' => 'roles.view',
],
[
    'icon' => 'fas fa-users nav-icon',
    'route' => 'users.index',
    'title' => 'Users',
    'active' => 'users.*',
    'ability' => 'users.view',
],
[
    'icon' => 'fas fa-users nav-icon',
    'route' => 'admins.index',
    'title' => 'Admins',
    'active' => 'admins.*',
    'ability' => 'admins.view',
],




];


