<?php

use App\Models\Genre;
use App\Models\Video;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class VideoSeeder extends Seeder
{

    private $allGenres;
    private $relations = [
        'genres_id' => [],
        'categories_id' => []
    ];

    public function run()
    {

        $dir = Storage::getDriver()->getAdapter()->getPathPrefix();

        File::deleteDirectory($dir, true);

        $self = $this;

        $this->allGenres = Genre::all();

        Model::reguard();

        factory(Video::class, 100)->make()->each(function (Video $video) use ($self) {
            $self->fetchRelations();
            Video::create(
                array_merge(
                    $video->toArray(),
                    [
                        'thumb_file' => $self->getImageFile(),
                        'banner_file' => $self->getImageFile(),
                        'video_file' => $self->getVideoFile(),
                        'trailer_file' => $self->getVideoFile(),
                    ],
                    $this->relations
                )
            );
        });
        Model::unguard();
    }

    public function fetchRelations()
    {
        $subGenres = $this->allGenres->random(5)->load('categories');
        $categoriesId = [];
        foreach ($subGenres as $genre) {
            array_push($categoriesId, ...$genre->categories->pluck('id')->toArray());
        }
        $categoriesId = array_unique($categoriesId);
        $genresId = $subGenres->pluck('id')->toArray();
        $this->relations['categories_id'] = $categoriesId;
        $this->relations['genres_id'] = $genresId;
    }

    public function getImageFile()
    {
        return new UploadedFile(storage_path('faker/thumbs/trator.png'), 'trator.png');
    }

    public function getVideoFile()
    {
        return new UploadedFile(storage_path('faker/videos/video.mp4'), 'video.mp4');
    }
}
