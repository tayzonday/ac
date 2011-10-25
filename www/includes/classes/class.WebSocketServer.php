<?php

Class WebSocketServer {
    
    protected $address = null;
    
    protected $port = null;
    
    protected $users = array();
    
    protected $master = null;
    
    protected $sockets = array();
    
    protected $callback = null;
    
    protected $maxConnection = 99;
    
    public function __construct($address, $port, $callback) {
        
        echo "constructed";
        
        $this->address = $address;
        $this->port = $port;
        $this->callback = $callback;
        
        $this->connectMaster($address, $port);        
    }
    
    public function getUsers() {
        return $this->users;
    }
    
    protected function connectMaster() {
        $this->master = socket_create(AF_INET, SOCK_STREAM, SOL_TCP) or die("socket_create() failed");
        $this->sockets[] = $this->master;
        socket_set_option($this->master, SOL_SOCKET, SO_REUSEADDR, 1) or die("socket_option() failed");
        socket_bind($this->master, $this->address, $this->port) or die("socket_bind() failed");
        socket_listen($this->master, 20) or die("socket_listen() failed");

		echo "Server Started : " . date('Y-m-d H:i:s') . "\n";
		echo "Master socket  : " . $this->master . "\n";
		echo "Listening on   : " . $this->address . " port " . $this->port . "\n\n";

        return $this->master;
    }

    public function run() {        
        while(true){
            $changed = $this->sockets;
            socket_select($changed, $write=NULL, $except=NULL,NULL);
            foreach($changed as $socket){
                if ($socket == $this->master) {
                    $client = socket_accept($this->master);
                    if($client < 0){ console("socket_accept() failed"); continue; }
                    else{ $this->connect($client); }
                } else {
                    $bytes = @socket_recv($socket, $buffer, 2048, 0);
                    if($bytes == 0) {
                        $this->disconnect($socket);
                    } else {
                        $user = $this->getUserBySocket($socket);
                        if(! $user->handshake) {
                            $user->doHandshake($buffer);
                        } else {
                            $user->lastAction = time();
                            // call the callback function
        					$this->process($user, $buffer);
                        }
                    }
                }
            }
        }        
        
    }
    
    public function connect($socket) {
        $this->users[] = new WebSocketUser($socket);
        $this->sockets[] = $socket;        
    }
    
    public function disconnect($socket) {
        if ($this->users) {
            $found=null;
            $n = count($this->users);
            for($i=0;$i<$n;$i++){
                if($this->users[$i]->socket == $socket){ $found=$i; break; }
            }
            if(!is_null($found)){ array_splice($this->users, $found, 1); }
            $index = array_search($socket, $this->sockets);
            socket_close($socket);
            $this->say($socket." DISCONNECTED!");
            if($index>=0){ array_splice($this->sockets, $index, 1); }
        }
    }
    
    public function getUserBySocket($socket) {
        $found=null;
        foreach($this->users as $user) {
            if($user->socket==$socket) {
                $found=$user;
                break;
            }
        }
        return $found;        
    }

    public function send($client, $msg){
        $msg = $this->wrap($msg);
        $this->say("OUT: ". $msg);
        @socket_write($client, $msg, strlen($msg));
    }

	public function process($user, $msg) {

		$action = $this->unwrap($msg);
		$this->say("IN: ".$action);
		
		$data = json_decode($action);
		print_r($data);
		
		if(isset($data->setup)) {

			// setup
			$user->on_page = $data->page_id;
			
			$query = "select * from sessions where session_hash = '" . mysql_real_escape_string($data->session_hash) . "' limit 1";
			echo $query;
			$res = mysql_query($query);
			if(mysql_num_rows($res) == 0) {
				$this->send($user->socket, 'Invalid session');
				$user->disconnect();
			} else {
				$row = mysql_fetch_assoc($res);
				// User is not authenticated
				if(($row['user_id'] == 0) && ($row['driver_id'] == 0)) {
					$this->send($user->socket, 'Not logged in');
					$user->disconnect();
				} else {
				
					if($row['user_id'] > 0) {
						$user->user_id = $row['user_id'];
					}

					if($row['driver_id'] > 0) {
						$user->driver_id = $row['driver_id'];
					}
				
				}
			
			}
			
			$this->say("NEW USER ON PAGE " . $data->page_id);
			print_r($user);
			return TRUE;
		
		}

		switch($user->on_page) {
		
			case 1: // User on /demo/user
			
				
			
			
				break;
				
				
			case 2: // Driver on iPhone webclient
			
				switch($data->action_id) {
				
					case 1: // Driver updating Geolocation
					
						// Send geolocation to all connected users who are not drivers
						foreach($this->users as $socket_user) {
							if($socket_user->user_id > 0) {
							
								$send = new StdClass;
								$send->action_id = 1;
								$send->driver_id = $user->driver_id;
								$send->long      = $data->long;
								$send->lat       = $data->lat;
							
								$this->send($socket_user->socket, json_encode($send));
							}
						}
					
					
						break;
				
				}
			
				break;
		
		}

//		switch($action) {
		
		
//			case "hello" : $this->send($user->socket,"hello human");                       break;
//


//			default      : $this->send($user->socket, $action." not understood");           break;
		//}
	}
    
    private function say($msg="") { echo $msg . "\n"; }
    private function wrap($msg="") { return chr(0).$msg.chr(255); }
    private function unwrap($msg="") { return substr($msg, 1, strlen($msg)-2); }
}
