<?php

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverBy;
use PHPUnit\Framework\TestCase;

class PaginaInicialTest extends TestCase
{
    private WebDriver $driver;

    protected function setUp(): void{
        // Arrange
        $host = 'http://192.168.0.9:1234/';
        
        // Chrome
        $this->driver = RemoteWebDriver::create($host, DesiredCapabilities::chrome(), 3600000, 3600000);
    }

    protected function tearDown(): void
    {
        $this->driver->close();
    }

    public function testPaginaInicialNaoLogadaDeveSerListagemDeSeries()
    {
        // Act
        $this->driver->get('http://localhost:80');
        
        // Assert
        $h1Locator = WebDriverBy::tagName('h1');
        $textoH1 = $this->driver->findElement($h1Locator)->getText();

        self::assertSame('Séries', $textoH1);
    }

}