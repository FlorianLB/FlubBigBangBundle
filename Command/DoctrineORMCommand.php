<?php

namespace Flub\BigBangBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

/**
 * @author Florian Vilpoix
 */
abstract class DoctrineORMCommand extends ContainerAwareCommand
{
    protected function getKernel()
    {
        return $this->getApplication()->getKernel();
    }

    protected function generateSchema()
    {
        $em = $this->getContainer()->get('doctrine')->getManager();
        $metadatas = $em->getMetadataFactory()->getAllMetadata();

        if (!empty($metadatas)) {
            $tool = new \Doctrine\ORM\Tools\SchemaTool($em);
            $tool->dropDatabase();
            $tool->dropSchema($metadatas);
            $tool->createSchema($metadatas);
        }
    }

    protected function emptyDatabase()
    {
        $tools = $this->getContainer()->get('bigbang.doctrine.mysql.tools');
        $tools->truncateAll();
    }
}
