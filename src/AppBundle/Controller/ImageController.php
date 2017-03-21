<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use FOS\RestBundle\Controller\FOSRestController as Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\Annotations\View;
use AppBundle\Entity\Image;
use AppBundle\Entity\Tag;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageController extends Controller
{
    /**
     * @Rest\Get("/api/image")
     * @Rest\View
     */
    public function getImagesAction()
    {
        $images = $this->getDoctrine()->getRepository('AppBundle:Image')->findAll();

        return $this->handleView(
            $this->view($images, Response::HTTP_OK)
        );
    }

    /**
     * @Rest\Get("/api/image/{id}")
     * @Rest\View
     */
    public function getImageAction($id)
    {
        $image = $this->getDoctrine()->getRepository('AppBundle:Image')->findOneBy(array(
            'id' => $id
        ));

        if (!$image instanceof Image) {
            throw new NotFoundHttpException('Image not found');
        }

        return $this->handleView(
            $this->view($image, Response::HTTP_OK)
        );
    }

    /**
    * @Rest\Post("/api/image")
    */
    public function postAction(Request $request)
    {
        $image = new Image;
        $tagsString = $request->get('tags');

        foreach ($_FILES as $file) {
            $uploadDir = $this->get('kernel')->getRootDir() . '/../web/upload/image/';

            $uploadedFile = new UploadedFile(
                $file['tmp_name'],
                $file['name'], $file['type'],
                $file['size'], $file['error'],
                $test = false);

            $uploadedFile->move($uploadDir, $file['name']);

            $image->setPath('/upload/image/' . $file['name']);

            break;
        }

        $tagsNames = explode(',', $tagsString);

        $em = $this->getDoctrine()->getManager();

        foreach($tagsNames as $tagsName) {
            // check if tag exists
            $tag = $this->getDoctrine()
                ->getRepository('AppBundle:Tag')
                ->findOneByName($tagsName);

            if (!$tag) {
                $tag = new Tag();
                $tag->setName($tagsName);

                $em->persist($tag);
            }

            $image->addTag($tag);
        }


        $em->persist($image);
        $em->flush();

        return $this->handleView(
            $this->view("Image Added Successfully", Response::HTTP_OK)
        );
 }

    /**
     * @View(statusCode=204)
     */
    public function deleteImageAction()
    {
        //...
    }
}
