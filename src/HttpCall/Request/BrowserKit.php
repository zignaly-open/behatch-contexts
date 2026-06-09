<?php

declare(strict_types=1);

namespace Behatch\HttpCall\Request;

use OutOfBoundsException;
use Behat\Mink\Mink;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class BrowserKit
{
    public function __construct(protected readonly Mink $mink)
    {
    }

    public function getMethod(): string
    {
        return $this->getRequest()->getMethod();
    }

    public function getUri(): string
    {
        return $this->getRequest()->getUri();
    }

    public function getServer(): array
    {
        return $this->getRequest()->getServer();
    }

    public function getParameters(): array
    {
        return $this->getRequest()->getParameters();
    }

    protected function getRequest()
    {
        return $this->mink->getSession()->getDriver()->getClient()->getInternalRequest();
    }

    public function getContent(): string
    {
        return $this->mink->getSession()->getPage()->getContent();
    }

    public function send(string $method, string $url, array $parameters = [], array $files = [], ?string $content = null, array $headers = [])
    {
        foreach ($files as $originalName => &$file) {
            if (is_string($file)) {
                $file = new UploadedFile($file, $originalName);
            }
        }

        $client = $this->mink->getSession()->getDriver()->getClient();

        $client->followRedirects(false);
        $client->request($method, $url, $parameters, $files, $headers, $content);
        $client->followRedirects(true);
        $this->resetHttpHeaders();

        return $this->mink->getSession()->getPage();
    }

    public function setHttpHeader(string $name, string $value): void
    {
        // Mirrors Behat\Mink\Driver\BrowserKitDriver::setRequestHeader header-name mapping:
        // CONTENT_* are not prefixed with HTTP_ in PHP when building $_SERVER.
        $contentHeaders = ['CONTENT_LENGTH' => true, 'CONTENT_MD5' => true, 'CONTENT_TYPE' => true];
        $name = str_replace('-', '_', strtoupper($name));

        if (!isset($contentHeaders[$name])) {
            $name = 'HTTP_' . $name;
        }

        $this->mink->getSession()->getDriver()->getClient()->setServerParameter($name, $value);
    }

    public function getHttpHeaders(): array
    {
        return array_change_key_case(
            $this->mink->getSession()->getResponseHeaders(),
            CASE_LOWER
        );
    }

    public function getHttpHeader(string $name): string
    {
        return implode(', ', $this->getHttpRawHeader($name));
    }

    public function getHttpRawHeader(string $name): array
    {
        $name = strtolower($name);
        $headers = $this->getHttpHeaders();

        if (!isset($headers[$name])) {
            throw new OutOfBoundsException("The header '$name' doesn't exist");
        }

        return is_array($headers[$name]) ? $headers[$name] : [$headers[$name]];
    }

    protected function resetHttpHeaders(): void
    {
        $this->mink->getSession()->getDriver()->getClient()->setServerParameters([]);
    }
}
