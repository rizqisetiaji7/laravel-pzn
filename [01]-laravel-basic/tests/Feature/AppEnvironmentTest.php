<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class AppEnvironmentTest extends TestCase
{
	public function test_app_environment(): void
	{
		if (App::environment(['testing', 'local', 'development', 'production'])) {
			self::assertTrue(true);
		}
	}
}
