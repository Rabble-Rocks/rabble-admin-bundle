<?php

namespace Rabble\AdminBundle\Request\ParamConverter;

use Doctrine\Common\Persistence\Mapping\MappingException;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ImplementedEntityConverter implements ParamConverterInterface
{
    private EntityManagerInterface $entityManager;

    /**
     * ImplementedEntityConverter constructor.
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function apply(Request $request, ParamConverter $configuration)
    {
        $paramValue = $request->attributes->get($configuration->getName());
        $options = $configuration->getOptions();
        if (isset($options['repository_method']) && is_string($options['repository_method'])) {
            $repositoryMethod = $options['repository_method'];
            $result = $this->entityManager->getRepository($options['entity'])->{$repositoryMethod}($paramValue);
        } elseif (isset($options['field']) && is_string($options['field'])) {
            $result = $this->entityManager->getRepository($options['entity'])->findBy([$options['field'] => $paramValue]);
            if (1 !== count($result)) {
                throw new \RuntimeException(sprintf('Expecting one result. Got %s', count($result)));
            }
            $result = $result[0];
        } else {
            $result = $this->entityManager->find($options['entity'], $paramValue);
        }
        if (!is_a($result, $configuration->getClass()) && !is_subclass_of($result, $configuration->getClass())) {
            throw new NotFoundHttpException();
        }
        $request->attributes->set($configuration->getName(), $result);
    }

    /**
     * {@inheritdoc}
     */
    public function supports(ParamConverter $configuration)
    {
        $options = $configuration->getOptions();
        if (null === $configuration->getName() || !isset($options['entity'])) {
            return false;
        }

        try {
            $this->entityManager->getMetadataFactory()->getMetadataFor($options['entity']);
        } catch (MappingException $exception) {
            return false;
        }

        return true;
    }
}
