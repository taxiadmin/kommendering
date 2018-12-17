<?php
/** 
 * pagecontroller för source.php
 * 
 * Det här är mitt första försök till em me-sida med tango
 */

// Ikluderar config.php. som sätter igång allt.

include( __DIR__ . '/config.php');


//fyller $tango med lite data att skriva ut...
$source= new CSource(array('secure_dir' => '..', 'base_dir' => '..'));
$tango->set_property('title', "CSource. Visar källkoden");
$tango->set_property('title_append', "En möjlighet att studera bakomliggande kod");

//$main_menu = array(
//    'id'=>'',
//    'vertical'=>false,
//    'choise'=>array(
//        'home'  => array('text'=>'Home',  'url'=>'me.php?p=home', 'class'=>''),
//        'away'  => array('text'=>'Källkod',  'url'=>'?source.php?p=away', 'class'=>''),
//        'about' => array('text'=>'About', 'url'=>'?p=about', 'class'=>''),
//    )
//);

/**
 * Du är inte nöjd med det sidhuvud som automatiskt skapas av CTango?
 * Fritt fram att göra vad du vill. Mallen här nedan är precis vad som
 * skrivs ut av systemet automatiskt baserat på inlagda värden
 */
//$header = "<img class='sitelogo left' src='" . $tango->logo() . "' alt=''/>n";
//$header .= "<div class='sitetitle left'>" . $tango->title() . "</div>\n";
//$header .= "<div class='siteslogan left'>" . $tango->title_append() . "</div>\n";
//$tango->set_property('header', $header);

$tango->set_property("main", "<h1>Visa källkod</h1>\n" . $source->View());

$tango->set_property('footer', <<<EOD
        <div class='sitefooter left'>
            &copy;Peder Nordenstad <a href='mailto:peder@nordenstad.se'>(peder@nordenstad.se)</a>
        </div>
        <div class='right sitefooter'>
            <a  href='http://validator.w3.org/unicorn/check?ucn_uri=referer&amp;ucn_task=conformance'>Unicorn</a> | <a href='https://github.com/kerrik/ooophp'>tango på GitHub</a>
        </div>
EOD
);

include_once (TANGO_THEME_PATH);
        
