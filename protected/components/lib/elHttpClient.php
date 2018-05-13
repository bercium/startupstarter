<?php
//---------------------------------------------------

    class elHttpHeaders{
        private $listHeaders = array(); // The headers array
        //function elHttpHeaders(){ $this->__construct(); }
        function __construct(){}
        // Empty array and return old contents
        function clean(){ $old = $this->listHeaders; $this->listHeaders = array(); return $old; }
        // Set a value to a name, actually ... it means add
        function set($headerName, $headerValue){
        	if(!is_string($headerName) || !strlen($headerName)) return false;
            if(!isset($this->listHeaders[$headerName])) $this->listHeaders[$headerName] = array();
            if(is_array($headerValue)){
                $this->listHeaders[$headerName] = array_merge($this->listHeaders[$headerName],$headerValue);
                $this->listHeaders[$headerName] = array_unique($this->listHeaders[$headerName]);
            }else{
                if(!in_array($headerValue,$this->listHeaders[$headerName]))
                	$this->listHeaders[$headerName][] = $headerValue;
            }
            return $this->listHeaders[$name];
        }
        // Get value(s) of a headername
        function get($headerName = null, $first = false){
            if(is_null($headerName)) return $this->listHeaders; // Returns everything
            if(!isset($this->listHeaders[$headerName])) return null; // If not found return null
            if((count($this->listHeaders[$headerName]) == 1) || $first) return $this->listHeaders[$headerName][0]; // If one value return string
            return $this->listHeaders[$headerName]; // Return array for multiple values
        }
        // Del a headername and values
        function del($headerName, $headerValue = null){
        	if(!is_string($headerName) || !strlen($headerName)) return false;
            if(!isset($this->listHeaders[$headerName])) return false;
            if(is_null($headerValue)){ unset($this->listHeaders[$headerName]); return true; }
            if(!is_array($headerValue)) $headerValue = array($headerValue);
            $this->listHeaders[$headerName] = array_diff($this->listHeaders[$headerName], $headerValue);
            if(!count($this->listHeaders[$headerName])) unset($this->listHeaders[$headerName]);
            return true;
        }
        // Import query string
        function fromQueryString($queryString){
        	// Must be met to even imagine this is a query string
        	if(!is_string($queryString) || !strlen($queryString) || !strchr($queryString,'=')) return false;
			parse_str($queryString, $queryVars);
			$headers = array();
			foreach($queryVars as $name => $value){
				if(is_array($value)){
					foreach($value as $val){
						$headers[] = $name.': '.$val;
					}
					continue;
				}
				$headers[] = $name.': '.$value;
			}
			$this->fromHeaders(array_unique($headers));
			return true;
        }
        // Import from HTTP Headers
        function fromHeaders($headersArray){
            if(is_string($headersArray)) $headersArray = preg_split("@[\r\n]@s",$headersArray);
            if (is_array($headersArray))
            foreach($headersArray as $header){
                if(!preg_match("@^([^\s:]+):\s?(.*)$@i", $header, $slices)){
                    continue; // This looks peculiar, but if commented will translate HTTP/... response line
                    if(preg_match('@^HTTP/([0-1]\.[0-1])\s+([0-9]+)\s?(.*)$@i', $header, $slices)){
                        $this->listHeaders['HTTP-Version'] = $slices[1];
                        $this->listHeaders['HTTP-Status'] = $slices[2];
                        if(strlen($slices[3])) $this->listHeaders['HTTP-Message'] = $slices[3];
                    }
                }else{
                    $name = trim($slices[1]); $value = trim($slices[2]);
                }
                if(!strlen($name)) continue;
                if(!isset($this->listHeaders[$name])) $this->listHeaders[$name] = array();
                if(!in_array($value,$this->listHeaders[$name])) $this->listHeaders[$name][] = $value;
            }
            return $this->listHeaders;
        }
        // Export HTTP headers
        function toHeaders(){
            $headers = array();
            foreach($this->listHeaders as $name => $values){
                if(!is_array($values) || !count($values)) continue;
                foreach($values as $value){ $headers[] = $name.': '.$value; }
            }
            $headers = array_unique($headers);
            return implode("\r\n", $headers);
        }
        // Export as query string
        function toQueryString(){ return http_build_query($this->get()); }
        // Get distinct header names
        function headers(){ return array_keys($this->listHeaders); }
        // Get array as a multiline string
        function __toString(){ return $this->toHeaders(); }
    };

//---------------------------------------------------

    class elHttpResponse{
        //--
        private $cURL = null; // The cURL handle
        private $cURLMulti = null; // The cURL multi-handle ... further use
        //--
        var $httpBody       = null; // The HTTP Body (HTML)
        var $httpHeaders    = null; // The HTTP response headers
        var $httpResponse   = null; // Last HTTP Response Header
        var $httpRequest    = null; // The HTTP Reqeust Headers
        var $httpCookies    = null; // HTTP Cookies as an array
        var $responseURL    = null; // Response URL .. different from requestURL is redirected
        var $requestURL     = null; // Request URL ... the URL you asked for
        //--
        private $httpInfo = null; // HTTP info ... curl_getinfo()
        private $httpStatus = null; // The HTTP status code (eg: 200)
        private $headersResponse = null, $headersRequest = null, $headersCookies = null;
        //--
        //function elHttpResponse($cURL, $URL, $cURLMulti = null){ $this->__construct($cURL, $cURLMulti, $URL); }
        private function __prepare($cURL, $cURLMulti = null){
            $this->cURL         = (get_resource_type($cURL) == 'curl') ? $cURL : null;
            $this->cURLMulti    = (!is_null($cURLMulti) && get_resource_type($cURLMulti) == 'curl') ? $cURLMulti : null;
            if(get_resource_type($this->cURL) != 'curl') return false;
            curl_setopt_array($this->cURL,
                array(
                    CURLINFO_HEADER_OUT => TRUE, // We get request header back
                    CURLOPT_RETURNTRANSFER => TRUE, // We return no direct output
                    CURLOPT_HEADER => TRUE, // We request headers too
                    CURLOPT_BINARYTRANSFER => TRUE, // Binary please
                    CURLOPT_ENCODING => 'gzip, deflate, compress', // Accept compressed data
                    CURLOPT_SSL_VERIFYPEER => FALSE,
                    CURLOPT_SSL_VERIFYHOST => FALSE,
                    CURLOPT_FORBID_REUSE => TRUE,
                    CURLOPT_FRESH_CONNECT => TRUE,
                )
            );
            return true;
        }
        // The construct uses provided cURL to assign internal values for your further use
        function __construct($cURL, $URL, $cURLMulti = null){
            if(!$this->__prepare($cURL, $cURLMulti)) return; // Some things gotta go our way!
            $raw_data           = (is_null($this->cURLMulti) ? curl_exec($this->cURL) : curl_multi_getcontent($this->cURL));
            $this->httpStatus   = curl_getinfo($this->cURL, CURLINFO_HTTP_CODE);
            $this->httpRequest  = curl_getinfo($this->cURL, CURLINFO_HEADER_OUT);
            $this->requestURL   = $URL;
            $this->responseURL  = curl_getinfo($this->cURL, CURLINFO_EFFECTIVE_URL);
            $header_size        = curl_getinfo($this->cURL, CURLINFO_HEADER_SIZE);
            $this->httpHeaders  = explode("\n\n", trim(str_replace("\r", null, mb_substr($raw_data, 0, $header_size))));
            $this->httpResponse = $this->httpHeaders[count($this->httpHeaders)-1];
            $this->httpBody     = mb_substr($raw_data, $header_size);
            $this->httpInfo     = curl_getinfo($this->cURL); unset($this->httpInfo['request_header']);
            $this->httpCookies  = array();
            $httpResponse       = preg_split('@[\r\n]+@s',$this->httpResponse);
            foreach($httpResponse as $key => $value){
                if(!preg_match('@^Set-Cookie:\s+([^\s=]+)\s*=\s*([^;]+)@i',$value,$slices)) continue;
                $this->httpCookies[$slices[1]] = $slices[2];
            }
            //-- Let's load the headers
            $this->headersResponse 	= new elHttpHeaders();
            $this->headersResponse->fromHeaders($this->httpResponse);
            $this->headersRequest 	= new elHttpHeaders();
            $this->headersRequest->fromHeaders($this->httpRequest);
            $this->headersCookies 	= new elHttpHeaders();
            $this->headersCookies->fromQueryString(http_build_query($this->httpCookies));
        }
        //--
        function cURL(){ return $this->cURL; }
        function cURLMulti(){ return $this->cURLMulti; }
        function getInfo(){ return $this->httpInfo; }
        function __toString(){ return $this->httpBody; } // echo(elHttpResponse); echoes the RAW data
        function getData(){ return $this->httpBody; }
        //--
        function getResponse(){ return $this->headersResponse; } // elHttpHeaders instance
        function getRequest(){ return $this->headersRequest; } // elHttpHeaders instance
        function getCookies(){ return $this->headersCookies; } // elHttpHeaders instance
        //--
        function isOK(){ return ($this->httpStatus == 200) || ($this->httpStatus == 206); } // OK , OK:partial
        function getStatus(){ return $this->httpStatus; } // Status
        function acceptsRanges(){ return $this->headersResponse->get('Accept-Ranges',true) == 'bytes'; } // Ranges OK?
        function getCRange(&$first = null, &$last = null, &$total = null){ // Content-Range breakdown
        	$contentRange = $this->headersResponse->get('Content-Range',true);
        	if(!preg_match('@^bytes\s+([0-9]+)\-([0-9]+)/([0-9]+)$@i',$contentRange,$matches))
        		return false;
        	$first = (int)$matches[1]; $last = (int)$matches[2]; $total = (int)$matches[3];
        	return true;
        }
        //Content Length ... if any
        function getCLength(){ return (int)$this->headersResponse->get('Content-Length',true); }
        function getCType(){ return $this->headersResponse->get('Content-Type',true); }
    }

//---------------------------------------------------

    class elHttpClient{
        //-- --------------------------------------------- --//
        private $cURLInstance   	= null;
        private $cookieJar      	= ""; // The cookie JAR file
        private $cURLMultiInstance  = null;
        //-- --------------------------------------------- --//
        /*function elHttpClient($cURLMultiInstance = null, $cURLInstance = null){
        	$this->__construct($cURLMultiInstance, $cURLInstance);
        }*/
        function __construct($cURLMultiInstance = null, $cURLInstance = null) {
            $cURLMultiInstance    = (get_class($cURLMultiInstance) == 'elHttpMClient' ?
            	$cURLMultiInstance->cURLMultiInstance : $cURLMultiInstance);
            $cURLInstance         = (get_class($cURLInstance) !== 'elHttpClient' ?
            	$cURLInstance->cURLInstance : $cURLInstance);
            if (!is_null($cURLMultiInstance) && get_resource_type($cURLMultiInstance) != 'curl') $cURLMultiInstance = null;
            $this->cURLMultiInstance = $cURLMultiInstance;
            //$this->cookieJar        = dirname(__FILE__).'/cookies.curl.txt';
            $this->cookieJar        = dirname(__FILE__)."/cookies.curl.txt";
            if(!is_null($cURLInstance) && get_resource_type($cURLInstance) == 'curl'){
                // Duplicate existing cURL handle
                $this->cURLInstance     = curl_copy_handle($cURLInstance);
            }else{
                // Create new cURL handle
                $this->cURLInstance     = curl_init();
            }
            // Assign to a multiget if any passed
            if(!is_null($this->cURLMultiInstance)){
                curl_multi_add_handle($this->cURLMultiInstance, $this->cURLInstance);
            }
            // Set cookie saving location
            $this->setOpts(array(CURLOPT_COOKIEFILE => $this->cookieJar, CURLOPT_COOKIEJAR => $this->cookieJar));
            $this->setHttpVersion(); // Let's play by HTTP/1.0 rules - I h8 fancy stuff
        }
        function __destruct() {
            // Remove from multiget
            if(!is_null($this->cURLMultiInstance)) curl_multi_remove_handle($this->cURLMultiInstance, $this->cURLInstance);
            // Close instance
            curl_close($this->cURLInstance); unset($this->cURLInstance);
        }
        //-- --------------------------------------------- --//
        // Access to private stuff
        function cURL(){ return $this->cURLInstance; }
        function cURLMulti(){ return $this->cURLMultiInstance; }
        //-- --------------------------------------------- --//
        // Config / Query cURL
        function setOpts($optionsArray){ return curl_setopt_array($this->cURLInstance, $optionsArray); }
        function setOpt($optionName, $optionValue){ return curl_setopt($this->cURLInstance, $optionName, $optionValue); }
        function getInfo($infoName = null){
        	if(is_null($infoName)) return curl_getinfo($this->cURLInstance);
        	return curl_getinfo($this->cURLInstance,$infoName);
        }
        //-- --------------------------------------------- --//
        // HTTP Auth
        function setHttpAuth($authUser, $authPass, $authType = CURLAUTH_BASIC){
        	return $this->setOpt(CURLOPT_HTTPAUTH, $authType) && $this->setOpt(CURLOPT_USERPWD, $authUser.':'.$authPass);
        }
        function setHttpVersion($httpVersion = CURL_HTTP_VERSION_1_0){ return $this->setOpt(CURLOPT_HTTP_VERSION, $httpVersion );}
        //-- --------------------------------------------- --//
        // Proxy settings
        function setProxy($proxyHost, $proxyPort, $authUser = null, $authPass = null){
            if(!$this->setOpt(CURLOPT_PROXY, $proxyHost)) return false;
            if(!$this->setOpt(CURLOPT_PROXYPORT, $proxyPort)) return false;
            if(!is_null($authUser) && !is_null($authPass)) return true;
            if(!$this->setOpt(CURLOPT_PROXYUSERPWD, $authUser.':'.$authPass))  return false;
            return true;
        }
        //-- --------------------------------------------- --//
        // Timeouts
        function setTimeout($nTimeout = 30){ return $this->setOpt(CURLOPT_TIMEOUT, $nTimeout); }
        function setDNSTimeout($nTimeout = 30){ return $this->setOpt(CURLOPT_DNS_CACHE_TIMEOUT, $nTimeout); }
        function setReferer($refererURL = null){ return $this->setOpt(CURLOPT_REFERER, $refererURL); }
        //-- --------------------------------------------- --//
        // Autoreferer / Autoredirects
        function enableAutoReferer($autoReferer = true){ return $this->setOpt(CURLOPT_AUTOREFERER, $autoReferer); }
        function disableAutoReferer(){ return $this->enableAutoReferer(false); }
        function enableRedirects($autoFollow = true){ return $this->setOpt(CURLOPT_FOLLOWLOCATION, $autoFollow); }
        function disableRedirects(){ return $this->enableRedirects(false); }
        //-- --------------------------------------------- --//
        // Manage request headers
        function setHeader($headerName, $headerValue){ return $this->setHeaders(array($headerName => $headerValue)); }
        function setHeaders($headersArray){
            if(is_object($headersArray) && (get_class($headersArray) == 'elHttpHeaders'))
                $headersArray = $headersArray->get(null);
            $setHeaders = array();
            foreach($headersArray as $name => $value){
                if(!is_array($value)){ $setHeaders[] = $name.': '.$value; continue; }
                foreach($value as $val){ $setHeaders[] = $name.': '.$val;  }
            }
            return $this->setOpt(CURLOPT_HTTPHEADER, $setHeaders);
        }
        function resetHeaders(){ return $this->setHeaders(array()); }
        //-- --------------------------------------------- --//
        // Set your own cookies
        function setCookies($cookieArray){
            if(is_array($cookieArray)){
            	$cookieArray = str_replace('&','; ',http_build_query($cookieArray));
            }
            return $this->setOpt(CURLOPT_COOKIE,$cookieArray);
        }
        //-- --------------------------------------------- --//
        // Set User-Agent
        function setUserAgent( $userAgent ){
        	// We got some predefined values or use your own
            if($userAgent=="gg")
            	$httpUserAgent = "Mozilla/5.0 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)"; // Googlebot
            elseif($userAgent=="tb" || $userAgent=="ggtb" || $userAgent=="pr") // Google Toolbar
            	$httpUserAgent = "Mozilla/4.0 (compatible; GoogleToolbar 2.0.114-big; Windows XP 5.1)";
            elseif($userAgent=="ms")
            	$httpUserAgent = "msnbot/1.0 (+http://search.msn.com/msnbot.htm)"; // MSNBot
            elseif($userAgent=="yh")
            	$httpUserAgent = "Mozilla/5.0 (compatible; Yahoo! Slurp; http://help.yahoo.com/help/us/ysearch/slurp)"; // SLURP
            elseif($userAgent=="ie")
            	$httpUserAgent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; en)"; // IE
            elseif($userAgent=="ff2")
            	$httpUserAgent = "Mozilla/5.0 (Windows; U; Windows NT 5.2; en-US; rv:1.8.1.8) Gecko/20071008 Firefox/2.0.0.8"; // FF2
            elseif($userAgent=="ff3")
            	$httpUserAgent = "Mozilla/5.0 (Windows; U; Windows NT 5.2; en-US; rv:1.9) Gecko/2008052906 Firefox/3.0"; // FF3
            else $httpUserAgent = $userAgent; // Custom
            return $this->setOpt(CURLOPT_USERAGENT, $httpUserAgent);
        }
        //-- --------------------------------------------- --//
        // This resets post variables for GETs to work after POSTs
        private function resetPost(){
        	return $this->setOpts(
        		array(
        			CURLOPT_POSTFIELDS => null,
        			CURLOPT_POST => FALSE
        		)
        	); // This is how you use setOpts
        }
        //-- --------------------------------------------- --//
        // Set POST data
        private function buildPost($postData, $postRegular = 1){
            if(is_array($postData)) $postData = http_build_query($postData);
            if(!strlen($postData)) return false;
            return $this->setOpts(
	            array(
    	        	CURLOPT_POSTFIELDS => $postData,
        	    	CURLOPT_POST => (int)$postRegular,
        	    )
            );
        }
        //-- --------------------------------------------- --//
        // Prepare the request
        private function buildRequest($URL, $httpVerb = 'GET'){
            // These are vital to have this in best shape
            if(!$this->setOpts(
                array(
                    CURLINFO_HEADER_OUT => TRUE, // We get request header back
                    CURLOPT_RETURNTRANSFER => TRUE, // We return no direct output
                    CURLOPT_HEADER => TRUE, // We request headers too
                    CURLOPT_BINARYTRANSFER => TRUE, // Binary please
                    CURLOPT_ENCODING => 'gzip, deflate, compress', // Accept compressed data
                    CURLOPT_SSL_VERIFYPEER => FALSE, // These can cause errors and should be disabled
                    CURLOPT_SSL_VERIFYHOST => FALSE, // These can cause errors and should be disabled
                    CURLOPT_FORBID_REUSE => TRUE,
                    CURLOPT_FRESH_CONNECT => TRUE,
                )
            )) return false;
            if(!$this->setOpts(array(CURLOPT_URL => $URL, CURLOPT_CUSTOMREQUEST => $httpVerb))) return false;
            if(!$this->resetPost()) return false;
            $this->setOpt(CURLOPT_NOBODY, !strcmp($httpVerb,'HEAD'));
            return true;
        }
        //-- --------------------------------------------- --//
        // Do the request ... manually
        function fetch($URL = null){
            // If this assigned to a multiCURL make sure it finished downloading
            return new elHttpResponse($this->cURLInstance, $URL, $this->cURLMultiInstance);
        }
        //-- --------------------------------------------- --//
        // Autorequests ... use these instead of buildRequest + fetch combination
        function get($URL, $reqHeaders = null){
            $this->buildRequest($URL, 'GET');
            if(!is_null($this->cURLMultiInstance)) return null;
            if(!is_array($reqHeaders)) $reqHeaders = array();
            $reqHeaders = array_merge($reqHeaders, array('Content-Length' => '', 'Content-Type' => ''));
            if(!is_null($reqHeaders)) $this->setHeaders($reqHeaders);
            return $this->fetch($URL);
        }
        function head($URL, $reqHeaders = null){
            $this->buildRequest($URL,'HEAD');
            if(!is_array($reqHeaders)) $reqHeaders = array();
            $reqHeaders = array_merge($reqHeaders, array('Content-Length' => '', 'Content-Type' => ''));
            if(!is_null($reqHeaders)) $this->setHeaders($reqHeaders);
            if(!is_null($this->cURLMultiInstance)) return null;
            return $this->fetch($URL);
        }
        // PostData can be a string from http_build_query or an associative array of names and values
        function post($URL, $postData, $reqHeaders = null, $postRegular = 1){
        	if(is_array($postData)) $postData = http_build_query($postData);
            if(!$this->buildRequest($URL, 'POST')) return null;
            if(!$this->buildPost($postData, $postRegular)) return null;
            if(!is_array($reqHeaders)) $reqHeaders = array();
            $this->setHeaders($reqHeaders);
            if(!is_null($this->cURLMultiInstance)) return null;
            return $this->fetch($URL);
        }
        //-- --------------------------------------------- --//
    }

//---------------------------------------------------
if(!function_exists('el_http_getURL')){
	function el_http_getURL($url, $headers = null){
		$httpClient = new elHttpClient();
		$httpResult = $httpClient->get($url, $headers);
		return $httpResult;
	}
	function el_http_getHTML($url, $headers = null){
		$httpResult = el_http_getURL($url, $headers);
		if(!$httpResult->isOK()) return null;
		return $httpResult->httpBody;
	}
}
//---------------------------------------------------
if(!function_exists('el_http_headURL')){
	function el_http_headURL($url, $headers = null){
		$httpClient = new elHttpClient();
		$httpResult = $httpClient->head($url, $headers);
		return $httpResult;
	}
	function el_http_headHTML($url, $headers = null){
		$httpResult = el_http_headURL($url, $headers);
		if(!$httpResult->isOK()) return null;
		return $httpResult->getResponse();
	}
}
//---------------------------------------------------
if(!function_exists('el_http_postURL')){
	function el_http_postURL($url, $pdata, $headers = null){
		$httpClient = new elHttpClient();
		$httpResult = $httpClient->post($url, $pdata, $headers);
		return $httpResult;
	}
	function el_http_postHTML($url, $pdata, $headers = null){
		$httpResult = el_http_postURL($url, $pdata, $headers);
		if(!$httpResult->isOK()) return null;
		return $httpResult->httpBody;
	}
}
//---------------------------------------------------
?>