<?php  

/* ********************************************************** */
/*                  JSON object prototype                     */
/*  {
		    	"DataThisID" : "ID OF THE STEP - GOES TO DIV ID ATTRIBUTE",
		    	"DataContent" : "THE YES OR NO QUESTION",
		    	"DataYesID" : "ID OF THE *YES* STEP - USE DataThisID from another step",
		    	"DataNoID" : "ID OF THE *NO* STEP - USE DataThisID from another step",
		    	"DataPrevID" : "ID OF THE *PREVIOUS* STEP - USE DataThisID from another step, ACCESSIBLE FROM THE *GO BACK BUTTON* ",
		    	"DataEffectShow" : "EFFECTS FOR SHOWING THE CONTENT - EFFECTS ARE DISACTIVATED IN THIS VERSION"
		    	}

************************************************************** */

function cc_licence_chooser_return_steps() {
	$steps = '{
     "steps": [
		    	{
		    	"DataThisID" : "cc-firstAgree",
		    	"DataContent" : "Czy zgadzasz się aby inne osoby mogły korzystać z i kopiować Twoje utwory? Legalnie, bez pytania o zgodę, ale z zachowaniem Twoich praw",
		    	"DataYesID" : "cc-first-modify",
		    	"DataNoID" : "cc-nocclicence",
		    	"DataPrevID" : "cc-firstAgree",
		    	"DataEffectShow" : "fade"
		    	},
		    	{
		    	"DataThisID" : "cc-nocclicence",
		    	"DataContent" : "Z Twojego utworu będzie można korzystać wyłącznie w ramach dozwolonego użytku",
		    	"DataYesID" : "cc-hide-buttons",
		    	"DataNoID" : "cc-hides-the-buttons",
		    	"DataPrevID" : "cc-firstAgree",
		    	"DataEffectShow" : "fade"
		    	},
		    	{
		    	"DataThisID" : "cc-first-modify",
		    	"DataContent" : "Czy zgadzasz się na modyfikowanie swojego utworu?",
		    	"DataYesID" : "cc-first-modify-yes",
		    	"DataNoID" : "cc-first-modify-no",
		    	"DataPrevID" : "cc-firstAgree",
		    	"DataEffectShow" : "fade"
		    	},
		    	{
		    	"DataThisID" : "cc-first-modify-yes",
		    	"DataContent" : "Czy zgadzasz się aby Twój utwór był wykorzystywany w możliwie szeroki sposób, również komercyjny? Twój utwor może stać się Otwartym Zasobem Edukacyjnym",
		    	"DataYesID" : "cc-first-modify-yes-yes",
		    	"DataNoID" : "cc-first-modify-yes-no",
		    	"DataPrevID" : "cc-first-modify",
		    	"DataEffectShow" : "fade"
		    	},
		    	{
		    	"DataThisID" : "cc-first-modify-no",
		    	"DataContent" : "Czy zgadzasz się na komercyjne wykorzystanie Twojego utworu?",
		    	"DataYesID" : "cc-licence-chooser-outcome-4",
		    	"DataNoID" : "cc-licence-chooser-outcome-6",
		    	"DataPrevID" : "cc-first-modify",
		    	"DataEffectShow" : "fade"
		    	},
		    	{
		    	"DataThisID" : "cc-first-modify-yes-yes",
		    	"DataContent" : "Czy chcesz aby utwory zależne były również dostępne na takiej samej licencji?",
		    	"DataYesID" : "cc-licence-chooser-outcome-2",
		    	"DataNoID" : "cc-licence-chooser-outcome-1",
		    	"DataPrevID" : "cc-first-modify-yes",
		    	"DataEffectShow" : "fade"
		    	},
		    	{
		    	"DataThisID" : "cc-first-modify-yes-no",
		    	"DataContent" : "Czy chcesz aby utwory zależne były również dostępne na takiej samej licencji?",
		    	"DataYesID" : "cc-licence-chooser-outcome-5",
		    	"DataNoID" : "cc-licence-chooser-outcome-3",
		    	"DataPrevID" : "cc-first-modify-yes",
		    	"DataEffectShow" : "fade"
		    	}
    	]
    }';
    return $steps;
}
function cc_licence_chooser_json_steps(){
    echo '<h3> ' . __('Poniżej przedstawiamy pogdląd pytań w notacji JSON. Edycja obiektów dostępna w pliku pluginu /php/cc-licence-chooser-json-steps.php.') . ' </h3>';
    echo '<p> ' . __('Notacja ta pozwala w łatwy sposób modyfikować plugin oraz umożliwia zaimplementowanie dowolnego wyboru na zasadach TAK / NIE ') . ' </p>';

    $ccLicenceSteps = cc_licence_chooser_return_steps();
    echo '<pre>';
    //var_dump(json_decode($ccLicenceSteps));
    echo '</pre>';
    $steps = json_decode($ccLicenceSteps);
    $tmp = $steps->steps;
    foreach ($tmp as $step)
    {
    	//print_r($step);
    	echo '<div class="cc-steps-preview">';
    	// echo '<h3>'  . $step->DataHeader . '</h3>';
    	echo '<p>' . $step->DataContent . '</p>';
    	echo '</div>';
    }
    
    
}
?>