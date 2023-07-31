<?php

namespace Tests\Feature;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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

	public function test_select_data_with_query_builder(): void
	{
		$this->test_insert_with_query_builder();

		$collection = DB::table('categories')
			->select(['id', 'name'])
			->get();
		
		self::assertNotNull($collection);

		$collection->each(function($record) {
			Log::info(json_encode($record));
		});
	}

	public function insertCategories()
	{
		DB::table('categories')->insert([
			'id'				=> 'SMARTPHONE',
			'name'			=> 'Smartphone',
			'created_at'	=> '2023-07-31 00:00:00'
		]);

		DB::table('categories')->insert([
			'id'				=> 'FOOD',
			'name'			=> 'Food',
			'created_at'	=> '2023-07-31 00:00:00'
		]);

		DB::table('categories')->insert([
			'id'				=> 'LAPTOP',
			'name'			=> 'Laptop',
			'created_at'	=> '2023-07-31 00:00:00'
		]);

		DB::table('categories')->insert([
			'id'				=> 'FASHION',
			'name'			=> 'Fashion',
			'created_at'	=> '2023-07-31 00:00:00'
		]);
	}

	public function test_select_with_where_clause_in_query_builder(): void
	{
		$this->insertCategories();

		$collection = DB::table('categories')->where(function(Builder $query) {
			$query->where('id', '=', 'SMARTPHONE');
			$query->orWhere('id', '=', 'LAPTOP');
		})->get();

		self::assertCount(2, $collection);

		$collection->each(function($item) {
			Log::info(json_encode($item));
		});
	}
}
