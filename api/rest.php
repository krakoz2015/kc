<?php

function getFormData($method) {
    if ($method === 'GET') return $_GET;
    if ($method === 'POST') return $_POST;

    $data = array();
    $exploded = explode('&', file_get_contents('php://input'));

    foreach($exploded as $pair) {
        $item = explode('=', $pair);
        if (count($item) == 2) {
            $data[urldecode($item[0])] = urldecode($item[1]);
        }
    }
    return $data;
}

function error(){
    header('HTTP/1.0 400 Bad Request');
    echo json_encode(array(
        'error' => 'Bad Request'
    ));
	exit();
}

$method = $_SERVER['REQUEST_METHOD'];
$formData = getFormData($method);

$url = (isset($_GET['q'])) ? $_GET['q'] : '';
$url = rtrim($url, '/');
$urls = explode('/', $url);
if ($urls[0]!='rest' or !isset($urls[1])){
	error();
}

include_once 'config/database.php';

//header("Content-Type: application/json; charset=UTF-8");

switch ($urls[1]) {
	case 'signup':
		if ($method!='POST'){
			error();
		}
		include_once 'objects/user.php';
		$database = new Database();
		$db = $database->getConnection();
		 
		$user = new User($db);
		 
		$user->username = $formData['username'];
		$user->password = base64_encode($formData['password']);
		$user->created = date('Y-m-d H:i:s');
		 
		if($user->signup()){
		    $user_arr=array(
		        "status" => true,
		        "message" => "Successfully Signup!",
		        "id" => $user->id,
		        "username" => $user->username
		    );
		}
		else{
		    $user_arr=array(
		        "status" => false,
		        "message" => "Username already exists!"
		    );
		}
		echo json_encode($user_arr);
		break;
	case 'auth':
		if ($method!='DELETE'){
			error();
		}
		include_once 'config/database.php';
		unset($_SESSION["uname"]);
		unset($_SESSION["user_id"]);
		setcookie ("member_login","");
		break;		
	case 'login':
		if ($method!='POST'){
			error();
		}
		include_once 'objects/user.php';
		$database = new Database();
		$db = $database->getConnection();
		$user = new User($db);
		$user->username = isset($formData['username']) ? $formData['username'] : die();
		$user->password = base64_encode(isset($formData['password']) ? $formData['password'] : die());
		if(empty($user->username) or empty($user->password)){
		    $user_arr=array(
		        "status" => false,
		        "message" => "Enter your Username and Password!",
		    );	
		}else{
			$stmt = $user->login();
			if($stmt->rowCount() > 0){
			    $row = $stmt->fetch(PDO::FETCH_ASSOC);
			    $user_arr=array(
			        "status" => true,
			        "message" => "Successfully Login!",
			        "id" => $row['id'],
			        "username" => $row['username']
			    );
				$_SESSION["uname"] = $row['username'];
				$_SESSION["user_id"] = $row['id'];
				if(!empty($formData["remember"])) {
					//setcookie("member_login",$formData["username"],time()+ (10 * 365 * 24 * 60 * 60));
				} else {
					if(isset($_COOKIE["member_login"])) {
						//setcookie("member_login","");
					}
				}				
			}
			else{
			    $user_arr=array(
			        "status" => false,
			        "message" => "Invalid Username or Password!",
			    );
			}
		}
		echo json_encode($user_arr);		
		break;	
	case 'users':
		$res=array();
		if(!isset($_SESSION['user_id'])) {
			$res['html']='
		  <div class="login-wrap">
			  <img src="./style/img/Logo.svg" />
			  <div class="login-html">
			  	<h1 class="login-h1">Welcome to the Learning Management System</h1>
			  	<div class="login-sp">Please log in to continue</div>
			    <div class="login-form">
			      <form class="sign-in-htm" action="" method="GET">
			        <div class="group">
			          <input id="username" name="username" type="text" class="input" placeholder="Username" value="'.(isset($_COOKIE["member_login"])?'$_COOKIE["member_login"]':'').'">
			        </div>
			        <div class="group">
			          <input id="password" name="password" type="password" class="input" data-type="password" placeholder="Password" value="'.(isset($_COOKIE["member_login"])?'$_COOKIE["member_login"]':'').'">
			        </div>
			        <div class="group">
			          <input id="remember" name="remember" type="checkbox" class="check" '.(isset($_COOKIE["member_login"])?'checked':'').'
			          <label for="check"> Remember me</label>
			        </div>
			        <div class="group">
			          <input id="login" type="submit" class="button" value="Log in">
			          <input id="signup" type="submit" class="button" value="Sign up">
			        </div>
			      </form>
			      <div class="message"></div>
			    </div>
			  </div>
		  </div>
			';	
		}else{
			include_once 'objects/student.php';
			$database = new Database();
			$db = $database->getConnection();
		
			$student = new Student($db);
			$page=isset($formData['page'])?$formData['page']:1;
			$count=$student->all_students_count();
			$rows=$student->all_students($page);
			$res['count']=$count;	
			$out='<div class="text-center user_list"><h1>User List</h1><table id="table"><thead><tr><th></th><th></th><th></th></tr></thead>';
			$i=0;
		    foreach ($rows as $v) {
		        $i++;
		        $c='odd';	
		    	if ($i%2 === 0) {
		    		$c='even';	
		    	}
		        $out.='<tr class="'.$c.'">';
		        if ($v['status']==0) $out.='<td class="first"><i class="i_status"></i></td>';
				else $out.='<td></td>';
		        $out.='<td class="seconde">'.$v['name'].'<span class="gray_text">'.$v['full_name'].'</span></td>';
		        $out.='<td class="third"><b>...</b><span class="def_group">Default group</span></td>';
		        $out.='</tr>';
		    }	
		    $out.='</table>';
			$out.='<ul class="pager">';
			if ($page!=1)
				$out.='<li><a href="#" data-n="'.($page-1).'">&laquo; Prev</a></li>';
			
			$ii=0;		
			$limit=$student->limit;
			$cc=round($count/$limit)+($count%$limit);
			$bb=($page-3)<1?1:$page-3;
			for ($i=$bb; $i <= $cc; $i++) {
				$ii++;	
				$out.='<li'.($i==$page?' class="active"':'').'><a href="#" data-n="'.$i.'">'.$i.'</a></li>';
				if ($ii==$limit) break;
			}
			if (($page+1)<=$cc)
				$out.='<li><a href="#" data-n="'.($page+1).'">Next &raquo;</a></li>';
		    $out.='</ul>';
		    $out.='<p class="footer"><i class="ilogout"></i><a href="#" id="logout"><i class="i_logout"></i>Log Out</a></p></div>';	
			$res['html']=$out;
		}
		echo json_encode($res);
		break;
	default:
		error();
		break;
}


/*
print_r($urls);
$router = $urls[0];
$urlData = array_slice($urls, 1);

print($method."\n");
print($router."\n");
print_r($urlData);
print_r($formData);
*/
