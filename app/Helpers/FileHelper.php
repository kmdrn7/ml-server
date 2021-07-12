<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class FileHelper
{
    public static function toRupiah($uang)
    {
        return 'Rp'.number_format($uang, 0, ',', '.');
    }

    public static function upload($file, $dir, $name, $w, $h)
    {
        $time = Carbon::now();
        $extension = $file->getClientOriginalExtension();
        $filename = Str::slug($name).'-'.date_format($time, 'd').rand(1, 9).date_format($time, 'h').'.'.$extension;
        $location = $dir.'/'.$filename;
        $img = Image::make($file->getRealPath());
        $img = $img->resize($w, $h, function ($cons) {
            $cons->aspectRatio();
        })->stream($extension);

        Storage::disk(config('filesystem.default'))->put($location, $img);

        return $filename;
    }

    public static function rawUpload($file, $dir, $name)
    {
        $time = Carbon::now();
        $extension = $file->getClientOriginalExtension();
        $filename = Str::slug($name).'-'.date_format($time, 'd').rand(1, 9).date_format($time, 'h').'.'.$extension;
        $location = $dir.'/'.$filename;

        $up = Storage::disk(config('filesystem.default'))->put($location, File::get($file->getRealPath()));

        return $filename;
    }

    public static function delete($path)
    {
        if (Storage::disk(config('filesystem.default'))->exists($path)) {
            Storage::disk(config('filesystem.default'))->delete($path);
            return true;
        }

        return false;
    }
}