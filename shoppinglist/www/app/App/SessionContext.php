<?php

namespace App;

class SessionContext {
	
	private static $exists = false;
	private static $sessionId = "3bda555e033d79fc552a";

	public static function create() : bool {
		if (!self::$exists) {

			// save session id in cookies and not as gross URL query param
			// ini_set('session.use_trans_sid', 0);
			// ini_set('session.use_only_cookies', 1);
			
			session_name(self::$sessionId);
			self::$exists = session_start();
		}
		return self::$exists;
	}

}