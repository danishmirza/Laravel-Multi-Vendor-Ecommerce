<?php

namespace App\DTO;

use App\Http\Requests\SavePageRequest;
use Illuminate\Support\Str;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;


class SavePageDTO extends DataTransferObject
{

    public int $id = 0;
    public string $page_type = 'page';
    public array $name = ['en'=>'', 'ar'=>''];
    public array $content = ['en'=>'', 'ar'=>''];
    public string $slug;
    public ?string $image = null;
    public ?string $icon = null;

    public function __construct($args)
    {
        parent::__construct($args);
    }

    /**
     * @throws UnknownProperties
     */
    public static function fromRequest(SavePageRequest $params): self
    {
        $self = collect([
            'id' => $params->input('page_id'),
            'page_type' => $params->input('page_type', 'page'),
            'name' => $params->input('name', ['en'=>'', 'ar'=>'']),
            'content' => $params->input('content', ['en'=>'', 'ar'=>'']),
            'sort_order' => $params->input('sort_order', 0),
            'slug' => $params->input('slug', Str::slug($params->input('name', ['en'=>'', 'ar'=>''])['en'])),
            'image' => $params->filled('image')? $params->input('image') : null,
            'icon' => $params->filled('icon')? $params->input('icon') : null,
        ]);

        return new self($self->toArray());
    }

}
