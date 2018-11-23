<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Circuit;

class FrontofficeHomeController extends AbstractController
{
    /**
     * @Route("/home", name="frontoffice_home")
     */
    public function index()
    {

	$em = $this->getDoctrine()->getManager();


        $circuits = $em->getRepository(Circuit::class)->findAll();

     		 dump($circuits);
	
    	return $this->render('front/home.html.twig', [
	'circuits' => $circuits
      ]);

 	//return $this->render('frontoffice_home/index.html.twig', [
        //    'controller_name' => 'FrontofficeHomeController',
        //]);
	
       
    }

	/**
 	* Finds and displays a circuit entity.
	 *
 	* @Route("/circuit/{id}", name="front_circuit_show")
	 */
	public function circuitShow($id)
	{
 	   $em = $this->getDoctrine()->getManager();
	
  	  $circuit = $em->getRepository(Circuit::class)->find($id);
	
   	 dump($circuit);
	
   	 return $this->render('front/circuit_show.html.twig', [
   	 'circuit' => $circuit,
   	 ]);
	}





	
}
