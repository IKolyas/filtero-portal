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
use app\traits\ErrorsForm;

class AdminController extends AbstractController
{
    use ErrorsForm;

    protected string $defaultAction = 'activities';

    const TABS = [
        ['tab' => 'activities', 'title' => 'Активности', 'link' => '/admin/activities', 'is_active' => false],
        ['tab' => 'types', 'title' => 'Типы', 'link' => '/admin/types', 'is_active' => false],
        ['tab' => 'institutes', 'title' => 'Учреждения', 'link' => '/admin/institutes', 'is_active' => false],
        ['tab' => 'users', 'title' => 'Пользователи', 'link' => '/admin/users', 'is_active' => false],
    ];

    public function runAction($action = null, $params = []): void
    {
        if (!app()->session->isAuth()) app()->path->redirect('/auth/login');

        parent::runAction($action, $params);
    }

    public function actionActivities()
    {
        list($errorsFields, $oldFields) = $this->getErrors('activity');

        $user = User::findAll()[0];
        $auth_user = app()->session->isAuth();

        $activities = Activity::getActivitiesIndex()->get([]);

        Activity::getActivitiesFields($activities);

        $institutes = Institute::findAll();
        $types = ActivityType::findAll();

        $tabs = $this->tabActivate('activities');

        echo $this->render('admin.index', compact('activities', 'user', 'institutes', 'types', 'auth_user', 'tabs', 'errorsFields', 'oldFields'));

        app()->session->delete('activity');
    }

    public function actionTypes()
    {
        list($errorsFields, $oldFields) = $this->getErrors('types');

        $types = ActivityType::findAll();

        $tabs = $this->tabActivate('types');

        echo $this->render('admin.index', compact('types', 'tabs', 'errorsFields', 'oldFields'));

        app()->session->delete('types');
    }

    public function actionInstitutes()
    {
        list($errorsFields, $oldFields) = $this->getErrors('institutes');

        $institutes = Institute::findAll();

        $tabs = $this->tabActivate('institutes');

        echo $this->render('admin.index', compact('institutes', 'tabs', 'errorsFields', 'oldFields'));

        app()->session->delete('institutes');
    }

    public function actionUsers()
    {
        list($errorsFields, $oldFields) = $this->getErrors('users');

        $user = User::findAll();

        $tabs = $this->tabActivate('users');

        echo $this->render('admin.index', compact('user', 'tabs', 'errorsFields', 'oldFields'));

        app()->session->delete('users');
    }

    public function actionCreateActivity()
    {
        if (app()->request->isPost()) {
            $activitiesRequest = new ActivitiesRequest();

            if ($fields = $activitiesRequest->validate('create')) {
                if (Activity::create($fields)) {
                    app()->path->redirect('/admin/activities');
                }
            } elseif ($errors = $activitiesRequest->errors()) {
                $oldFields = $activitiesRequest->post();
                $this->setErrors($errors, $oldFields, "activity");

                app()->path->redirect('/admin/activities');
            }
        }
    }


    public function actionCreateInstitutes()
    {
        if (app()->request->isPost()) {
            $institutesRequest = new InstitutesRequest();

            if ($fields = $institutesRequest->validate('create')) {
                if (Institute::create($fields)) {
                    app()->path->redirect('/admin/institutes');
                }
            } elseif ($errors = $institutesRequest->errors()) {
                $oldFields = $institutesRequest->post();
                $this->setErrors($errors, $oldFields, "institutes");

                app()->path->redirect('/admin/institutes');
            }
        }
    }

    public function actionCreateTypes()
    {
        if (app()->request->isPost()) {
            $typesRequest = new TypesRequest();

            if ($fields = $typesRequest->validate('create')) {
                if (ActivityType::create($fields)) {
                    app()->path->redirect('/admin/types');
                }
            } elseif ($errors = $typesRequest->errors()) {
                $oldFields = $typesRequest->post();
                $this->setErrors($errors, $oldFields, "types");

                app()->path->redirect('/admin/types');
            }
        }
    }

    public function actionCreateUser()
    {
        if (app()->request->isPost()) {

            $userRequest = new UserRequest();

            if ($fields = $userRequest->validate('create')) {

                if (User::create($fields)) {
                    app()->path->redirect('/admin/users');
                }
            } elseif ($errors = $userRequest->errors()) {
                $oldFields = $userRequest->post();
                $this->setErrors($errors, $oldFields, "users");

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
            $fields = $activitiesRequest->validate('update');
            if ($fields) {
                $activities = Activity::find($fields['id']);
                if ($activities) {
                    Activity::update($fields);
                    app()->path->redirect('/admin');
                }
            } elseif ($errors = $activitiesRequest->errors()) {
                $oldFields = $activitiesRequest->post();
                $this->setErrors($errors, $oldFields, "activity");

                app()->path->redirect('/admin/activities');
            }
        }
    }

    public function actionUpdateInstitutes()
    {
        if (app()->request->isPost()) {
            $institutesRequest = new InstitutesRequest();
            $fields = $institutesRequest->validate('update');

            if ($fields) {
                $institutes = Institute::find($fields['id']);
                if ($institutes) {
                    Institute::update($fields);
                    app()->path->redirect('/admin/institutes');
                }
            } elseif ($errors = $institutesRequest->errors()) {
                $oldFields = $institutesRequest->post();
                $this->setErrors($errors, $oldFields, "institutes");

                app()->path->redirect('/admin/institutes');
            }
        }
    }

    public function actionUpdateTypes()
    {
        if (app()->request->isPost()) {
            $typesRequest = new TypesRequest();
            $fields = $typesRequest->validate('update');

            if ($fields) {
                $types = ActivityType::find($fields['id']);
                if ($types) {
                    ActivityType::update($fields);
                    app()->path->redirect('/admin/types');
                }
            } elseif ($errors = $typesRequest->errors()) {
                $oldFields = $typesRequest->post();
                $this->setErrors($errors, $oldFields, "types");

                app()->path->redirect('/admin/types');
            }
        }
    }

    public function actionUpdateUser()
    {

        if (app()->request->isPost()) {
            $userRequest = new UserRequest();
            $fields = $userRequest->validate('update');

            if ($fields) {
                $user = User::find($fields['id']);
                if ($user) {
                    User::update($fields);
                    app()->path->redirect('/admin/users');
                }
            } elseif ($errors = $userRequest->errors()) {
                $oldFields = $userRequest->post();
                $this->setErrors($errors, $oldFields, "users");

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