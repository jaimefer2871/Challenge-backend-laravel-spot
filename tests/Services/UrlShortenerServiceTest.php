<?php

namespace Tests\Services;

use App\Models\UrlShortenerModel;
use Tests\TestCase;

class UrlShortenerServiceTest extends TestCase
{

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_getList()
    {
        $data = $this->repository->findByConditions([]);

        $this->assertEquals(3, $data->count(), 'Total de registros');
    }

    public function test_create()
    {
        $shortened = bin2hex(random_bytes(4));

        $this->assertEquals(8, strlen($shortened));

        $data = $this->repository->save([
            'original' => 'http://www.example.com',
            'shortened' => $shortened
        ]);

        $this->assertIsArray($data);
        $this->assertArrayHasKey('id', $data);
        $this->assertNotEmpty($data['id']);

        $data = $this->repository->save([
            'original' => 'http://www.example.com',
            'shortened' => 'das7d6a78d6a87d2321ads'
        ]);

        $this->assertFalse($data);
    }

    public function test_delete()
    {
        $row = UrlShortenerModel::first();

        $result = $this->repository->destroy($row->id);

        $this->assertEquals(1, $result);

        $result2 = $this->repository->destroy(9999);

        $this->assertEquals(0, $result2);
    }
}
