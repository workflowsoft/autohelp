<?php
/**
 * Created by PhpStorm.
 * User: PavelTropin
 * Date: 19.01.14
 * Time: 16:53
 */

class ApicardController extends  Controller {

    public function accessRules()
    {
        return array(
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                  'actions' => array('check'),
                  'users' => array('@'),
                 ),
        );
    }

    public function actionCheck($id)
    {
        $result = CardChecker::CheckCard($id);
        $this->_sendResponse(200, CJSON::encode($result));
    }
 }