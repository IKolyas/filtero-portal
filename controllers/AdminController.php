<?php

namespace app\controllers;

use app\models\Activity;
use app\models\ActivityType;
use app\models\Institute;
use app\models\User;

class AdminController extends AbstractController
{

    public function actionIndex()
    {
        $activities = Activity::findAll();
        $user = User::findAll()[0];
        foreach ($activities as $activity) {
            $activity->age = $activity->getAgeRange();
            $activity->institute = Institute::find($activity->institute_id)->title;
            $activity->type = ActivityType::find($activity->activity_type_id)->title;
        }

        $institutes = Institute::findAll();
        $types = ActivityType::findAll();

        echo $this->render('admin.activities', compact('activities', 'institutes', 'types', 'user'));
    }

    public function actionTypes()
    {
        $types = ActivityType::findAll();

        echo $this->render('admin.types', compact('types'));
    }

    public function actionInstitutes()
    {
        $institutes = Institute::findAll();

        echo $this->render('admin.institutes', compact('institutes'));
    }

    public function actionUser()
    {
        $user = User::findAll();
        
        echo $this->render('admin.user', compact('user'));
    }

    public function actionCreateActivity()
    {

        if (app()->request->isPost()) {
            if (Activity::create(app()->request->post())) {
                app()->path->redirect('/admin');
            }
        }
    }

    public function actionCreateInstitutes()
    {

        if (app()->request->isPost()) {
            if (Institute::create(app()->request->post())) {
                app()->path->redirect('/admin/institutes');
            }
        }
    }

    public function actionCreateTypes()
    {
        if (app()->request->isPost()) {
            if (ActivityType::create(app()->request->post())) {
                app()->path->redirect('/admin/types');
            }
        }
    }

    public function actionCreateUser()
    {

        if (app()->request->isPost()) {
            if (User::create(app()->request->post())) {
                app()->path->redirect('/admin/user');
            }
        }
    }

    public function actionDeleteActivity()
    {
        if (app()->request->isGet()) {
            if (Activity::delete(app()->request->getParams())) {
                app()->path->redirect('/admin');
            }
        }
    }
    
    public function actionDeleteInstitutes()
    {
        if (app()->request->isGet()) {
            if (Institute::delete(app()->request->getParams())) {
                app()->path->redirect('/admin/institutes');
            }
        }
    }

    public function actionDeleteTypes()
    {
        if (app()->request->isGet()) {
            if (ActivityType::delete(app()->request->getParams())) {
                app()->path->redirect('/admin/types');
            }
        }
    }
    
    public function actionDeleteUser()
    {
        if (app()->request->isGet()) {
            if (User::delete(app()->request->getParams())) {
                app()->path->redirect('/admin/user');
            }
        }
    }

    public function actionUpdateInstitutes()
    {
        if (app()->request->isPost()) {
            $request = app()->request->post();
            $type_id = Institute::find($request['id']);
            
            if($type_id) {
                if (Institute::update($request)) {
                    app()->path->redirect('/admin/institutes');
                }
            }
        }
    }

    public function actionUpdateTypes()
    {
        if (app()->request->isPost()) {
            $request = app()->request->post();
            $type_id = ActivityType::find($request['id']);
            
            if($type_id) {
                if (ActivityType::update($request)) {
                    app()->path->redirect('/admin/types');
                }
            }
        }
    }
    public function actionUpdateUser()
    {
        if (app()->request->isPost()) {
            $request = app()->request->post();
            $type_id = User::find($request['id']);
            
            if($type_id) {
                if (User::update($request)) {
                    app()->path->redirect('/admin/user');
                }
            }
        }
    }
}