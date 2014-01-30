<?php

class ApiticketController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow', // allow all users to perform 'index' and 'view' actions
                'actions' => array('reject', 'partnerassign', 'savechecked', 'unlock'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    public function actionUnlock($id)
    {
        if (empty($id)) {
            $this->_sendResponse(200, CJSON::encode(array('success' => false, 'message' => 'No ticket id specified')));
        }
        $ticket = Ticket::model()->findByPk($id);
        if (empty($ticket)) {
            $this->_sendResponse(200, CJSON::encode(array('success' => false, 'message' => 'No ticket found by this id')));
        }
        if ($ticket->status != TicketStatus::CHECKING && $ticket->status != TicketStatus::ASSIGNING ) {
            $this->_sendResponse(200, CJSON::encode(array('success' => false, 'message' => 'Wrong ticket status')));
        }

        if ($ticket->status == TicketStatus::ASSIGNING) {
            $ticket->status = TicketStatus::NEW_TICKET;
            $ticket->user_id = null;
            if(!$ticket->save()){
                $this->_sendResponse(200, json_encode(array('success' => false, 'message' => $ticket->getErrors()), JSON_UNESCAPED_UNICODE));
            }
        } elseif ($ticket->status == TicketStatus::CHECKING) {
            $ticket->status = TicketStatus::ASSIGNED;
            $ticket->user_id = null;
            if(!$ticket->save()){
                $this->_sendResponse(200, json_encode(array('success' => false, 'message' => $ticket->getErrors()), JSON_UNESCAPED_UNICODE));
            }

        } else {
            $this->_sendResponse(200, CJSON::encode(array('success' => false, 'message' => 'Ticket status doesn\'t allow unlock')));
        }

        $this->_sendResponse(200, CJSON::encode(array('success' => true)));

    }


    public function actionPartnerAssign($id)
    {
//        $this->_sendResponse(400, CJSON::encode($_POST['data']));
        if (empty($id) || !isset($_POST['data'])) {
            $this->_sendResponse(404, 'No ticket id specified or empty data');
        }
        $ticket_id = $id;
        $ticket = Ticket::model()->findByPk($ticket_id);

        if ($ticket->status != TicketStatus::ASSIGNING) {
            $this->_sendResponse(404, 'Incorrect status for assign');
        }
        $data = $_POST['data'];
        foreach ($data as $item) {
            if (empty($item['time'])) {
                $this->_sendResponse(404, 'Empty time for partner_id=' . $item['partner_id'] . ' and service_id=' . $item['service_id']);
            }
            if (!empty($item['partner_id']) && !empty($item['service_id'])) {
                $partner2ticket = new Partner2ticket;
                $param = array(
                    ':pid' => $item['partner_id'],
                    ':sid' => $item['service_id'],
                );
                $partner2service = Partner2service::model()
                    ->find('partner_id=:pid and service_id=:sid', $param
                    );
                $partner2ticket->partner2service_id = $partner2service->id;
                $partner2ticket->ticket_id = $ticket_id;
                $partner2ticket->arrival_time = $this->addTime($item['time']);
                $partner2ticket->save();
            }
        }

        $ticket->status = TicketStatus::ASSIGNED;
        $ticket->user_id = null;
        $ticket->save();

        $this->_sendResponse(200, CJSON::encode(array('success' => true)));
    }


    public function actionReject($id)
    {
        if (empty($id) || empty($_POST['reject_comment'])) {
            $this->_sendResponse(404, 'No ticket id specified or empty data');
        }

        $ticket = Ticket::model()->findByPk($id);

        if ($ticket->status == TicketStatus::DONE || $ticket->status == TicketStatus::REJECTED ) {
            $this->_sendResponse(200, CJSON::encode(array('success' => false, 'message' => 'Wrong ticket status')));
        }

        $ticket->status = TicketStatus::REJECTED;
        $ticket->reject_comment = $_POST['reject_comment'];

        $ticket->user_id = null;
        $response = array();
        if ($ticket->save()) {
            $response = array('success' => true);
        } else {
            $response = array('success' => true);
        }
        $this->_sendResponse(200, CJSON::encode($response));
    }


    public function actionSaveChecked($id)
    {
        if (empty($id)) {
            $this->_sendResponse(200, CJSON::encode(array('success' => false, 'description' => 'No ticket id')));
        }
        $ticket = Ticket::model()->findByPk($id);
        if ($ticket->status != TicketStatus::CHECKING ) {
            $this->_sendResponse(200, CJSON::encode(array('success' => false, 'message' => 'Wrong ticket status')));
        }


        if (!empty($_POST['rejected_services'])) {
            foreach ($_POST['rejected_services'] as $service) {
                $partner2service = Partner2service::model()->find(
                    'partner_id=:pid and service_id=:sid',
                    array(
                        ':pid' => $service['partner_id'],
                        ':sid' => $service['service_id'],
                    )
                );
                $partner2ticket = Partner2ticket::model()->find(
                    'partner2service_id=:p2sid and ticket_id=:tid',
                    array(
                        ':p2sid' => $partner2service->id,
                        ':tid' => $id,
                    )
                );

                $partner2ticket->reject_comment = $service['comment'];
                $partner2ticket->save();
            }
        }


        $ticket->status = TicketStatus::DONE;
        $ticket->user_id = null;
        $response = array();
        if ($ticket->save()) {
            $response = array('success' => true);
        } else {
            $response = array('success' => false);
        }
        $this->_sendResponse(200, CJSON::encode($response));
    }

    /**
     * adds minutes to current time
     * @param int $minutes
     */
    private function addTime($minutes)
    {
        $time = new DateTime(date('H:i:s'));
        $interval = new DateInterval('PT' . $minutes . 'M');
        $time->add($interval);
        return $time->format('H:i:s');
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = Ticket::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'ticket-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
