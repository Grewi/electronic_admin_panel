<?php
if(!defined('ADMIN')){
    define('ADMIN', 'admin');
}

$route->namespace('app/controllers/admin')->prefix('admin')->group(ADMIN, function ($route) {
    
    $route->get('/')->controller('adminController', 'index');
});

$route->namespace('app/controllers/admin')->prefix('admin')->group('admin/users', function ($route) {
    $route->get('/')->controller('usersController', 'index');
});

$route->namespace('app/controllers/admin')->prefix('admin')->group('admin/user', function ($route) {
    $route->get('/create')->controller('usersController', 'create');
    $route->post('/create')->controller('usersController', 'createAction');
    $route->get('/edit/{user_id}')->controller('usersController', 'update');
    $route->post('/edit/{user_id}')->controller('usersController', 'updateAction');
    $route->get('/delete/{user_id}')->controller('usersController', 'delete');
    $route->post('/delete/{user_id}')->controller('usersController', 'deleteAction');
});


$route->namespace('app/controllers/admin/forum')->prefix('admin')->group('admin/forum/section', function ($route) {
    $route->get('/')->controller('sectionsController', 'index');
    $route->get('/create')->controller('sectionsController', 'create');
    $route->get('/edit/{section_id}')->controller('sectionsController', 'update');
    $route->get('/delete/{section_id}')->controller('sectionsController', 'delete');
    $route->post('/create')->controller('sectionsController', 'createAction');
    $route->post('/edit/{section_id}')->controller('sectionsController', 'updateAction');
    $route->post('/delete/{section_id}')->controller('sectionsController', 'deleteAction');
});

$route->namespace('app/controllers/admin/forum')->prefix('admin')->group('admin/forum/forums', function ($route) {
    $route->get('/{section_id?}')->controller('forumsController', 'index');
});

$route->namespace('app/controllers/admin/forum')->prefix('admin')->group('admin/forum/forum', function ($route) {
    $route->get('/create')->controller('forumsController', 'create');
    $route->get('/edit/{forum_id}')->controller('forumsController', 'update');
    $route->get('/delete/{forum_id}')->controller('forumsController', 'delete');
    $route->post('/create')->controller('forumsController', 'createAction');
    $route->post('/edit/{forum_id}')->controller('forumsController', 'updateAction');
    $route->post('/delete/{forum_id}')->controller('forumsController', 'deleteAction');
});

$route->namespace('app\controllers\admin')->prefix('admin')->group('admin/roles', function($route){
    $route->get('/')->controller('userRoleController', 'index');
});

$route->namespace('app/controllers/admin')->prefix('admin')->group('admin/rules', function($route){
    $route->get('/')->controller('rulesController', 'index');
    $route->get('/create')->controller('rulesController', 'create');
    $route->post('/create')->controller('rulesController', 'createAction');
    $route->get('/edit/{rule_id}')->controller('rulesController', 'update');
    $route->post('/edit/{rule_id}')->controller('rulesController', 'updateAction');
    $route->get('/delete/{rule_id}')->controller('rulesController', 'delete');
    $route->post('/delete/{rule_id}')->controller('rulesController', 'deleteAction');
    $route->post('/save')->controller('rulesController', 'save');
});

$route->namespace('app/controllers/admin');
$route->get('/admin/ban')->prefix('admin')->controller('banController', 'index');