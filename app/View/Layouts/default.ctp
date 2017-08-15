<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		//echo $this->Html->css('cake.generic');
		echo $this->Html->css('style');
        echo $this->Html->css('general');

		echo $this->Html->script('//code.jquery.com/jquery-1.11.0.min.js');
		
		echo $this->Html->css('metro-bootstrap', array('media' => 'screen'));
        echo $this->Html->css('metro-bootstrap-responsive', array('media' => 'screen'));
        echo $this->Html->css('iconFont.min');

        echo $this->Html->script('jquery.widget.min');
    	echo $this->Html->script('jquery.mousewheel');
    	echo $this->Html->script('metro.min', array('media' => 'screen'));

        echo $this->Html->css('print', array('media' => 'print'));
        echo $this->Html->script('main');
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body class="metro">
<header>
<nav class="navigation-bar fixed-top">
    <nav class="navigation-bar-content container">
        <?php echo $this->Html->link('<span class="icon-cart-2"></span> GETRÄNKE <sup>ABH/RSH</sup>', '/', array('class' => 'element', 'escape' => false)); ?>
 
        <span class="element-divider">&nbsp;</span>
        
        <?php echo $this->Html->link('Wizard', array('controller' => 'bill', 'action' => 'customers'), array('class' => 'element')); ?>

        <div class="element place-right">
            <a class="dropdown-toggle" href="#">
                <span class="icon-user-3"></span>
                <span id="session_user"><?php echo $session_users[$session_user_index]['User']['name'].' '.$session_users[$session_user_index]['User']['room']; ?></span>
            </a>
            <ul class="dropdown-menu place-right" data-role="dropdown">
                <?php foreach($session_users as $user): ?>
                <li><a href="#" class="change_user" id="cu_<?php echo $user['User']['id']; ?>"><?php echo $user['User']['name'].' '.$user['User']['room']; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="element place-right">
            <a class="dropdown-toggle" href="#">
                <span class="icon-calendar"></span>
                <span id="session_term"><?php echo $session_terms[$session_term_index]['Term']['name']; ?></span>
            </a>
            <ul class="dropdown-menu place-right" data-role="dropdown">
                <?php foreach($session_terms as $term): ?>
                <li><a href="#" class="change_term" id="ct_<?php echo $term['Term']['id']; ?>"><?php echo $term['Term']['name']; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <?php echo $this->Html->link('<span class="icon-screen"></span>', '#', array('class' => 'element place-right', 'escape' => false, 'id' => 'open-second-screen')); ?>
    </nav>
</nav>
</header>

<div class="container content">
			<?php echo $this->Session->flash(); ?>
			<?php echo $this->fetch('content'); ?>
</div>

	<?php //echo $this->element('sql_dump'); ?>
</body>
</html>
