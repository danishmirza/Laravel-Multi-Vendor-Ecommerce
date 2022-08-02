<?php


namespace App\Actions\Dashboard\Reviews;


use App\Models\ServiceReview;
use App\Models\StoreReview;
use Illuminate\Auth\Access\Response;
use Illuminate\Routing\Router;
use Illuminate\Validation\Rule;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class AddServiceReview
{
    use AsAction;

    public function handle($reviewId, $rating, $comment)
    {
        try {
            ServiceReview::where(['id' => $reviewId])->update([
                'rating' => $rating,
                'comment' => $comment,
                'is_given' => 1
            ]);
            return ['action' => 'status', 'msg' => 'Review added successfully.', 'status' => 'pending'];
        }catch (\Exception $exception){
            return ['action' => 'err', 'msg' => $exception->getMessage()];
        }
    }

    public function getControllerMiddleware(): array
    {
        return ['auth:sanctum', 'verified'];
    }

    public function authorize(ActionRequest $request): Response
    {
        if ($request->user()->isStore()) {
            return Response::deny('You are not allowed to perform this action', 404);
        }
        return Response::allow();
    }

    public function rules(){
        return [
            'review_id' => [
                'required',
                Rule::exists('service_reviews', 'id')->where('user_id', auth()->id())->where( 'is_given' , 0)
            ],
            'rating' => 'required|max:5',
            'comment' => 'required'
        ];
    }

    public function asController(ActionRequest $request)
    {

        return $this->handle($request->get('review_id'), $request->get('rating'), $request->get('comment'));
    }

    public function htmlResponse($paramters)
    {
        if($paramters['action'] == 'err'){
            return redirect()->back()->withInput()->with($paramters['action'], $paramters['msg']);
        }
        return redirect()->back()->with($paramters['action'], $paramters['msg']);
    }

    public function jsonResponse($paramters)
    {
        if($paramters['action'] == 'err'){
            return responseBuilder()->error($paramters['msg']);
        }
        return responseBuilder()->success($paramters['msg']);
    }

    public static function routes(Router $router)
    {
        $router->post('dashboard/service-reviews/add', static::class)->name('dashboard.service-reviews.add');
    }

}
