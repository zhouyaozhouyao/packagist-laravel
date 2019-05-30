<?php
namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Container\Container;

class WelcomeController
{
    public function index()
    {
        $student = Student::first();
        $data = $student->getAttributes();
        // 获取容器实例
        $app = Container::getInstance();
        // 获取服务对象
        $factory = $app->make('view');
        return $factory->make('welcome')->with('data', $data);
        // return "学生 id=" . $data['id'] . "; 学生 name = " . $data['name'];
    }
}
