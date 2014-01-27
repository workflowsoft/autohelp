<?php

class TicketController extends Controller
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
                'actions' => array('index', 'view', 'create', 'update', 'admin', 'delete', 'partnerassign', 'a_partnerassign', 'check', 'a_saveChecked'),
                'users' => array('@'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        $ticket = $this->loadModel($id);

        $partner2ticket = Partner2ticket::model()->findAll('ticket_id=:id', array(':id' => $id));
        $partners = array();
        foreach ($partner2ticket as $item) {
            $par2service = Partner2service::model()->findByPk($item->partner2service_id);
            $partner = Partner::model()->findByPk($par2service->partner_id);
            $service = Service::model()->findByPk($par2service->service_id);
            if (empty($partners[$partner->id])) {
                $partners[$partner->id] = array(
                    'id' => $partner->id,
                    'title' => $partner->title,
                    'phone' => $partner->phone,
                );
            }
            $partners[$partner->id]['services'][] = array(
                'service' => $service,
                'time' => $item->arrival_time,
                'reject_comment' => $item->reject_comment,
            );
        }

//        throw new CHttpException(400, var_export($partners, true));

        $this->render('view', array(
            'model' => $ticket,
            'order' => Order::model()->findByPk($ticket->order_id),
            'partners' => $partners,
        ));
    }

    public function actionCheck($id)
    {
        $ticket = $this->loadModel($id);

        if ($ticket->status != TicketStatus::CHECKING && $ticket->status != TicketStatus::ASSIGNED) {
            throw new CHttpException(400, 'Статус данного инцдента не позволяет проверку');
        }
        if ($ticket->status == TicketStatus::CHECKING && UserIdentity::getCurrentUserId() !== $ticket->user_id) {
            throw new CHttpException(400, 'Инцидент уже проверяется другим пользователем');
        }

        $ticket->status = TicketStatus::CHECKING;
        $ticket->user_id = UserIdentity::getCurrentUserId();
        $ticket->save();

        $partner2ticket = Partner2ticket::model()->findAll('ticket_id=:id', array(':id' => $id));
        $partners = array();
        foreach ($partner2ticket as $item) {
            $par2service = Partner2service::model()->findByPk($item->partner2service_id);
            $partner = Partner::model()->findByPk($par2service->partner_id);
            $service = Service::model()->findByPk($par2service->service_id);
            if (empty($partners[$partner->id])) {
                $partners[$partner->id] = array(
                    'id' => $partner->id,
                    'title' => $partner->title,
                    'phone' => $partner->phone,
                );
            }
            $partners[$partner->id]['services'][] = array(
                'service' => $service,
                'time' => $item->arrival_time,
            );
        }

//        throw new CHttpException(400, var_export($partners, true));

        $this->render('view_check', array(
            'model' => $ticket,
            'partners' => $partners,
            'order' => Order::model()->findByPk($ticket->order_id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $order_id = isset($_REQUEST['order_id']) ? $_REQUEST['order_id'] : null;
        $ticket_id = isset($_REQUEST['ticket_id']) ? $_REQUEST['ticket_id'] : null;

        if (empty($order_id)) {
            throw new CHttpException(400, 'Invalid request. Specify order_id');
        }

        if (!empty($ticket_id)) {
            $tmp = Ticket::model()->findByPk($ticket_id);
            if ($tmp->status != TicketStatus::DRAFT) {
                throw new CHttpException(400, 'Статус данного инцдента не позволяет создание');
            }
        }

        //если для этого ордера уже существуюет тикет, редирект на него
        $old_ticket = Ticket::model()->find('order_id=:order_id and status not in ("' . TicketStatus::REJECTED . '","' . TicketStatus::DONE . '")', array(':order_id' => $order_id));
        if ($old_ticket && empty($ticket_id)) {
            $this->redirect(array('/ticket/view', 'id' => $old_ticket->id));
        }

        $order = Order::model()->findByPk($order_id);

        if (isset($_POST['Ticket']) && isset($ticket_id)) {

            $ticket = Ticket::model()->findByPk($ticket_id);
            if ($ticket->status != 'draft') {
                throw new CHttpException(400, 'We can save only drafts');
            }
            $ticket->attributes = $_POST['Ticket'];
            if ($ticket->validate()) {
                $ticket->order_id = $order_id;
                $ticket->payment_without_card = (int)!$order->isActivated();
                $ticket->status = TicketStatus::NEW_TICKET;
                $ticket->user_id = null;
                if ($ticket->save()) {
                    if (isset($_POST['Service'])) {
                        foreach ($_POST['Service'] as $key => $service) {
                            if (!empty($service)) {
                                $relation = new Ticket2service();
                                $relation->ticket_id = $ticket->id;
                                $relation->service_id = $key;

                                $relation->save();
                            }

                        }
                    }

                } else {
                    throw new CHttpException(400, var_export($ticket->getErrors(), true));
                }
                $this->redirect(array('view', 'id' => $ticket->id));
            } else {
                $validate_errors = true;
            }
        }


        if (!empty($ticket_id)) {
            if (empty($validate_errors)) {
                $ticket = new Ticket;
            }
            $ticket->payment_without_card = !$order->isActivated();
            $this->render('create', array(
                'ticket' => $ticket,
                'order' => $order,
                'services' => new Services(),
            ));
        } else {
            // first status is draft
            $ticket = new Ticket;
            $ticket->status = TicketStatus::DRAFT;
            $ticket->comment = 'Заполните поле комментарий!';
            $ticket->user_id = UserIdentity::getCurrentUserId();
            $ticket->order_id = $order_id;
            if (!$ticket->save()) {
                throw new CHttpException(400, var_export($ticket->getErrors(), true));
            };
            $this->redirect(array('create', 'order_id' => $order_id, 'ticket_id' => $ticket->id));
        }


    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $ticket = $this->loadModel($id);
        if ($ticket->status != TicketStatus::DRAFT) {
            throw new CHttpException(400, 'Статус данного инцдента не позволяет редактирование');
        }

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Ticket'])) {
            $ticket->attributes = $_POST['Ticket'];
            if ($ticket->validate()) {
                if ($_POST['save_new']) {
                    $ticket->status = TicketStatus::NEW_TICKET;
                }
                if ($ticket->save()) {
                    Ticket2service::model()->deleteAll('ticket_id=:tid', array(':tid' => $ticket->id));
                    if (isset($_POST['Service'])) {
                        foreach ($_POST['Service'] as $key => $service) {
                            if (!empty($service)) {
                                $relation = new Ticket2service();
                                $relation->ticket_id = $ticket->id;
                                $relation->service_id = $key;

                                $relation->save();
                            }

                        }
                    }

                } else {
                    throw new CHttpException(400, var_export($ticket->getErrors(), true));
                }
                $this->redirect(array('view', 'id' => $ticket->id));
            }
        }

        //get acrive services
        $sql = "SELECT service_id FROM ticket2service where ticket_id=" . $ticket->id;
        $services = Yii::app()->db->createCommand($sql)->queryAll();
        $active_services = array();
        foreach ($services as $item) {
            $active_services[] = $item['service_id'];
        }

        $this->render('update', array(
            'ticket' => $ticket,
            'order' => Order::model()->findByPk($ticket->order_id),
            'services' => new Services(),
            'active_services' => $active_services,
        ));
    }

    public function actionPartnerAssign($id)
    {
        $ticket = $this->loadModel($id);
        if ($ticket->status != TicketStatus::ASSIGNING && $ticket->status != TicketStatus::NEW_TICKET) {
            throw new CHttpException(400, 'Статус данного инцдента не позволяет назначение');
        }
        if ($ticket->status == TicketStatus::ASSIGNING && UserIdentity::getCurrentUserId() !== $ticket->user_id) {
            throw new CHttpException(400, 'Партнеры уже назначаются другим пользователем');
        }

        if (isset($_POST['data'])) {
//            $this->redirect(array('view','id'=>$model->id));
        }

        if (isset($_POST['Ticket'])) {
            $ticket->attributes = $_POST['Ticket'];
            if ($ticket->save())
                $this->redirect(array('view', 'id' => $ticket->id));
        }
        $ticket->status = TicketStatus::ASSIGNING;
        $ticket->user_id = UserIdentity::getCurrentUserId();
        $ticket->save();


        // select available partners
        $sql = "call getPartnersAssignList($id)";
        $partners = Yii::app()->db->createCommand($sql)->queryAll();

        foreach ($partners as $k => $partner) {
            //Получаем услуги
            $service_ids = preg_split('/,/', $partner['ServiceIds']);
            $service_ids = array_unique($service_ids);
            foreach ($service_ids as $sid) {
                $partners[$k]['services'][] = Service::model()->findByPk($sid);
            }


            // Выбираем услуги, кот не могут быть предоставлены
            if (empty($partner['PartnerId'])) {
                foreach ($partners[$k]['services'] as $service) {
                    $partners['services_not_available'][] = $service;
                }
            } else {
                //Запихнем все услуги партнера, для полного счастья
                $ps = Partner::model()->with('service')->findByPk($partner['PartnerId']);
                $partners[$k]['all_services'] = array_diff($ps->service, $partners[$k]['services']);
                $partners['available'][] = $partners[$k];
            }

            unset($partners[$k]);
        }


//        $ps = Partner::model()->with('service')->findByPk(1);


        $this->render('partnerAssign', array(
            'model' => $ticket,
            'partners' => $partners,
            'order' => Order::model()->findByPk($ticket->order_id),
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
//    public function actionDelete($id)
//    {
//        if (Yii::app()->request->isPostRequest) {
//             we only allow deletion via POST request
//            $this->loadModel($id)->delete();
//
//             if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
//            if (!isset($_GET['ajax']))
//                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
//        } else
//            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
//    }

    /**
     * Lists all models.
     */
//    public function actionIndex()
//    {
//        $dataProvider = new CActiveDataProvider('Ticket');
//        $this->render('index', array(
//            'dataProvider' => $dataProvider,
//        ));
//    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $status = isset($_REQUEST['status']) ? $_REQUEST['status'] : 'new';
        $model = new Ticket();
//        $data_provider = $model->searchByStatus($status);
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Ticket'])) {
            $model->attributes = $_GET['Ticket'];
        }

        $this->render('admin', array(
            'model' => $model,
            'status' => $status,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model = Ticket::model()->with('order')->findByPk($id);
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
