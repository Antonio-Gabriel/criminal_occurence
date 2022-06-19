<?php

namespace CriminalOccurence\common;

/**
 * File.
 *
 * Upload pictures and files.
 *
 * @author Garcia Pedro <garciapedro.php@gmail.com>
 * @author Crisvan dos Santos <csdesigner.05@gmail.com>
 * @author António Gabriel <antoniocamposgabriel@gmail.com>
 */

use CriminalOccurence\common\Application;
use CriminalOccurence\common\Thumbnail;

use CriminalOccurence\utils\LinkGeneratorTrait;

class File
{
    public function __construct(
        private string $file,
        private string $dir,
        private $fileType = null,
        private ?string $targetDir = null,
        private ?string $fileName = null,
        private ?string $targetFilePath = null,

        private ?Thumbnail $thumbnail = null
    ) {
        $this->targetDir = Application::getAlias("@files") . $dir;
        $this->fileName = basename($_FILES[$this->file]["name"]);

        $this->thumbnail = new Thumbnail();
    }

    public function uploadImage(int $defaulFile = 0)
    {
        if (
            !empty($_FILES[$this->file]["name"])
        ) {
            $createdDirName = $this->createDynamicPath();
            $dynamicDir = "{$this->targetDir}{$createdDirName}/";

            // Optional, i used because in my operational system is required permitted the folder for the upload
            shell_exec("chmod -R 777 {$dynamicDir}");

            $this->targetFilePath = $dynamicDir . $this->fileName;

            $currentDir = $this->uploadAndMakeThumbnail($dynamicDir);

            if ($currentDir) {
                return strval($createdDirName);
            }
        } else {
            return $defaulFile;
        }
    }

    private function uploadAndMakeThumbnail(string $dynamicDir)
    {
        $temp = explode(".", $this->fileName);
        $newfilename = "thumbnail_large" . '.' . end($temp);
        $thumbName = str_replace("_large", "_small", $newfilename);

        $this->targetFilePath = $dynamicDir . $newfilename;

        $uploaded = move_uploaded_file(
            $_FILES[$this->file]["tmp_name"],
            $this->targetFilePath
        );

        if ($uploaded) {
            $thumbLocal = $dynamicDir . $thumbName;

            $isUpload = $this->thumbnail->createThumbnail(
                $this->targetFilePath,
                $thumbLocal,
                320
            );

            if ($isUpload) {
                return $dynamicDir;
            }
        }
    }

    private function createDynamicPath()
    {
        $folders = [];
        foreach (scandir($this->targetDir) as $file) {
            if (is_dir($file)) {
                continue;
            }

            $folders[] = (int)$file;
        }

        if (empty($folders)) {
            mkdir($this->targetDir . "1", 777, true);

            return "1";
        }

        sort($folders);

        $newFolder = strval($folders[count($folders) - 1] + 1);

        mkdir($this->targetDir . $newFolder, 777, true);

        return $newFolder;
    }

    /**
     * Get images on dir
     */
    public function getImages(string $dirName)
    {
        $folders = [];
        foreach (scandir($this->targetDir . $dirName) as $file) {
            if (is_dir($file)) {
                continue;
            }

            $thumbType = explode(".", $file);

            $folders[current($thumbType)] = LinkGeneratorTrait::generateLink($dirName, $file);
        }

        return $folders;
    }
}
