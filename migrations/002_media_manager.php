<?php

namespace Fuel\Migrations;

class Media_Manager
{

    function up()
    {

        \DBUtil::add_fields('cms__ticker_messages', [
            'image_id' => ['type' => 'int', 'null' => true],
        ]);
    }

    function down()
    {
        \DBUtil::drop_fields('cms__ticker_messages', ['image_id']);
    }
}
