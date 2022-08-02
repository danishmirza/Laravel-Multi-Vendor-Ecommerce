<?php


namespace App\Services;


use App\Libraries\DataTable;
use App\Models\Ad;
use App\Models\Article;
use App\Models\Coupon;
use App\Models\Faq;
use App\Models\Package;
use App\Models\Page;
use App\Models\Service;
use App\Models\Setting;
use App\Models\StoreArea;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;

class DatatableService
{
    public function pagesDatatable()
    {
        $columns = [
            ['db' => 'id', 'dt' => 'id'],
            ['db' => 'slug', 'dt' => 'slug'],
            ['db' => 'page_type', 'dt' => 'page_type'],
            ['db' => 'name', 'dt' => 'name'],
            ['db' => 'content', 'dt' => 'content'],
        ];
        DataTable::init(new Page, $columns);
        DataTable::where('page_type', '=', 'page');
        $pages = DataTable::get();
        $start = 1;
        if ($pages['meta']['start'] > 0 && $pages['meta']['page'] > 1) {
            $start = $pages['meta']['start'] + 1;
        }
        $count = $start;
        if (sizeof($pages['data']) > 0) {
            $dateFormat = config('settings.date-format');
            foreach ($pages['data'] as $key => $page) {
                $pages['data'][$key]['count'] = $count++;
                $pages['data'][$key]['en_title'] = $page['name']['en'];
                $pages['data'][$key]['ar_title'] = '';
                if (isset($page['name']['ar'])) {
                    $pages['data'][$key]['ar_title'] = $page['name']['ar'];
                }
                $pages['data'][$key]['slug'] = '';
                $pages['data'][$key]['actions'] = '<a href="' . route('admin.dashboard.pages.edit', $page['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="fa fa-fw fa-edit"></i></a>';
                $pages['data'][$key]['slug'] = $page['slug'];
            }
        }
        return $pages;
    }

    public function settingsDatatable()
    {
        $columns = [
            ['db' => 'id', 'dt' => 'id'],
            ['db' => 'setting_key', 'dt' => 'key'],
            ['db' => 'setting_value', 'dt' => 'value'],
        ];
        DataTable::init(new Setting(), $columns);
        DataTable::orderBy('id', 'asc');
        $settings = DataTable::get();
        $start = 1;
        if ($settings['meta']['start'] > 0 && $settings['meta']['page'] > 1) {
            $start = $settings['meta']['start'] + 1;
        }
        $count = $start;
        if (sizeof($settings['data']) > 0) {
            foreach ($settings['data'] as $key => $setting) {
                $settings['data'][$key]['count'] = $count++;
                $settings['data'][$key]['actions'] = '<a href="' . route('admin.dashboard.settings.edit', $setting['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="fa fa-fw fa-edit"></i></a>';
            }
        }
        return $settings;
    }

    public function articlesDatatable(){
        $columns = [
            ['db' => 'id', 'dt' => 'id'],
            ['db' => 'slug', 'dt' => 'slug'],
            ['db' => 'title', 'dt' => 'title'],
            ['db' => 'author', 'dt' => 'author'],
        ];
        DataTable::init(new Article(), $columns);
        $name = request('datatable.query.heading', '');
        if (!empty($name)) {
            DataTable::where('title', 'LIKE', '%' . addslashes($name) . '%');
        }
        $articles = DataTable::get();
        $start = 1;
        if ($articles['meta']['start'] > 0 && $articles['meta']['page'] > 1) {
            $start = $articles['meta']['start'] + 1;
        }
        $count = $start;
        if (sizeof($articles['data']) > 0) {
            foreach ($articles['data'] as $key => $data) {
                $data['count'] = $count++;
                $data['title'] = $data['title']['en'];
                $data['author'] = $data['author']['en'];
                $data['actions'] = '<a href="' . route('admin.dashboard.articles.edit', $data['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="fa fa-fw fa-edit"></i></a>' .
                    '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-record-button" href="javascript:{};" data-url="' . route('admin.dashboard.articles.destroy', $data['id']) . '" title="Delete"><i class="fa fa-fw fa-trash-o"></i></a>';

                $articles['data'][$key] = $data;
            }
        }
        return $articles;
    }

    public function faqsDatatable(){
        $columns = [
            ['db' => 'id', 'dt' => 'id'],
            ['db' => 'question', 'dt' => 'question'],
        ];
        DataTable::init(new Faq(), $columns);
        $name = request('datatable.query.heading', '');

        if (!empty($name)) {
            DataTable::where('title', 'LIKE', '%' . addslashes($name) . '%');
        }
        $faqs = DataTable::get();
        $start = 1;
        if ($faqs['meta']['start'] > 0 && $faqs['meta']['page'] > 1) {
            $start = $faqs['meta']['start'] + 1;
        }
        $count = $start;
        if (sizeof($faqs['data']) > 0) {
            foreach ($faqs['data'] as $key => $data) {
                $data['count'] = $count++;
                $data['question'] = $data['question']['en'];
                $data['actions'] = '<a href="' . route('admin.dashboard.faqs.edit', $data['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="fa fa-fw fa-edit"></i></a>' .
                    '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-record-button" href="javascript:{};" data-url="' . route('admin.dashboard.faqs.destroy', $data['id']) . '" title="Delete"><i class="fa fa-fw fa-trash-o"></i></a>';

                $faqs['data'][$key] = $data;
            }
        }
        return $faqs;
    }

    public function packageDatatable($type){
        $columns = [
            ['db' => 'id', 'dt' => 'id'],
            ['db' => 'title', 'dt' => 'title'],
            ['db' => 'duration', 'dt' => 'duration'],
            ['db' => 'duration_type', 'dt' => 'duration_type'],
            ['db' => 'package_type', 'dt' => 'package_type'],
            ['db' => 'is_free', 'dt' => 'is_free'],
            ['db' => 'price', 'dt' => 'price'],
        ];
        DataTable::init(new Package(), $columns);
        DataTable::where('package_type', '=', $type);

        $articles = DataTable::get();
        $start = 1;
        if ($articles['meta']['start'] > 0 && $articles['meta']['page'] > 1) {
            $start = $articles['meta']['start'] + 1;
        }
        $count = $start;

        if (sizeof($articles['data']) > 0) {
            foreach ($articles['data'] as $key => $article) {
                $articles['data'][$key]['count'] = $count++;
                $articles['data'][$key]['title'] = ucwords($article['title']['en']);
                $articles['data'][$key]['duration'] = $article['duration'].' '.$article['duration_type'];
//                $articles['data'][$key]['duration_type'] = $article['duration_type'];
                $articles['data'][$key]['price'] = $article['price'];
                $articles['data'][$key]['actions'] = '<a href="' . route('admin.dashboard.packages.edit', ['id' =>$article['id'], 'type' => $article['package_type']] ) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="fa fa-fw fa-edit"></i></a>' .
                    '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-article-button" href="javascript:{};" data-url="' . route('admin.dashboard.packages.destroy', $article['id']) . '" title="Delete"><i class="fa fa-fw fa-trash-o"></i></a>';

            }
        }
        return $articles;
    }

    public function userDatatable(){
        $columns = [
            ['db' => 'id', 'dt' => 'id'],
            ['db' => 'name', 'dt' => 'name'],
            ['db' => 'email', 'dt' => 'email'],
            ['db' => 'phone', 'dt' => 'phone'],
            ['db' => 'is_active', 'dt' => 'is_active'],
            ['db' => 'email_verified', 'dt' => 'email_verified'],
        ];
        DataTable::init(new User(), $columns);
        DataTable::where('user_type', '=', User::$USER);
        $email = \request('datatable.query.email', null);
        $title = \request('datatable.query.name', null);
        $activeStatus = \request('datatable.query.activeStatus', null);
        $verificationStatus = \request('datatable.query.verificationStatus', null);

        if (!is_null($verificationStatus)) {
            DataTable::where('email_verified', '=', $verificationStatus);
        }
        if (!is_null($activeStatus)) {
            DataTable::where('is_active', '=', $activeStatus);
        }
        if (!is_null($title)) {
            DataTable::where('name', 'LIKE', '%'.$title.'%');
        }
        if (!is_null($email)) {
            DataTable::where('email', 'like', '%' . addslashes($email) . '%');
        }
        $user = DataTable::get();
        $start = 1;
        if ($user['meta']['start'] > 0 && $user['meta']['page'] > 1) {
            $start = $user['meta']['start'] + 1;
        }
        $count = $start;
        if (sizeof($user['data']) > 0) {
            foreach ($user['data'] as $key => $data) {
                $user['data'][$key]['id'] = $count++;
                $user['data'][$key]['is_active'] = $data['is_active'] == 1;
                $user['data'][$key]['email_verified'] = $data['email_verified'] == 1;
                $user['data'][$key]['actions'] = '<a href="' . route('admin.dashboard.users.edit', $data['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="fa fa-fw fa-edit"></i></a>' .
                    '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-record-button" href="javascript:{};" data-url="' . route('admin.dashboard.users.destroy', $data['id']) . '" title="Delete"><i class="fa fa-fw fa-trash-o"></i></a>';
            }
        }

        return $user;
    }

    public function storeDatatable(){
        $columns = [
            ['db' => 'id', 'dt' => 'id'],
            ['db' => 'store_name', 'dt' => 'store_name'],
            ['db' => 'email', 'dt' => 'email'],
            ['db' => 'phone', 'dt' => 'phone'],
            ['db' => 'is_active', 'dt' => 'is_active'],
            ['db' => 'email_verified', 'dt' => 'email_verified'],
            ['db' => 'trade_license_verified', 'dt' => 'trade_license_verified'],
        ];
        DataTable::init(new User(), $columns);
        DataTable::where('user_type', '=', User::$STORE);
        $email = \request('datatable.query.email', null);
        $titleEn = \request('datatable.query.titleEn', null);
        $titleAr = \request('datatable.query.titleAr', null);
        $activeStatus = \request('datatable.query.activeStatus', null);
        $verificationStatus = \request('datatable.query.verificationStatus', null);
        $tradeLicenseStatus = \request('datatable.query.tradeLicenseStatus', null);

        if (!is_null($verificationStatus)) {
            DataTable::where('email_verified', '=', $verificationStatus);
        }
        if (!is_null($tradeLicenseStatus)) {
            DataTable::where('trade_license_verified', '=', $tradeLicenseStatus);
        }
        if (!is_null($activeStatus)) {
            DataTable::where('is_active', '=', $activeStatus);
        }
        if (!is_null($titleEn)) {
            DataTable::where('store_name->en', 'LIKE', '%'.$titleEn.'%');
        }
        if (!is_null($titleAr)) {
            DataTable::where('store_name->ar', 'LIKE', '%'.$titleAr.'%');
        }
        if (!is_null($email)) {
            DataTable::where('email', 'like', '%' . addslashes($email) . '%');
        }
        $user = DataTable::get();
        $start = 1;
        if ($user['meta']['start'] > 0 && $user['meta']['page'] > 1) {
            $start = $user['meta']['start'] + 1;
        }
        $count = $start;
        if (sizeof($user['data']) > 0) {
            foreach ($user['data'] as $key => $data) {
                $user['data'][$key]['id'] = $count++;
                $user['data'][$key]['title_en'] = $data['store_name']['en'];
                $user['data'][$key]['title_ar'] = $data['store_name']['ar'];
                $user['data'][$key]['is_active'] = $data['is_active'] == 1;
                $user['data'][$key]['email_verified'] = $data['email_verified'] == 1;
                $user['data'][$key]['trade_license_verified'] = $data['trade_license_verified'] == 1;
                $user['data'][$key]['actions'] = '<div><a href="' . route('admin.dashboard.stores.edit', ['store' => $data['id']]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="fa fa-fw fa-edit"></i></a>' .
                    '<div class="m-dropdown m-dropdown--inline  m-dropdown--arrow" data-dropdown-toggle="click">
															<a href="#" class="m-portlet__nav-link m-dropdown__toggle btn m-btn m-btn--link">
																<i class="la la-ellipsis-h"></i>
															</a>
															<div class="m-dropdown__wrapper">
																<span class="m-dropdown__arrow m-dropdown__arrow--left"></span>
																<div class="m-dropdown__inner">
																	<div class="m-dropdown__body">
																		<div class="m-dropdown__content">
																			<ul class="m-nav">
																				<li class="m-nav__item">
																					<a href="' . route('admin.dashboard.stores.areas.index', ['store' => $data['id']]) . '"  class="m-nav__link">
																						<i class="m-nav__link-icon fa fa-arrow-right"></i>
																						<span class="m-nav__link-text">
																							Delivery Areas
																						</span>
																					</a>
																				</li>
																				<li class="m-nav__item">
																					<a href="' . route('admin.dashboard.stores.services.index', ['store' => $data['id']]).'" class="m-nav__link">
																						<i class="m-nav__link-icon fa fa-arrow-right"></i>
																						<span class="m-nav__link-text">
																							Services
																						</span>
																					</a>
																				</li>
																				<li class="m-nav__item">
																					<a href="' . route('admin.dashboard.stores.ads.index', ['store' => $data['id']]) . '" class="m-nav__link">
																						<i class="m-nav__link-icon fa fa-arrow-right"></i>
																						<span class="m-nav__link-text">
																							Ads
																						</span>
																					</a>
																				</li>
																				<li class="m-nav__item">
																					<a href="' . route('admin.dashboard.stores.portfolio.index', ['store' => $data['id']]) . '" class="m-nav__link">
																						<i class="m-nav__link-icon fa fa-arrow-right"></i>
																						<span class="m-nav__link-text">
																							Portfolio
																						</span>
																					</a>
																				</li>
																				<li class="m-nav__item">
																					<a class="m-nav__link delete-record-button" href="javascript:{};" data-url="' . route('admin.dashboard.stores.destroy', ['store' => $data['id']]) . '">
																						<i class="m-nav__link-icon fa fa-arrow-right"></i>
																						<span class="m-nav__link-text">
																							Delete
																						</span>
																					</a>
																				</li>
																			</ul>
																		</div>
																	</div>
																</div>
															</div>
														</div>
														</div>';



//
//                    '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" href="' . route('admin.dashboard.stores.areas.index', ['store' => $data['id']]) . '" title="Delivery Areas">Delivery Areas</a>'.
//                    '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill" href="' . route('admin.dashboard.stores.services.index', ['store' => $data['id']]) . '" title="Services">Services</a>'.
//                    '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill " href="' . route('admin.dashboard.stores.portfolio.index', ['store' => $data['id']]) . '" title="Portfolio">Portfolio</a>'.
//                    '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill " href="' . route('admin.dashboard.stores.ads.index', ['store' => $data['id']]) . '" title="Ads">Ads</a>';
            }
        }

        return $user;
    }

    public function storeAreasDatatable($storeId)
    {
        $columns = [
            ['db' => 'id', 'dt' => 'id'],
            ['db' => 'area_id', 'dt' => 'area_id'],
            ['db' => 'store_id', 'dt' => 'store_id'],
            ['db' => 'price', 'dt' => 'price'],
        ];
        DataTable::init(new StoreArea(), $columns);
        DataTable::where('store_id', '=', $storeId);
        DataTable::with('area');
        $areas = DataTable::get();
        $start = 1;
        if ($areas['meta']['start'] > 0 && $areas['meta']['page'] > 1) {
            $start = $areas['meta']['start'] + 1;
        }
        $count = $start;
        if (sizeof($areas['data']) > 0) {
            foreach ($areas['data'] as $key => $area) {
                $areas['data'][$key]['count'] = $count++;
                $areas['data'][$key]['area'] = $area['area']['title']['en'];
                $areas['data'][$key]['actions'] = '<a href="' . route('admin.dashboard.stores.areas.edit', ['store' => $area['store_id'], 'area'=> $area['id']]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="fa fa-fw fa-edit"></i></a>' .
                    '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-record-button" href="javascript:{};" data-url="' . route('admin.dashboard.stores.areas.destroy', ['store' => $area['store_id'], 'area'=> $area['id']]) . '" title="Delete"><i class="fa fa-fw fa-trash-o"></i></a>';
            }
        }
        return $areas;
    }

    public function servicesDatatable($storeId){
        $columns = [
            ['db' => 'id', 'dt' => 'id'],
            ['db' => 'store_id', 'dt' => 'store_id'],
            ['db' => 'title', 'dt' => 'title'],
            ['db' => 'price', 'dt' => 'price'],
            ['db' => 'has_offer', 'dt' => 'has_offer'],
            ['db' => 'discount_percentage', 'dt' => 'discount_percentage'],
            ['db' => 'is_active', 'dt' => 'is_active'],
        ];
        DataTable::init(new Service(), $columns);
        if($storeId > 0){
            DataTable::where('store_id', '=', $storeId);
        }else{
            DataTable::with('store');
        }
        $titleEn = \request('datatable.query.titleEn', null);
        $activeStatus = \request('datatable.query.activeStatus', null);
        $discountStatus = \request('datatable.query.discountStatus', null);

        if (!is_null($discountStatus)) {
            DataTable::where('has_offer', '=', $discountStatus);
        }
        if (!is_null($activeStatus)) {
            DataTable::where('is_active', '=', $activeStatus);
        }
        if (!is_null($titleEn)) {
            DataTable::where('title->en', 'LIKE', '%'.$titleEn.'%');
        }

        $services = DataTable::get();
        $start = 1;
        if ($services['meta']['start'] > 0 && $services['meta']['page'] > 1) {
            $start = $services['meta']['start'] + 1;
        }
        $count = $start;
        if (sizeof($services['data']) > 0) {
            foreach ($services['data'] as $key => $data) {
                $data['count'] = $count++;
                $data['title'] = $data['title']['en'];
                if($storeId == 0){
                    $data['store'] = $data['store']['store_name']['en'];
                }
                $data['price'] = strtoupper(env('BASE_CURRENCY')).$data['price'];
                $data['discount_percentage'] = (!is_null($data['discount_percentage'])) ? $data['discount_percentage'].'%' : 'No Discount';
                $data['has_offer'] = $data['has_offer'] == 1;
                $data['is_active'] = $data['is_active'] == 1;
                $data['actions'] = '<a href="' . route('admin.dashboard.stores.services.edit', ['store' => $data['store_id'], 'service' => $data['id']]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="fa fa-fw fa-edit"></i></a>' .
                    '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-record-button" href="javascript:{};" data-url="' . route('admin.dashboard.stores.services.destroy', ['store' => $data['store_id'], 'service' => $data['id']]) . '" title="Delete"><i class="fa fa-fw fa-trash-o"></i></a>';


                $services['data'][$key] = $data;
            }
        }
        return $services;
    }

    public function storeAdDatatable($storeId)
    {
        $columns = [
            ['db' => 'id', 'dt' => 'id'],
            ['db' => 'title', 'dt' => 'title'],
            ['db' => 'sub_title', 'dt' => 'sub_title'],
            ['db' => 'ad_status', 'dt' => 'ad_status'],
            ['db' => 'store_id', 'dt' => 'store_id'],
        ];
        DataTable::init(new Ad(), $columns);
        if($storeId > 0){
            DataTable::where('store_id', '=', $storeId);
        }else{
            DataTable::with('store');
        }
        $areas = DataTable::get();
        $start = 1;
        if ($areas['meta']['start'] > 0 && $areas['meta']['page'] > 1) {
            $start = $areas['meta']['start'] + 1;
        }
        $count = $start;
        if (sizeof($areas['data']) > 0) {
            foreach ($areas['data'] as $key => $area) {
                $areas['data'][$key]['count'] = $count++;
                $areas['data'][$key]['title_en'] = $area['title']['en'];
                $areas['data'][$key]['sub_title_en'] = $area['title']['en'];
                $areas['data'][$key]['actions'] = '<a href="' . route('admin.dashboard.stores.ads.show', ['store' => $area['store_id'], 'ad'=> $area['id']]) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="fa fa-fw fa-eye"></i></a>';
                if($area['ad_status'] == 'pending'){
                    $areas['data'][$key]['actions'] .= '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-record-button" href="javascript:{};" data-url="' . route('admin.dashboard.stores.ads.status', ['store' => $area['store_id'], 'ad'=> $area['id'], 'status' =>'approved']) . '" title="Accepted"><i class="fa fa-fw fa-check"></i></a>'.
                    '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-record-button" href="javascript:{};" data-url="' . route('admin.dashboard.stores.ads.status', ['store' => $area['store_id'], 'ad'=> $area['id'], 'status' =>'rejected']) . '" title="Rejected"><i class="fa fa-fw fa-close"></i></a>';
                }elseif($area['ad_status'] == 'approved'){
                    $areas['data'][$key]['actions'] .= '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-record-button" href="javascript:{};" data-url="' . route('admin.dashboard.stores.ads.status', ['store' => $area['store_id'], 'ad'=> $area['id'], 'status' =>'completed']) . '" title="Completed"><i class="fa fa-fw fa-check"></i></a>';
                }
            }
        }
        return $areas;
    }

    public function couponDatabase()
    {
        $columns = [
            ['db' => 'id', 'dt' => 'id'],
            ['db' => 'name', 'dt' => 'name'],
            ['db' => 'coupon_code', 'dt' => 'coupon_code'],
            ['db' => 'discount', 'dt' => 'discount'],
            ['db' => 'end_date', 'dt' => 'end_date'],
            ['db' => 'status', 'dt' => 'status'],
            ['db' => 'coupon_type', 'dt' => 'coupon_type'],
            ['db' => 'coupon_number', 'dt' => 'coupon_number'],

        ];
        DataTable::init(new Coupon(), $columns);
        $coupons = DataTable::get();
        $start = 1;
        if ($coupons['meta']['start'] > 0 && $coupons['meta']['page'] > 1) {
            $start = $coupons['meta']['start'] + 1;
        }
        $count = $start;
        if (sizeof($coupons['data']) > 0) {
            foreach ($coupons['data'] as $key => $data) {
                $coupons['data'][$key]['count'] = $count++;
                $coupons['data'][$key]['name'] = $data['name']['en'];
                $coupons['data'][$key]['coupon_code'] = $data['coupon_code'];
                $coupons['data'][$key]['discount'] = $data['discount'] . '%';
                $coupons['data'][$key]['end_date'] = Carbon::parse($data['end_date'])->format('d-m-Y');
                $coupons['data'][$key]['status'] = ucfirst($data['status']);
                $coupons['data'][$key]['coupon_type'] = $data['coupon_type'];
                $coupons['data'][$key]['coupon_number'] = $data['coupon_number'];
                if ($data['coupon_number'] <= 0 && $data['coupon_type'] == 'infinite') {
                    $coupons['data'][$key]['coupon_number'] = 'Unlimited';
                }
                $coupons['data'][$key]['actions'] = '<a href="' . route('admin.dashboard.coupons.edit', $data['id']) . '" class="m-portlet__nav-link btn m-btn m-btn--hover-accent m-btn--icon m-btn--icon-only m-btn--pill" title="Edit"><i class="fa fa-fw fa-edit"></i></a>' .
                    '<a class="m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill delete-record-button" href="javascript:{};" data-url="' . route('admin.dashboard.coupons.destroy', $data['id']) . '" title="Delete"><i class="fa fa-fw fa-trash-o"></i></a>';

            }
        }
        return $coupons;
    }
}
