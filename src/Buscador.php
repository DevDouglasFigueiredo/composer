<?php

namespace Douglas\BuscardorDeCursos;


use Psr\Http\Client\ClientInterface;
use Symfony\Component\DomCrawler\Crawler;

class Buscador
{   
    private $httpClient;
    private $crawler;

    public function __construct(ClientInterface $httpCliente, Crawler $crawler)
    {
        $this->httpCliente = $httpCliente;
        $this->crawler = $crawler;
    }

    public function buscar(string $url): array
    {
        $resposta = $this->httpClient->request('GET', $url);

        $html = $resposta->getBody();

        $this->crawler->addHtmlContent($html);

        $elementosCursos = $cursos = $this->crawler->filter('span.card-curso__nome');

        $cursos = [];

        foreach($elementosCursos as $elemento){
            $cursos[] = $elemento->textContent;
        }
        return $cursos;
    }

    
}
