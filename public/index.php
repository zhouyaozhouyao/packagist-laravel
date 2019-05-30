<?php
use Illuminate\Database\Capsule\Manager;
use Illuminate\Support\Fluent;

require __DIR__ . '/../vendor/autoload.php';

// 服务容器实例化
$app = new Illuminate\Container\Container;
// 注册视图属性
Illuminate\Container\Container::setInstance($app);
// 服务注册
with(new Illuminate\Events\EventServiceProvider($app))->register();
// 路由注册
with(new Illuminate\Routing\RoutingServiceProvider($app))->register();

// 启动 Eloquent ORM 模块并进行相关配置
$manager = new Manager();
$manager->addConnection(require __DIR__ . '/../config/database.php');
$manager->bootEloquent();

// 视图文件
$app->instance('config', new Fluent());
$app['config']['view.compiled'] = __DIR__ . '/../storage/framework/views';
$app['config']['view.paths'] = [__DIR__ . '/../resources/views'];
with(new Illuminate\View\ViewServiceProvider($app))->register();
with(new Illuminate\Filesystem\FilesystemServiceProvider($app))->register();


// 加载路由
require __DIR__ . '/../app/Http/routes.php';
// 实例化请求并分发处理请求
$request = Illuminate\Http\Request::createFromGlobals();
$response = $app['router']->dispatch($request);
// 返回请求响应
$response->send();
