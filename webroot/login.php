<?php
/** Det här är en sida för in och utloggning.
 *
 * Möjlighet för utloggning ligger också i sidforen
 */

// Ikluderar config.php. som sätter igång allt.

include( __DIR__ . '/config.php');

//fyller $tango med lite data att skriva ut...

$tango->set_property('title', "Proteus taxi");
$tango->set_property('title_append', "Login");

$tango->main_content(<<<EOD
    <p></p>
    <form method=post>
        <fieldset>
        <legend>Login</legend>
EOD
); //end main_content

if( $user->logged_in()){
    $url= 'start';
    header("location:$url");
    $tango->main_content("<p>Du &auml;r inloggad som " . $user->name() . " </p>");
    $tango->main_content("<p><input type='submit' name='logout' value='Logout'/></p>");
}else{
    $tango->main_content( <<<EOD
        <p><label>Användare:<br/><input type='text' name='acronym' value=''/></label></p>
        <p><label>Lösenord:<br/><input type='password' name='password' value=''/></label></p>
        <p><input type='submit' name='login' value='Login'/></p>
        </fieldset>
    </form>

EOD
    );// end main content
} // end if


include_once 'footer.php';
include_once (TANGO_THEME_PATH);
