<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// auth routes
require __DIR__ . '/api/auth.php';

// media routes
require __DIR__ . '/api/media.php';

// product routes
require __DIR__ . '/api/products.php';

// user routes
require __DIR__ . '/api/users.php';

// cart routes
require __DIR__ . '/api/cart.php';

// wishlist routes
require __DIR__ . '/api/wishlist.php';

// order routes
require __DIR__ . '/api/orders.php';
