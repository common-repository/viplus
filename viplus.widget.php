<?php
/*
Plugin Name: V.I.Plus - email marketing widget
Plugin URI: www.viplus.com
Description: V.I.Plus registration plug-in enables you to integrate your V.I.Plus account with WORD PRESS system.
Author: Ilya Krashchyn
Version: 1.5
Last Revision: 29/09/2013
*/

global $atp_viplus_error_message;

class AtpViplusRegister extends WP_Widget{

	/*
	* Widget specific
	*/
	function AtpViplusRegister(){
		$widget_ops = array('classname' => 'AtpViplusRegister', 'description' => __('Subscribes new customer to V.I.Plus service', 'viplus') );
		$this->WP_Widget('AtpViplusRegister', 'V.I.Plus - email marketing widget', $widget_ops);
	}

	/*
	* Widget specific
	*/
	function form($instance){
		$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'ApiKey' => '' ) );
		$title = $instance['title'];
		$ApiKey = $instance['ApiKey'];
		?>
		<p><label for="<?php echo $this->get_field_id('title'); ?>">Title:
		<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo attribute_escape($title); ?>" />
		</label>
		</p>
		<p><label for="<?php echo $this->get_field_id('ApiKey'); ?>">API Key:
		<input class="widefat" id="<?php echo $this->get_field_id('ApiKey'); ?>" name="<?php echo $this->get_field_name('ApiKey'); ?>" type="text" value="<?php echo attribute_escape($ApiKey); ?>" />
		</label>
		</p>

		<?php
	}

	/*
	* Widget specific
	*/
	function update($new_instance, $old_instance){
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['ApiKey'] = $new_instance['ApiKey'];
		return $instance;
	}

	/*
	* Widget specific
	*/
	function widget($args, $instance){
		extract($args, EXTR_SKIP);

		echo $before_widget;
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$ApiKey= empty($instance['ApiKey']) ? ' ' : apply_filters('widget_title', $instance['ApiKey']);

		// WIDGET CODE GOES HERE
		//echo "<h1>This is my new widget!</h1>";
		$this->atpBuildForm('', $title);

		echo $after_widget;
	}

	/*
	* Create HTML form on the page and sends entered inputs throught POST protocol
	*/
	function atpBuildForm($apikey, $title='', $echo=true)
	{
		global $atp_viplus_error_message;
		$html = '<!--<link rel="stylesheet" href="'.plugins_url( "/viplus.css" , __FILE__ ).'" type="text/css" media="screen" />-->
				<div class="viplus_register" id="viplus_register_wrapper">';
		$display = ($atp_viplus_error_message == '' && $title == '') ? 'display:none;' : '';
		$class = ($atp_viplus_error_message == '' && $title != '' ) ? 'class="title"' : '';
		$html .= '<h2 id="error_msg" style="'.$display.'" '.$class.'>';	// #error_msg tag is required
		if($atp_viplus_error_message != '')
			$html .= $atp_viplus_error_message;
		else
			$html .= $title;
		$html .= '</h2>';
		
		$key = '';
		if($apikey != '')
			$key = "<input type='hidden' name='APIKey' value='$apikey' /><br/>";
		
		$InvalidCellular = __('Invalid Cellular','viplus');
		$InvalidEmail = __('Invalid Email','viplus');
		$FirstName = __('First Name:','viplus');
		$LastName = __('Last Name:','viplus');
		$Cellular = __('Cellular:','viplus');
		$Email = __('EMail:','viplus');
		$Register = __('Register','viplus');
		$JSError = __('JSError','viplus');
		$html .= <<< HtmlEnd
				<form method='POST' action='' id='viplus_register_form' name='viplus_register_form'>
					<label for='firstname'>$FirstName </label><input type='text' name='firstname' id='fname'/><br/>
					<label for='lastname'>$LastName </label><input type='text' name='lastname' id='lname'/><br/>
					<label for='cellphone'>$Cellular </label><input type='text' name='cellphone' id='cell'/><br/>
					<label for='email'>$Email </label><input type='text' name='email' id='email'/><br/>
					<label for='submit1' class='submit_spacer'>&nbsp;</label><input type='button' name='submit1' value='$Register' onclick='javascript:submitForm();' /><br/>
					<input type='hidden' name='RegisterViplus' value='true' /><br/>
					$key;
				</form>
				<script type="text/javascript">
					function validateEmail(email) {
						var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
						return re.test(email);
					}
					function isValidPhone(p){if(p!=''){var g="+- 1234567890()";for(i=0;i<p.length;i++){var c=p.charAt(i);if(g.indexOf(c)<0)return false;}return true;}else return false;}
					function submitForm() {
						err_obj = document.getElementById('error_msg');
						try{
							var fn_obj = document.getElementById('fname'),
								ln_obj = document.getElementById('lname'),
								ce_obj = document.getElementById('cell'),
								em_obj	= document.getElementById('email');
							var fname = fn_obj.value, lname = ln_obj.value, cell = ce_obj.value, email= em_obj.value;

							if(!isValidPhone(cell) && cell != ''){
								err_obj.innerHTML = '$InvalidCellular';
								ce_obj.style.border = "1px solid #f53";
								err_obj.style.display = "inline-block";
								return false;
							}else if(!validateEmail(email)){
								ce_obj.style.border = "1px solid #DDDDDD";
								err_obj.innerHTML = '$InvalidEmail';
								em_obj.style.border = "1px solid #f53";
								err_obj.style.display = "inline-block";
								return false;
							}
							else
								document.forms["viplus_register_form"].submit();
						}
						catch(e){
							if(err_obj != undefined) 
								err_obj.innerHTML = '$JSError';
							else
								alert('$JSError');
						}
					}
				</script>
			</div>
HtmlEnd;
		if ($echo)
			echo $html;
		else
			return $html;
	}

	/*
	*	Function that process POST params and do the registration
	*/
	function atpSendData(){
		global $atp_viplus_error_message;
		if(isset($_POST['RegisterViplus']) and $_POST['RegisterViplus'] == 'true') {
			$post_data = array(
				'firstname' => $_POST['firstname'],
				'lastname' => $_POST['lastname'],
				'cellphone' => $_POST['cellphone'],
				'email' => $_POST['email'],
				'exists' => 'Merge',	// Possible options: Merge|Update|Fail
				'viplists' => '0'		// List ID to insert to
			);
			$settings = $this->get_settings();
			$keys = array_keys($settings);
			$ApiKey = $settings[$keys[0]]['ApiKey'];
			if($ApiKey == '')
				$ApiKey = $_POST['APIKey'];
			// Debug:
			// print_r($ApiKey);
			// die();
			
			$result = $this->post_request('http://api.viplus.com/Gates/Ws-'.$ApiKey.'.asmx/RMembers_Import', $post_data);
			$xml = simplexml_load_string($result['content']);
			$rVal = $xml[0];
			if ($result['status'] == 'ok'){
				switch($rVal){
					case 'OkInserted': $atp_viplus_error_message = __('Thank You for registering','viplus'); break;
					case 'OkUpdated': $atp_viplus_error_message = __('Thank You for registering','viplus'); break;
					case 'ErrNotValid': $atp_viplus_error_message = __('Invalid data','viplus'); break;
					case 'ErrExists': $atp_viplus_error_message = __('This user already exists','viplus'); break;
					case 'ErrBlackListed': $atp_viplus_error_message = __('This user is blacklisted','viplus'); break;
					default: $atp_viplus_error_message = __('Unrecognized error message:','viplus').' '.$rVal.""; break;
				}
			}
			else _e('Registration failed: HTTP response status code:','viplus').' '.$result['status'].' ('.$result['error'].')';
		}
	}

	/*
	*	Low level send data throught POST request
	*/
	function post_request($url, $data, $referer='') {
		$port = 80;
		$timeout = 15;	// seconds
		$data = http_build_query($data);
		$url = parse_url($url);
		
		if ($url['scheme'] != 'http') { die(__('Error: Only HTTP requests are supported !', 'viplus')); }
		$host = $url['host'];
		$path = $url['path'];

		$fp = fsockopen($host, $port, $errno, $errstr, $timeout);
		if ($fp){
			fputs($fp, "POST $path HTTP/1.1\r\n");
			fputs($fp, "Host: $host\r\n");
			if ($referer != '')
				fputs($fp, "Referer: $referer\r\n");
			fputs($fp, "Content-type: application/x-www-form-urlencoded\r\n");
			fputs($fp, "Content-length: ". strlen($data) ."\r\n");
			fputs($fp, "Connection: close\r\n\r\n");
			fputs($fp, $data);
			$result = '';
			while(!feof($fp))
				$result .= fgets($fp, 300);
		}
		else return array(
				'status' => 'err',
				'error' => "$errstr ($errno)"
		);
		fclose($fp);
		/* Debug:
		print_r($url);
		echo '<br>';
		print_r($data);
		echo '<br>';
		print_r($result);
		echo '<br>';
		die();*/
		
		$result = explode("\r\n\r\n", $result, 2);
		$header = isset($result[0]) ? $result[0] : '';
		$content = isset($result[1]) ? $result[1] : '';

		return array(
			'status' => 'ok',
			'header' => $header,
			'content' => $content
		);
	}

	/*
	*	Init translations
	*/
	function viplus_init_translations() {
		$plugin_dir = basename(dirname(__FILE__));
		load_plugin_textdomain('viplus', false, $plugin_dir );
	}

	/*
	*	Include custom css file
	*/
	function include_css(){
		echo '<link rel="stylesheet" href="'.plugins_url( '/viplus.css' , __FILE__ ).'" type="text/css" media="screen" />';
	}

}

function AtpViplusRegister_shortcode( $atts, $content = null ) {
	extract( shortcode_atts( array(
		'apikey' => '',
		'title' => ''
	), $atts ) );

	global $wp_widget_factory;
	$widget_obj = $wp_widget_factory->widgets["AtpViplusRegister"];
	return $widget_obj->atpBuildForm($apikey, $title, false);
}
add_shortcode( 'atp-viplus-register', 'AtpViplusRegister_shortcode' );

/*
*	Register hooks
*/
add_action( 'widgets_init', create_function('', 'return register_widget("AtpViplusRegister");') );
$atpClass = new AtpViplusRegister();
add_action('init', array($atpClass, 'atpSendData'));
add_action('plugins_loaded', array($atpClass, 'viplus_init_translations'));
add_action('wp_head', array($atpClass, 'include_css'));
?>