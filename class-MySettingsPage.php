<?php

class MySettingsPage
{
    public function __construct() {
            add_action( 'admin_menu', array($this, 'registration_plugin_menu' ));
            add_action( 'admin_menu', array($this, 'registration_plugin_submenu' ));
          
    }

    public function registration_plugin_menu() {
        
        //add_menu_page( 'Page Title', 'Menu Title', $capability, 'slug-in-the url', array($this, 'menu_callback' ) );
        
        add_menu_page( 'Basic Registration Form', 'Basic Registration Form', 'manage_options', 'registration-plugin-menu-page', array($this, 'menu_callback' ) );

    }

    public function registration_plugin_submenu() {

        //add_submenu_page( 'top-level-slug','SubMenu Page Title', 'SubMenu Title', 'manage_options', 'submenu-page', array($this, 'submenu_callback' ) );

         add_submenu_page( 'registration-plugin-menu-page','Settings', 'Settings', 'manage_options', 'submenu-page', array($this, 'submenu_callback' ) );
    }

    public function menu_callback() {
        if ( !current_user_can( 'manage_options' ) )  {
            wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        }

        if(isset($_POST['submit']))
        {
            
            $username_value = isset($_POST['username']) ? 'checked': 0;
            $username_value = update_option('bp-username-field',$username_value);

            $email_value = isset($_POST['email']) ? 'checked': 0;
            $email_value = update_option('bp-email-field',$email_value);

            $password_value = isset($_POST['password']) ? 'checked': 0;
            $password_value = update_option('bp-password-field',$password_value);
            
            $website_value = isset($_POST['website']) ? 'checked': 0;
            $website_value = update_option('bp-website-field',$website_value);

            $bio_value = isset($_POST['bio']) ? 'checked': 0;
            $bio_value = update_option('bp-bio-field',$bio_value);

            $country_value = isset($_POST['country']) ? 'checked': 0;
            $country_value = update_option('bp-country-field',$country_value);

            echo "Settings Updated!!";
        }
            echo 'ShortCode: [registration-plugin]';
            echo '<div class="wrap">';
            echo 'Form Fields';


             echo '
                <form method="post" action="' . $_SERVER['REQUEST_URI'] . '">
                    <input name="username" type="checkbox" '.get_option('bp-username-field').'>Username<br>
                    <input name="email" type="checkbox" '.get_option('bp-email-field').'>Email<br>
                    <input name="password" type="checkbox" '.get_option('bp-password-field').'>Password<br>
                    <input name="website" type="checkbox" '.get_option('bp-website-field').'>Website<br>
                    <input name="bio" type="checkbox" '.get_option('bp-bio-field').'>Bio<br>
                    <input name="country" type="checkbox" '.get_option('bp-country-field').'>Country<br>
                    
                    <input name="submit" type="submit" class="button button-primary" value="Save Changes">
                </form>         
            ';

            echo '</div>';
    }

    public function submenu_callback() {
        
        echo '<div class="wrap">';
        echo '<h2>Settings</h2>';
        echo 'Settings here...';
        echo '</div>';
    }

}

$settings = new MySettingsPage();

?>