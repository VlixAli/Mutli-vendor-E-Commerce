<?php

return [
    [
        'icon' => "nav-icon fas fa-tachometer-alt",
        'route' => 'dashboard.dashboard',
        'title' => 'Dashboard',
        'active' => 'dashboard.dashboard'
    ],
    [
        'icon' => "bi bi-tags-fill",
        'route' => 'dashboard.categories.index',
        'title' => 'Categories',
        'badge' => 'New',
        'active' => 'dashboard.categories.*',
        'ability' => 'categories.view',
    ],
    [
        'icon' => "bi bi-box2-fill",
        'route' => 'dashboard.products.index',
        'title' => 'Products',
        'active' => 'dashboard.products.*',
        'ability' => 'products.view',
    ],
    [
        'icon' => "bi bi-receipt",
        'route' => 'dashboard.categories.index',
        'title' => 'Orders',
        'active' => 'dashboard.orders.*',
        'ability' => 'orders.view',
    ],
    [
        'icon' => "bi bi-shield-fill",
        'route' => 'dashboard.roles.index',
        'title' => 'Roles',
        'active' => 'dashboard.roles.*',
        'ability' => 'roles.view',
    ],

];
