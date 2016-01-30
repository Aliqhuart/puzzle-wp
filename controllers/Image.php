<?php

namespace App;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Symfony\Component\HttpFoundation\File\File as SymfonyFile;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use \Image as ImageLib;

/**
 * App\Image
 *
 * @property integer $id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $original
 * @property string $hash
 * @property string $extension
 * @method static \Illuminate\Database\Query\Builder|\App\Image whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Image whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Image whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Image whereOriginal($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Image whereHash($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Image whereExtension($value)
 * @property integer $width
 * @property integer $height
 * @method static \Illuminate\Database\Query\Builder|\App\Image whereWidth($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Image whereHeight($value)
 */
class Image extends EloquentModel {
    protected $table = 'images';
    protected $guarded = [];
//    protected $fillable = ['*'];

    protected static $allowedMimes = [
        'image/jpeg',
        // 'image/bmp', // Not supported by standard GD Library
        'image/png',
        'image/gif',
    ];

    /**
     * Get the entire image, without editing
     * @return string
     */
    public function getFull() {
        $filePath = $this->getPath();
        if (\File::exists($filePath)) {
            return \File::get($filePath);
        }
        return '';
    }

    public function getCropFit($rawOptions) {
        $options = array_only($rawOptions, [
            'width',
            'height',
        ]);

        if (empty($options)) {
            return $this->getFull();
        }
        $fitName = $this->hash . '-' . urlencode(\GuzzleHttp\Psr7\build_query($options)) . '.' . $this->extension;

        $fitPath = storage_path("images/fit/$fitName");

        if (\File::exists($fitPath)) {
            return \File::get($fitPath);
        }

        $img = ImageLib::make($this->getPath());
        $newWidth = array_get($options, 'width', $img->width());
        $newHeight = array_get($options, 'height', $img->height());
        $img->fit($newWidth, $newHeight);

        $img->save($fitPath);

        return \File::get($fitPath);
    }

    public function getFit($rawOptions) {
        $options = array_only($rawOptions, [
            'width',
            'height',
        ]);

        if (empty($options)) {
            return $this->getFull();
        }
        $fitName = $this->hash . '-' . urlencode(\GuzzleHttp\Psr7\build_query($options)) . '.' . $this->extension;

        $fitPath = storage_path("images/fit/$fitName");

        if (\File::exists($fitPath)) {
            return \File::get($fitPath);
        }

        $img = ImageLib::make($this->getPath());
        $newWidth = array_get($options, 'width', null);
        $newHeight = array_get($options, 'height', null);
        if ($newWidth ) {
            if ($newHeight) {
                // both width and height
                $img->fit($newWidth, $newHeight);
            } else {
                // Only Width
                $img->widen($newWidth);
            }
        } else if ($newHeight){
            // only height
            $img->heighten($newHeight);
        }

        $img->save($fitPath);

        return \File::get($fitPath);
    }

    /**
     * Get image mime type
     * @return string
     */
    public function getMime() {
        $filePath = $this->getPath();
        if (\File::exists($filePath)) {
            return \File::mimeType($filePath);
        }
        return 'unknown/unknown';
    }

    /**
     * Get file system path of the image ("storage/images/{hash}.{extension})
     * @return string
     */
    public function getPath() {
        return storage_path('images' . DIRECTORY_SEPARATOR . $this->hash . '.' . $this->extension);

    }

    /**
     * Construct the file URL, based on options
     * @param array $options
     * @return string
     */
    public function url ($options = []) {
        if (!empty($options)) {
            return Http\Controllers\ImagesController::action('getFit', [$this->hash]). '?' . http_build_query($options);

        }
        return Http\Controllers\ImagesController::action('getFull', [$this->hash]). '?' . http_build_query($options);
    }

    /**
     * Create record based on input and save untouched file in storage/images
     * @param UploadedFile $file
     * @return static
     * @throws Exception
     */
    public static function createFromInput(UploadedFile $file) {
        if (!in_array($file->getMimeType(), static::$allowedMimes)) {
            throw new Exception("Invalid mime type");
        }

        $newFileName = static::count() . md5(str_random());
        $newExtension = $file->guessExtension();

        $img = ImageLib::make($file)->save(storage_path('images') . DIRECTORY_SEPARATOR . $newFileName . '.' . $newExtension);
        try {
            $dbImage = new Image([
                'original' => $file->getClientOriginalName(),
                'hash' => $newFileName,
                'extension' => $newExtension,
                'width' => $img->width(),
                'height' => $img->height(),
            ]);
            $dbImage->save();

        } catch (\Exception $ex) {
            dd ($ex);
        }
        return $dbImage;
    }

    public static function hash_url($hash){
        $args = array_slice(func_get_args(), 1);

        $img = static::whereHash($hash)->first();

        return call_user_func_array([$img, 'url'], $args);
    }
}
