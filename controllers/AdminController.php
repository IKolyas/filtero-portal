<?php

namespace app\controllers;

use app\models\Activity;
use app\models\ActivityType;
use app\models\Institute;
use app\models\User;


use app\requests\admin\UserRequest;
use app\requests\admin\InstitutesRequest;
use app\requests\admin\TypesRequest;
use app\requests\admin\ActivitiesRequest;

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
        $sessionInfo = app()->session->get('activity');
        $errorsFields = [];
        $oldFields = [];

        if (isset($sessionInfo['errorsFields']) && !empty($sessionInfo['errorsFields'])) {
            $errorsFields = $sessionInfo['errorsFields'];
        }

        if (isset($sessionInfo['oldFields']) && !empty($sessionInfo['oldFields'])) {
            $oldFields = $sessionInfo['oldFields'];
        }

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


        echo $this->render('admin.index', compact('activities', 'user', 'institutes', 'types', 'auth_user', 'tabs', 'errorsFields', 'oldFields'));

        app()->session->delete('activity');
    }

    public function actionTypes()
    {
        $sessionInfo = app()->session->get('types');
        $errorsFields = [];
        $oldFields = [];

        if (isset($sessionInfo['errorsFields']) && !empty($sessionInfo['errorsFields'])) {
            $errorsFields = $sessionInfo['errorsFields'];
        }

        if (isset($sessionInfo['oldFields']) && !empty($sessionInfo['oldFields'])) {
            $oldFields = $sessionInfo['oldFields'];
        }

        $types = ActivityType::findAll();

        $tabs = $this->tabActivate('types');

        echo $this->render('admin.index', compact('types', 'tabs', 'errorsFields', 'oldFields'));

        app()->session->delete('types');
    }

    public function actionInstitutes()
    {
        $sessionInfo = app()->session->get('institutes');
        $errorsFields = [];
        $oldFields = [];

        if (isset($sessionInfo['errorsFields']) && !empty($sessionInfo['errorsFields'])) {
            $errorsFields = $sessionInfo['errorsFields'];
        }

        if (isset($sessionInfo['oldFields']) && !empty($sessionInfo['oldFields'])) {
            $oldFields = $sessionInfo['oldFields'];
        }

        $institutes = Institute::findAll();

        $tabs = $this->tabActivate('institutes');

        echo $this->render('admin.index', compact('institutes','tabs', 'errorsFields', 'oldFields'));

        app()->session->delete('institutes');
    }

    public function actionUsers()
    {
        $sessionInfo = app()->session->get('users');
        $errorsFields = [];
        $oldFields = [];

        if (isset($sessionInfo['errorsFields']) && !empty($sessionInfo['errorsFields'])) {
            $errorsFields = $sessionInfo['errorsFields'];
        }

        if (isset($sessionInfo['oldFields']) && !empty($sessionInfo['oldFields'])) {
            $oldFields = $sessionInfo['oldFields'];
        }

        $user = User::findAll();

        $tabs = $this->tabActivate('users');
        
        echo $this->render('admin.index', compact('user', 'tabs', 'errorsFields', 'oldFields'));

        app()->session->delete('users');
    }

    public function actionCreateActivity()
    {


        if (app()->request->isPost()) {
            $activitiesRequest = new ActivitiesRequest();

            if($fields = $activitiesRequest->validate()) {
                if (Activity::create($fields)) {
                    app()->path->redirect('/admin/activities');
                }
            } elseif ($errors = $activitiesRequest->errors()) {
                $info = [];
                $info['errorsFields'] = $errors;
                $info['oldFields'] = $activitiesRequest->post();
                app()->session->set("activity", $info);
                app()->path->redirect('/admin/activities');
            }
        }
    }
    

    public function actionCreateInstitutes()
    {

        if (app()->request->isPost()) {
            $institutesRequest = new InstitutesRequest();
            
            if($fields = $institutesRequest->validate()) {
                                
                if (Institute::create($fields)) {
                    app()->path->redirect('/admin/institutes');
                }
            } elseif ($errors = $institutesRequest->errors()) {
                $info = [];
                $info['errorsFields'] = $errors;
                $info['oldFields'] = $institutesRequest->post();
                app()->session->set("institutes", $info);
                app()->path->redirect('/admin/institutes');
            }
        }
    }

    public function actionCreateTypes()
    {
        if (app()->request->isPost()) {
            $typesRequest = new TypesRequest();
            
            if($fields = $typesRequest->validate()) {
                if (ActivityType::create($fields)) {
                    app()->path->redirect('/admin/types');
                }
            } elseif ($errors = $typesRequest->errors()) {
                $info = [];
                $info['errorsFields'] = $errors;
                $info['oldFields'] = $typesRequest->post();
                app()->session->set("types", $info);
                app()->path->redirect('/admin/types');
            }
        }
    }
    
    public function actionCreateUser()
    {
        if (app()->request->isPost()) {

            $userRequest = new UserRequest();
            
            if($fields = $userRequest->validate()) {
                                
                if (User::create($fields)) {
                    app()->path->redirect('/admin/users');
                }
            } elseif ($errors = $userRequest->errors()) {
                $info = [];
                $info['errorsFields'] = $errors;
                $info['oldFields'] = $userRequest->post();
                app()->session->set("users", $info);
                app()->path->redirect('/admin/users');
            }
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
            $activitiesRequest = new ActivitiesRequest();
            $fields = $activitiesRequest->validate();
            
            if($fields) {
                $activities = Activity::find($fields['id']);
                if($activities) {
                    if (Activity::update($fields)) {
                        app()->path->redirect('/admin');
                    }
                }
            } elseif ($errors = $activitiesRequest->errors()) {
                $info = [];
                $info['errorsFields'] = $errors;
                $info['oldFields'] = $activitiesRequest->post();
                app()->session->set("activity", $info);
                app()->path->redirect('/admin/activities');
            }
        }
    }

    public function actionUpdateInstitutes()
    {
        if (app()->request->isPost()) {
            $institutesRequest = new InstitutesRequest();
            $fields = $institutesRequest->validate();
            
            if($fields) {
                $institutes = Institute::find($fields['id']);
                if($institutes) {
                    if (Institute::update($fields)) {
                        app()->path->redirect('/admin/institutes');
                    }
                }
            } elseif ($errors = $institutesRequest->errors()) {
                $info = [];
                $info['errorsFields'] = $errors;
                $info['oldFields'] = $institutesRequest->post();
                app()->session->set("institutes", $info);
                app()->path->redirect('/admin/institutes');
            }
            
        }
    }

    public function actionUpdateTypes()
    {
        if (app()->request->isPost()) {
            $typesRequest = new TypesRequest();
            $fields = $typesRequest->validate();
            

            if($fields) {
                $institutes = ActivityType::find($fields['id']);
                if($institutes) {
                    if (ActivityType::update($fields)) {
                        app()->path->redirect('/admin/types');
                    }
                }
            } elseif ($errors = $typesRequest->errors()) {
                $info = [];
                $info['errorsFields'] = $errors;
                $info['oldFields'] = $typesRequest->post();
                app()->session->set("types", $info);
                app()->path->redirect('/admin/types');
            }
            
        }
    }

    public function actionUpdateUser()
    {

        if (app()->request->isPost()) {
            $userRequest = new UserRequest();
            $fields = $userRequest->validate();
            
            if($fields) {
                $user = User::find($fields['id']);
                if($user) {
                    if (User::update($fields)) {
                        app()->path->redirect('/admin/users');
                    }
                }
            } elseif ($errors = $userRequest->errors()) {
                $info = [];
                $info['errorsFields'] = $errors;
                $info['oldFields'] = $userRequest->post();
                app()->session->set("users", $info);
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