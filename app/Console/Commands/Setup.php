<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Stancl\Tenancy\Exceptions\TenantDatabaseDoesNotExistException;

class Setup extends Command
{
	/** @var string */
	protected $signature = "app:setup";

	/** @var string */
	protected $description = "Setup the application";

	public function handle()
	{
		$this->info("Freshly migrating the database...");

		try {
			$this->call("tenants:migrate-fresh");
		} catch (TenantDatabaseDoesNotExistException $exception) {
			// We ignore this exception as the SQLite file was
			// probably deleted manually.
		}

		$this->call("migrate:fresh");

		$this->info("Generating IDE helper files...");
		$this->call("ide-helper:generate");

		$this->info("Generating IDE helper meta files...");
		$this->call("ide-helper:meta");

		$this->info("Generating IDE helper model comments...");
		$this->call("ide-helper:models", [
			"--write" => true,
			"--reset" => true,
		]);

		$this->call("db:seed", [
			"--class" => "Database\Seeders\DatabaseSeeder",
		]);
	}
}
