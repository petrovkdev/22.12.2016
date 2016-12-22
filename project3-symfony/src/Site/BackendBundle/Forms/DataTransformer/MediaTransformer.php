<?php

namespace Site\BackendBundle\Forms\DataTransformer;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class MediaTransformer implements DataTransformerInterface
{
    private $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }


    public function transform($photoDayMedia)
    {
        if (!$photoDayMedia) {
            return null;
        }

        $media = $this->manager
            ->getRepository('ApplicationSonataMediaBundle:Media')

            ->find($photoDayMedia)
        ;

        if (null === $media) {

            throw new TransformationFailedException(sprintf(
                'An issue with number "%s" does not exist!',
                $photoDayMedia
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