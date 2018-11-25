<?php
/**
 * Created by PhpStorm.
 * User: art
 * Date: 11/24/18
 * Time: 10:59 AM
 */

namespace App\Services;


use App\Helpers\FileHelper;
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
        $disk = 'productAttachments';
        $prodId = $storeData['product_id'];

        foreach ($files as $file) {
            $fileName = FileHelper::makeFileName($file->getClientOriginalExtension(), $disk);
            $storeDatum  =array(
                'product_id' => $prodId,
                'path' => $prodId . '/' . $fileName,
                'thumbnail' => FileHelper::getDimensions($file),
            );

            $newOne = $this->model->create($storeDatum);

            $newOnes[] = $newOne;

            Storage::disk($disk)->put(
                '/' . $prodId . '/' . $fileName,
                File::get($file),
                'public'
            ); // todo put in mutators after
        }

        return collect($newOnes);
    }

    /**
     * @param int $id
     * @param array $with
     * @return Attachment|null
     */
    public function getById(int $id, array $with = array()): ?Attachment
    {
        return $this->model->where('id', $id)->with($with)->first();
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
}