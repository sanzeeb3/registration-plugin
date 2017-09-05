<?php

class MySettingsPage
{
    public function __construct() {
            add_action( 'admin_menu', array($this, 'registration_plugin_menu' ));
    }

    public function registration_plugin_menu() {
        add_menu_page( 'Basic Registration Form', 'Basic Registration Plugin', 'manage_options', 'registration-plugin', array($this, 'my_plugin_options' ) );
    }


    public function my_plugin_options() {
        if ( !current_user_can( 'manage_options' ) )  {
            wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        }
        if(isset($_POST['submit']))
        {
            echo "Settings Updated!";
        }
            echo 'ShortCode: [registration-plugin]';
            echo '<div class="wrap">';
            echo 'Form Fields';

            echo '
                <form method="post" action="' . $_SERVER['REQUEST_URI'] . '">
                    <input name="username" type="checkbox">Username<br>
                    <input name="email" type="checkbox">Email<br>
                    <input name="password" type="checkbox">Password<br>
                    <input name="website" type="checkbox">Website<br>
                    <input name="bio" type="checkbox">Bio<br>
                    <input name="submit" type="submit">
                </form>         
            ';

            echo '</div>';
    }
}

$settings = new MySettingsPage();

?>