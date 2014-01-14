<?php

namespace Fuel\Migrations;

class Media_Manager_Size
{
    public function up()
    {
        $now = time();
        // Add default media for image maps
        $id = \DB::select('id')
            ->from('media__types')
            ->where('name', '=', 'class-image')
            ->execute()
            ->get('id');


        \DB::insert('media__sizes')->set(array(
            'name'			=> 'normal',
            'width'			=> 300,
            'height'		=> 300,
            'type_id'		=> $id,
            'dir_name'		=> 'class-image/normal/',
            'created_at'	=> $now,
            'updated_at'	=> $now,
        ))->execute();

        \Cli::write('Migration Successful: '. __METHOD__.' in '.__FILE__, 'green');
    }

    public function down()
    {
         \DB::delete('media__sizes')
            ->where('dir_name', '=', 'class-image/normal/')
            ->execute();


        \Cli::write('Migration Successful: '. __METHOD__.' in '.__FILE__, 'green');
    }
}