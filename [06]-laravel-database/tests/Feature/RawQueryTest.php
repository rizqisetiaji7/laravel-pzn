<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class RawQueryTest extends TestCase
{
	protected function setUp(): void
	{
		parent::setUp();
		DB::delete('DELETE FROM categories');
	}

	public function test_raw_db_query_crud(): void
	{
		DB::insert('INSERT INTO categories (id, name, description, created_at) VALUES (?, ?, ?, ?)', [
			'GADGET', 'Gadget', 'Gadget Category', '2023-07-29 01:45:50'
		]);

		$results = DB::select('SELECT * FROM categories WHERE id=?', ['GADGET']);

		self::assertCount(1, $results);
		self::assertEquals('GADGET', $results[0]->id);
		self::assertEquals('Gadget', $results[0]->name);
		self::assertEquals('Gadget Category', $results[0]->description);
		self::assertEquals('2023-07-29 01:45:50', $results[0]->created_at);
	}
}
