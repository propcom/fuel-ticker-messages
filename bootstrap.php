<?php

// Dependencies
\Package::load('admin');
\Module::load('media_manager');
\Config::load('cms', true);

\PropNav\Menu::instance('admin')->add_item(\PropNav\Item::forge('Your CMS.Ticker Messages', '/admin/ticker/manage/', 200));

$roles = array(
	'manage_tickers_messages' => array('Ticker\Controller_Manage' => true),
);

\Auth::acl()->add($roles);
