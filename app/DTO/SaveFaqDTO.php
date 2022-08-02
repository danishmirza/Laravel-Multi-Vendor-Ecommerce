<?php


namespace App\DTO;


use App\Http\Requests\SaveFaqRequest;
use Spatie\DataTransferObject\DataTransferObject;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class SaveFaqDTO extends DataTransferObject
{
    public int $id = 0;
    public array $question = ['en'=>'', 'ar'=>''];
    public array $answer = ['en'=>'', 'ar'=>''];

    public function __construct($args)
    {
        parent::__construct($args);
    }

    public static function fromRequest(SaveFaqRequest $params): self
    {
        $self = collect([
            'question' => $params->input('question', ['en'=>'', 'ar'=>'']),
            'answer' => $params->input('answer', ['en'=>'', 'ar'=>''])
        ]);
        return new self($self->toArray());
    }
}
