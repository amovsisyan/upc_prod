<?php
/**
 * Created by PhpStorm.
 * User: art
 * Date: 11/24/18
 * Time: 10:59 AM
 */

namespace App\Services;


use App\Models\Attachment;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AttachmentService extends BasicService
{
    public function __construct
    (
        Attachment $attachmentModel
    )
    {
        $this->model = $attachmentModel;
    }


    /**
     * @param array $storeData
     * @return Collection|null
     */
    public function store(array $storeData): ?Collection
    {
        $newOnes = array();
        $videos = $storeData['videos'] ?? array();
        $images = $storeData['images'] ?? array();
        $files = array_merge($videos, $images);

        foreach ($files as $file) {
            $fileName = $this->makeFileName($file->getClientOriginalExtension());
            $storeDatum  =array(
                'product_id' => $storeData['product_id'],
                'path' => $storeData['product_id'] . '/' . $fileName,
            );

            $newOne = $this->model->create($storeDatum);

            $newOnes[] = $newOne;

            Storage::disk('productAttachments')->put(
                '/' . $storeData['product_id'] . '/' . $fileName,
                File::get($file),
                'public'
            ); // todo put in mutators after
        }

        return collect($newOnes);
    }

    /**
     * @param int $id
     * @return Attachment|null
     */
    public function getById(int $id): ?Attachment
    {
        return $this->model->find($id);
    }

    /**
     * @param int $id
     * @return bool
     * @throws \Exception
     */
    public function delete(int $id): bool
    {
        $attachment = $this->getById($id);

        Storage::disk('productAttachments')->delete($attachment->getPath());// todo put in mutators after

        return parent::delete($id);
    }

    /**
     * @param string $extension
     * @return string
     */
    private function makeFileName(string $extension): string
    {
        return md5(microtime()).'.'.$extension;
    }
}