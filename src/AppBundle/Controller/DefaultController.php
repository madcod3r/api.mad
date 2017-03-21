<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $imageRepository = $this->getDoctrine()->getRepository('AppBundle:Image');

        $images = $imageRepository->findAll();

        return $this->render('default/index.html.twig', [
            'images' => $images
        ]);
    }
}
