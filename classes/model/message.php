<?php

namespace Ticker;

class Model_Message extends \Orm\Model
{
	protected static $_table_name = 'cms__ticker_messages';

	protected static $_properties = array(
		'id' => array(
			'data_type' => 'int',
			'label' => 'ID',
			'search' => array(
				'type' => \Search\Search::TYPE_INT,
			)
		),
		'message' => array(
			'type' => 'text',
			'label' => 'Message',
			'form' => array(
				'type' => 'textarea',
				'class' => 'markitup',
			),
			'search' => array(
				'type' =>  \Search\Search::TYPE_TEXT,
			),
			'validation' => array('required')
		),
		'default' => array(
			'type' => 'bool',
			'label' => 'Default',
			'form' => array(
				'type' => 'checkbox',
				'value' => 1,
			),
			'default' => 0
		),
		'created_at' => array(
			'type' => 'int',
			'label' => 'Created',
			'form' => array('type' => false),
		),
		'updated_at' => array(
			'type' => 'int',
			'label' => 'Updated',
			'form' => array('type' => false),
		),
	);

	protected static $_observers = array(
		'Orm\Observer_CreatedAt' => array(
			'events' => array('before_insert'),
		),
		'Orm\Observer_UpdatedAt' => array(
			'events' => array('before_save'),
		),
		'Orm\Observer_Validation' => array(
			'events' => array('before_save'),
		)
	);

	public static function get_current_message()
	{
		// Try to get the "default" message, set by the user
		$msg = \Ticker\Model_Message::query()
			->where('default', '=', 1)
			->get_one();

		// otherwise get the latest message
		if( ! $msg ) $msg = \Ticker\Model_Message::find('last');

		// return the message, if found, otherwise, return null
		return ( ! $msg ? false : $msg->get_message() );
	}

	public static function last_message()
	{
		return \Ticker\Model_Message::find("last");
	}

	public static function notifications($time)
	{
		return count(\Ticker\Model_Message::query()->where("created_at", ">", $time)->get());
	}

	public function set_default()
	{
		// set all entries (default) to 0
		// this allows us to default the selected
		// message
		\DB::update("cms__ticker_messages")
			->set(array(
				'default' => 0
			))
			->execute();

		$this->default = 1;

		// return this for chaining purposes
		return $this;
	}

	public function get_message()
	{
		$textile = new \Textile\Textile();
		return $textile->textileThis($this->message);
	}
}
