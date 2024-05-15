<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MigrationTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_roles_table(): void
    {
        $this->assertTrue(Schema::hasTable('roles'));
    }

    public function test_device_table(): void
    {
        $this->assertTrue(Schema::hasTable('devices'));
    }

    public function test_ticket_table(): void
    {
        $this->assertTrue(Schema::hasTable('tickets'));
    }

    public function test_proces_table(): void
    {
        $this->assertTrue(Schema::hasTable('proces'));
    }

    public function test_status_table(): void
    {
        $this->assertTrue(Schema::hasTable('statuses'));
    }
}
