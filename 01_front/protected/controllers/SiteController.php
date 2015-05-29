<?php

class SiteController extends Controller
{
    /**
     * This is the default 'index' action that is invoked
     * when an action is not explicitly requested by users.
     */
    public function actionIndex()
    {
        $this->render('index');
    }

    public function actionLogin()
    {
        //Check logined
        if (!Yii::app()->user->IsGuest) {
            $this->redirect('index');
        }

        $model = new LoginForm;

        //Reject  ajax request
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'login-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        $hasError = false;

        // collect user input data
        if (isset($_POST['LoginForm'])) {
            $_POST['LoginForm']['rememberMe'] = $_POST['LoginForm']['rememberMe'] == 'on' ? true : false;
            $model->attributes = $_POST['LoginForm'];

            if ($model->validate() && $model->login()) {
                $this->forward('index');
            }
            $hasError = true;
            $errorMessage = $model->getError('username') ? $model->getError('username') : $model->getError('password');
        }

        // display the login form
        $this->layout = 'login';
        $this->render('login', compact('model', 'hasError', 'errorMessage'));
    }

    public function actionError()
    {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else

                $this->render($error['code'], $error);
        }
    }

    /**
     * Logs out the current user and redirect to homepage.
     */
    public function actionLogout()
    {
        Yii::app()->user->logout();
        $this->redirect(Yii::app()->homeUrl);
    }

    /**
     * send mail by ajax
     * @throws \CException
     * @throws \Exception
     * @throws \phpmailerException
     */
    public function actionTest()
    {
        if(!Yii::app()->request->isAjaxRequest) throw new CHttpException(404,' Page not found.');

        if (isset($_POST['email'])) {

            $mail2Send = $_POST['email'];
            if (strpos($mail2Send['emailto'], '@') == false) {
                $mail2Send['emailto'] .= substr(Yii::app()->user->email, strpos(Yii::app()->user->email, '@'));
            }

            Yii::import('ext.YiiMailer', true);
            $config = require_once(Yii::getPathOfAlias(Yii::app()->params['YiiMailer']) . DIRECTORY_SEPARATOR . "mail.php");
            $config['Username'] = Yii::app()->user->email;

            $CriteriaArr = array(
                'staff_id' => Yii::app()->user->getId(),
                'role' =>  'staff',
            );

            if (Yii::app()->user->isAdmin) {
                $config['savePath'] = str_replace('assets', "assets.admin." . Yii::app()->user->getId(), $config['savePath']);
                $CriteriaArr['role'] = 'administrators';
            }
            else $config['savePath'] = str_replace('assets', "assets.staff." . Yii::app()->user->getId(), $config['savePath']);

            $config['Password'] = PwdStore::model()->findByAttributes($CriteriaArr)->value;;

            if (!file_exists(Yii::getPathOfAlias($config['savePath']))) {
                mkdir(Yii::getPathOfAlias($config['savePath']), 0755, true);
            }

            $mail = new YiiMailer($config);
            $mail->setFrom(Yii::app()->user->email, Yii::app()->user->getName());
            $mail->setTo($mail2Send['emailto']);
            $mail->setSubject($mail2Send['subject']);
            $mail->setBody($mail2Send['data']);
            $mail->IsSMTP();
            if ($mail->send()) {
                echo json_encode(
                    array(
                        'status' => 200,
                        'message' => 'send mail success.',
                    )
                );
            } else {
                echo json_encode(
                    array(
                        'error' => 500,
                        'message' => $mail->getError(),
                    )
                );
            }
        }
    }

}