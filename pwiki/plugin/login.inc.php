<?php
/////////////////////////////////////////////////
// login.inc.php
// 
// 2007/5/11	無駄な変数を除いて、分かりやすく変更. get_script_uri()を使用
//		htmlspecialcharsをつけた。
// 2007/5/9	オリジナル//
/////////////////////////////////////////////////


/* initialize 
function plugin_login_init()
{
}
*/

function plugin_login_inline()
{
	if(isset($_SESSION['login_user'])){
		$msg = $_SESSION['login_user'];
	        $msg .= ' <a href="' . get_script_uri() . '?plugin=login">Logout</a>';
	} else {
	        $msg = '<a href="' . get_script_uri() . '?plugin=login">Login</a>';
	}
	return $msg;
}


function plugin_login_convert()
{
	if(isset($_SESSION['login_user'])){
		return _get_logout_form();
	} 
	return _get_login_form();
}

function plugin_login_action()
{
	global $vars, $auth_users;

	if($vars['pcmd']=='login')
	{
		if( isset($vars['pass']) 
			&& isset($vars['user'])
			&& isset($auth_users[$vars['user']])
			&& pkwk_hash_compute($vars['pass'], $auth_users[ $vars['user'] ]) == $auth_users[ $vars['user'] ])
		{
			// login success
			$_SESSION['login_user'] = $vars['user'];
	                header('Location: ' . get_script_uri() . '?' . rawurlencode( $vars['referer'] ) );
			return;
		}
		// login fail
		unset($_SESSION['login_user']);
		$body = "!!! LOGIN FAILED !!!" . _get_login_form();
	}
	else if($vars['pcmd']=='logout')
	{
		$body = '';
		if( isset($_SESSION['login_user'])) {
			$body = htmlspecialchars($_SESSION['login_user']) . " Logout.";
			unset($_SESSION['login_user']);
		}
		$body .= _get_login_form();
	}
	else
	{
		if (!isset($_SESSION['login_user']) ) {
			$body = _get_login_form();
		} else {
			$body = _get_logout_form();
		}
	}
	return array('msg' => 'login', 'body' => $body);
}

function _get_login_form(){
	global $vars;
	$script = htmlspecialchars(get_script_uri());
	$s_referer= htmlspecialchars($vars['referer']);
	
	return <<<EOD
<div>
<form action="$script" method="post">
  <input type="hidden"   name="cmd"  value="login" />
  <input type="hidden"   name="pcmd" value="login" />
  <input type="hidden"   name="referer" value="$s_referer" />
   User Name<br /><input type="user"  name="user" size="12" /><br />
   Password<br /><input type="password" name="pass" size="12" /><br />
  <input type="submit" value="login" />
</form>
</div>
EOD;
}

function _get_logout_form(){
	global $vars;
	$script = htmlspecialchars(get_script_uri());
	$s_referer= htmlspecialchars($vars['referer']);
	$user = $_SESSION['login_user'];
	
	return  <<<EOD
<div>
Current User : $user

<form action="$script" method="post">
  <input type="hidden"   name="cmd"  value="login" />
  <input type="hidden"   name="pcmd" value="logout" />
  <input type="hidden"   name="referer" value="$s_referer" />
  <input type="submit"   value="logout" />
</form>
</div>
EOD;
}


?>
