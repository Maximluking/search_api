<?php

namespace console\controllers;

use common\models\User;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\helpers\Console;

class AuthController extends Controller
{
    public $login;
    public $password;
    public $email;

    public function options($actionID)
    {
        return array_merge(parent::options($actionID), ['login', 'password', 'email']);
    }

    public function optionAliases()
    {
        return array_merge(parent::optionAliases(), ['l' => 'login', 'p' => 'password', 'e' => 'email']);
    }

    public function actionAddAdmin()
    {
        if (!$this->login || !$this->email || !$this->password) {
            $this->stdout("All parameters must be specified[login|email|password]!\n", Console::FG_RED);

            return ExitCode::UNSPECIFIED_ERROR;
        }

        if (User::find()->where(['username' => $this->login])->count()) {
            $this->stdout("This login is already taken!\n", Console::FG_YELLOW);

            return ExitCode::UNSPECIFIED_ERROR;
        }

        if (User::find()->where(['email' => $this->email])->count()) {
            $this->stdout("This email is already taken!\n", Console::FG_YELLOW);

            return ExitCode::UNSPECIFIED_ERROR;
        } elseif (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->stdout("This email is incorrect!\n", Console::FG_YELLOW);

            return ExitCode::UNSPECIFIED_ERROR;
        }

        $superAdmin = new User();
        $superAdmin->username = trim($this->login);
        $superAdmin->status = User::STATUS_ACTIVE;
        $superAdmin->email = $this->email;
        $superAdmin->setPassword($this->password);
        $superAdmin->generateAuthKey();

        if ($superAdmin->save(false)) {
            $this->stdout("An account with a role super admin has been added!\n", Console::FG_GREEN);

            return ExitCode::OK;
        } else {
            return ExitCode::UNSPECIFIED_ERROR;
        }
    }
}
