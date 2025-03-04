<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php wp_head(); ?>
</head><?php $sidebar_position = get_option( 'sidebar_type', false ); 
if(!$sidebar_position)
	$sidebar_position = 'side-right'; 
$login = get_option( 'header_login', false ); 
if(!$login){
	$login_class = 'login-off';
} else {$login_class = '';}
$sticky = get_option( 'header_sticky', false );
if($sticky){
	$sticky_class = 'pfx';
} else {$sticky_class = '';}
?>
<body <?php body_class($sidebar_position . ' ' .$login_class . ' ' . $sticky_class); ?>>
	<div id="aa-wp" class="cont">
		<header class="hd dfx alg-cr">
			<?php do_action( 'header_content' ); 
			# 10: LOGO
			# 20: NAV
			# 30: TOGGLE MENU ?>
		</header>