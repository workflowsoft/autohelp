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
                'actions' => array('index', 'view', 'create', 'update', 'admin', 'delete', 'partnerassign', 'a_partnerassign'),
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
        $model = $this->loadModel($id);

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

        $this->render('view', array(
            'model' => $this->loadModel($id),
            'partners' => $partners,
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

        $order = Order::model()->findByPk($order_id);

        if (isset($_POST['Ticket']) && isset($ticket_id)) {
            $ticket = Ticket::model()->findByPk($ticket_id);
            if ($ticket->status != 'draft') {
                throw new CHttpException(400, 'We can save only drafts');
            }
            $ticket->attributes = $_POST['Ticket'];
            $ticket->order_id = $order_id;
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

                $this->redirect(array('view', 'id' => $ticket->id));
            }
        }


        if (!empty($ticket_id)) {
            $this->render('create', array(
                'ticket' => new Ticket,
                'order' => $order,
                'services' => new Services(),
            ));
        } else {
            // first status is draft
            $ticket = new Ticket;
            $ticket->status = TicketStatus::DRAFT;
            $user = User::model()->find('email=:email', array(':email' => Yii::app()->user->id));
            $ticket->user_id = $user->id;
            $ticket->order_id = $order_id;
            $ticket->save();
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
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Ticket'])) {
            $model->attributes = $_POST['Ticket'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }


    public function actiona_PartnerAssign()
    {
        if (isset($_POST['data'])) {
            $data = $_POST['data'];
            foreach ($data as $item) {
                if (!empty($item['partner_id']) && !empty($item['ticket_id'])) {
                    if (!empty($item['services'])) {
                        foreach ($item['services'] as $service) {
                            $ticket2service = new Ticket2service;
                            $ticket2service->ticket_id = $item['ticket_id'];
                            $ticket2service->service_id = $service['id'];
                            $ticket2service->save();

                            $partner2ticket = new Partner2ticket;
                            $param = array(
                                ':pid' => $item['partner_id'],
                                ':sid' => $service['id'],
                            );
                            $partner2service = Partner2service::model()
                                ->find('partner_id=:pid and service_id=:sid', $param
                                );
                            $partner2ticket->partner2service_id = $partner2service->id;
                            $partner2ticket->ticket_id = $item['ticket_id'];
                            $partner2ticket->arrival_time = $this->addTime($service['time']);
                            $partner2ticket->save();
                        }
                    }
                }
            }
        }

        echo CJSON::encode(array('success' => true));
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


    public function actionPartnerAssign($id)
    {
        $model = $this->loadModel($id);

        if (isset($_POST['data'])) {
//            $this->redirect(array('view','id'=>$model->id));
        }

        if (isset($_POST['Ticket'])) {
            $model->attributes = $_POST['Ticket'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }


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
            'model' => $model,
            'partners' => $partners,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest) {
            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        } else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $dataProvider = new CActiveDataProvider('Ticket');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Ticket('search');
        $model->unsetAttributes(); // clear any default values
        if (isset($_GET['Ticket'])) {
            $model->attributes = $_GET['Ticket'];
        }
        $status = isset($_GET['status']) ? $_GET['status'] : 'new';

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
