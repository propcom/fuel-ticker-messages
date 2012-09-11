<?php

// Dependencies
\Package::load('admin');
\Config::load('cms', true);

\PropNav\Menu::instance('admin')->add_item(
	\PropNav\Item::forge('CMS', '', 100)
		->add_item(\PropNav\Item::forge('Ticker Messages', '/admin/ticker/manage/'), 6)
);

$roles = array(
	'manage_tickers_messages' => array('\TickerMessages\Controller_Manage' => true),
);

\Auth::acl()->add($roles);