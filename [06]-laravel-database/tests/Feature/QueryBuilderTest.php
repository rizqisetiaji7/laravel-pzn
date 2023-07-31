<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class QueryBuilderTest extends TestCase
{
	protected function setUp(): void
	{
		parent::setUp();
		DB::delete('DELETE FROM categories');
	}

	public function test_insert_with_query_builder(): void
	{
		DB::table('categories')->insert([
			'id'		=> 'GADGET',
			'name'	=> 'Gadget'
		]);
		
		DB::table('categories')->insert([
			'id'		=> 'FOOD',
			'name'	=> 'Food'
		]);

		$results = DB::select('SELECT COUNT(id) AS total FROM categories');
		self::assertEquals(2, $results[0]->total);
	}
}
