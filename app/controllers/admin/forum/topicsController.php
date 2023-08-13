<?php 
namespace app\controllers\admin\forum;
use app\controllers\controller;
use electronic\core\view\view;

class topicsController extends controller
{
    public function index()
    {
        $this->title('');
        new view('admin/forum/topics/index', $this->data);
    }

    public function create()
    {
        $this->title('');
        new view('admin/forum/topics/create', $this->data);
    }

    public function update()
    {
        $this->title('');
        new view('admin/forum/topics/update', $this->data);
    }

    public function delete()
    {
        $this->title('');
        new view('admin/forum/topics/delete', $this->data);
    }
}
