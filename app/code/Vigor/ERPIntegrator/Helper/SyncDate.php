<?php
/**
 * @author Ahmed El-Araby <araby2305@gmail.com>
 */

namespace Vigor\ERPIntegrator\Helper;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\Filesystem;

class SyncDate extends AbstractHelper
{
    public const FILE_NAME = 'erp_products_sync_data';
    private $filesystem;
    private $directory;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        Filesystem $filesystem,
        Filesystem\DirectoryList $directoryList
    )
    {
        parent::__construct($context);
        $this->filesystem = $filesystem;
    }

    protected function _prepareDataForSave(array $data)
    {
        return implode('|', $data);
    }

    protected function _prepareDataForUse(string $dataString)
    {
        return explode('|', $dataString);
    }

    public function writeSyncData(array $data)
    {
        $writer = $this->filesystem->getDirectoryWrite(DirectoryList::VAR_DIR);
        $file = $writer->openFile(self::FILE_NAME, 'w');
        try {
            $file->lock();
            try {
                $file->write($this->_prepareDataForSave($data));
            } finally {
                $file->unlock();
            }
        } finally {
            $file->close();
        }
    }

    public function readSyncData()
    {
        $reader = $this->filesystem->getDirectoryRead(DirectoryList::VAR_DIR);
        $file = $reader->openFile(self::FILE_NAME);
        try {
            $data = $file->readAll();
        } finally {
            $file->close();
        }
        return $this->_prepareDataForUse($data);
    }
}
