<?php

class OrderController extends Controller
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
                'actions' => array('index', 'view'),
                'users' => array('@'),
            ),
            array('allow', // allow authenticated user to perform 'create' and 'update' actions
                'actions' => array('create', 'update'),
                'users' => array('@'),
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('admin', 'delete', 'search'),
//                'users' => array('admin', 'altruer@gmail.com', 'maden@csharper.ru'),
                'users' => array('@')
            ),
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('filterbyactiontag'),
                'users' => array('admin'),
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
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate()
    {
        $order = new Order;

        if (isset($_POST['Order'])) {
            $gotOrder = $_POST['Order'];
            $order->activation_range = $_POST['Order']['activation_range'];
            $dates = explode(" - ", $order->activation_range);
            $order->card_number = $_POST['Order']['card_number'];

            if ($order->card_number!="")
            {
                $cardResult = CardChecker::CheckCard($order->card_number);
                if ($cardResult['result'] != "CanCreateNew" && $cardResult['result']!= "CanUseThis")
                    throw new CException("Карточка не может быть использована по причине:".$cardResult['result']);
                else
                {
                    //Создаем карточку или используем существующую
                    if ($cardResult['result'] == "CanUseThis")
                    {
                        $gotOrder["card_id"] = $cardResult['id'];
                    }
                    else if ($cardResult['result'] == "CanCreateNew")
                    {
                        $card = new Card;
                        $card->number = $order->card_number;
                        $card->series_id = $cardResult['series_id'];
                        $card->save();
                        $gotOrder['card_id'] = $card->id;
                    }
                }
            }
            unset($gotOrder["card_number"]);

            if (count($dates)>1)
            {
                $gotOrder["activation_start"] = date('Y-m-d H:i:s', strtotime($dates[0]));
                $gotOrder["activation_end"] = date('Y-m-d H:i:s', strtotime($dates[1]));
                unset($gotOrder["activation_range"]);
            }

            $order->attributes = $gotOrder;
            $action_tag = ActionTag::model()->find('name=:name', array(':name' => 'call'));
            if ($order->save()) {
                $relation = new Order2actionTag;
                $relation->action_tag_id = $action_tag->id;
                $relation->order_id = $order->id;
                $relation->save();
                $this->redirect(array('view', 'id' => $order->id));
            }
        }

        $this->render('create', array(
            'model' => $order,
        ));
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

        // TODO very dirty, write the better front to back parameters transfer
        $at_name = null;
        if (isset($_POST['activate'])) {
            $at_name = 'activate';
        } elseif (isset($_POST['recall'])) {
            $at_name = 'recall';
        } elseif (isset($_POST['call'])) {
            $at_name = 'call';
        } elseif (isset($_POST['check'])) {
            $at_name = 'check';
        } elseif (isset($_POST['delivery'])) {
            $at_name = 'delivery';
        }

        if (isset($_POST['Order'])) {
            $model->attributes = $_POST['Order'];
            if ($model->save()) {
                if (isset($at_name)) {
                    //найдем старый тег и удалим
                    Order2actionTag::model()
                        ->deleteAll(
                            'order_id=:o_id AND action_tag_id=:at_id',
                            array(
                                ':o_id' => $model->id,
                                ':at_id' => $model->action_tag[0]->id,
                            )
                        );
                    //добавим новый
                    $action_tag = ActionTag::model()->find('name=:name', array(':name' => $at_name));

                    $relation = new Order2actionTag;
                    $relation->action_tag_id = $action_tag->id;
                    $relation->order_id = $model->id;
                    $relation->save();
                }
                $this->redirect(array('view', 'id' => $model->id));
            }
        }

        $this->render('update', array(
            'model' => $model,
        ));

    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     * @throws CHttpException
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
        $dataProvider = new CActiveDataProvider('Order');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new Order('search');
        $model->unsetAttributes(); // clear any default values

        if (isset($_GET['Order'])) {
            $model->attributes = $_GET['Order'];
        }
        $action_tag = isset($_GET['action_tag']) ? $_GET['action_tag'] : 'call';
        $data_provider = $model->searchNotActivated($action_tag);

        $this->render('admin', array(
            'model' => $model,
            'data_provider' => $data_provider,
            'action_tag' => $action_tag,
        ));
    }


    /**
     * Manages all models.
     */
    public function actionSearch()
    {
        $model = new Order('search');
        $model->unsetAttributes(); // clear any default values

        if (isset($_GET['Order'])) {
            $model->attributes = $_GET['Order'];
        }
        $data_provider = $model->search();

        $sql = 'SELECT order_id, id as `ticket_id` from ticket where order_id > 0';
        $query_results = Yii::app()->db->createCommand($sql)->queryAll();
        $order2ticket = array();
        foreach ($query_results as $res) {
            $order2ticket[$res['order_id']] = $res['ticket_id'];
        }

        $this->render('search', array(
            'model' => $model,
            'data_provider' => $data_provider,
            'order2ticket' => $order2ticket,
        ));
    }


    /**
     * Фильтрация по тегу действия
     */
    public function actionFilterByActionTag()
    {


//        if(Yii::app()->request->isPostRequest)
//        {
//             we only allow deletion via POST request
//            $this->loadModel($id)->delete();
//
//             if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
//            if(!isset($_GET['ajax']))
//                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
//        }
//        else
//            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');

    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param $id
     * @throws CHttpException
     * @internal param \the $integer ID of the model to be loaded
     * @return \CActiveRecord
     */
    public function loadModel($id)
    {
        $model = Order::model()->with('action_tag')->findByPk($id);
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'order-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}
