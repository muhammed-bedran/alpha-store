<?php

return [
    [
        'title'=>'Dashboard',
        'icon'=>'nav-icon fas fa-tachometer-alt',
        'route'=> 'dashboard.index'
    ],
    [
        'title'=>'Categories',
        'icon'=>'nav-icon fas fa-list',
        'route'=> 'dashboard.categories.index',
        'badge'=> 'New',
    ],
    [
        'title'=>'Stores',
        'icon'=>'nav-icon fas fa-store',
        'route'=> 'dashboard.stores.index',
    ],
    [
        'title'=>'Products',
        'icon'=>'nav-icon fas fa-box',
        'route'=> 'dashboard.products.index',
    ],
    [
        'title'=>'Two Factor Auth',
        'icon'=>'nav-icon fas fa-shield-alt',
        'route'=> 'dashboard.admin.2fa',
    ]
];