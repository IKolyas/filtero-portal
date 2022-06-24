<?php

namespace app\controllers;

use app\models\Activity;
use app\models\ActivityType;
use app\models\Institute;
use app\models\User;


class AdminController extends AbstractController
{
    protected string $defaultAction = 'activities';

    const TABS = [
        ['tab' => 'activities', 'title' => 'Активности', 'link' => '/admin/activities', 'is_active' => false],
        ['tab' => 'types', 'title' => 'Типы', 'link' => '/admin/types', 'is_active' => false],
        ['tab' => 'institutes', 'title' => 'Учреждения', 'link' => '/admin/institutes', 'is_active' => false],
        ['tab' => 'users', 'title' => 'Пользователи', 'link' => '/admin/users', 'is_active' => false],
    ];

    public function runAction($action = null, $params = []): void
    {
        if(!app()->session->isAuth()) app()->path->redirect('/auth/login');

        parent::runAction($action, $params);
    }

    public function actionActivities()
    {
        $activities = Activity::findAll();
        $user = User::findAll()[0];
        $auth_user = app()->session->isAuth();
        foreach ($activities as $activity) {
            $activity->age = $activity->getAgeRange();
            $activity->institute = Institute::find($activity->institute_id)->title;
            $activity->institute_id = Institute::find($activity->institute_id)->id;
            $activity->type = ActivityType::find($activity->activity_type_id)->title;
            $activity->type_id = ActivityType::find($activity->activity_type_id)->id;
        }
        $institutes = Institute::findAll();
        $types = ActivityType::findAll();

        $tabs = $this->tabActivate('activities');


        echo $this->render('admin.index', compact('activities', 'user', 'institutes', 'types', 'auth_user', 'tabs'));

    }

    public function actionTypes()
    {
        $types = ActivityType::findAll();

        $tabs = $this->tabActivate('types');

        echo $this->render('admin.index', compact('types', 'tabs'));
    }

    public function actionInstitutes()
    {
        $institutes = Institute::findAll();

        $tabs = $this->tabActivate('institutes');

        echo $this->render('admin.index', compact('institutes','tabs'));
    }

    public function actionUsers()
    {
        $user = User::findAll();

        $tabs = $this->tabActivate('users');
        
        echo $this->render('admin.index', compact('user', 'tabs'));

    }

    public function actionCreateActivity()
    {

        if (app()->request->isPost()) {

            Activity::create(app()->request->post());
            app()->path->redirect('/admin');
        } 
    }
    

    public function actionCreateInstitutes()
    {
        
        if (app()->request->isPost()) {
            
            Institute::create(app()->request->post());
            app()->path->redirect('/admin/institutes');

        }
    }
    

    public function actionCreateTypes()
    {
        if (app()->request->isPost()) {
            ActivityType::create(app()->request->post());
            app()->path->redirect('/admin/types');
            
        }
    }

    public function actionCreateUser()
    {

        if (app()->request->isPost()) {
            User::create(app()->request->post());
                app()->path->redirect('/admin/users');
        } 
    }


    public function actionDeleteActivity()
    {
        if (app()->request->isGet()) {
            Activity::delete(app()->request->getParams());
            app()->path->redirect('/admin');
            
        }
    }
    
    public function actionDeleteInstitutes()
    {
        if (app()->request->isGet()) {
            Institute::delete(app()->request->getParams());
            app()->path->redirect('/admin/institutes');
            
        }
    }

    public function actionDeleteTypes()
    {
        if (app()->request->isGet()) {
            ActivityType::delete(app()->request->getParams());
            app()->path->redirect('/admin/types'); 
            
        }
    }
    
    public function actionDeleteUser()
    {
        if (app()->request->isGet()) {
            User::delete(app()->request->getParams());
            app()->path->redirect('/admin/users');
            
        }
    }

    public function actionUpdateActivity()
    {
        if (app()->request->isPost()) {
            $request = app()->request->post();
            $type_id = Activity::find($request['id']);
            if($type_id) {
                Activity::update($request);
                app()->path->redirect('/admin');  
            }
        }
    }

    public function actionUpdateInstitutes()
    {
        if (app()->request->isPost()) {
            $request = app()->request->post();
            $type_id = Institute::find($request['id']);
            
            if($type_id) {
                Institute::update($request);
                app()->path->redirect('/admin/institutes');
            }
        }
    }

    public function actionUpdateTypes()
    {
        if (app()->request->isPost()) {
            $request = app()->request->post();
            $type_id = ActivityType::find($request['id']);
            
            if($type_id) {
                ActivityType::update($request);
                app()->path->redirect('/admin/types');
            }
        }
    }
    public function actionUpdateUser()
    {
        $request = app()->request->post();
        if ($request) {
            $user = User::find($request['id']);
            if($user) {
                User::update($request);
                app()->path->redirect('/admin/users');
            }
        }
    }

    private function tabActivate($tab_name): array
    {
        $tabs = self::TABS;
        return array_map(function ($tab) use ($tab_name) {
            if ($tab['tab'] == $tab_name) $tab['is_active'] = true;
            return $tab;
        }, $tabs);
    }
}