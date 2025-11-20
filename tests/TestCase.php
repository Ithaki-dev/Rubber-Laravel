<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        
        // Create testing database if it doesn't exist
        $this->createTestingDatabase();
    }
    
    protected function createTestingDatabase(): void
    {
        $database = env('DB_DATABASE', 'aventones_testing');
        
        try {
            \DB::statement("CREATE DATABASE IF NOT EXISTS `{$database}`");
        } catch (\Exception $e) {
            // Database might already exist or MySQL might not be running
            // Tests will fail if database cannot be created
        }
    }
}
