<?php
/**
 * Part of the Joomla Framework Http Package
 *
 * @copyright  Copyright (C) 2005 - 2022 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\Http\Transport;

use Joomla\Http\Exception\InvalidResponseCodeException;
use Joomla\Http\Response;
use Joomla\Http\TransportInterface;
use Joomla\Uri\Uri;
use Joomla\Uri\UriInterface;

/**
 * HTTP transport class for using sockets directly.
 *
 * @since  1.0
 */
class Socket implements TransportInterface
{
	/**
	 * Reusable socket connections.
	 *
	 * @var    array
	 * @since  1.0
	 */
	protected $connections;

	/**
	 * The client options.
	 *
	 * @var    array|\ArrayAccess
	 * @since  1.0
	 */
	protected $options;

	/**
	 * Constructor.
	 *
	 * @param   array|\ArrayAccess  $options  Client options array.
	 *
	 * @since   1.0
	 * @throws  \RuntimeException
	 */
	public function __construct($options = array())
	{
		if (!self::isSupported())
		{
			throw new \RuntimeException('Cannot use a socket transport when fsockopen() is not available.');
		}

		if (!\is_array($options) && !($options instanceof \ArrayAccess))
		{
			throw new \InvalidArgumentException(
				'The options param must be an array or implement the ArrayAccess interface.'
			);
		}

		$this->options = $options;
	}

	/**
	 * Send a request to the server and return a Response object with the response.
	 *
	 * @param   string        $method     The HTTP method for sending the request.
	 * @param   UriInterface  $uri        The URI to the resource to request.
	 * @param   mixed         $data       Either an associative array or a string to be sent with the request.
	 * @param   array         $headers    An array of request headers to send with the request.
	 * @param   integer       $timeout    Read timeout in seconds.
	 * @param   string        $userAgent  The optional user agent string to send with the request.
	 *
	 * @return  Response
	 *
	 * @since   1.0
	 * @throws  \RuntimeException
	 */
	public function request($method, UriInterface $uri, $data = null, array $headers = null, $timeout = null, $userAgent = null)
	{
		$connection = $this->connect($uri, $timeout);

		// Make sure the connection is alive and valid.
		if (\is_resource($connection))
		{
			// Make sure the connection has not timed out.
			$meta = stream_get_meta_data($connection);

			if ($meta['timed_out'])
			{
				throw new \RuntimeException('Server connection timed out.');
			}
		}
		else
		{
			throw new \RuntimeException('Not connected to server.');
		}

		// Get the request path from the URI object.
		$path = $uri->toString(array('path', 'query'));

		// If we have data to send make sure our request is setup for it.
		if (!empty($data))
		{
			// If the data is not a scalar value encode it to be sent with the request.
			if (!is_scalar($data))
			{
				$data = http_build_query($data);
			}

			if (!isset($headers['Content-Type']))
			{
				$headers['Content-Type'] = 'application/x-www-form-urlencoded; charset=utf-8';
			}

			// Add the relevant headers.
			$headers['Content-Length'] = \strlen($data);
		}

		// Configure protocol version, use transport's default if not set otherwise.
		$protocolVersion = isset($this->options['protocolVersion']) ? $this->options['protocolVersion'] : '1.1';

		// Build the request payload.
		$request   = array();
		$request[] = strtoupper($method) . ' ' . ((empty($path)) ? '/' : $path) . ' HTTP/' . $protocolVersion;

		if (!isset($headers['Host']))
		{
			$request[] = 'Host: ' . $uri->getHost();
		}

		// If an explicit user agent is given use it.
		if (isset($userAgent))
		{
			$headers['User-Agent'] = $userAgent;
		}

		// If we have a username then we include basic authentication credentials.
		if ($uri->getUser())
		{
			$authString               = $uri->getUser() . ':' . $uri->getPass();
			$headers['Authorization'] = 'Basic ' . base64_encode($authString);
		}

		// If there are custom headers to send add them to the request payload.
		if (\is_array($headers))
		{
			foreach ($headers as $k => $v)
			{
				$request[] = $k . ': ' . $v;
			}
		}

		// Authentication, if needed
		if (isset($this->options['userauth'], $this->options['passwordauth']))
		{
			$request[] = 'Authorization: Basic ' . base64_encode($this->options['userauth'] . ':' . $this->options['passwordauth']);
		}

		// Set any custom transport options
		if (isset($this->options['transport.socket']))
		{
			foreach ($this->options['transport.socket'] as $value)
			{
				$request[] = $value;
			}
		}

		// If we have data to send add it to the request payload.
		if (!empty($data))
		{
			$request[] = null;
			$request[] = $data;
		}

		// Send the request to the server.
		fwrite($connection, implode("\r\n", $request) . "\r\n\r\n");

		// Get the response data from the server.
		$content = '';

		while (!feof($connection))
		{
			$content .= fgets($connection, 4096);
		}

		$content = $this->getResponse($content);

		// Follow Http redirects
		if ($content->code >= 301 && $content->code < 400 && isset($content->headers['Location']))
		{
			return $this->request($method, new Uri($content->headers['Location']), $data, $headers, $timeout, $userAgent);
		}

		return $content;
	}

	/**
	 * Method to get a response object from a server response.
	 *
	 * @param   string  $content  The complete server response, including headers.
	 *
	 * @return  Response
	 *
	 * @since   1.0
	 * @throws  \UnexpectedValueException
	 * @throws  InvalidResponseCodeException
	 */
	protected function getResponse($content)
	{
		// Create the response object.
		$return = new Response;

		if (empty($content))
		{
			throw new \UnexpectedValueException('No content in response.');
		}

		// Split the response into headers and body.
		$response = explode("\r\n\r\n", $content, 2);

		// Get the response headers as an array.
		$headers = explode("\r\n", $response[0]);

		// Set the body for the response.
		$return->body = empty($response[1]) ? '' : $response[1];

		// Get the response code from the first offset of the response headers.
		preg_match('/[0-9]{3}/', array_shift($headers), $matches);
		$code = $matches[0];

		if (is_numeric($code))
		{
			$return->code = (int) $code;
		}
		else
		{
			// No valid response code was detected.
			throw new InvalidResponseCodeException('No HTTP response code found.');
		}

		// Add the response headers to the response object.
		foreach ($headers as $header)
		{
			$pos                                             = strpos($header, ':');
			$return->headers[trim(substr($header, 0, $pos))] = trim(substr($header, ($pos + 1)));
		}

		return $return;
	}

	/**
	 * Method to connect to a server and get the resource.
	 *
	 * @param   UriInterface  $uri      The URI to connect with.
	 * @param   integer       $timeout  Read timeout in seconds.
	 *
	 * @return  resource  Socket connection resource.
	 *
	 * @since   1.0
	 * @throws  \RuntimeException
	 */
	protected function connect(UriInterface $uri, $timeout = null)
	{
		$errno = null;
		$err   = null;

		// Get the host from the uri.
		$host = ($uri->isSsl()) ? 'ssl://' . $uri->getHost() : $uri->getHost();

		// If the port is not explicitly set in the URI detect it.
		if (!$uri->getPort())
		{
			$port = ($uri->getScheme() == 'https') ? 443 : 80;
		}

		// Use the set port.
		else
		{
			$port = $uri->getPort();
		}

		// Build the connection key for resource memory caching.
		$key = md5($host . $port);

		// If the connection already exists, use it.
		if (!empty($this->connections[$key]) && \is_resource($this->connections[$key]))
		{
			// Connection reached EOF, cannot be used anymore
			$meta = stream_get_meta_data($this->connections[$key]);

			if ($meta['eof'])
			{
				if (!fclose($this->connections[$key]))
				{
					throw new \RuntimeException('Cannot close connection');
				}
			}

			// Make sure the connection has not timed out.
			elseif (!$meta['timed_out'])
			{
				return $this->connections[$key];
			}
		}

		if (!is_numeric($timeout))
		{
			$timeout = ini_get('default_socket_timeout');
		}

		// Capture PHP errors
		if (PHP_VERSION_ID < 70000)
		{
			// @Todo Remove this path, when PHP5 support is dropped.
			set_error_handler(
				function () {
					return false;
				}
			);
			@trigger_error('');
			restore_error_handler();
		}
		else
		{
			/** @noinspection PhpElementIsNotAvailableInCurrentPhpVersionInspection */
			error_clear_last();
		}

		// PHP sends a warning if the uri does not exists; we silence it and throw an exception instead.
		// Attempt to connect to the server
		$connection = @fsockopen($host, $port, $errno, $err, $timeout);

		if (!$connection)
		{
			$error = error_get_last();

			if ($error === null || $error['message'] === '')
			{
				// Error but nothing from php? Create our own
				$error = array(
					'message' => sprintf('Could not connect to resource %s: %s (%d)', $uri, $err, $errno)
				);
			}

			throw new \RuntimeException($error['message']);
		}

		// Since the connection was successful let's store it in case we need to use it later.
		$this->connections[$key] = $connection;

		// If an explicit timeout is set, set it.
		if (isset($timeout))
		{
			stream_set_timeout($this->connections[$key], (int) $timeout);
		}

		return $this->connections[$key];
	}

	/**
	 * Method to check if http transport socket available for use
	 *
	 * @return  boolean   True if available else false
	 *
	 * @since   1.0
	 */
	public static function isSupported()
	{
		return \function_exists('fsockopen') && \is_callable('fsockopen');
	}
}
