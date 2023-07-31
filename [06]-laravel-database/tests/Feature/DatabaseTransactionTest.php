<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DatabaseTransactionTest extends TestCase
{
    public function test_database_transaction(): void
	{
		DB::transaction(function() {
			
		});
	}
}
