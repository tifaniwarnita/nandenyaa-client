<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/constants.php';
require_once __DIR__ . '/request_builder.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
class FibonacciRpcClient {
	private $connection;
	private $channel;
	private $callback_queue;
	private $response;
	private $corr_id;
	public function __construct() {
		$this->connection = new AMQPStreamConnection(
			Constants::SERVER_ADDRESS, 5672, 'guest', 'guest');
		$this->channel = $this->connection->channel();
		list($this->callback_queue, ,) = $this->channel->queue_declare(
			"", false, false, true, false);
		$this->channel->basic_consume(
			$this->callback_queue, '', false, false, false, false,
			array($this, 'on_response'));
	}
	public function on_response($rep) {
		if($rep->get('correlation_id') == $this->corr_id) {
			$this->response = $rep->body;
		}
	}
	public function call($n) {
		$this->response = null;
		$this->corr_id = uniqid();	
		$arr = array('tifani','acel');
		$msg = new AMQPMessage(
	 		RequestBuilder::buildGetGroupMembersMessage("quinsy", 1), //RequestBuilder::buildExitGroupMessage("kucing", 6) , //RequestBuilder::buildGetGroupMembersMessage("quinsy", 1), //buildExitGroupMessage("kucing", 6), //RequestBuilder::buildRemoveGroupMembersMessage("tifani", 6, $arr), // RequestBuilder::buildLoginMessage("quinsy", "quinsy"), //RequestBuilder::buildCreateGroupMessage("quinsy", "Tifa Semangat", $arr), // '{"password":"quinsy","request_type":"register","date_time":1478091245602,"username":"quinsy"}'
			array('correlation_id' => $this->corr_id,
			      'reply_to' => $this->callback_queue)
			);
		$this->channel->basic_publish($msg, '', Constants::SERVER_QUEUERE_NAME);
		while(!$this->response) {
			$this->channel->wait();
		}
		return $this->response;
	}
};
$fibonacci_rpc = new FibonacciRpcClient();
$response = $fibonacci_rpc->call(30);
echo " [.] Got ", $response, "\n\n\n <br>";
echo RequestBuilder::buildLoginMessage("quinsy", "quinsy") , "<br>";
$arr = array('kucing','snowball');
echo RequestBuilder::buildAddGroupMembersMessage("quinsy", 1, $arr), "<br>";
echo RequestBuilder::buildRemoveGroupMembersMessage("quinsy", 1, $arr) , "<br>";
echo RequestBuilder::buildExitGroupMessage("kucing", 6) , "<br>";
echo RequestBuilder::buildGetGroupMembersMessage("quinsy", 1)

?>