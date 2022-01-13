<?php

use Tests\TestCase;
use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\RemoteWebElement;
use Facebook\WebDriver\Remote\DesiredCapabilities;

class RegistroTest extends TestCase
{   

    private static WebDriver $driver;

    public static function setUpBeforeClass()
    {
        // Arrange
        $host = 'http://192.168.0.9:1234/';
        
        // Chrome
        self::$driver = RemoteWebDriver::create($host, DesiredCapabilities::chrome(), 3600000, 3600000);
    }


    protected function setUp(): void{
        self::$driver->get('http://localhost:80/novo-usuario');
    }

    protected function tearDown(): void
    {
        self::$driver->close();
    }

    public function testQuandoRegistrarNovoUsuarioDeveRedirecionarParaListaDeSeries()
    {
        // Act
        $inputNome = self::$driver->findElement(WebDriverBy::id('name'));
        $inputEmail = self::$driver->findElement(WebDriverBy::id('email'));
        $inputSenha = self::$driver->findElement(WebDriverBy::id('password'));

        $inputNome->sendKeys('Nome teste');
        $inputEmail->sendKeys(md5(time()) . '@teste.com.br');
        $inputSenha->sendKeys('123')->submit();

        // Assert
        self::assertSame('http://localhost/series', self::$driver->getCurrentURL());
        self::assertInstanceOf(
            RemoteWebElement::class, 
            self::$driver->findElement(WebDriverBy::linkText('Sair'))
        );
    }
}
?>