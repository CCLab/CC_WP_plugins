<?php


function cc_licence_chooser_shortcode() {

	// Cook content
	$welcomeScreen = get_option('cc-licence-chooser-welcome-screen');


	?>
	<div id="lnc-cnt-wraper">
	<div id="lc-cnt">
		<div id="welcome-screen" class="cc-licence-step">
			<?=$welcomeScreen;?>
		</div>
		<div id="cc-steps-cnt">
			<?

			$ccLicenceSteps = cc_licence_chooser_return_steps();
			$steps = json_decode($ccLicenceSteps);
			$tmp = $steps->steps;
			foreach ($tmp as $step)
			{
				
				if ($step->DataThisID == "cc-firstAgree") {

					echo '<div id="alwaysVisible" data-thisID="' . $step->DataThisID . '" class="cc-steps-front box-shadow-rigid border-box-strong" data-yesid=' . $step->DataYesID . ' data-noid=' . $step->DataNoID . ' data-previd=' . $step->DataPrevID . ' >';
					echo '<span id="cc-licence-choser-top-ar-in"></span>';
					echo '<p>' . $step->DataContent . '</p>';
					echo '</div>';					 
				}
					echo '<div ' . 'id="' . $step->DataThisID  . '" data-thisID="' . $step->DataThisID . '" class="cc-steps-front box-shadow-rigid border-box-strong" data-yesid=' . $step->DataYesID . ' data-noid=' . $step->DataNoID . ' data-previd=' . $step->DataPrevID . ' >';
					echo '<p>' . $step->DataContent . '</p>';
					echo '</div>';					 
			}

			?>
			<div class="cc-btns-cnt">
				<div id="cc-go-back" class="go-around-buttons go-to-steps" data-GoID="cc-firstAgree"> <span> <?_e('Wróć', 'cc-licence-chooser');?> </span> </div>
				<div id="cc-yes-no-cnt">
					<div id="cc-go-yes" class="border-box-strong box-shadow-rigid go-around-buttons go-to-steps" data-GoID="cc-firstAgree"> <span> <?_e('Tak', 'cc-licence-chooser');?> </span> </div>
					<div id="cc-go-no" class="border-box-strong box-shadow-rigid go-around-buttons go-to-steps" data-GoID="cc-firstAgree"> <span> <?_e('Nie', 'cc-licence-chooser');?> </span> </div>
					<div id="cc-go-start" class="cc-clear border-box-strong box-shadow-rigid go-around-buttons go-to-steps" data-GoID="cc-firstAgree"> <span> <?_e('od początku', 'cc-licence-chooser');?> </span> </div>
				</div>
			</div>
			<div class="cc-clear"> &nbsp; </div>
			<a id="cc-more-licences" href="http://creativecommons.org" data-target="_blank" class="cc-clear border-box-strong box-shadow-rigid"> 
					<?_e('Więcej informacji o licencjach <span> Creative Commons </span>', 'cc-licence-chooser');?>
			</a>
			<div class="cc-clear"> &nbsp; </div>
		</div>
		<div class="cc-clear"> &nbsp; </div>
		<div id="cc-footer-vivid-webchefs-cnt">
			<p> <?_e('Aplikacja dostępna jest na licencji', 'cc-licence-chooser');?> <a href="http://creativecommons.org/licenses/by/3.0/pl/" data-tagert="_blank" class="cc-green-highlight"> <?_e('Creative Commons, Uznianie Autorstwa 3.0', 'cc-licence-chooser');?> </a></p>
			<div id="cc-creative-commons-attibs">
				<a id="cc-atrib-cc" href="http://centrumcyfrowe.pl" data-target="_blank"> </a>
				<a id="cc-atrib-cnt" href="http://nck.pl" data-target="_blank"> </a>
				<p> <?_e('Dofinansowano ze środków Narodowego Centrum Kultury w ramach <br> Programu Narodowego Centrum Kultury – Kultura – Interwencje', 'cc-licence-chooser')?> </p>
				<a id="cc-atrib-webchefs" href="http://webchefs.pl" data-target="_blank"> </a>
				<a id="cc-atrib-vivid" href="http://vividstudio.pl" data-target="_blank">  </a>

			</div>
		</div>
		<div class="cc-clear"> &nbsp; </div>
	</div>
<div class="cc-clear"> &nbsp; </div>
</div>
	
	<?

}
add_shortcode('cc_licence_chooser', 'cc_licence_chooser_shortcode');

// ajax outcome

add_action('wp_ajax_cc-licence-chooser-outcome', 'cc_licence_chooser_outcome_callback');
add_action('wp_ajax_nopriv_cc-licence-chooser-outcome', 'cc_licence_chooser_outcome_callback');

function cc_licence_chooser_outcome_callback() {
	global $wpdb; 
	$outcomeid =  $_POST['outcomeid'];
	$ajaxcontent = get_option($outcomeid);
    echo $ajaxcontent;
	die(); 
}

?>