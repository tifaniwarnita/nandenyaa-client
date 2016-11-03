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
    public function friendIndex($username, $friend_username) {
        $data = [];
        if($username != null && $friend_username !=null) {
            // Get Chat From Friend
            $data = $this->getData($username);
            $data['friend_username'] = $friend_username;
        }
        return response()->view('home', ['data' => $data, 'response' => null], 200);
    }

    public function groupIndex($username, $group_id) {
        $data = [];
        if($username != null && $group_id != null) {
            // Get Chat From Friend
            $data = $this->getData($username);
            $data['group_id'] = $group_id;
        }
        // echo json_encode($data);
        return response()->view('home', ['data' => $data, 'response' => null], 200);
    }    

    public function login(Request $request) {
        $vals = $request->all();

        $response = json_decode($this->call(RequestBuilder::buildLoginMessage($vals['username'], $vals['password'])));
        // echo " [.] Got ", json_encode($response), "\n\n\n <br>";
        $status = Constants::STATUS;
        if(strcmp($response->$status, Constants::SUCCESS) == 0) {
            $this->active_user = $vals['username'];

            $data = $this->getData($this->active_user);

            $msg = $this->loginSuccess($vals['username']);
            return response()->view('home', ['data' => $data, 'response' => $response], 200);
        } else {
            return response()->view('login', ['response' => $response]);
        }
    }

    public function register(Request $request) {
        $vals = $request->all();
        if($vals['password'] == $vals['password-confirmation']) {
            $response = json_decode($this->call(RequestBuilder::buildRegisterMessage($vals['username'], $vals['password'])));
            $status = Constants::STATUS;
            if(strcmp($response->$status, Constants::SUCCESS) == 0) {
                $data = $this->getData($vals['username']);
                return response()->view('home', ['data' => $data, 'response' => $response], 200);
            } else {
                return response()->view('register', ['response' => $response], 200);
            }
        } else {
            $json = '{"response_type":"login","status":"success","info":"Password confirmation does not match"}';
            $response = json_decode($json);
            return response()->view('register', ['response' => $response]);
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

    public function chat(Request $request) {
        $vals = $request->all();
        
        $response = json_decode($this->call(RequestBuilder::buildPrivateMessage($vals['username'], $vals['friend_username'], $vals['message'])));

        $data = $this->getData($vals['username']);
        
        return response()->view('home', ['data' => $data, 'response' => $response], 200);
    }

    public function call($n) {
        $this->response = null;
        $this->corr_id = uniqid();  
        
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
        // echo "login: ", $username;
        $this->active_user = $username;

        $this->client_queue = $this->active_user;
        $this->channel->queue_declare($this->client_queue, false, false, false, true);
        $this->channel->basic_consume(
            $this->client_queue, '', false, false, false, false,
            array($this, 'on_message'));

        $data = $this->getData($username);
        return $this->message;
    }

    public function addFriend(Request $request) {
        $vals = $request->all();
        $this->active_user = $vals['username'];

        $response = json_decode($this->call(RequestBuilder::buildAddFriendMessage($vals['username'], $vals['friend_username'])));
        $data = $this->getData($vals['username']);

        return response()->view('home', ['data' => $data, 'response' => $response], 200);
    }

     public function createGroup(Request $request) {
        $vals = $request->all();
        $this->active_user = $vals['username'];

        $members = explode(" ", $vals['members']);

        $response = json_decode($this->call(RequestBuilder::buildCreateGroupMessage($vals['username'], $vals['group_name'], $members)));
        $data = $this->getData($vals['username']);

        return response()->view('home', ['data' => $data, 'response' => $response], 200);
    }

    public function deleteGroup(Request $request) {
        $vals = $request->all();
        $this->active_user = $vals['username'];

        $response = json_decode($this->call(RequestBuilder::buildExitGroupMessage($vals['username'], $vals['group_id'])));
        $data = $this->getData($vals['username']);

        return response()->view('home', ['data' => $data, 'response' => $response], 200);

    }

    public function updateGroup(Request $request) {
        $vals = $request->all();
        $this->active_user = $vals['username'];

        $members = explode(" ", $vals['members']);

        $response = json_decode($this->call(RequestBuilder::buildAddGroupMembersMessage($vals['username'], $vals['group_id'], $members)));

        $data = $this->getData($vals['username']);

        return redirect()->route('group.index', ['group_id' => $vals['group_id'], 'username' => $vals['username'], 'data' => $data, 'response' => $response]);
    }

    public function getData($username) {
        // Get Friends
        $response = json_decode($this->call(RequestBuilder::buildGetFriendsMessage($username)));
        $friends = $response->friends;

        // TO-DO
        // Get chat from each friend

        // Get Groups
        $response = json_decode($this->call(RequestBuilder::buildGetGroupsMessage($username)));
        $groups = $response->groups;

        $group_members = [];
        foreach ($groups as $group) {
            $response = json_decode($this->call(RequestBuilder::buildGetGroupMembersMessage($username, $group->group_id)));
            $group_members[$group->group_id] = $response->group_members;
        }

        // TO-DO
        // Get chat from each group

        $data = [
            'user' => $username,
            'friends' => $friends,
            'groups' => $groups,
            'group_members' => $group_members,
            'group_id' => null,
            'friend_username' => null
        ];

        return $data;
    }
}

?>