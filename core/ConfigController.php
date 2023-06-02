<?php

namespace Core;

class ConfigController
{
    private string $url;
    private array $urlArray;
    private String $urlController;
    // private string $urlParameter;
    private string $urlSlugController;
    private array $format;

    public function __construct()
    {
            if(!empty(filter_input(INPUT_GET, 'url', FILTER_SANITIZE_SPECIAL_CHARS))){
                $this->url=filter_input(INPUT_GET, 'url', FILTER_SANITIZE_SPECIAL_CHARS);

                $this->clearUrl();

                $this->urlArray = explode("/", $this->url);

                if(isset($this->urlArray[0])){
                    var_dump($this->urlArray[0]);
                    $this->urlController = $this->slugController($this->urlArray[0]);

                }else{
                    $this->urlController = $this->slugController("Home");;
                }


            } else {
                $this->urlController = $this->slugController("Home");;
                
            }
            echo "Controller: {$this->urlController}<br>";


    }

    private function clearUrl() 
    {
        // Eliminar as tags
        $this->url = strip_tags($this->url);
        // Eliminar espaços em branco
        $this->url = trim($this->url);
        // Eliminar a barra no final da URL
        $this->url = rtrim($this->url, "/");
        // Eliminar caracteres
        $this->format['a'] = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿRr"!@#$%&*()_-+={[}]?;:.,\\\'<>°ºª ';
        $this->format['b'] = 'aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr-------------------------------------------------------------------------------------------------';
        $this->url = strtr(utf8_decode($this->url), utf8_decode($this->format['a']), $this->format['b']); 
    }

    private function slugController($slugController) 
    {
        // Converter para minúsculo
        $this->urlSlugController = strtolower($slugController);
        // Converter o traço para espaco em branco
        $this->urlSlugController = str_replace("-", " ", $this->urlSlugController);
        // converter a primeira letra de todas palavras em maíusculo
        $this->urlSlugController = ucwords($this->urlSlugController);
        // Retirar o espaço em branco
        $this->urlSlugController = str_replace(" ", "", $this->urlSlugController);


        return $this->urlSlugController;
    }

    public function loadPage()
    {
        $classLoad = "\\Sts\\Controllers\\". $this->urlController;
        $classPage = new $classLoad();
        $classPage->index(); 
    }
           
}