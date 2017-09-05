<?php

class GetData
{
  	public function __construct() {
        add_action('wp_ajax_myprefix_delete_user',array($this,'myprefix_delete_user_cb'));
		add_action('wp_ajax_myprefix_edit_user',array($this,'myprefix_edit_user_cb'));
    }


	public function getdata()
	{ 
    	$blogusers = get_users(['role'=>'subscriber']);

	    foreach ( $blogusers as $user ) {
    	    echo '<span>' . esc_html( $user->user_email ) . '</span>';

        	$deleteUrl = admin_url('admin-ajax.php').'?action=myprefix_delete_user&user_id='.$user->ID;

	        $editUrl = admin_url('admin-ajax.php').'?action=myprefix_edit_user&user_id='.$user->ID;	

    	    echo  "<a href='".$deleteUrl. "'>Delete User</a>"; 
        	echo  "<a href='".$editUrl. "'>Edit User</a>"; 

        	echo '<br>';
    	}     	
	}

 	public function myprefix_delete_user_cb()
 	{

    	wp_enqueue_style('mysample'); 

        	$user_id = intval($_REQUEST['user_id']);
        	require_once(ABSPATH.'wp-admin/includes/user.php'); //for wp_delete_user() to work
     
        	if(wp_delete_user($user_id))
        	{
            	echo '<span id="delete"> User Deleted.</span>';
        	}
    	die();
	}

	public function myprefix_edit_user_cb()
	{
	 	$user_id=$_REQUEST['user_id'];
	
	 	$user = get_user_by( 'ID', $user_id );
	
	 	  	echo 
	  	  		'	<fieldset>
	  	  			<legend>Form</legend>
	  	  			<form id="update-form" action="' . $_SERVER['REQUEST_URI'] . '" method="POST">
	  					<label>Username:<span style="color:red">*</span></label>
	
	  					<input name="id" type="hidden" value=" '. $user->ID.' " required>
	  					<input name="username" type="text" value=" '. $user->user_login.' " required>
	  					<label>Email:<span style="color:red">*</span></label>
	  					<input name="email" type="email" value="'.$user->user_email.'" required>
	  					<label>Password:</label>
	  					<input name="password" type="password" value="'.$user->user_pass.'">
	  					<input class="btn btn-default" name="submit" type="submit" value="submit">
	  				</form>
	  				</fieldset>
 	 			';

  		die();
    }    

	public function validation_for_edit($username,$email,$password)
	{
		global $reg_errors;
	    $reg_errors = new WP_Error;

	    if ( empty( $username ) || empty( $password ) || empty( $email ) ) {
	        $reg_errors->add('field', 'Required form field is missing');
	    }

	    if ( 4 > strlen( $username ) ) {
	        $reg_errors->add( 'username_length', 'Username too short. At least 4 characters is required' );
	    }

	    
	    if ( 5 > strlen( $password ) ) {
	        $reg_errors->add( 'password', 'Password length must be greater than 5' );
	    }
	    
	    
	    if ( is_wp_error( $reg_errors ) ) {
	 
	        foreach ( $reg_errors->get_error_messages() as $error ) {
	     
	            echo '<div>';
	            echo '<strong>ERROR</strong>:';
	            echo $error . '<br/>';
	            echo '</div>';         
	        }
	    }

	}

	public  function update_data()
	{

		wp_enqueue_style('mysample');

	  	global $reg_errors;

		if(isset($_POST['submit']))
		{

			$username=isset($_POST['username'])?$_POST['username']:null;
			$email=isset($_POST['email'])?$_POST['email']:null;
			$password=isset($_POST['password'])?$_POST['password']:null;

			validation_for_edit($username,$email,$password);
		
			$userdata = array(

				'ID' => $_POST['id'],
	        	'user_login'    =>   $username,
	        	'user_email'    =>   $email,
	        	'user_pass'     =>   $password,
	        );

			echo "<pre>";print_r($userdata);

			if(1 > count( $reg_errors->get_error_messages() ) )
			{
				if($userdata=wp_update_user( $userdata ))
				{
	    				echo '<span id="message">Update complete.</span>';
	    				echo 'Goto <a href="' . get_site_url() . '/wp-login.php">login page</a>';
	   			}
	   		}
	   	}
	 	die();
	}
}


?>


