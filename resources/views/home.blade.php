@extends('layouts.default')
@section ('content')
<link rel="stylesheet" type="text/css" href="{{ asset('css/style.css') }}">

<div class="container-fluid bootstrap snippet">
    @if ($response != null)
    <div class="alert alert-info alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        {{ $response->info }}
    </div>
    @endif

    <div class="row">
		<div class="col-md-4">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <!-- Centered Pills -->
                    <ul class="nav nav-pills nav-justified">
                        @if ($data['friend_username'] != null)
                        <li>
                            <a data-toggle="pill" href="#friend-list" id="friend-pane"><span class="fa fa-user"></span> Friend</a>
                        </li>
                        @elseif ($data['group_id'] != null)
                        <li>
                            <a data-toggle="pill" href="#group-list" id="group-pane"><span class="fa fa-group"></span> Group</a>
                        </li>
                        @else
                        <li>
                            <a data-toggle="pill" href="#friend-list" id="friend-pane"><span class="fa fa-user"></span> Friend</a>
                        </li>
                        <li>
                            <a data-toggle="pill" href="#group-list" id="group-pane"><span class="fa fa-group"></span> Group</a>
                        </li>
                        @endif
                    </ul>
                </div>
                <div class="panel-content">
                    <div class="nano tab-content">
                        <!-- Friend List -->
                        <ul id="friend-list" class="friend-list tab-pane fade in">
                            @foreach ($data['friends'] as $friend)
                            @if ($data['friend_username'] == null || $data['friend_username'] == $friend)
                            <li class="bounceInDown">
                                <a href="{{ route('friend.index', ['username' => $data['user'], 'friend_username' => $friend]) }}" class="clearfix">
                                    <img src="/user_default.jpg" alt="" class="img-circle">
                                    <div class="friend-name">
                                        <strong>{{ $friend }}</strong>
                                    </div>
                                </a>
                            </li>
                            @endif
                            @endforeach
                            <li class="bounceInDown">
                                <a href="{{ url('friend')}}" class="btn btn-primary btn-flat" data-toggle="modal" data-target="#addFriendModal">
                                    Add Friend
                                </a>
                            </li>
                        </ul>
                        <!-- Group List -->
                        <ul id="group-list" class="friend-list tab-pane fade in">
                            <li class="bounceInDown">
                                <a href="#" class="btn btn-success btn-flat" data-toggle="modal" data-target="#addGroupMembersModal">
                                    Add Group Members
                                </a>
                            </li>
                            @foreach ($data['groups'] as $group)
                            @if ($data['group_id'] == null || $data['group_id'] == $group->group_id)
                                <li class="bounceInDown">
                                    <a href="{{ route('group.index', ['username' => $data['user'], 'group_id' => $group->group_id]) }}" class="clearfix">
                                        <img src="/user_default.jpg" alt="" class="img-circle">
                                        <div class="friend-name">   
                                            <strong>{{ $group->group_name }}</strong>
                                        </div>
                                    </a>
                                </li>
                                @if ($data['group_id'] == $group->group_id)
                                @foreach ($data['group_members'][$group->group_id] as $member)
                                    <li class="list-group-item">
                                        {{ $member }}
                                    </li>
                                @endforeach
                                <li class="bounceInDown">
                                    <a href="#" class="btn btn-danger btn-flat" data-toggle="modal" data-target="#exitGroupModal">
                                        Exit Group
                                    </a>
                                </li>
                                @endif

                            @endif
                            @endforeach
                            
                            <li class="bounceInDown">
                                <a href="#" class="btn btn-primary btn-flat" data-toggle="modal" data-target="#createGroupModal">
                                    Add Group
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
		</div>

        <!-- Modal -->
        <div id="addFriendModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add Friend</h4>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('friend') }}" method="post">
                            <div class="form-group">
                                <label for="add-friend-form-username">Friend Username</label>
                                <input id="add-friend-form-username" name="friend_username" type="text" class="form-control" placeholder="Enter username">
                            </div>
                            <input type="hidden" name="username" value="{{ $data['user'] }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Add</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal -->
        <div id="createGroupModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add Group</h4>
                    </div>
                    <div class="modal-body"><form action="{{ url('group') }}" method="post">
                        <form action="{{ url('group') }}" method="post">
                            <div class="form-group">
                                <label for="create-group-form-name">Group Name</label>
                                <input id="create-group-form-name" name="group_name" type="text" class="form-control" placeholder="Enter Group Name">
                            </div>
                            <div class="form-group">
                                <label for="create-group-form-members">Members</label>
                                <input id="create-group-form-members" name="members" type="text" class="form-control" placeholder="Enter member usernames separated by space">
                            </div>
                            <input type="hidden" name="username" value="{{ $data['user'] }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Add</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal -->
        <div id="exitGroupModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Exit Group</h4>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to exit this group?</p>
                        <form action="{{ route('group.delete') }}" method="post">
                            <input type="hidden" name="username" value="{{ $data['user'] }}">
                            <input type="hidden" name="group_id" value="{{ $data['group_id'] }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <button type="submit" class="btn btn-danger">Exit Group</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal -->
        <div id="addGroupMembersModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Exit Group</h4>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('group.update') }}" method="post">
                            <input type="hidden" name="username" value="{{ $data['user'] }}">
                            <input type="hidden" name="group_id" value="{{ $data['group_id'] }}">
                            <div class="form-group">
                                <label for="add-group-members-form-members">Members</label>
                                <input id="add-group-members-form-members" name="members" type="text" class="form-control" placeholder="Enter member usernames separated by space">
                            </div>
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">Add Group Members</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!--=========================================================-->
        <!-- selected chat -->
    	<div class="col-md-8">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="text-center">Chat</h3>
                </div>
                <div class="panel-content">
                    <div class="nano">
                        <ul class="chat">
                            <li class="left clearfix">
                                <span class="chat-img pull-left">
                                    <img src="/user_default.jpg" alt="User Avatar">
                                </span>
                                <div class="chat-body clearfix">
                                    <div class="header">
                                        <strong class="primary-font">tifani</strong>
                                    </div>
                                    <p>
                                        Created with RabbitMQ
                                    </p>
                                </div>
                            </li>
                            <li class="right clearfix">
                                <span class="chat-img pull-right">
                                    <img src="/user_default.jpg" alt="User Avatar">
                                </span>
                                <div class="chat-body clearfix">
                                    <div class="header">
                                        <strong class="primary-font">acel</strong>
                                    </div>
                                    <p>
                                        Laravel 5.3
                                    </p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="panel-footer">
                    <form action="{{ route('friend.chat', ['username' => $data['user'], 'friend_username' => $data['friend_username']]) }}" method="post">
                        <div class="content row">
                            <div class="col-md-10">
                		        <input class="form-control" type="text" name="message" placeholder="Type your message here">
                            </div>
                            <div class="col-md-2">
                                <button class="form-control btn btn-success" type="submit">Send</button>
                            </div>
                            <input type="hidden" name="username" value="{{ $data['user'] }}">
                            <input type="hidden" name="friend_username" value="{{ $data['friend_username'] }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        </div>
                    </form>
                </div>
            </div>
		</div>        
	</div>
</div>
@endsection