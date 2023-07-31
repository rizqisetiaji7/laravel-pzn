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

	public function test_crud_insert_with_raw_database_sql_query(): void
	{

		// Without Named Binding
		DB::insert('INSERT INTO categories (id, name, description, created_at) 
				VALUES (?, ?, ?, ?)', [
				'GADGET', 
				'Gadget', 
				'Gadget Category', 
				'2023-07-29 01:45:50'
			]);

		$results = DB::select('SELECT * FROM categories WHERE id=?', ['GADGET']);

		self::assertCount(1, $results);
		self::assertEquals('GADGET', $results[0]->id);
		self::assertEquals('Gadget', $results[0]->name);
		self::assertEquals('Gadget Category', $results[0]->description);
		self::assertEquals('2023-07-29 01:45:50', $results[0]->created_at);
	}

	public function test_crud_insert_raw_sql_query_with_named_binding(): void
	{
		// With Named Binding
		DB::insert('INSERT INTO categories (id, name, description, created_at) 
			VALUES (:id, :name, :description, :created_at)', [
				'id'				=> 'GADGET',
				'name'			=> 'Gadget',
				'description'	=> 'Gadget Category',
				'created_at'	=> '2023-07-29 01:45:50'
			]);

		$results = DB::select('SELECT * FROM categories WHERE id = :id', ['id' => 'GADGET']);

		self::assertCount(1, $results);
		self::assertEquals('GADGET', $results[0]->id);
		self::assertEquals('Gadget', $results[0]->name);
		self::assertEquals('Gadget Category', $results[0]->description);
		self::assertEquals('2023-07-29 01:45:50', $results[0]->created_at);
	}
}
