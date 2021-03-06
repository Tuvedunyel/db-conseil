<!DOCTYPE html>
<html <?php language_attributes( ); ?>>
<head>
<?php

    $old_url = "https://dbconseils.nicoka.com/api/jobs";
    $url='https://dbconseils.nicoka.com/api/jobs/published/?__hr=1';

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $token = get_field('token_nicoka', 'option');

    $headers = array(
    "Accept: application/json",
    "Authorization: Bearer " . $token,
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    //for debug only!
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

    $resp = curl_exec($curl);
    if($resp === false) {
        var_dump($resp);
    } else {
     $resp = json_decode($resp, true);
     $sendingData = json_encode($resp);
    }
    curl_close($curl);

?>

    <meta charset="<?php bloginfo('charset'); ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
    <script>
        const jsonApi = <?php echo $sendingData ?>;
    </script>
</head>
<body <?php body_class(  ); ?>>
    <?php wp_body_open(); ?>
    <header>
        <a class="homeurl" href="<?php echo home_url(); ?>">
            <img src="<?php echo get_template_directory_uri(); ?>/img/top-logo.svg" alt="DB Conseil, Un accompagnement sur-mesure">
        </a>
        <div class="main-menu__container">
            <?php wp_nav_menu( array(
                'theme_location' => 'main',
                'container' => 'nav',
                'menu_id' => 'main-menu',
                'fallback_cb' => false,
                'items_wrap' => '<div class="menu-btn">
                    <div class="menu-btn__burger">
                    </div>
                </div><ul id="%1$s" class="%2$s" hidden>%3$s<div class="form-button__container">
                <a rel="noopener noreferrer" href="/db-conseils/je-postule" >Je postule</a>
                <a rel="noopener noreferrer" href="/db-conseils/je-recrute" >Je recrute</a>
            </div></ul>',
            ) ); ?>
            <!-- <div class="form-button__container">
                <a rel="noopener noreferrer" href="<?php echo site_url('/je-postule'); ?>">Je postule</a>
                <a rel="noopener noreferrer" href="<?php echo site_url('/votre-cabinet-de-recrutement-sur-mesure'); ?>">Je recrute</a>
            </div> -->
        </div>
    </header>