<?php

namespace Tests\Helpers;

use PHPUnit\Framework\TestCase;

use App\Helpers\ApiResponse;

class ApiResponseTest extends TestCase
{
    public function testSuccessResponse()
    {
        $resultado =
            ApiResponse::success([
                'id' => 1
            ]);

        $this->assertTrue(
            $resultado['success']
        );

        $this->assertEquals(
            1,
            $resultado['data']['id']
        );
    }

    public function testErrorResponse()
    {
        $resultado =
            ApiResponse::error(
                'Error de prueba'
            );

        $this->assertFalse(
            $resultado['success']
        );

        $this->assertEquals(
            'Error de prueba',
            $resultado['message']
        );
    }
}
