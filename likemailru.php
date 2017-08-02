<?php
/*
Plugin Name: Like in Mail.ru
Plugin URI: http://bogutsky.ru/?page_id=40
Description: This plugin add in you posts and pages button "I like" by Mail.ru; Данный плагин добавляет к вашим постам и страницам кнопку "Мне нравится" от Mail.ru
Author: Bogutsky Yaroslav
Version: 1.2
Author URI: http://bogutsky.ru
*/
/*  Copyright 2011  Bogutsky Yaroslav  (email: admin@bogutsky.ru)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
function likemailru_feedback()
{
	$feedback = "
	<div>
	". __('Like this plugin?','likemailru') ." ". __('Press','likemailru') ." <button id=\"likemailru_send_thank_btn\" class=\"button\">". __('Send thank','likemailru') ."</button> ". __('or','likemailru') ." <button id=\"likemailru_show_responseform\" class='button'>". __('Send message to author','likemailru') ."</button>
	<div id=\"likemailru_responseform\" style=\"display:none;\">
	<input type=\"hidden\" id=\"likemailru_send_project\" value=\"likemailru\">
	<input type=\"hidden\" id=\"likemailru_send_url\" value=\"". get_bloginfo('siteurl') ."\">
	<input type=\"hidden\" id=\"likemailru_send_email\" value=\"". get_bloginfo('admin_email')."\">
	<textarea id=\"likemailru_send_response\"></textarea><br>
	<input id=\"likemailru_send_response_btn\" class=\"button\" type=\"button\"  value=\"". __('Send message','likemailru') ."\">
	</div>
	</div>
	";
	return $feedback;
}


	
if( is_admin() )
{
	add_action('admin_head','likemailru_admin_add_js');	
	function likemailru_admin_add_js()
	{
		echo "<script type='text/javascript' src='" . get_bloginfo('siteurl'). "/wp-content/plugins/" . dirname(plugin_basename( __FILE__ )) . "/js/jquery-1.5.1.js" ."'></script>";
		echo "<script type='text/javascript' src='" . get_bloginfo('siteurl'). "/wp-content/plugins/" . dirname(plugin_basename( __FILE__ )) . "/js/likemailru.js" ."'></script>";
	}	
	
	/* Административная часть */
	add_action('admin_menu', 'likemailru_admin_menu');
	function likemailru_admin_menu(){
		add_options_page('Like in Mail.ru', 'Like in Mail.ru', 10, 'likemailru', 'likemailru_options' );
		add_action( 'admin_init', 'likemailru_register_options' );
	}
	
	function likemailru_register_options() {
		register_setting( 'likemailru_options_group', 'likemailru_display_type' );
		register_setting( 'likemailru_options_group', 'likemailru_button_text' );
		register_setting( 'likemailru_options_group', 'likemailru_width' );
		register_setting( 'likemailru_options_group', 'likemailru_show_text' );
		register_setting( 'likemailru_options_group', 'likemailru_show_faces' );
		register_setting( 'likemailru_options_group', 'likemailru_show_in_posts' );
		register_setting( 'likemailru_options_group', 'likemailru_show_on_pages' );
	}
	
	function likemailru_options(){
	?>
        <div class="wrap">
		<h2><?php _e('Settings Like in Mail.ru','likemailru'); ?></h2>
        <?php settings_errors(); ?>
		<form method="post" action="options.php">
		
		<?php settings_fields( 'likemailru_options_group' ); ?>
        
			<?php _e('Display type','likemailru'); ?>:
	        <br>
			<select name="likemailru_display_type">
				<option value="button"<?php if(get_option('likemailru_display_type') == 'button') echo " selected=\"selected\""; ?>><?php _e('button','likemailru'); ?></option>
				<option value="micro"<?php if(get_option('likemailru_display_type') == 'micro') echo " selected=\"selected\""; ?>><?php _e('micro','likemailru'); ?></option>
			</select>
			<br>
			<?php _e('Button text','likemailru'); ?>:
	        <br>
			<select name="likemailru_button_text">
				<option value="Нравится"<?php if(get_option('likemailru_button_text') == 'Нравится') echo " selected=\"selected\""; ?>>Нравится</option>
				<option value="Поделиться"<?php if(get_option('likemailru_button_text') == 'Поделиться') echo " selected=\"selected\""; ?>>Поделиться</option>
				<option value="Рекомендую"<?php if(get_option('likemailru_button_text') == 'Рекомендую') echo " selected=\"selected\""; ?>>Рекомендую</option>
				<option value="Рассказать"<?php if(get_option('likemailru_button_text') == 'Рассказать') echo " selected=\"selected\""; ?>>Рассказать</option>
			</select>
	        <br>
			<?php _e('Width (pixels, recommended 550 with text or faces, else 150)','likemailru'); ?>:
	        <br>
			<input type="text" name="likemailru_width" size="10" maxlength="10" value="<?php if((get_option('likemailru_width'))&&(is_numeric(get_option('likemailru_width'))))  echo get_option('likemailru_width'); else echo "550"; ?>">
			<br>
			<input type="checkbox" name="likemailru_show_text" value="1"<?php if(get_option('likemailru_show_text'))  echo " checked=\"checked\""; ?>><?php _e('Show text','likemailru'); ?>
	        <br>
	        <input type="checkbox" name="likemailru_show_faces" value="1"<?php if(get_option('likemailru_show_faces'))  echo " checked=\"checked\""; ?>><?php _e('Show friends faces','likemailru'); ?>
	        <br>
	        <input type="checkbox" name="likemailru_show_in_posts" value="1"<?php if(get_option('likemailru_show_in_posts'))  echo " checked=\"checked\""; ?>><?php _e('Show in posts','likemailru'); ?>
	        <br>
	        <input type="checkbox" name="likemailru_show_on_pages" value="1"<?php if(get_option('likemailru_show_on_pages'))  echo " checked=\"checked\""; ?>><?php _e('Show on pages','likemailru'); ?>
	        <br>
	        <input class="button" type="submit" name="likemailru_save" value="<?php _e('Save options','likemailru'); ?>">
        </form>
        <?php echo likemailru_feedback(); ?>
        </div>
	<?php
	}


	function likemailru_delete_options($args)
	{
		$num = count($args);
		if ($num == 1) {
			delete_option($args[0]);
		}
		elseif (count($args) > 1)
		{
			foreach ($args as $option) {
				delete_option($option);
			}
		}
	}

	function likemailru_deactivation () {
		$options = array(
			'likemailru_display_type',
			'likemailru_button_text',
			'likemailru_width',
			'likemailru_show_text',
			'likemailru_show_faces',
			'likemailru_show_in_posts',
			'likemailru_show_on_pages'
		);
		likemailru_delete_options($options);
	}
	register_deactivation_hook(__FILE__,'likemailru_deactivation');

	function likemailru_add_options($args)
	{
		foreach ($args as $name => $value) {
			add_option($name,$value,'','no');
		}
	}
	
	function likemailru_activation () {
		$options = array(
			'likemailru_display_type' => 'button',
			'likemailru_button_text' => 'Нравится',
			'likemailru_width' => '550',
			'likemailru_show_text' => '1',
			'likemailru_show_faces' => '1',
			'likemailru_show_in_posts' => '1',
			'likemailru_show_on_pages' => '1'
		);
		likemailru_add_options($options);
		
	}
	register_activation_hook(__FILE__,'likemailru_activation');
	add_action('init', 'likemailru_textdomain');
	function likemailru_textdomain() {
		load_plugin_textdomain('likemailru', false, dirname( plugin_basename( __FILE__ ) ).'/lang/');
	}
}
else
{
	/* Публичная часть */
//	if( == 1)
	
	
	add_filter('the_content','likemailru_add_to_post');

	function likemailru_get_link()
	{
		$add_link = "
		<a target=\"_blank\" class=\"mrc__plugin_like_button\" href=\"http://connect.mail.ru/share\" data-mrc-config=\"{'type' : '" . get_option('likemailru_display_type') . "', 'width' : '";
		if((get_option('likemailru_width'))&&(is_numeric(get_option('likemailru_width'))))
			$add_link .= get_option('likemailru_width');
		else
			$add_link .= "550";
		$add_link .= "'";
		if(get_option('likemailru_show_text')) $add_link .= ",'show_text' : 'true'";
		if(get_option('likemailru_show_faces')) $add_link .= ",'show_faces' : 'true'";
		$add_link .= "}\">";
		$add_link .= get_option('likemailru_button_text');
		$add_link .= "</a><script src=\"http://cdn.connect.mail.ru/js/loader.js\" type=\"text/javascript\" charset=\"UTF-8\"></script>";
		
		return $add_link;

	}

	function likemailru_add_to_post($content) {
		if(get_option('likemailru_show_in_posts'))
			if(is_single())
				$add_link = likemailru_get_link();
		if(get_option('likemailru_show_on_pages'))
			if(get_post_type() == 'page')		
				$add_link = likemailru_get_link();
		$content .=	$add_link;
		return $content;
	}
}


?>
