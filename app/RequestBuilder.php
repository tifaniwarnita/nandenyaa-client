<?php
namespace App;

use App\Constants;
	
class RequestBuilder {
    public static function buildRegisterMessage($username, $password) {
        $message = array(
        	Constants::REQUEST_TYPE => Constants::REGISTER,
        	Constants::USERNAME => $username,
        	Constants::PASSWORD => $password,
        	Constants::DATE_TIME => microtime());
        return json_encode($message);
    }

    public static function buildLoginMessage($username, $password) {
        $message = array(
        	Constants::REQUEST_TYPE => Constants::LOGIN,
        	Constants::USERNAME => $username,
        	Constants::PASSWORD => $password,
        	Constants::DATE_TIME => microtime());
        return json_encode($message);
    }

    public static function buildPrivateMessage($username, $receiver, $messageContent) {
        $message = array(
        	Constants::REQUEST_TYPE => Constants::PRIVATE_MESSAGE,
        	Constants::USERNAME => $username,
        	Constants::RECEIVER => $receiver,
        	Constants::MESSAGE => $messageContent,
        	Constants::DATE_TIME => microtime());
        return json_encode($message);
    }

    public static function buildGroupMessage($username, $groupId, $messageContent) {
        $message = array(
        	Constants::REQUEST_TYPE => Constants::GROUP_MESSAGE,
        	Constants::USERNAME => $username,
        	Constants::GROUP_ID => $groupId,
        	Constants::MESSAGE => $messageContent,
        	Constants::DATE_TIME => microtime());
        return json_encode($message);
    }

    public static function buildAddFriendMessage($username, $userToAdd) {
        $message = array(
        	Constants::REQUEST_TYPE => Constants::ADD_FRIEND,
        	Constants::USERNAME => $username,
        	Constants::USER_TO_ADD => $userToAdd,
        	Constants::DATE_TIME => microtime());
        return json_encode($message);
    }

    public static function buildCreateGroupMessage($username, $groupName, $members) {
		$arr = array();
        if ($members != null) {
			foreach($members as $member) {
				array_push($arr, $member);
			}
        }
        $message = array(
        	Constants::REQUEST_TYPE => Constants::CREATE_GROUP,
        	Constants::USERNAME => $username,
        	Constants::GROUP_NAME => $groupName,
			Constants::MEMBERS => $arr,
        	Constants::DATE_TIME => microtime());
        return json_encode($message);
    }

    public static function buildAddGroupMembersMessage($username, $groupId, $newMembers) {
				$arr = array();
        if ($newMembers != null) {
			foreach($newMembers as $member) {
				array_push($arr, $member);
			}
        }
        $message = array(
        	Constants::REQUEST_TYPE => Constants::ADD_GROUP_MEMBERS,
        	Constants::USERNAME => $username,
        	Constants::GROUP_ID => $groupId,
        	Constants::MEMBERS => $arr,
        	Constants::DATE_TIME => microtime());
        return json_encode($message);
    }

    public static function buildRemoveGroupMembersMessage($username, $groupId, $members) {
		$arr = array();
        if ($members != null) {
			foreach($members as $member) {
				array_push($arr, $member);
			}
        }
        $message = array(
        	Constants::REQUEST_TYPE => Constants::REMOVE_GROUP_MEMBERS,
        	Constants::USERNAME => $username,
        	Constants::GROUP_ID => $groupId,
        	Constants::MEMBERS => $arr,
        	Constants::DATE_TIME => microtime());
        return json_encode($message);
    }

    public static function buildExitGroupMessage($username, $groupId) {
        $message = array(
        	Constants::REQUEST_TYPE => Constants::EXIT_GROUP,
        	Constants::USERNAME => $username,
        	Constants::GROUP_ID => $groupId,
        	Constants::DATE_TIME => microtime());
        return json_encode($message);
    }

    public static function buildGetFriendsMessage($username) {
        $message = array(
        	Constants::REQUEST_TYPE => Constants::GET_FRIENDS,
        	Constants::USERNAME => $username,
        	Constants::DATE_TIME => microtime());
        return json_encode($message);
    }

    public static function buildGetGroupsMessage($username) {
        $message = array(
        	Constants::REQUEST_TYPE => Constants::GET_GROUPS, 
        	Constants::USERNAME => $username,
        	Constants::DATE_TIME => microtime());
        return json_encode($message);
    }

    public static function buildGetGroupMembersMessage($username, $groupId) {
        $message = array(
        	Constants::REQUEST_TYPE => Constants::GET_GROUP_MEMBERS,
        	Constants::USERNAME => $username,
        	Constants::GROUP_ID => $groupId,
        	Constants::DATE_TIME => microtime());
        return json_encode($message);
    }
}
?>