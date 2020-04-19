<?php

use Phinx\Migration\AbstractMigration;

class FilesTable extends AbstractMigration
{
    /**
     * Change Method.
     *
     */
    public function change()
    {
        $this->table('files')
            ->addColumn('name', 'string')
            ->addColumn('path', 'string', [ 'null' => true ])
            ->addColumn('real_location', 'string')
            ->addColumn('deleted', 'boolean', [ 'default' => false ])
            ->addTimestamps()
            ->create();
    }
}