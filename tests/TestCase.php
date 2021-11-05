<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Model\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function authenticate()
    {
        $user = factory(User::class)->make();
        $this->actingAs($user);
    }
}