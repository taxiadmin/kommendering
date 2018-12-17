<?php
/** Det här är mitt första försök till em me-sida med tango
 * 
 * Tango är en struktur för websidor skapad på kursen ooophp av mig
 * Peder Nordenstad.
 */

// Ikluderar config.php. som sätter igång allt.

include( __DIR__ . '/config.php');

//fyller $tango med lite data att skriva ut...

$tango->set_property('title', "Tango, webbsidor som en dans");
$tango->set_property('title_append', "En webmall skapad på kursen ooophp på BTH");


/**
 * Du är inte nöjd med det sidhuvud som automatiskt skapas av CTango?
 * Fritt fram att göra vad du vill. Mallen här nedan är precis vad som
 * skrivs ut av systemet automatiskt baserat på inlagda värden
 */
//$header = "<img class='sitelogo left' src='" . $tango->logo() . "' alt=''/>n";
//$header .= "<div class='sitetitle left'>" . $tango->title() . "</div>\n";
//$header .= "<div class='siteslogan left'>" . $tango->title_append() . "</div>\n";
//$tango->set_property('header', $header);


if( $user->logincheck()){    
    $tango->main_content("<p>Du &auml;r inloggad som " . $user->name() . " </p>"); 
}else{
    $tango->main_content( <<<EOD
        <p><em>Du är inte inloggad.</em></p>
        <p>Kila iväg till inloggningssidan och logga in först. </p>
        <p>Den sidan kan hantera både in och utloggning ...</p>
        <a href='login.php'>Till inloggning</a>
    </form>

EOD
);} //end EOD end IF

include_once 'footer.php';
include_once (TANGO_THEME_PATH);
        
