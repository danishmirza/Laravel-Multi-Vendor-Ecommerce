<?php


namespace App\DTO;


use App\Http\Requests\SaveCategoryRequest;
use Spatie\DataTransferObject\DataTransferObject;

class SaveCategoryDTO extends DataTransferObject
{
    public int $id = 0;
    public array $title = ['en'=>'', 'ar'=>''];
    public array $content = ['en'=>'', 'ar'=>''];
    public ?string $image = null;

    public function __construct($args)
    {
        parent::__construct($args);
    }

    public static function fromRequest(SaveCategoryRequest $params): self
    {
        $self = collect([
            'title' => $params->input('title', ['en'=>'', 'ar'=>'']),
            'content' => $params->input('content', ['en'=>'', 'ar'=>'']),
            'image' => $params->filled('image')? $params->input('image') : null,
        ]);
        return new self($self->toArray());
    }
}
