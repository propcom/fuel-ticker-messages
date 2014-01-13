<?php

namespace Ticker;

class Controller_Manage extends \Cms\Controller_Template
{
    public function before()
    {
        parent::before();
        \Module::load('media_manager');
        \Propeller\AssetInjector::add_js('admin/classes.js');
        \Propeller\AssetInjector::add_css('classes.css');
        \Media_Manager\Init::run();
    }

	/**
	 * Display a list of all messages
	 */
	public function action_index()
	{
		// find all the ticker messages
		$messages = \Ticker\Model_Message::find('all');

		// details for datatable
		$datatable_fields = array(
			array('message', 'sprintf', 'Message',array(
				'format' => '<blockquote><p>%s</p></blockquote>',
				'fields' => array('message'),
			)),
			array('edit', 'sprintf', 'Edit', array(
				'format' => '<a href="/admin/ticker/manage/edit/%d/" class="btn" title="Edit"><i class="icon icon-pencil"></i></a>',
				'fields' => array('id'),
			)),
			array('set_default', 'sprintf', 'Default', array(
				'format' => '<a href="/admin/ticker/manage/set_default/%d/" class="btn btn-info" title="Set Default"><i class="icon icon-asterisk"></i></a>',
				'fields' => array('id'),
			)),
			array('manage', 'sprintf', 'Delete', array(
				'format' => '<a href="/admin/ticker/manage/delete/%d/" class="btn btn-danger" title="Delete"><i class="icon icon-remove"></i></a>',
				'fields' => array('id'),
			)),
		);

		// create a datatable instance and forge the list view
		$datatable_table = new \DataTable\DataTable($datatable_fields, 50, $messages);
		$datatable = \Request::forge('datatable/datatable/build_table', false)->execute(array($datatable_table));

		$view =  \View::forge('list');
		$view->set('datatable', $datatable, false);
		$view->set('current_message', "Trolololo");

		$this->template->content = $view;
	}

	/**
	 * Creates a ticker message
	 */
	public function action_create()
	{
		$this->_edit(\Ticker\Model_Message::forge());
	}

	/**
	 * Edits the message
	 */
	public function action_edit($id = false)
	{
		$message = \Ticker\Model_Message::find($id);

		// basic handling for id or message not set
		if( ! $id or ! $message) \Response::redirect("/admin/ticker/manage/create");

		$this->_edit($message);
	}

	/**
	 * Delete a ticker message from the database
	 */
	public function action_delete($id = false)
	{
		$message = \Ticker\Model_Message::find($id);

		// try to delete the message
		try
		{
			$message->delete();
			\Session::set_flash("success", "Message deleted");

			\Response::redirect(\Uri::create("/admin/ticker/manage"));
		}
		catch(\Exception $e)
		{
			\Session::set_flash("Unable to delete message");
		}
	}

	public function action_set_default($id = false)
	{
		$message = \Ticker\Model_Message::find($id);

		// if we can't find the message of the id is not set, redirect the user back to the list
		if( ! $id or ! $message) \Response::redirect(\Uri::create("/admin/ticker/manage"));

		// try to default said message
		try
		{
			$message->set_default()->save();

			\Session::set_flash("success", '"' . $message->message . '" is now set as the default message');
		}
		catch(\Exception $e)
		{
			\Session::set_flash("error", "Unable to set default message. " . $e->getMessage());
		}

		\Response::redirect(\Uri::create("/admin/ticker/manage"));

	}

	private function _edit(\Ticker\Model_Message $message)
	{
        \Propeller\AssetInjector::add_js('chosen.jquery.js');
        \Propeller\AssetInjector::add_css('chosen/chosen.css');

		if(\Input::method() == "POST"){
			$message->message = \Input::post("message");
            $message->image_id 	= \Input::post('image_id', null);

			// only set as default message is checkbox is ticked
			if(\Input::post("default") == 1) $message->set_default()->save();

			try
			{
				$message->save();
				\Session::set_flash("success", "Message Saved.");

				\Response::redirect(\Uri::create("/admin/ticker/manage"));
			}
			catch(\Exception $e)
			{
				\Session::set_flash("error", "Unable to save message: " . $e->getMessage());
			}
		}

		$fieldset = \Fieldset::forge('addedit_message', array(
			'form_attributes' => array(
				'class' => 'form-horizontal',
			)
		));

		$fieldset->add_model($message, $message)->populate($message);

        $image = $message->image ?: false;
        $fieldset->add(new \Propeller\Fieldset_Markup_Field(
            'image',
            'Add Image',
            array('value' => \View::forge('manage/single-image')
                    ->set('image', $image)
                    ->set('mm_multi', 0)
                    ->set('media_type', 'class-image')
                    ->set('mm_field_name', 'image_id')
                    ->render(),
                'class' => 'image'
            )
        ));
        $image = false;
        if($message->image_id)
        {
           // $image = \Media_Manager\Model_Image::find($message->image_id);
        }


		// buttons used to save or return back to the the list
		$buttons = \Fieldset::forge('buttons', array('form_attributes' => array('class' => 'form-actions'), 'field_template' => '{field}'));
		$buttons->add('submit', '', array('type' => 'submit', 'value' => 'Save', 'class' => 'btn btn-primary'));

		$fieldset->add($buttons);

		// forge the view and set variables
		$view = \View::forge('addedit');
		$view->set('fieldset', $fieldset, false);
		$view->set('message', $message, false);

		$this->template->set("content", $view);
	}
}
