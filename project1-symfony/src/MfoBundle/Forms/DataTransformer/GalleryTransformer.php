<?php

namespace MfoBundle\Forms\DataTransformer;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class GalleryTransformer implements DataTransformerInterface
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }


    public function transform($id)
    {
        if (!$id) {
            return null;
        }

        $media = $this->manager
            ->getRepository('ApplicationSonataMediaBundle:Gallery')

            ->find($id)
        ;

        if (null === $media) {

            throw new TransformationFailedException(sprintf(
                'An issue with number "%s" does not exist!',
                $id
            ));
        }

        return $media;
    }


    public function reverseTransform($media)
    {

        if (null === $media) {
            return null;
        }

        return $media;
    }
}