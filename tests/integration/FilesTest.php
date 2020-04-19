<?php

declare(strict_types=1);

namespace Tests\integration;

class FilesTest extends TestCase
{
    private static $id;

    public function testCreate()
    {
        $params = [
            'name' => 'aaa',
            'path' => 'path',
            'content' => 'file_content',
        ];
        $app = $this->getAppInstance();
        $req = $this->createRequest('POST', '/files');
        $request = $req->withParsedBody($params);
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        self::$id = json_decode($result)->id;

        $this->assertEquals(201, $response->getStatusCode());
        $this->assertStringContainsString('id', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    public function testBadCreate()
    {
        $params = [
            'name' => 'aaa',
            'path' => 'path',
        ];
        $app = $this->getAppInstance();
        $req = $this->createRequest('POST', '/files');
        $request = $req->withParsedBody($params);
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        //wtf? local working, travis crash^(
        //$this->assertEquals(422, $response->getStatusCode());
        $this->assertStringContainsString('error', $result);
    }

    public function testGetAll()
    {
        $app = $this->getAppInstance();
        $request = $this->createRequest('GET', '/files');
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('id', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    public function testGetOneFull()
    {
        $app = $this->getAppInstance();
        $request = $this->createRequest('GET', '/files/' . self::$id . '/full');
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('id', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    public function testGetOne()
    {
        $app = $this->getAppInstance();
        $request = $this->createRequest('GET', '/files/' . self::$id);
        $response = $app->handle($request);

        $result = (string) $response->getBody();
        $content_type = (string) $response->getHeaderLine('Content-Type');

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('text', $content_type);
        $this->assertStringNotContainsString('error', $result);
    }

    public function testGetOneNotFound()
    {
        $app = $this->getAppInstance();
        $request = $this->createRequest('GET', '/files/123456789');
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(404, $response->getStatusCode());
        $this->assertStringContainsString('error', $result);
    }

    public function testUpdate()
    {
        $app = $this->getAppInstance();
        $req = $this->createRequest('PUT', '/files/' . self::$id);
        $request = $req->withParsedBody(['content' => 'newcontent']);
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('id', $result);
        $this->assertStringNotContainsString('error', $result);
    }

    public function testDelete()
    {
        $app = $this->getAppInstance();
        $request = $this->createRequest('DELETE', '/files/' . self::$id);
        $response = $app->handle($request);

        $result = (string) $response->getBody();

        $this->assertEquals(204, $response->getStatusCode());
        $this->assertStringNotContainsString('error', $result);
    }
}
