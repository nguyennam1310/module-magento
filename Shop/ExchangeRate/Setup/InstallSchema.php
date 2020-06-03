<?php


namespace Shop\ExchangeRate\Setup;

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
            ->newTable($setup->getTable('shop_exchangerate'))
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
                'eur',
                Table::TYPE_DECIMAL,'10,4',
                
                [
                    'nullable' => true
                  
                ]
            )
            ->addColumn(
                'aud',
                Table::TYPE_DECIMAL,'10,4',
                
                [
                    'nullable' => true
                   
                ]
            )
            ->addColumn(
                'chf',
                Table::TYPE_DECIMAL,'10,4',
                [
                    'nullable' => true
                  
                ]
            )
            ->addColumn(
                'cny',
                Table::TYPE_DECIMAL,'10,4',
                [
                    'nullable' => true
               
                ]
            )
               ->addColumn(
                'gbp',
                Table::TYPE_DECIMAL,'10,4',
                [
                    'nullable' => true
                  
                ]
            )
                  ->addColumn(
                'rub',
                Table::TYPE_DECIMAL,'10,4',
                [
                    'nullable' => true
                
                ]
            )
                ->addColumn(
                'jpy',
               Table::TYPE_DECIMAL,'10,4',
                [
                    'nullable' => true
               
                ]
            )
                ->addColumn(
                'cad',
               Table::TYPE_DECIMAL,'10,4',
                [
                    'nullable' => true
                 
                ]
            )
           ->addColumn(
                'vnd',
               Table::TYPE_DECIMAL,'10,4',
                [
                    'nullable' => true
                
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
