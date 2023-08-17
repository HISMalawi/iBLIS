<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Facades\DB;

class AlterResultColumnType extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'fix:histopathology';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Fixes and adds metadata for Histopathology tests';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
    // Execute the raw SQL statement
    echo "Altering result column in test_results from varchar to text\n";
    DB::statement("ALTER TABLE test_results MODIFY result TEXT");
    echo "Column altered successfully\n";
    echo "Altering interpretation column in tests from varchar to text\n";
    DB::statement("ALTER TABLE tests MODIFY interpretation TEXT");
    echo "Column altered successfully\n";
    echo "Insert measure type metadata for histopathology tests\n";
    DB::statement("INSERT INTO measure_types (id, name, deleted_at, created_At, updated_at) VALUES(5, 'Rich Text', NULL, NOW(), NOW())");
    echo "Metadata inserted successfully\n";
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			array('example', InputArgument::REQUIRED, 'An example argument.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}
	

}
