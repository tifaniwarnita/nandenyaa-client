<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/constants.php';
require_once __DIR__ . '/request_builder.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class NandeNyaaClient {
	private $connection;
	private $channel;
	private $request_queue = Constants::SERVER_QUEUERE_NAME;
	private $response_queue;
	private $client_queue;
	private $response;
	private $message;
	private $corr_id;
	private $active_user;

	public function __construct() {
		// Create new connection
		$this->connection = new AMQPStreamConnection(
			Constants::SERVER_ADDRESS, 5672, 'guest', 'guest');
		$this->channel = $this->connection->channel();

		$args = array(
			"x-dead-letter-exchange" =>Constants::DEAD_LETTER_EXCHANGE_NAME);

		list($this->response_queue, ,) = $this->channel->queue_declare(
			"", false, false, false, true);
		$this->channel->basic_consume(
			$this->response_queue, '', false, false, false, false,
			array($this, 'on_response'));
	}

	public function on_response($rep) {
		if($rep->get('correlation_id') == $this->corr_id) {
			$this->response = $rep->body;
		}
	}

	public function on_message($rep) {
		$this->message = $rep->body;
		echo "GOT MESSAGE: ", $this->message;
	}

	public function call($n) {
		$this->response = null;
		$this->corr_id = uniqid();	
		$arr = array('tifani','acel');
		$msg = new AMQPMessage($n,
			array('correlation_id' => $this->corr_id,
			      'reply_to' => $this->response_queue,
						'delivery_mode' => 2)
			);
		$this->channel->basic_publish($msg, '', Constants::SERVER_QUEUERE_NAME);
		while(!$this->response) {
			$this->channel->wait();
		}
		return $this->response;
	}

	public function loginSuccess($username) {
		echo "login: ", $username;
		$this->active_user = $username;

		$args = array(
			"x-dead-letter-exchange" =>Constants::DEAD_LETTER_EXCHANGE_NAME);

		$this->client_queue = $username;
		$this->channel->queue_declare($this->client_queue, false, false, false, true, $args);
		$this->channel->basic_consume(
			$this->client_queue, '', false, false, false, false,
			array($this, 'on_message'));
	}
}

$nandenyaa_client = new NandeNyaaClient();
echo RequestBuilder::buildLoginMessage("quinsy", "quinsy") , "<br>";
$arr = array('kucing','snowball');
echo RequestBuilder::buildAddGroupMembersMessage("quinsy", 1, $arr), "<br>";
echo RequestBuilder::buildRemoveGroupMembersMessage("quinsy", 1, $arr) , "<br>";
echo RequestBuilder::buildExitGroupMessage("kucing", 6) , "<br>";
echo RequestBuilder::buildGetGroupMembersMessage("quinsy", 1), "<br><br><br><br>";


$response = $nandenyaa_client->call(RequestBuilder::buildGetGroupMembersMessage("quinsy", 1));
// $fibonacci_rpc = new FibonacciRpcClient();
// $response = $fibonacci_rpc->call(RequestBuilder::buildGetGroupMembersMessage("quinsy", 1));
echo " [.] Got ", $response, "\n\n\n <br>";
$nandenyaa_client->loginSuccess("kucing");

?>