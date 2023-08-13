<?php 
namespace app\controllers\admin\forum;

use app\models\forums;
use app\models\sections;
use app\models\user_role;
use app\models\rules_object;
use app\models\rules_list;
use app\controllers\controller;
use electronic\core\view\view;
use electronic\core\validate\validate;

class forumsController extends controller
{
    public function index()
    {
        $section = sections::find(request('get')->section_id);
        if($section){
            $forums = forums::where('section_id', $section->id)->pagin();
        }else{
            $forums = forums::pagin();
        }
        
        $this->title(lang('forum', 'forums'));
        $this->bc(lang('global','admin'), '/admin');
        $this->bc(lang('forum', 'forums'), '/admin/forum/forums');
        $this->data['forumsSubMenu'] = true;
        $this->data['forums'] = $forums->all();
        $this->data['pagin'] = $forums->pagination();
        new view('admin/forum/forums/index', $this->data);
    }

    public function create()
    {
        
        $sections = sections::all();
        $this->title('Создать форум');
        $this->bc(lang('forum', 'forums'), '/admin/forum/forums');
        $this->bc('Создать форум');
        $this->data['forumsSubMenu'] = true;
        $this->data['sections'] = $sections;
        new view('admin/forum/forums/create', $this->data);
    }

    public function createAction()
    {
        $valid = new validate();
        $valid->name('csrf')->csrf('forumCreate');
        $valid->name('section_id')->isset('sections');
        $valid->name('name')->latRuInt()->empty();
        $valid->name('description')->text();
        $valid->name('icon')->url();
        $valid->name('sort')->int()->toInt();
        $valid->name('active')->bool();

        if($valid->control()){
            $data = [
                'section_id' => $valid->return('section_id'),
                'name' => $valid->return('name'),
                'description' => $valid->return('description'),
                'icon' => $valid->return('icon'),
                'sort' => $valid->return('sort'),
                'active' => $valid->return('active'),
            ];
            forums::insert($data);
            redirect('/admin/forum/forums');
        }else{
            redirect(referal_url(), $valid->data(), $valid->error());
        }
    }

    public function update()
    {
        $forum = forums::find(request('get')->forum_id);
        $sections = sections::all();
        $userRole = user_role::all();
        $rulesList = rules_list::all();
        $rulesObject = rules_object::where('object', 'forum')->get();
        $this->title('Обновить форум');
        $this->bc(lang('global','admin'), '/admin');
        $this->bc(lang('forum', 'forums'), '/admin/forum/forums');
        $this->bc('Редактирование форума');
        $this->data['forumsSubMenu'] = true;
        $this->data['forum'] = $forum;
        $this->data['sections'] = $sections;
        $this->data['userRole'] = $userRole;
        $this->data['rulesList'] = $rulesList;
        $this->data['rulesObject'] = $rulesObject;
        new view('admin/forum/forums/update', $this->data);
    }

    public function updateAction()
    {
        $forum = forums::find(request('get')->forum_id);
        $valid = new validate();
        $valid->name('csrf')->csrf('forumUpdate');
        $valid->name('section_id')->isset('sections');
        $valid->name('name')->latRuInt()->empty();
        $valid->name('description')->text();
        $valid->name('icon')->url();
        $valid->name('sort')->int()->toInt();
        $valid->name('active')->bool();

        if($valid->control() && $forum){
            $data = [
                'id' => $forum->id,
                'section_id' => $valid->return('section_id'),
                'name' => $valid->return('name'),
                'description' => $valid->return('description'),
                'icon' => $valid->return('icon'),
                'sort' => $valid->return('sort'),
                'active' => $valid->return('active'),
            ];
            forums::update($data);
            alert2('Сохранено!', 'primary');
            redirect('/admin/forum/forums');
        }else{
            redirect(referal_url(), $valid->data(), $valid->error());
        }
    }

    public function delete()
    {
        $forum = forums::find(request('get')->forum_id);
        $this->title('Удалить форум');
        $this->bc(lang('global','admin'), '/admin');
        $this->bc(lang('forum', 'forums'), '/admin/forum/forums');
        $this->bc('Удалить форум');
        $this->data['forumsSubMenu'] = true;
        $this->data['forum'] = $forum;
        new view('admin/forum/forums/delete', $this->data);
    }

    public function deleteAction()
    {
        $forum = forums::find(request('get')->forum_id);
        $forum->delete();
        redirect('/admin/forum/forums');
    }
}
