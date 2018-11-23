<?php

namespace App\Controller;

use App\Entity\Circuit;
use App\Form\CircuitType;
use App\Repository\CircuitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/circuit")
 */
class BackofficeCircuitController extends AbstractController
{
    /**
     * @Route("/", name="circuit_index", methods="GET")
     */
    public function index(CircuitRepository $circuitRepository): Response
    {
        return $this->render('back/circuit/index.html.twig', ['circuits' => $circuitRepository->findAll()]);
    }

    /**
     * @Route("/new", name="circuit_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $circuit = new Circuit();
        $form = $this->createForm(CircuitType::class, $circuit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($circuit);
            $em->flush();
            // Make sure message will be displayed after redirect
            $this->get('session')->getFlashBag()->add('message', 'bien ajouté');

            return $this->redirectToRoute('circuit_index');
        }

        return $this->render('back/circuit/new.html.twig', [
            'circuit' => $circuit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="circuit_show", methods="GET")
     */
    public function show(Circuit $circuit): Response
    {
        return $this->render('back/circuit/show.html.twig', ['circuit' => $circuit]);
    }

    /**
     * @Route("/{id}/edit", name="circuit_edit", methods="GET|POST")
     */
    public function edit(Request $request, Circuit $circuit): Response
    {
        $form = $this->createForm(CircuitType::class, $circuit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('circuit_edit', ['id' => $circuit->getId()]);
        }

        return $this->render('back/circuit/edit.html.twig', [
            'circuit' => $circuit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="circuit_delete", methods="DELETE")
     */
    public function delete(Request $request, Circuit $circuit): Response
    {
        if ($this->isCsrfTokenValid('delete'.$circuit->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($circuit);
            $em->flush();
            // Make sure message will be displayed after redirect
            $this->get('session')->getFlashBag()->add('message', 'bien supprimé');
        }

        return $this->redirectToRoute('circuit_index');
    }


    /**
     * @Route("/{id}", name="circuit_like", methods="LIKE")
     */
    public function like($id)
    {


        {

            $likes = $this->get('session')->get('likes');
            dump($likes);
            if ($likes == null){
                $likes = array($id);
            }
            else{
                if (in_array($id, $likes)){
                    $likes = array_diff($likes, array($id));
                }
                else{
                    $likes[] = $id;
                }
            }
            dump($likes);
            $this->get('session')->set('likes', $likes);




            return $this->redirectToRoute("frontoffice_home");
        }

        return $this->render('home.html.twig', [
            'likes' => $likes,
        ]);
    }





}
