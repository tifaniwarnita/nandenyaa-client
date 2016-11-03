<?php


namespace App\Http\Controllers;

use App\Constants;
use App\RequestBuilder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;


class HomeController extends Controller
{
    private $connection;
    private $channel;
    private $request_queue = Constants::SERVER_QUEUERE_NAME;
    private $response_queue;
    private $client_queue;
    private $response;
    private $message;
    private $corr_id;
    private $active_user;

    // Constructor
    public function __construct() {
        // Create new connection
        $this->connection = new AMQPStreamConnection(
            Constants::SERVER_ADDRESS, 5672, 'guest', 'guest');
        $this->channel = $this->connection->channel();
        
        list($this->response_queue, ,) = $this->channel->queue_declare(
            "", false, false, false, true);
        $this->channel->basic_consume(
            $this->response_queue, '', false, false, false, false,
            array($this, 'on_response'));
    }

    // Function for View
    public function index() {
        $data = [
            'user' => 'omarcelh',
            'friends' => [
                'teman-1',
                'teman-2',
                'teman-3'
            ],
            'groups' => [
                'group-1',
                'group-2',
                'group-3'
            ]
        ];
        return view('home', compact($data));
    }

    public function login(Request $request) {
        $vals = $request->all();

        $response = json_decode($this->call(RequestBuilder::buildLoginMessage($vals['username'], $vals['password'])));
        // echo " [.] Got ", json_encode($response), "\n\n\n <br>";
        $status = Constants::STATUS;
        if(strcmp($response->$status, Constants::SUCCESS) == 0) {
            return response()->view('home');
        } else {
            return response()->view('login');
        }
    }

    public function register(Request $request) {
        $vals = $request->all();
        if($vals['password'] == $vals['password-confirmation']) {
            $response = json_decode($this->call(RequestBuilder::buildRegisterMessage($vals['username'], $vals['password'])));
            // echo " [.] Got ", json_encode($response), "\n\n\n <br>";
            $status = Constants::STATUS;
            if(strcmp($response->$status, Constants::SUCCESS) == 0) {
                // TO-DO Get list of friends and groups and chats
                return response()->view('home');
            } else {
                return response()->view('register');
            }
        } else {
            return response()->view('register');
        }
    }

    // Function for RabbitMQ
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

        $this->client_queue = $this->active_user;
        $this->channel->queue_declare($this->client_queue, false, false, false, true);
        $this->channel->basic_consume(
            $this->client_queue, '', false, false, false, false,
            array($this, 'on_message'));

        $data = [
            'user' => 'omarcelh',
            'friends' => [
                'teman-1',
                'teman-2',
                'teman-3'
            ],
            'groups' => [
                'group-1',
                'group-2',
                'group-3'
            ]
        ];

        // while(!$this->message) {
        //     $this->channel->wait();
        // }
        return $this->message;
    }
}

?>