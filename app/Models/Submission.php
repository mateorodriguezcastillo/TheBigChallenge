<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use League\CommonMark\Node\Block\Document;

class Submission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'title',
        'info',
        'symptoms',
        'status',
        'file'
    ];

    protected $attributes = [
        'status' => Status::PENDING,
        'file' => null,
    ];

    /**
      * @return BelongsTo<Role>
      */
    public function patient(): BelongsTo
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    /**
      * @return BelongsTo<Role>
      */
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function setFileAttribute($value)
    {
        if ($value !== null) {
            $attribute_name = "file";
            $disk = "do_spaces";
            $destination_path = config('filesystems.disks.do_spaces.folder');
            $this->uploadFileToDisk($value, $attribute_name, $disk, $destination_path);
        }
    }

    function uploadFileToDisk($file, $attribute_name, $disk, $destination_path)
    {
        if (request()->hasFile($attribute_name)) {
            $file = request()->file($attribute_name);
            // dd($file);
            $filename = $file->getClientOriginalName();
            $path = $file->storeAs($destination_path, $filename, $disk);
            $this->attributes[$attribute_name] = $path;
        }
    }

    public function getFile($id)
    {
        $document = Document::find($id);
        $file = Storage::disk('do_spaces')->get($document->file);
        $mimetype = \GuzzleHttp\Psr7\MimeType::fromFilename($document->file);
        $headers = [
            'Content-Type' => $mimetype,
        ];
        return response($file, 200, $headers);
    }
}
