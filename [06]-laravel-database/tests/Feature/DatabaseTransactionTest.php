<?php

namespace Tests\Feature;

use Error;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DatabaseTransactionTest extends TestCase
{
	protected function setUp(): void
	{
		parent::setUp();
		DB::delete('DELETE FROM categories');
	}

	public function test_database_transaction_success(): void
	{
		DB::transaction(function() {
			DB::insert('INSERT INTO categories (id, name, description, created_at) 
				VALUES (:id, :name, :description, :created_at)', [
					'id'            => 'GADGET',
					'name'          => 'Samsung Galaxy Note 12 Pro',
					'description'   => 'Smartphone Samsung',
					'created_at'    => '2023-07-31 11:01:01'
				]);
			
			DB::insert('INSERT INTO categories (id, name, description, created_at) 
				VALUES (:id, :name, :description, :created_at)', [
					'id'            => 'FOOD',
					'name'          => 'Kebab Turki',
					'description'   => 'Makanan Khas',
					'created_at'    => '2023-07-31 11:08:10'
				]);
		});

		$results = DB::select('SELECT * FROM categories');

		self::assertCount(2, $results);
	}

	public function test_database_transaction_failed(): void
	{
		try {
			DB::transaction(function() {
				DB::insert('INSERT INTO categories (id, name, description, created_at) 
					VALUES (:id, :name, :description, :created_at)', [
						'id'            => 'GADGET',
						'name'          => 'Samsung Galaxy Note 12 Pro',
						'description'   => 'Smartphone Samsung',
						'created_at'    => '2023-07-31 11:01:01'
					]);
				
				DB::insert('INSERT INTO categories (id, name, description, created_at) 
					VALUES (:id, :name, :description, :created_at)', [
						'id'            => 'GADGET',
						'name'          => 'Kebab Turki',
						'description'   => 'Makanan Khas',
						'created_at'    => '2023-07-31 11:08:10'
					]);
			});
		} catch (QueryException $error) {
			// Expected
		}
		
		$results = DB::select('SELECT * FROM categories');
		self::assertCount(0, $results);
	}

	public function test_manual_database_transaction_success(): void
	{
		try {
			DB::beginTransaction(); // Run the beginning of transaction

				DB::insert('INSERT INTO categories (id, name, description, created_at) 
					VALUES (:id, :name, :description, :created_at)', [
						'id'            => 'GADGET',
						'name'          => 'Samsung Galaxy Note 12 Pro',
						'description'   => 'Smartphone Samsung',
						'created_at'    => '2023-07-31 11:01:01'
					]);
				
				DB::insert('INSERT INTO categories (id, name, description, created_at) 
					VALUES (:id, :name, :description, :created_at)', [
						'id'            => 'FOOD',
						'name'          => 'Kebab Turki',
						'description'   => 'Makanan Khas',
						'created_at'    => '2023-07-31 11:08:10'
					]);

			DB::commit(); // If success commit the transaction

		} catch (QueryException $error) {
			DB::rollBack(); // Run rollback if error
		}

		$results = DB::select('SELECT * FROM categories');
		self::assertCount(2, $results);
	}

	public function test_manual_database_transaction_failed(): void
	{
		try {
			DB::beginTransaction();

				DB::insert('INSERT INTO categories (id, name, description, created_at) 
					VALUES (:id, :name, :description, :created_at)', [
						'id'            => 'GADGET',
						'name'          => 'Samsung Galaxy Note 12 Pro',
						'description'   => 'Smartphone Samsung',
						'created_at'    => '2023-07-31 11:01:01'
					]);
				
				DB::insert('INSERT INTO categories (id, name, description, created_at) 
					VALUES (:id, :name, :description, :created_at)', [
						'id'            => 'GADGET',
						'name'          => 'Kebab Turki',
						'description'   => 'Makanan Khas',
						'created_at'    => '2023-07-31 11:08:10'
					]);
					
			DB::commit();
		} catch (QueryException $error) {
			DB::rollBack();
		}
		
		$results = DB::select('SELECT * FROM categories');
		self::assertCount(0, $results);
	}
}
