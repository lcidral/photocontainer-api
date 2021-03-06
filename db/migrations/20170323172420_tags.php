<?php

use Phinx\Migration\AbstractMigration;

class Tags extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $categories = $this->table('tag_categories');
        $categories
            ->addColumn('description', 'string', ['limit' => 250, 'null' => true])
            ->addColumn('created_at', 'timestamp')
            ->addColumn('updated_at', 'timestamp', ['null' => true])
            ->create();

        $categories = $this->table('tags');
        $categories
            ->addColumn('tag_category_id', 'integer')
            ->addForeignKey('tag_category_id', 'tag_categories', 'id', ['delete'=> 'RESTRICT', 'update'=> 'NO_ACTION'])
            ->addColumn('description', 'string', ['limit' => 250, 'null' => true])
            ->addColumn('created_at', 'timestamp')
            ->addColumn('updated_at', 'timestamp', ['null' => true])
            ->create();
    }
}
