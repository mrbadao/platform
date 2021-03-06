<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
    public $siteId;
    public $title;
    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu = array();
    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs = array();

    public function init()
    {
        Yii::app()->theme = 'adminlte';
    }

    public function render($view, $data = null, $return = false)
    {
        if ($this->beforeRender($view)) {
            $output = $this->renderPartial($view, $data, true);
            if (($layoutFile = $this->getLayoutFile($this->layout)) !== false)
                if (!is_array($data)) {
                    $output = $this->renderFile($layoutFile, array('content' => $output), true);
                } else {
                    $output = $this->renderFile($layoutFile, array_merge(array('content' => $output), $data), true);
                }

            $this->afterRender($view, $output);

            $output = $this->processOutput($output);

            if ($return)
                return $output;
            else
                echo $output;
        }
    }

    public function beforeAction(CAction $action)
    {
        $this->title = Yii::app()->name." | ".$action->id;

        if($action->controller->id == 'site') return true;

        if(Yii::app()->user->isGuest && !($action->controller->id == 'admin' && $action->id == 'login'))
        {
            switch($action->controller->id){
                case 'admin':
                    if($action->id == 'login') return true;
                    else $loginUrl = $this->createUrl('admin/login');
                    break;
                case 'member':
                    if($action->id == 'login') return true;
                    else $loginUrl = $this->createUrl('member/login');
                    break;
            }
            var_dump($loginUrl);
            $this->redirect($loginUrl);
        }
        return true;
    }


}
