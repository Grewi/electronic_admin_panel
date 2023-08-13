<?php 
namespace app\controllers\admin\forum;

use app\models\sections;
use app\models\user_role;
use app\models\rules_object;
use app\models\rules_list;
use app\controllers\controller;
use electronic\core\view\view;
use electronic\core\validate\validate;

class sectionsController extends controller
{
    public function index()
    {
        $sections = sections::pagin();
        $this->title('Секции форума');
        $this->bc('admin', '/admin');
        $this->bc('Форум', '/forum');
        $this->bc('Секции форума');
        $this->data['sectionSubMenu'] = true;
        $this->data['sections'] = $sections->all();
        $this->data['pagin'] = $sections->pagination;
        new view('admin/forum/sections/index', $this->data);
    }

    public function create()
    {
        $this->title('Создать секцию');
        $this->bc('admin', '/admin');
        $this->bc('Форум', '/forum');
        $this->bc('Секции форума', '/admin/forum/section');
        $this->bc('Создать секцию');
        $this->data['sectionSubMenu'] = true;
        new view('admin/forum/sections/create', $this->data);
    }

    public function createAction()
    {
        $valid = new validate();
        $valid->name('csrf')->csrf('sectionCreate');
        $valid->name('name')->latRuInt()->empty();
        $valid->name('description')->text();
        $valid->name('icon')->url();
        $valid->name('active')->bool();

        if($valid->control()){
            $data = [
                'name' => $valid->return('name'),
                'description' => $valid->return('description'),
                'icon' => $valid->return('icon'),
                'active' => $valid->return('active'),
            ];
            sections::insert($data);
            redirect('/admin/forum/section');
        }else{
            redirect(referal_url(), $valid->data(), $valid->error());
        }
    }

    public function update()
    {
        $section = sections::find(request('get')->section_id);
        $userRole = user_role::all();
        $rulesList = rules_list::all();
        $rulesObject = rules_object::where('object', 'section')->get();
        $this->title('Редактировать секцию');
        $this->bc('admin', '/admin');
        $this->bc('Форум', '/forum');
        $this->bc('Секции форума', '/admin/forum/section');
        $this->bc('Редактировать секцию');
        $this->data['sectionSubMenu'] = true;
        $this->data['section'] = $section;
        $this->data['userRole'] = $userRole;
        $this->data['rulesList'] = $rulesList;
        $this->data['rulesObject'] = $rulesObject;
        new view('admin/forum/sections/update', $this->data);
    }

    public function updateAction()
    {
        $section = sections::find(request('get')->section_id);
        $valid = new validate();
        $valid->name('csrf')->csrf('editCreate');
        $valid->name('name')->latRuInt()->empty();
        $valid->name('description')->text();
        $valid->name('icon')->url();
        $valid->name('active')->bool();

        if($valid->control()){
            $section = sections::find(request('get')->section_id);
            $section->name = $valid->return('name');
            $section->description = $valid->return('description');
            $section->icon = $valid->return('icon');
            $section->active = $valid->return('active');
            $section->save();
            redirect('/admin/forum/section');
        }else{
            redirect(referal_url(), $valid->data(), $valid->error());
        }
    }

    public function delete()
    {
        $this->title('Удалить секцию');
        $this->bc('admin', '/admin');
        $this->bc('Форум', '/forum');
        $this->bc('Секции форума', '/admin/forum/section');
        $this->bc('Удалить секцию');
        $this->data['sectionSubMenu'] = true;
        new view('admin/forum/sections/delete', $this->data);
    }

    public function deleteAction()
    {
        $section = sections::find(request('get')->section_id);
        $section->delete();
        redirect('/admin/forum/section');
    }
}
