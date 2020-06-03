<?php


namespace Shop\Weather\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * @codeCoverageIgnore
 */
class InstallSchema implements InstallSchemaInterface
{
    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $table = $setup->getConnection()
            ->newTable($setup->getTable('shop_weather'))
            ->addColumn(
                'id',
                Table::TYPE_INTEGER,
                null,
                [
                    'identity' => true,
                    'unsigned' => true,
                    'nullable' => false,
                    'primary' => true
                ]
            )
            ->addColumn(
                'temperature',
                Table::TYPE_FLOAT,
                null,
                [
                    'nullable' => true,
                ]
            )
            ->addColumn(
                'pressure',
                Table::TYPE_INTEGER,
                null,
                [
                    'nullable' => true,
                ]
            )
            ->addColumn(
                'humidity',
                Table::TYPE_DECIMAL,
                null,
                [
                    'nullable' => true,
                ]
            )
            ->addColumn(
                'city',
                Table::TYPE_TEXT,
                255,
                [
                    'nullable' => false
                ]
            )
            ->addColumn(
                'icon',
                Table::TYPE_TEXT,
                255,
                [
                    'nullable' => false
                ]
            )
            ->addColumn(
                'description',
                Table::TYPE_TEXT,
                255,
                [
                    'nullable' => false
                ]
            )
            ->addColumn(
                'created_at',
                Table::TYPE_TIMESTAMP,
                null,
                [
                    'nullable' => false,
                    'default' => Table::TIMESTAMP_INIT
                ]
            )
        ;


        $setup->getConnection()->createTable($table);
    }
}
