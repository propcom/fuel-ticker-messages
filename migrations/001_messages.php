<?php

namespace Fuel\Migrations;

class Messages
{
	public function up()
	{
		try {
			\DB::start_transaction();

			\DBUtil::create_table(
				'cms__ticker_messages',
				array(
					'id'				=> array('type' => 'int', 'unsigned' => true, 'auto_increment' => true),
					'message'			=> array('type' => 'text'),
					'default'			=> array('type' => 'bool', 'default' => 0),
					'created_at'		=> array('type' => 'int'),
					'updated_at'		=> array('type' => 'int', 'null' => true),
				),
				array('id'),
				false,
				'InnoDB',
				'utf8_general_ci'
			);

			\DB::commit_transaction();
			
			\Cli::write('Migration Successful: '. __METHOD__.' in '. __FILE__, 'green');
		}
		catch (\Exception $e) {
			\DB::rollback_transaction();

			\Cli::error('Migration Failed: '.__METHOD__.' in '. __FILE__);
			\Cli::write($e->getMessage());
			
			// Unless there is a better way to prevent the Migration version from incrementing on failure.
			exit;
		}
	}

	public function down()
	{
		try {
			\DB::start_transaction();

			\DBUtil::drop_table('cms__ticker_messages');
			
			\DB::commit_transaction();
			
			\Cli::write('Migration Successful: '. __METHOD__.' in '. __FILE__, 'green');
		}
		catch (\Exception $e) {
			\DB::rollback_transaction();

			\Cli::error('Migration Failed: '.__METHOD__.' in '. __FILE__);
			\Cli::write($e->getMessage());
			
			// Unless there is a better way to prevent the Migration version from incrementing on failure.
			exit;
		}
	}
}
