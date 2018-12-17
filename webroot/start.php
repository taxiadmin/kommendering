<?php
include( __DIR__ . '/config.php');


$tango->set_property('title', "Proteus taxi");




if($user->logged_in()){
    $logged_in = <<<EOF
        <form method=post >
            <input type="submit" class="button blue-button" value="Logout" name= "logout" id='logout' />
        </form>
EOF
    ; // end first if
}else {
    $logged_in = "<a  href='login' class='button blue-button'>Login</a>";
}

//fyller $tango med lite data att skriva ut...


//$header = "<img class='sitelogo left' src='" . $tango->logo() . "' alt=''/>n";
//$header .= "<div class='sitetitle left'>" . $tango->title() . "</div>\n";
//$header .= "<div class='siteslogan left'>" . $tango->title_append() . "</div>\n";
//$tango->set_property('header', $header);

$tango->set_property('main', <<<EOD

        <div class="text">
        <h1>Taxiadmin</h1>
        <p>
		<h2>hjälper dig med schemaläggning av bilar och förare</h2>
		</p>
        </div><!--text-->
        <p>
		$logged_in
        </p>
EOD
);

    $tango->set_property('footer', <<<EOD

EOD
);


include_once 'footer.php';
include_once (TANGO_THEME_PATH);
