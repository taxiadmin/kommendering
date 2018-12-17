<?php
/**Sida för att visa att man är utloggad. Används inte, syns i sidfoten ...
 */

// Ikluderar config.php. som sätter igång allt.

include( __DIR__ . '/config.php');





$tango->main_content(<<<EOD
    <p></p>
    <form method=post>
        <fieldset>
        <legend>Login</legend>
EOD
); //end main_content

if( $user->logincheck(true)){
    $tango->main_content("<p><input type='submit' name='logout' value='Logout'/></p>");
}else{
    $tango->main_content( <<<EOD
        <p><em>Du är inte inloggad.</em></p>
        <p>Kila iväg till inloggningssidan och logga in först. </p>
        <p>Den sidan kan hantera både in och utloggning ...</p>
        <a href='login.php'>Till inloggning</a>
    </form>

EOD
    );// end main content
} // end if


include_once 'footer.php';
include_once (TANGO_THEME_PATH);
