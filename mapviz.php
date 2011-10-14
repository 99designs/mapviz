<?php

class Mapviz
{
	public function __construct($server)
	{
		$this->_server = $server;
	}

	public function login($user, $latitude, $longitude)
	{
		$this->_send(array(
			'type' => 'login',
			'userid' => $user->userid,
			'avatar' => $user->avatar()->url(),
			'latitude' => $latitude,
			'longitude' => $longitude,
		));
	}

	public function entry($designid, $user, $latitude, $longitude)
	{
		$this->_send(array(
			'type' => 'entry',
			'entry' => Ergo::lookup('router')->buildUrl('designattachment.resized', array('designid'=>$designid,'size'=>'smallcrop')),
			'avatar' => $user->avatar()->url(),
			'latitude' => $latitude,
			'longitude' => $longitude,
		));
	}

	private function _send($data)
	{
		$fp = fsockopen($this->_server, 4000, $errno, $errstr);
		fwrite($fp, json_encode($data));
		fclose($fp);
	}
}
