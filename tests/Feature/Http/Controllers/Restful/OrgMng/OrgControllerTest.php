<?php

namespace Tests\Feature\Http\Controllers\Restful\OrgMng;

use Tests\TestCase;

class OrgControllerTest extends TestCase
{
    public function test_should_add_org()
    {
        $response = $this->post('/api/organizations', [
            'tenantId' => 66,
            'name' => 'foo',
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure(['id', 'tenantId']);
        $response->assertJson([
            'tenantId' => 66,
            'name' => 'foo',
        ]);
    }

    public function test_should_update_org_basic_info()
    {
        $response = $this->put('/api/organizations/1/basic_info', [
            'tenantId' => 1
        ]);

        $response->assertStatus(200);
    }
}
