<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Image;

class LoadImageData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        // get reserved tags
        $tagNew = $this->getReference('tag-new');
        $hiresNew = $this->getReference('tag-hires');
        $hqNew = $this->getReference('tag-hq');

        // create some images
        $image1 = new Image();
        $image1->setPath('/upload/image/image1.jpg');
        $image1->addTag($tagNew);
        $image1->addTag($hiresNew);
        $image1->addTag($hqNew);


        $image2 = new Image();
        $image2->setPath('/upload/image/image2.jpg');
        $image2->addTag($tagNew);
        $image2->addTag($hiresNew);
        $image2->addTag($hqNew);


        $image3 = new Image();
        $image3->setPath('/upload/image/image3.jpg');
        $image3->addTag($tagNew);
        $image3->addTag($hiresNew);
        $image3->addTag($hqNew);

        $manager->persist($image1);
        $manager->persist($image2);
        $manager->persist($image3);
        $manager->flush();
    }

    public function getOrder()
    {
        return 2;
    }
}