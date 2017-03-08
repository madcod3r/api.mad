<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\Tag;

class LoadTagData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $tagNew = new Tag();
        $tagNew->setName('new');

        $hiresNew = new Tag();
        $hiresNew->setName('HiRes');

        $hqNew = new Tag();
        $hqNew->setName('HQ');

        $manager->persist($tagNew);
        $manager->persist($hiresNew);
        $manager->persist($hqNew);
        $manager->flush();

        $this->addReference('tag-new', $tagNew);
        $this->addReference('tag-hires', $hiresNew);
        $this->addReference('tag-hq', $hqNew);
    }

    public function getOrder()
    {
        return 1;
    }
}