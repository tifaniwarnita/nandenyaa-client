<?php
namespace App;

class Constants {
    const SERVER_ADDRESS = "localhost";
    const SERVER_QUEUERE_NAME = "rpc_nandenyaa";
    const EXCHANGE_NAME = "nandenyaa_exchange";
    const DEAD_LETTER_EXCHANGE_NAME = "dead_letter_nandenyaa_exchange";
    const REQUEST_TYPE = "request_type";
    const RESPONSE_TYPE = "response_type";

    // Request type
    const REGISTER = "register";
    const LOGIN = "login";
    const PRIVATE_MESSAGE = "private_message";
    const GROUP_MESSAGE = "group_message";
    const ADD_FRIEND = "add_friend";
    const CREATE_GROUP = "create_group";
    const ADD_GROUP_MEMBERS = "add_group_members";
    const REMOVE_GROUP_MEMBERS = "remove_group_members";
    const EXIT_GROUP = "exit_group";
    const GET_FRIENDS = "get_friends";
    const GET_GROUPS = "get_groups";
    const GET_GROUP_MEMBERS = "get_group_members";

    // Response type
    const SUCCESS = "success";
    const FAILED = "failed";
    const UNKNOWN = "unknown";

    // Params
    const DATE_TIME = "date_time";
    const USERNAME = "username";
    const PASSWORD = "password";
    const RECEIVER = "receiver";
    const MESSAGE = "message";
    const USER_TO_ADD = "user_to_add";
    const GROUP_ID = "group_id";
    const GROUP_NAME = "group_name";
    const MEMBERS = "members";
    const STATUS = "status";
    const INFO = "info";
    const FRIENDS = "friends";
    const GROUPS = "groups";
    const GROUP_MEMBERS = "group_members";
}
?>