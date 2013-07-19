<?php

namespace Flub\BigBangBundle\Doctrine\Mysql;

use Doctrine\Common\Persistence\ObjectManager;

/**
 * @author Florian Vilpoix
 */
class DatabaseTools
{
    /**
     * @var Doctrine\Common\Persistence\ObjectManager
     */
    protected $om;

    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $connection;

    /**
     * @var array
     */
    protected $truncatedTables;

    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
        $this->connection = $om->getConnection();
    }

    protected function reset()
    {
        $this->truncatedTables = array();
    }

    public function truncateAll()
    {
        $this->truncateMetadatas($this->om->getMetadataFactory()->getAllMetadata());
    }

    /**
     * @param array $entitiesNames list of full qualified class names
     */
    public function truncateEntities(array $entitiesNames)
    {
        $metadatas = array();
        foreach ($entitiesNames as $entity) {
            $metadatas[] = $this->om->getMetadataFactory()->getMetadataFor($entity);
        }

        $this->truncateMetadatas($metadatas);
    }

    /**
     * @param iterable $metadatas list of \Doctrine\ORM\Mapping\ClassMetadata
     * @throws \Horyou\Bundle\CoreBundle\Doctrine\Exception
     */
    public function truncateMetadatas($metadatas)
    {
        $this->reset();

        $this->connection->beginTransaction();
        try {
            $this->connection->executeUpdate("SET FOREIGN_KEY_CHECKS=0;");

            /* @var $classMetadata \Doctrine\ORM\Mapping\ClassMetadata */
            foreach ($metadatas as $classMetadata) {
                if ($classMetadata->isMappedSuperclass === false) {

                    $this->truncateTable($classMetadata->getTableName());

                    foreach ($classMetadata->getAssociationMappings() as $field) {
                        if (isset($field['joinTable']) && isset($field['joinTable']['name'])) {
                            $this->truncateTable($field['joinTable']['name']);
                        }
                    }
                }
            }

            $this->connection->executeUpdate("SET FOREIGN_KEY_CHECKS=1;");
            $this->connection->commit();
        }
        catch (\Exception $e) {
            $this->connection->rollback();
            throw $e;
        }
    }

    protected function truncateTable($tableName)
    {
        if (!in_array($tableName, $this->truncatedTables)) {

            $query = $this->connection->getDatabasePlatform()->getTruncateTableSql($tableName, true);
            $this->connection->executeUpdate($query);
            $this->truncatedTables[] = $tableName;
        }
    }
}
