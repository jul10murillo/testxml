<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionGroups()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_XML;
        $items = [
            'grupos' =>
                [
                    'Frutas',
                    'Verduras',
                    'Hortalizas',
                ],
        ];
        return $items;
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionProducts()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_XML;

        $items = [
            'productos' =>
            [
                ['1',   'Mandarinas',  '1',   '3.9325'],
                ['2',   'Lechugas',    '2',   '1.6335'],
                ['3',   'Melones', '1',   '1.9360'],
                ['4',   'Coles',   '2',   '0.6050'],
                ['5',   'Berenjenas',  '3',   '2.5410'],
                ['6',   'Platanos',    '1',   '2.4200'],
                ['7',   'Tomates', '2',   '0.9680'],
                ['8',   'Uvas',    '1',   '3.6300'],
                ['9',   'Esparragos',  '3',   '1.2100'],
                ['10',  'Zanaorias',   '3',   '0.6050'],
            ],
        ];

        return $items;
    }

    /**
    * Displays about page.
    *
    * @return string
    */
    public function actionSales()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_XML;
        
        $items = [
            'Ventas' =>
            [
                ['7',   '1',   '1998-07-02 00:00:00', '2089'],
                ['7',   '1',   '1998-07-12 00:00:00', '1322'],
                ['7',   '1',   '1998-01-21 00:00:00', '1176'],
                ['7',   '1',   '1998-04-28 00:00:00', '352'],
                ['7',   '1',   '1998-05-28 00:00:00', '290'],
                ['7',   '8',   '1998-12-02 00:00:00', '2000'],
                ['7',   '8',   '1998-10-31 00:00:00', '1218'],
                ['7',   '8',   '1998-06-22 00:00:00', '951'],
                ['7',   '8',   '1998-01-28 00:00:00', '536'],
                ['7',   '8',   '1998-08-14 00:00:00', '467'],
                ['7',   '8',   '1998-07-10 00:00:00', '347'],
                ['7',   '6',   '1998-07-11 00:00:00', '2026'],
                ['7',   '6',   '1998-12-26 00:00:00', '1609'],
                ['7',   '6',   '1998-10-04 00:00:00', '1036'],
                ['7',   '6',   '1998-10-08 00:00:00', '770'],
                ['7',   '6',   '1998-03-12 00:00:00', '659'],
                ['7',   '13',  '1998-04-12 00:00:00', '2394'],
                ['7',   '13',  '1998-08-14 00:00:00', '1643']
            ]
        ];
        return $items;
    }

    /**
    * Displays about page.
    *
    * @return string
    */
    public function actionSellers()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_XML;

        $items = [
            'Vendedores' =>
            [
                ['1',   'Pepito',  '2004-03-15', '00:00:00 32456645D',   '2019-05-15 00:00:00', 'cvbmcvbmcvb', 'Barcelona',   '08782',   '937745214',   'Soltero', 'true'],
                ['2',   'Carmen',  '2004-04-12', '00:00:00 12121213G',   '1951-11-15 00:00:00', 'jkkhjkjhkhjk',    'Madrid',  '28257',   '914556565',   'Separado',    'false'],
                ['3',   'Rosa',    '2003-12-23', '00:00:00 11313155O',   '1977-11-12 00:00:00', 'jhjhgjhgjhgjg',   'Martorell',   '13131',   '937754585',   'Casado',  'true'],
                ['4',   'Gloria',  '2001-01-01', '00:00:00 13131333E',   '1960-01-13 00:00:00', 'dfsdgdfgdfg', 'badalona',    '15344',   '464646466',   'Divorciado',  'false'],
                ['5',   'Fran',    '2000-12-12', '00:00:00 11213123O',   '1955-02-15 00:00:00', 'ghfghgfh',    'Barcelona',   '23131',   '13123123123', 'Viudo',   'true'],
                ['6',   'Monica',  '2000-02-12', '00:00:00 13131313O',   '1970-11-12 00:00:00', 'hfghfghfghfg',    'malaga',  '13131',   '4454564646',  'Arrejuntado', 'false'],
                ['7',   'Quima',   '2002-12-12', '00:00:00 46464646F',   '1944-04-12 00:00:00', 'jghjghjghjghjgh', 'Madrid',  '45456',   '464646456',   'Separado',    'true'],
                ['8',   'Ramon',   '2002-12-12', '00:00:00 12113133G',   '1958-02-12 00:00:00',     'Sant', 'Esteve', 'sesrovires',  '32311',   '231313131',   'Divorciado',  'true'],
                ['9',   'Carlos',  '2004-02-12', '00:00:00 13131313F',   '1980-02-11 00:00:00', 'lkljkljkljkljkljkl',  'Madrid',  '43434',   '464646464',   'Arrejuntado', 'false']
            ],
        ];

        return $items;
    }
}
