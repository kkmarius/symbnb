<?php   

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController{

    /**
     * @Route("/", name="homepage")
     */
    public function home(){
        $prenom = ["Marius", "Jean de Dieu", "Moise"];
        return $this->render(
            'home.html.twig',
            [
                "title" => "Bonjour humain !",
                'age' => 31,
                'tableau' => $prenom
            ]
        );
    }
}
?>