<?php

namespace lbs\control;
use \lbs\model\Categories as Categories;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class Categoriescontroller {
    private $c;

    public function __construct(\Slim\Container $c){
        $this->c = $c;
    }

    public function getCategories(Request $req, Response $resp,$args){
        $req = Categories::get();
        $resp = $resp->withHeader('Content-Type','application/json');
        $resp->getBody()->write(json_encode($req));

        return $resp;
    }

    public function getCategorie(Request $req, Response $resp,$args){
        try {
         $req = Categories::where("id","=",$args["id"])->firstOrFail();
         $resp = $resp->withHeader('Content-Type','application/json');

     } catch (Exception $e) {
        $tab = array('type' => "error" ,"error" => 400, "Message :" => "Votre requête ne marche pas" );
        $resp->withStatus(500)->getBody()->write('Hello NOT ALLOWED ');
    }
    $resp->getBody()->write(json_encode($req));
    return $resp;
}
public function addCategorie(Request $req, Response $resp) {
    $postVars = $req->getParsedBody();
    $categ = new Categories;
    $categ->nom = filter_var($postVars["nom"],FILTER_SANITIZE_STRING);
    $categ->description =filter_var($postVars["description"],FILTER_SANITIZE_STRING);
    $categ->save();
    $resp = $resp->withHeader('Content-Type','application/json');
    $resp = $resp->withHeader('location', $this->c["router"]->pathFor('categorie',['id'=>$categ->id]))->withStatus(201);
    $resp->getBody()->write(json_encode($categ));
    return $resp;


}

}