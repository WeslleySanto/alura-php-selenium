<?php

use Tests\TestCase;
use Facebook\WebDriver\WebDriver;
use Facebook\WebDriver\WebDriverBy;
use Alura\Tests\PageObject\PaginaLogin;
use Facebook\WebDriver\WebDriverSelect;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Alura\Tests\PageObject\PaginaCadastroSeries;
use Facebook\WebDriver\Remote\DesiredCapabilities;

class CadastroSeriesTest extends TestCase
{   
    private static WebDriver $driver;

    public static function setUpBeforeClass()
    {
        // Arrange
        $host = 'http://192.168.0.9:1234/';
        
        // Chrome
        self::$driver = RemoteWebDriver::create($host, DesiredCapabilities::chrome(), 3600000, 3600000);

        $paginaLogin = new PaginaLogin(self::$driver);
        $paginaLogin->realizaLoginCom('email@teste.com.br', '123');
    }

    protected function setUp(): void{
        self::$driver->get('http://localhost:80/adicionar-serie');
    }

    protected function tearDown(): void
    {
        self::$driver->close();
    }

    public function testCadastrarNovaSerieDeveRedirecionarParaLista()
    {   

        $paginaCadastro = new PaginaCadastroSeries(self::$driver);
        $paginaCadastro
            ->preencheNome('Teste')
            ->selecionaGenero('acao')
            ->comTemporadas(1)
            ->comEpisodios(1)
            ->enviaFormulario();

        // Assert
        self::assertSame('http://localhost/series', self::$driver->getCurrentURL());
        self::assertSame(
            'Série com suas respectivas temporadas e episódios adicionada.', 
            trim(self::$driver->findElement(WebDriverBy::cssSelector('div.alert.alert-success'))->getText())
        );
    }
}
?>