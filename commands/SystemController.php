<?php

namespace app\commands;

use yii\console\Controller;
use app\models\Users;

class SystemController extends Controller
{
    
    public function actionIndex($message = 'hello world')
    {
        echo $message . "\n";
    }

    public function actionCreateUser($username, $password, $role, $dept)
    {
        $user = new Users();
        $user->username= $username;
        $user->setPassword($password);
        $user->role=$role;
        $user->department = $dept;
        if(!$user->save()){
            echo "Error!: \n";
            echo var_dump($user);
        }else {
            echo "The new user has been created.\n";
        }
    }
}
