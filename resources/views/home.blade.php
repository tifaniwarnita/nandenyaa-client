@extends('layouts.default')
@section ('content')
<link rel="stylesheet" type="text/css" href="css/style.css">
<div class="container-fluid bootstrap snippet">
    <div class="row">
		<div class="col-md-4">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <!-- Centered Pills -->
                    <ul class="nav nav-pills nav-justified">
                        <li class="active">
                            <a data-toggle="pill" href="#friend-list" id="friend-pane"><span class="fa fa-user"></span> Friend</a>
                        </li>
                        <li>
                            <a data-toggle="pill" href="#group-list" id="group-pane"><span class="fa fa-group"></span> Group</a>
                        </li>
                    </ul>
                </div>
                <div class="panel-content">
                    <div class="nano tab-content">
                        <!-- Friend List -->
                        <ul id="friend-list" class="friend-list tab-pane fade in active">
                            @foreach ($data['friends'] as $friend)
                            <li class="active bounceInDown">
                                <a href="#" class="clearfix">
                                    <img src="/user_default.jpg" alt="" class="img-circle">
                                    <div class="friend-name">   
                                        <strong>{{ $friend }}</strong>
                                    </div>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                        <!-- Group List -->
                        <ul id="group-list" class="friend-list tab-pane fade in">
                            @foreach ($data['groups'] as $group)
                            <li class="active bounceInDown">
                                <a href="#" class="clearfix">
                                    <img src="/user_default.jpg" alt="" class="img-circle">
                                    <div class="friend-name">   
                                        <strong>{{ $group->group_name }}</strong>
                                    </div>
                                </a>
                            </li>
                            @endforeach
                        </ul>
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
                            			<strong class="primary-font">John Doe</strong>
                            			<small class="pull-right text-muted"><i class="fa fa-clock-o"></i> 12 mins ago</small>
                            		</div>
                            		<p>
                            			Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            		</p>
                            	</div>
                            </li>
                            <li class="right clearfix">
                            	<span class="chat-img pull-right">
                            		<img src="/user_default.jpg" alt="User Avatar">
                            	</span>
                            	<div class="chat-body clearfix">
                            		<div class="header">
                            			<strong class="primary-font">Sarah</strong>
                            			<small class="pull-right text-muted"><i class="fa fa-clock-o"></i> 13 mins ago</small>
                            		</div>
                            		<p>
                            			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare dolor, quis ullamcorper ligula sodales at. 
                            		</p>
                            	</div>
                            </li>
                            <li class="left clearfix">
                                <span class="chat-img pull-left">
                            		<img src="/user_default.jpg" alt="User Avatar">
                            	</span>
                            	<div class="chat-body clearfix">
                            		<div class="header">
                            			<strong class="primary-font">John Doe</strong>
                            			<small class="pull-right text-muted"><i class="fa fa-clock-o"></i> 12 mins ago</small>
                            		</div>
                            		<p>
                            			Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            		</p>
                            	</div>
                            </li>
                            <li class="right clearfix">
                                <span class="chat-img pull-right">
                            		<img src="/user_default.jpg" alt="User Avatar">
                            	</span>
                            	<div class="chat-body clearfix">
                            		<div class="header">
                            			<strong class="primary-font">Sarah</strong>
                            			<small class="pull-right text-muted"><i class="fa fa-clock-o"></i> 13 mins ago</small>
                            		</div>
                            		<p>
                            			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare dolor, quis ullamcorper ligula sodales at. 
                            		</p>
                            	</div>
                            </li>                    
                            <li class="left clearfix">
                                <span class="chat-img pull-left">
                            		<img src="/user_default.jpg" alt="User Avatar">
                            	</span>
                            	<div class="chat-body clearfix">
                            		<div class="header">
                            			<strong class="primary-font">John Doe</strong>
                            			<small class="pull-right text-muted"><i class="fa fa-clock-o"></i> 12 mins ago</small>
                            		</div>
                            		<p>
                            			Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            		</p>
                            	</div>
                            </li>
                            <li class="right clearfix">
                                <span class="chat-img pull-right">
                            		<img src="/user_default.jpg" alt="User Avatar">
                            	</span>
                            	<div class="chat-body clearfix">
                            		<div class="header">
                            			<strong class="primary-font">Sarah</strong>
                            			<small class="pull-right text-muted"><i class="fa fa-clock-o"></i> 13 mins ago</small>
                            		</div>
                            		<p>
                            			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare dolor, quis ullamcorper ligula sodales at. 
                            		</p>
                            	</div>
                            </li>
                            <li class="right clearfix">
                                <span class="chat-img pull-right">
                            		<img src="/user_default.jpg" alt="User Avatar">
                            	</span>
                            	<div class="chat-body clearfix">
                            		<div class="header">
                            			<strong class="primary-font">Sarah</strong>
                            			<small class="pull-right text-muted"><i class="fa fa-clock-o"></i> 13 mins ago</small>
                            		</div>
                            		<p>
                            			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur bibendum ornare dolor, quis ullamcorper ligula sodales at. 
                            		</p>
                            	</div>
                            </li>                    
                        </ul>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="chat-box">
                    	<div class="input-group">
                    		<input class="form-control border no-shadow no-rounded" placeholder="Type your message here">
                    		<span class="input-group-btn">
                    			<button class="btn btn-success no-rounded" type="button">Send</button>
                    		</span>
                    	</div>
                    </div>
                </div>
            </div>
		</div>        
	</div>
</div>
@endsection