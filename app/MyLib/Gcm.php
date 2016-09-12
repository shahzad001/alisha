<?php

namespace App\MyLib;
/*
Usage
public function send_gcm() {
	// simple loading
	// note: you have to specify API key in config before
	$this->load->library('gcm');
	// simple adding message. You can also add message in the data,
	// but if you specified it with setMesage() already
	// then setMessage's messages will have bigger priority
	$this->gcm->setMessage('Test message '.date('d.m.Y H:s:i'));
	// add recepient or few
	$this->gcm->addRecepient('RegistrationId');
	$this->gcm->addRecepient('New reg id');
	// set additional data
	$this->gcm->setData(array(
		'some_key' => 'some_val'
	));
	// also you can add time to live
	$this->gcm->setTtl(500);
	// and unset in further
	$this->gcm->setTtl(false);
	// set group for messages if needed
	$this->gcm->setGroup('Test');
	// or set to default
	$this->gcm->setGroup(false);
	// then send
	if ($this->gcm->send())
		echo 'Success for all messages';
	else
		echo 'Some messages have errors';
	// and see responses for more info
	print_r($this->gcm->status);
	print_r($this->gcm->messagesStatuses);
	die(' Worked.');
}
*/
class Gcm {
	public $apiKey = '';
	protected $apiSendAddress = '';
	protected $payload = array();
	protected $additionalData = array();
	protected $recepients = array();
	protected $message = '';
	public $status = array();
	public $messagesStatuses = array();
	public $responseData = null;
	public $responseInfo = null;
	protected $errorStatuses = array(
		'Unavailable' => 'Maybe missed API key',
		'MismatchSenderId' => 'Make sure you\'re using one of those when trying to send messages to the device. If you switch to a different sender, the existing registration IDs won\'t work.',
		'MissingRegistration' => 'Check that the request contains a registration ID',
		'InvalidRegistration' => 'Check the formatting of the registration ID that you pass to the server. Make sure it matches the registration ID the phone receives in the google',
		'NotRegistered' => 'Not registered',
		'MessageTooBig' => 'The total size of the payload data that is included in a message can\'t exceed 4096 bytes'
	);
	/**
	 * Constructor
	 */
	public function __construct() {
		$this->apiKey = 'AIzaSyCOv9AjpeZu2RZdK33fkONjTbwfkoNeMoA';
		$this->apiSendAddress = 'https://android.googleapis.com/gcm/send';
		if (!$this->apiKey) {
			$this->status = array(
				'status' => '0',
				'message' => 'GCM: Needed API Key'
			);
			return false;
		}
		if (!$this->apiSendAddress) {
			$this->status = array(
				'status' => '0',
				'message' => 'GCM: Needed API Send Address'
			);
			return false;
		}
	}
	/**
	* Sets additional data which will be send with main apn message
	*
	* @param <array> $data
	* @return <array>
	*/
	public function setTtl($ttl = '') {
		if (!$ttl)
			unset($this->payload['time_to_live']);
		else
			$this->payload['time_to_live'] = $ttl;
	}
	/**
	 * Setting GCM message
	 *
	 * @param <string> $message
	 */
	public function setMessage($message = '') {
		$this->message = $message;
		$this->payload['data']['message'] = $message;
	}
	/**
	 * Setting data to message
	 *
	 * @param <string> $data
	 */
	public function setData($data = array()) {
		$this->payload['data'] = $data;
		if ($this->message)
			$this->payload['data']['message'] = $this->message;
	}
	/**
	 * Setting group of messages
	 *
	 * @param <string> $group
	 */
	public function setGroup($group = '') {
		if (!$group)
			unset($this->payload['collapse_key']);
		else
			$this->payload['collapse_key'] = $group;
	}
	/**
	 * Adding one recepient
	 *
	 * @param <string> $group
	 */
	public function addRecepient($registrationId) {
		$this->payload['registration_ids'][] = $registrationId;
	}
	/**
	 * Setting all recepients
	 *
	 * @param <string> $group
	 */
	public function setRecepients($registrationIds) {
		$this->payload['registration_ids'] = $registrationIds;
	}
	/**
	 * Clearing group of messages
	 */
	public function clearRecepients() {
		$this->payload['registration_ids'] = array();
	}
	/**
	 * Senging messages to Google Cloud Messaging
	 *
	 * @param <string> $group
	 */
	public function send() {
		$this->payload['registration_ids'] = array_unique($this->payload['registration_ids']);
		if (isset($this->payload['time_to_live']) && !isset($this->payload['collapse_key']))
			$this->payload['collapse_key'] = 'Punchmo Notifications';
		$data = json_encode($this->payload);
		return $this->request($data);
	}
	protected function request($data) {
		$headers[] = 'Content-Type:application/json';
		$headers[] = 'Authorization:key='.$this->apiKey;
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $this->apiSendAddress);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($curl, CURLOPT_FOLLOWLOCATION, false);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($curl, CURLOPT_HEADER, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
		$this->responseData = curl_exec($curl);
		$this->responseInfo = curl_getinfo($curl);
		curl_close($curl);
		return $this->parseResponse();
	}
	protected function parseResponse() {
		if ($this->responseInfo['http_code'] == 200) {
			$response = explode("\n", $this->responseData);
			$responseBody = json_decode($response[count($response)-1]);
			$status = '0';
			if ($responseBody->success && !$responseBody->failure) {
				$message = 'All messages were sent successfully';
				$status = '1';
			} elseif ($responseBody->success && $responseBody->failure) {
				$message = $responseBody->success.' of '.($responseBody->success+$responseBody->failure).' messages were sent successfully';
				$status = '0';
			} elseif (!$responseBody->success && $responseBody->failure) {
				$message = 'Messages cannot be sent. '.(isset($this->errorStatuses[$responseBody->results[0]->error])?$this->errorStatuses[$responseBody->results[0]->error]:$responseBody->results[0]->error);
				$status = '0';
			}
			$this->status = array(
				'status' => $status,
				'message' => $message
			);
			$this->messagesStatuses = array();
			foreach($responseBody->results as $key => $result) {
				if (isset($result->error) && $result->error) {
					$this->messagesStatuses[$key] = array(
						'status' => '0',
						'regid' => $this->payload['registration_ids'][$key],
						'message' => $this->errorStatuses[$result->error],
						'message_id' => ''
					);
				} else {
					$this->messagesStatuses[$key] = array(
						'status' => '0',
						'regid' => $this->payload['registration_ids'][$key],
						'message' => 'Message was sent successfully',
						'message_id' => $result->message_id
					);
				}
			}
			return $status;
		} else if ($this->responseInfo['http_code'] == 400) {
			$this->status = array(
				'status' => '0',
				'message' => 'Request could not be parsed as JSON'
			);
			return false;
		} else if ($this->responseInfo['http_code'] == 401) {
			$this->status = array(
				'status' => '0',
				'message' => 'There was an error authenticating the sender account'
			);
			return false;
		} else if ($this->responseInfo['http_code'] == 500) {
			$this->status = array(
				'status' => '0',
				'message' => 'There was an internal error in the GCM server while trying to process the request'
			);
			return false;
		} else if ($this->responseInfo['http_code'] == 503) {
			$this->status = array(
				'status' => '0',
				'message' => 'Server is temporarily unavailable'
			);
			return false;
		} else {
			$this->status = array(
				'status' => '0',
				'message' => 'Status undefined'
			);
			return false;
		}
	}
}