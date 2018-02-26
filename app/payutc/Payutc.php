<?php
/**
* payutc
* Copyright (C) 2013-2014 payutc <payutc@assos.utc.fr>
*
* This file is part of payutc
* 
* payutc is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* payutc is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

namespace App\Payutc;

use App\Payutc\JsonException;

/**
 * Basic client to do POST and GET
 */
class Payutc
{
	private static $singleton = NULL;
	protected $url;
	protected $useragent;
	protected $curl_settings;
    protected $result_encoded;
    protected $system_id;
    protected $app_key;
    protected $sessionid;
    protected $fun_id;


	private function __construct($url, $fun_id,  $curl_settings = array(), $useragent = "Payutc Json PHP Client", $cookies = array(), $system_id = null, $app_key = null, $sessionid = null)
	{
		$this->url = $url;
		$this->useragent = $useragent;
		$this->cookies = $cookies;
		$this->curl_settings = $curl_settings +
			array(
				CURLOPT_USERAGENT 		=> $this->useragent,
				CURLOPT_RETURNTRANSFER 	=> true,
                CURLOPT_HEADERFUNCTION 	=> array($this, 'readHeader')
			);
				// CURLOPT_SSL_VERIFYPEER => true,
        $this->system_id = $system_id;
        $this->app_key = $app_key;
        $this->sessionid = $sessionid;
	}

	// Singleton : Spécifique à l'application
	static function createPayutc() {
		if (self::$singleton)
			return self::$singleton;

		self::$singleton = new self(
			"https://api.nemopay.net/services/",
			config("billets.payutc.fun_id"),
			array(
				CURLOPT_PROXY => (config("billets.payutc.viaUTC") ? 'proxyweb.utc.fr:3128' : ''),
				CURLOPT_TIMEOUT => 5,
				CURLOPT_SSL_VERIFYPEER => config("billets.payutc.prod")
			),
			"Payutc Json PHP Client",
			array(),
			"payutc",
			config("billets.payutc.app_key")
		);
		self::$singleton->loginApp();
		return self::$singleton;
	}


	public function loginApp($appKey = null)
	{
		if($appKey == null)
			$appKey = $this->app_key;
		$data = $this->apiCall("SELFPOS", "loginApp", array("key" => $appKey));
		$this->sessionid = $data->sessionid;
	}

	public function login($login, $password)
	{
		$data = $this->apiCall("SELFPOS", "login2", array("login" => $login, "password" => $password));
		$this->sessionid = $data->sessionid;
	}

	public function loginCas2($service, $ticket)
	{
		$data = $this->apiCall("SELFPOS", "loginCas2", array("service" => $service, "ticket" => $ticket));
		$this->sessionid = $data->sessionid;
		return $data;
	}

	public static function checkTransaction($id) {
		$payutc = self::createPayutc();
		return $payutc->apiCall('WEBSALE', 'getTransactionInfo',
			[
				'fun_id' 	=> config("billets.payutc.fun_id"),
				'tra_id' 	=> $id
			]
		);
	}

	public static function cancelTransaction($id) {
		$payutc = self::createPayutc();
		$payutc->login("alexandre.brasseur@etu.utc.fr", "IC05picasso82");
		return $payutc->apiCall('GESSALES', 'cancelTransaction',
			[
				'fun_id' 	=> config("billets.payutc.fun_id"),
				'id' 	=> $id
			]
		);
	}


    public function readHeader($ch, $header)
    {
        preg_match('/^Set-Cookie: (.*?)=(.*?);/m', $header, $capturedArgs);
        if (array_key_exists(1, $capturedArgs) and array_key_exists(2, $capturedArgs)) {
            $this->cookies[$capturedArgs[1]] = $capturedArgs[1] . '=' . $capturedArgs[2];
        }
        return strlen($header);
    }

    public function getRawContent()
    {
        return $this->result_encoded;
    }

	/**
	 * @param string $func la fonction du service à appeller
	 * @param array $params un array key=>value des paramètres. default: array()
	 * @param string $method le méthode à utiliser (GET ou POST). default: 'POST'
	 */
    public function apiCall($service, $func, array $params = array(), $method = 'POST')
    {
        // Construction de la chaîne de paramètres
        $paramstring = "";
        if (!empty($this->system_id)) {
            $paramstring .= "system_id=" . $this->system_id . "&";
        }
        if (!empty($this->app_key)) {
            $paramstring .= "app_key=" . $this->app_key . "&";
        }
        if (!empty($this->sessionid)) {
            $paramstring .= "sessionid=" . $this->sessionid . "&";
        }

		$url = $this->url . $service . '/';

		// Réglages de cURL
		$settings = $this->curl_settings;
		$settings[CURLOPT_CUSTOMREQUEST] = $method;
        if($this->cookies) {
            $settings[CURLOPT_COOKIE] = implode(';', array_values($this->cookies));
        }
		
		// Construction de l'URL et des postfields
		if($method == "GET"){
            if (!empty($params))
                foreach ($params as $key => $param)
                    $paramstring .= $key . "=" . $param . "&";
            $paramstring = substr($paramstring, 0, -1);
			$url .= $func . "?" . $paramstring;
		}
		else {	// POST
            $data_string = json_encode($params, JSON_FORCE_OBJECT);
            $settings[CURLOPT_POSTFIELDS] = $data_string;
            $settings[CURLOPT_HTTPHEADER] = array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data_string),
            );
            $paramstring = substr($paramstring, 0, -1);
            $url .= $func . "?" . $paramstring;
		}
		
		// Initialisation de cURL
		$ch = curl_init($url);
		curl_setopt_array($ch, $settings);
		
		// Éxécution de la requête
		$this->result_encoded = curl_exec($ch);
		$result = json_decode($this->result_encoded);

		// Si erreur d'appel de cURL
		if (curl_errno($ch) != 0) {
			throw new JsonException("Unknown", 503, "Erreur d'appel de cURL");
		}
		// Si erreur on throw une exception
		if (isset($result->error)) {
			$err = $result->error;
			$type = isset($err->type) ? $err->type : "UnknownType";
			$code = isset($err->code) ? $err->code : "42";
			$message = isset($err->message) ? $err->message : "";
			throw new JsonException($type, $code, $message, curl_getinfo($ch, CURLINFO_HTTP_CODE));
		} else if (curl_getinfo($ch, CURLINFO_HTTP_CODE) != 200) {
			throw new JsonException("InvalidHTTPCode", 37, "La page n'a pas renvoye un code 200.", curl_getinfo($ch, CURLINFO_HTTP_CODE));
		} else { // Sinon, on renvoie le résultat
			return $result;
		}
	}
}
