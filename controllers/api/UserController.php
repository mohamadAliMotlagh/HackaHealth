<?php

namespace app\controllers\api;

use app\components\MCrypt;
use app\components\Result;
use app\components\Secure;
use app\components\UserManage;
use app\models\CoinLog;
use app\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class UserController extends Controller
{
	public $enableCsrfValidation = false;
	
	public function beforeAction($action)
	{
		header('Content-Type: application/json;Connection:close');
		
		return parent::beforeAction($action); // TODO: Change the autogenerated stub
	}
	
	/*
	 * User register function
	 */
	public function actionRegister()
	{
		$request = Yii::$app->request;
		
		$id            = $request->post('id', '');
		$username      = $request->post('username', '');
		$first_name    = $request->post('first_name', '');
		$last_name     = $request->post('last_name', '');
		$device_id     = $request->post('device_id', '');
		$serial_number = $request->post('serial_number', '');
		$model         = $request->post('model', '');
		$manufacture   = $request->post('manufacture', '');
		$brand         = $request->post('brand', '');
		$api_version   = $request->post('api_version', '');
		$app_version   = $request->post('app_version', '');
		$agent         = $request->post('agent', '');
		
		$string = (string)(1000000000000000 + $id + $api_version);
		Secure::Authorize($agent, $string);
		
		$result = UserManage::register($id, $username, $first_name, $last_name, $phone,
			$device_id, $serial_number, $model, $manufacture, $brand,
			$api_version, $app_version);
		
		
		Result::success($result);
	}
	
	/*
	 * User login function
	 */
	public function actionLogin()
	{
		$request = Yii::$app->request;
		
		$telegram_id   = $request->post('telegram_id', '');
		$at            = $request->post('at', '');
		$username      = $request->post('username', '');
		$first_name    = $request->post('first_name', '');
		$last_name     = $request->post('last_name', '');
		$phone         = $request->post('phone', '');
		$device_id     = $request->post('device_id', '');
		$serial_number = $request->post('serial_number', '');
		$model         = $request->post('model', '');
		$manufacture   = $request->post('manufacture', '');
		$brand         = $request->post('brand', '');
		$api_version   = $request->post('api_version', '');
		$app_version   = $request->post('app_version', '');
		$agent         = $request->post('agent', '');
		$checksum      = $request->post('checksum', '');
		
		$string = (string)(1000000000000000 + $telegram_id + $api_version + $app_version);
		Secure::Authorize($agent, $string);
		
		$result = UserManage::Login($telegram_id, $at, $username, $first_name,
			$last_name, $phone, $device_id, $serial_number,
			$model, $manufacture, $brand, $api_version, $app_version, $checksum);
		
		Result::success($result);
	}
	
	/*
	 * Get user data for its app private user
	 */
	public function actionGetData()
	{
		$user_id = $_GET['user_id'];
		$token   = $_GET['token'];
		
		$result = UserManage::getData($user_id, $token);
		
		Result::success($result);
	}
	
	/*
	 * Set the users heart rate in the db
	 */
	public function actionSetHeartRate()
	{
		$token = $_POST['token'];
		$rate  = $_POST['rate'];
		
		$result = UserManage::setHeartRate($token, $rate);
		
		Result::success($result);
		
	}
	
	/*
	 * Get the list of last user heart rates
	 */
	public function actionGetHeartRate()
	{
		$token  = $_GET['token'];
		$number = $_GET['number'];
		
		$result = UserManage::getHeartRate($token, $number);
		
		Result::success($result);
		
	}
	
	/*
	 * Get user public data for helpers use
	 */
	public function actionGetPublicData()
	{
		$user_id = $_GET['user_id'];
		
		$result = UserManage::getPublicData($user_id);
		
		Result::success($result);
	}
	
}
