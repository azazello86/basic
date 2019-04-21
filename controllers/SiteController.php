<?php

namespace app\controllers;

use app\models\AirportName;
use app\models\FlightSegment;
use app\models\Trip;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * @inheritdoc
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
     * @inheritdoc
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
        // comment test
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string
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
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
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

    public function actionTest()
    {
        define('TRIP_CORPORATE_ID', 3);
        define('TRIP_SERVICE_SERVICE_ID', 2);


/*
        Пробую одним запросом к двум базам - не получается

        $results = FlightSegment::find(['Trip.*'])->asArray()->with('tripService', 'tripService.trip')->joinWith(['airportName a'], true, 'INNER JOIN')->where([
            'and',
            ['a.value' => 'Домодедово, Москва'],
            ['trip.corporate_id' => TRIP_CORPORATE_ID],
            ['tripService.service_id' => TRIP_SERVICE_SERVICE_ID],
        ])->all();

        Тогда разобью задачу на 2 запроса
*/

        $airportArr = AirportName::find(['airport_id'])->asArray()->where(['value' => 'Домодедово, Москва'])->one();

        // die(print($airportArr['airport_id']));

        /*
        SELECT t.* FROM flight_segment f
        LEFT JOIN trip_service ts ON f.flight_id = ts.id
        LEFT JOIN trip t ON t.id = ts.trip_id
        WHERE f.depAirportId = 758
        AND t.corporate_id = 3
        AND ts.service_id = 2
        */

        $results = FlightSegment::find(['Trip.*'])->asArray()->joinWith(['tripService ts', 'tripService.trip t'])->where([
            'and',
            ['depAirportId' => $airportArr['airport_id']],
            ['t.corporate_id' => TRIP_CORPORATE_ID],
            ['ts.service_id' => TRIP_SERVICE_SERVICE_ID],
        ])->all();

        /*
        echo '<pre>';
        die(print_r($results));
        */
        return $this->render('test', [
            'results' => $results
        ]);
    }
}
