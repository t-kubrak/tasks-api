<?php

namespace App\Jobs;

use App\Image as ImageRecord;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProcessImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private const PATH_IMAGES_DESKTOP = 'app/images/desktop/';
    private const PATH_IMAGES_MOBILE = 'app/images/mobile/';

    private string $imageTempFilePath;

    private int $taskId;

    public function __construct(string $imageTempFilePath, int $taskId)
    {
        $this->imageTempFilePath = $imageTempFilePath;
        $this->taskId = $taskId;
    }

    /**
     * @throws \Exception
     */
    public function handle(): void
    {
        try {
            if (!Storage::exists('images/desktop')) {
                Storage::makeDirectory('images/desktop');
            }

            if (!Storage::exists('images/mobile')) {
                Storage::makeDirectory('images/mobile');
            }

            $img = Image::make($this->imageTempFilePath);

            $img->fit(1280, 720);

            $pathDesktop = storage_path(self::PATH_IMAGES_DESKTOP . $img->basename);
            $img->save($pathDesktop);

            $img->fit(640, 360);

            $pathMobile = storage_path(self::PATH_IMAGES_MOBILE . $img->basename);
            $img->save($pathMobile);

            DB::beginTransaction();

            $imageRecord = new ImageRecord();
            $imageRecord->task_id = $this->taskId;
            $imageRecord->path_desktop = $pathDesktop;
            $imageRecord->path_mobile = $pathMobile;
            $imageRecord->save();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        } finally {
            unlink($this->imageTempFilePath);
        }
    }
}
