<?php


namespace App\Actions\Dashboard\StorePackage;


use App\Models\Package;
use App\Models\StorePurchasedPackage;
use Carbon\Carbon;
use Illuminate\Auth\Access\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\ActionRequest;
use Lorisleiva\Actions\Concerns\AsAction;

class AssignFeaturePackage
{
    use AsAction;

    public function handle($packageId, $service)
    {
        try {
            $storePackage = StorePurchasedPackage::where([
                'package_id' => $packageId,
                'store_id' => Auth::user()->id,
                'package_status' => 'purchased'
            ])->firstOrFail();
            $package = json_decode($storePackage->package);
            $storePackage->update(['service_id' => $service->id, 'package_status' => 'used']);
            $service->update(['package_id' => $storePackage->id, 'package_expire_on' => Carbon::now()->addDays($package->total_days)->timestamp]);
            return ['action' => 'status', 'msg' => 'Package subscribed successfully.'];
        }
        catch (ModelNotFoundException $exception){
            throw new \Exception("No package purchased");
        }catch (\Exception $exception){
            throw new \Exception($exception->getMessage());
        }
    }
}
