<?php

namespace Tests\Feature\Http\Controllers\Restful\OrgMng;

use Tests\TestCase;

class OrgControllerTest extends TestCase
{
    public function test_should_add_org()
    {
        $response = $this->post('/api/organizations', [
            'tenant_id' => 1,
        ]);

        $response->assertStatus(200);
        $response->assertContent('"success"');
    }
}