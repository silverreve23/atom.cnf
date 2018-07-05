<?php

use App\Classes\RR;

Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
    return "Cache is cleared";
});

Route::get('/5a8d48f03d1eaf2a6c8b4568.txt', function(){
		return response()->download(
            '5a8d48f03d1eaf2a6c8b4568.txt'
        );
});

Route::group(['namespace' => 'Client', 'middleware' => 'client'], function (){

	Route::any('/sitemap.xml', 'SitemapController@index');

    Route::post('/interkassa', 'Interkassa\InterkassaController@index');
    Route::post('/interkassa/success', 'Interkassa\InterkassaController@success');

    Route::get('/auto-search', 'HomeController@autoSearch');
    Route::get('/filter-category-auto-search', 'HomeController@filterCategoryAutoSearch');

    Route::get('/set-locale/{code}', 'HomeController@setLocale');
    Route::get('/set-currency/{id}', 'HomeController@setCurrency');
	Route::get('/set-user-location', 'HomeController@setUserLocation');
	Route::get('/set-location', 'HomeController@setLocation');
	Route::get('/set-user-type', 'HomeController@setUserType');
	Route::get('/confirm/{hashemail}', 'HomeController@confirmEmail');

    Route::group(['prefix' => 'user'], function(){
        Route::get('{id}/services', 'UserPageController@userServices');
        Route::any('{id}/reviews', 'UserPageController@userReviews');
    });

    Route::group(['prefix' => 'shared'], function(){
        Route::get('formatPrice', function(){
            return calculatePrice(
                request('price'),
                request('currency')
            );
        });
    });

    Route::post('callback', 'CallbackController@main');

    Route::group(['prefix' => 'cart'], function () {
        Route::post('/add', 'CartController@add');
        Route::post('/quick-buy', 'CartController@quickBuy');
        Route::post('/quick-buy-load-form', 'CartController@quickBuyLoadForm');
        Route::post('/update', 'CartController@update');
        Route::post('/remove', 'CartController@remove');
        Route::post('/accept', 'CartController@accept');
        Route::post('/cancel', 'CartController@cancel');
        Route::post('/clear', 'CartController@clear');
        Route::post('/read-notification', 'CartController@readNotification');
    });

    Route::group(['prefix' => 'yandex', 'namespace' => 'Yandex'], function(){
        Route::any('/success', 'YandexTransactController@success');
    });

    Route::group(['prefix' => 'qiwi', 'namespace' => 'Qiwi'], function(){
        Route::any('/auth', 'QiwiTransactController@auth');
        Route::any('/success', 'QiwiTransactController@success');
    });

    Route::group(['prefix' => 'checkout'], function () {
        Route::get('/', 'CheckoutController@index');
        Route::post('/confirm', 'CheckoutController@confirm');
        Route::post('/check', 'CheckoutController@check');
        Route::post('/upgrade', 'CheckoutController@upgrade');
        Route::post('/done', 'CheckoutController@done');
        Route::post('/payment', 'CheckoutController@payment');
        Route::post('/add', 'CheckoutController@add');
        Route::post('/remove', 'CheckoutController@remove');
        Route::post('/confirm-promocode', 'CheckoutController@confirmPromocode');
        Route::post('/send-order-mail', 'CheckoutController@sendOrderMail');
        Route::get('/save-certificate', 'CheckoutController@saveCertificate');
		Route::get('/buyer-order-work', 'CheckoutController@getBuyerOrderInWork');
		Route::get('/buyer-order-check', 'CheckoutController@getBuyerOrderInCheck');
		Route::get('/buyer-order-cancel', 'CheckoutController@getBuyerOrderInCancel');
		Route::get('/buyer-order-done', 'CheckoutController@getBuyerOrderInDone');
		Route::get('/seller-order-work', 'CheckoutController@getSallerOrderInWork');
		Route::get('/seller-order-check', 'CheckoutController@getSallerOrderInCheck');
		Route::get('/seller-order-cancel', 'CheckoutController@getSallerOrderCancel');
		Route::get('/seller-order-paid', 'CheckoutController@getSallerOrderPaid');
    });

    Route::get('/baskets', 'CartController@index');
    Route::get('/cart_reload', 'CartController@renderView');
    Route::get('/cart_top_reload', 'CartController@cartTopReload');
    Route::get('/notifications/show', 'NotifyController@show');
    Route::get('/notifications/clear', 'NotifyController@clear');
    Route::get('/', 'HomeController@index');
    Route::get('/categories-products', 'HomeController@categoryProduct');
    Route::post('/get-languages-speraking-list', 'HomeController@getLanguagesSperakingList');

    Route::group(['prefix' => 'product'], function () {
        Route::get('/{id}', 'ProductController@cardProduct');
        Route::post('/compare/add', 'CompareController@add');
        Route::post('/compare/update', 'CompareController@updateTable');
        Route::post('/shipping-cost', 'CartController@shippingCost');
        Route::post('/complaint', 'ProductController@complaint');
        Route::post('/get-more-reviews', 'ProductController@getMoreReviews');
    });

    Route::group(['prefix' => 'messages', 'middleware' => 'messages'], function(){

        Route::get('/get', 'MessagesController@messages');
        Route::get('/interlocutor/{user}/{theme}', 'MessagesController@show');
        Route::post('/save-message', 'MessagesController@saveMessage');
        Route::post('/create-dialog', 'MessagesController@createDialog');
        Route::post('/trash-message', 'MessagesController@trashMessage');
        Route::get('/get-message/{user}', 'MessagesController@getMessage');

    });

    Route::post('/add_product_comment', 'ProductController@addProductComment');
    Route::get('/get_product_comments', 'ProductController@getProductComment');
    Route::post('/load-more-comments', 'ProductController@getMoreProductComment');
    Route::post('/load-more-all-comments', 'ProductController@getMoreAllProductComment');

    Route::get('/add_product_to_cart/{id}', 'ProductController@addProductToCart');

    Route::get('/compare', 'CompareController@index');

    Route::get('/about', 'SpecialPagesController@about');
    Route::get('/contacts', 'SpecialPagesController@contacts');
    Route::get('/license', 'SpecialPagesController@license');
    Route::get('/security', 'SpecialPagesController@security');
    Route::get('/qa', 'SpecialPagesController@qa');
    Route::get('/support', 'SpecialPagesController@support');
    Route::get('/seller', 'SpecialPagesController@saller');
    Route::get('/payments', 'SpecialPagesController@payments');
    Route::get('/affiliate', 'SpecialPagesController@affiliate');

    Route::get('/brands', 'BrandController@index');
    Route::get('/brand/{id}', 'BrandController@getBrand');
    Route::get('/get_more_brands', 'BrandController@getBrands');

    Route::get('/category/{id}', 'CategoryController@getCategory');
    Route::get('/sub-category/{id}', 'SubCategoryController@getSubCategory');
    Route::get('/ajax-sub-category/{id}', 'SubCategoryController@getAjaxSubCategory');

    Route::get('/new/{id}', 'NewsController@news');
    Route::get('/news/{id?}', 'NewsController@newsList');
    Route::get('/get_more_news', 'NewsController@getNews');

    Route::get('/article/{id}', 'ArticleController@article');
    Route::get('/articles/{id?}', 'ArticleController@articles');
    Route::get('/get_more_articles', 'ArticleController@getNews');

    Route::get('/video/{id}', 'VideoController@video');
    Route::get('/videos/{id?}', 'VideoController@videos');
    Route::get('/get_more_videos', 'VideoController@getNews');

    Route::get('/technology/{id}', 'TechnologyController@technology');
    Route::get('/technologies/{id?}', 'TechnologyController@technologies');
    Route::get('/get_more_technologies', 'TechnologyController@getNews');

    Route::post('/watch-product-price', 'WatchProductPriceController@subscription');
    Route::get('/select-type-profile', 'SpecialPagesController@selectTypeUser');
    Route::post('/update-type-profile', 'SpecialPagesController@updateTypeUser');
	Route::post('/complaint/add', 'ComplaintsController@addComplaint');

    Route::group(['prefix' => 'cabinet', 'middleware' => ['web', 'cabinet']], function(){

        Route::get('/', 'UserCabinetController@index');
        Route::get('/seller', 'UserCabinetController@saller');
        Route::get('/buyer', 'UserCabinetController@buyer');
        Route::get('/edit-info', 'UserCabinetController@editInfo');
        Route::get('/settings', 'UserCabinetController@settings');
        Route::post('/settings/delete-account', 'UserCabinetController@deleteAccount');
        Route::get('/order-history', 'UserCabinetController@orderHistory');
        Route::get('/remove-order-history/{id}', 'UserCabinetController@orderHistoryRemove');

        Route::get('/reviews', 'UserCabinetController@reviews');

        Route::get('/user-order-history/{hash}', 'UserCabinetController@userOrderHistory');
        Route::post('/user-order-confirm', 'UserCabinetController@userOrderConfirm');
        Route::post('/user-order-cancel', 'UserCabinetController@userOrderCancel');
        Route::post('/user-order-take', 'UserCabinetController@userOrderTake');
        Route::post('/user-order-data', 'UserCabinetController@userOrderData');
        Route::post('/user-order-confirm-data', 'UserCabinetController@userOrderConfirmData');
        Route::post('/user-order-confirm-work', 'UserCabinetController@userOrderConfirmWork');
        Route::post('/user-order-checkout-work', 'UserCabinetController@userOrderCheckoutWork');

        Route::get('/products-services', 'UserCabinetController@showProductOrServices');
        Route::get('/create-product', 'UserCabinetController@createProductOrServices');
        Route::get('/create-service', 'UserCabinetController@createProductOrServices');
        Route::get('/edit-product-service/{id}', 'UserCabinetController@editProductOrServices');
        Route::put('/update-product-service/{id}', 'UserCabinetController@updateProductOrServices');
        Route::post('/save-product-service', 'UserCabinetController@saveProductOrServices');
        Route::get('/publish-product-service/{id}', 'UserCabinetController@publishProductOrServices');
        Route::get('/unpublish-product-service/{id}', 'UserCabinetController@unpublishProductOrServices');
        Route::delete('/trash-product-service', 'UserCabinetController@trashProductOrServices');
        Route::post('/update-status-service', 'UserCabinetController@updateStatusServices');

        Route::post('/update-info', 'UserCabinetController@updateInfo');
        Route::post('/update-settings', 'UserCabinetController@updateSettings');
        Route::get('/edit-pass', 'UserCabinetController@editPass');
        Route::post('/update-pass', 'UserCabinetController@updatePass');
        Route::get('/edit-address', 'UserCabinetController@editAddress');
        Route::post('/update-address', 'UserCabinetController@updateAddress');
        Route::get('/edit-subscription', 'UserCabinetController@editSubscription');
        Route::get('/edit-tariff', 'UserCabinetController@editTariff');
        Route::get('/prepare-tariff', 'UserCabinetController@prepareTariff');
        Route::post('/save-tariff', 'UserCabinetController@saveTariff');

        Route::post('/update-subscription', 'UserCabinetController@updateSubscription');
        Route::post('/update-subscription', 'UserCabinetController@updateSubscription');

        Route::post('/update-background', 'UserCabinetController@updateBackground');
        Route::post('/update-avatar', 'UserCabinetController@updateAvatar');

        Route::get('/wish-list', 'WishListController@index');
        Route::post('/wish-list/add', 'WishListController@add');

        Route::get('balance-prepare', 'UserCabinetController@balancePrepare');
        Route::post('balance-check', 'UserCabinetController@balanceCheck');
        Route::get('balance-check', 'UserCabinetController@balancePrepare');
        Route::post('balance-refill', 'UserCabinetController@balanceRefill');

        Route::post('change-account', 'UserCabinetController@changeAccount');
        Route::post('trash-account', 'UserCabinetController@trashAccount');

        Route::any('/modification', 'UserCabinetController@modification');

    });

    Route::post('/u-login', 'UserCabinetController@userRegisterBySocial');

    Route::get('/country/filter_name', 'HomeController@getCountryByName');
    Route::get('/region/filter_name', 'HomeController@getRegionByName');
    Route::get('/town/filter_name', 'HomeController@getTownByName');

    Route::get('/searches', 'HomeController@searches');
    Route::get('/load-more-searches', 'HomeController@loadMoreSearches');
    Route::get('/load-more-products-category', 'CategoryController@loadMore');
    Route::get('/load-more-products-sub-category', 'SubCategoryController@loadMore');
    Route::get('/load-more-products-wish-list', 'WishListController@loadMore');

    Route::get('/page/{id}', 'HomeController@page');
    Route::post('/subscription', 'HomeController@subscription');
    Route::get('/send-newsletter', 'HomeController@sendNewsLetter');

    Route::get('/run-command-send-news-latter', 'HomeController@sendNewsLetter');

});

Route::group(['middleware' => 'client'], function (){
	Route::get('for-a-seller', [
		'as' => 'register',
		'uses' => 'Auth\RegisterController@showRegistrationForm'
	]);
	Auth::routes();
	Route::get('search_complete', 'Client\SearchCompleteController@index');
});

Route::get('/visitors/clear', 'Admin\AdminController@clearDateVisitors');

if(php_sapi_name() != 'cli'){

    Route::group(array(
        'prefix' => 'adminpanel/module',
        'namespace' => 'Admin\module'
    ), function(){
        Route::resource(RR::query(), RR::controller());
    });

}

Route::resource('/adminpanel', 'Admin\AdminController', [
    'only' => [
        'index', 'create', 'edit'
    ]
]);

Route::any('/adminpanel/module/modification', 'Admin\ModuleController@modification');
Route::resource('/adminpanel/module', 'Admin\ModuleController');

Route::any('/adminpanel/product/modification', 'Admin\ProductController@modification');
Route::resource('/adminpanel/product', 'Admin\ProductController');
Route::get('/adminpanel/category/edit/{product}', 'Admin\ProductController@edit');
Route::post('/adminpanel/category/forever-delete/{id}', 'Admin\ProductController@foreverDelete');

Route::any('/adminpanel/brand/modification', 'Admin\BrandController@modification');
Route::resource('/adminpanel/brand', 'Admin\BrandController');

Route::any('/adminpanel/setting/modification', 'Admin\SettingsController@modification');
Route::resource('/adminpanel/setting', 'Admin\SettingsController');

Route::any('/adminpanel/localisation/modification', 'Admin\LocalisationController@modification');
Route::resource('/adminpanel/localisation', 'Admin\LocalisationController');

Route::any('/adminpanel/category/modification', 'Admin\CategoryController@modification');
Route::resource('/adminpanel/category', 'Admin\CategoryController');
Route::post('/adminpanel/category/moderate/{id}', 'Admin\ProductController@moderate');

Route::any('/adminpanel/attribute/modification', 'Admin\AttributeController@modification');
Route::resource('/adminpanel/attribute', 'Admin\AttributeController');

Route::resource('/adminpanel/phones-code', 'Admin\AdminPhoneCodeController');

Route::group([ 'prefix' => 'adminpanel', 'namespace' => 'Admin', 'middleware' => 'admin'], function(){

	Route::get('request-ammount', 'RequestAmmount@index');
	Route::post('request-ammount-set-status', 'RequestAmmount@setStatus');

	Route::get('statistic-balance', 'StatisticBalance@index');
	Route::get('statistic-balance/{userId}/{year}', 'StatisticBalance@show');

    Route::post('update_social', 'SocialController@updateSocial');
    Route::get('get_social', 'SocialController@getSocial');

    Route::get('/complaints/show', 'ComplaintsController@show');
    Route::post('/complaints/delete', 'ComplaintsController@delete');

    Route::get('/clean-cache', 'MainAdminController@cleanCache');

    Route::resource('/tariff', 'TariffController');
    Route::any('/tariff/modification', 'TariffController@modification');

    Route::resource('/cases', 'CasesController');
    Route::any('/cases/modification', 'CasesController@modification');

    Route::resource('/accounts', 'AccountsController');
    Route::any('/accounts/modification', 'AccountsController@modification');

    Route::get('/message/{theme}/{chanel}', 'MessagesController@message');
    Route::get('/messages', 'MessagesController@messages');
    Route::post('/save-message', 'MessagesController@saveMessage');

    Route::resource('/passports', 'PassportController');
    Route::any('/passports/modification', 'PassportController@modification');

    Route::resource('/deadline', 'DeadlineController');
    Route::any('/deadline/modification', 'DeadlineController@modification');

    Route::get('/follow-price', 'FollowPriceController@followPrice');
    Route::get('/get-follow-users', 'FollowPriceController@getFollowUsers');
    Route::post('/trash-follow-users', 'FollowPriceController@trashFollowUsers');

    if(php_sapi_name() != 'cli'){
        Route::get('/get_menu_list', 'module\MainMenuController@getMenuList');
    }

    Route::get('/xml_product_index', 'XMLImportProductController@index');
    Route::post('/xml_product_parse', 'XMLImportProductController@parse');

    Route::resource('/import', 'ImportController');

    Route::get('/export_xml', 'ExportXMLController@index');
    Route::post('/export_xml', 'ExportXMLController@export');

    Route::any('/countries/modification', 'CountriesController@modification');
    Route::resource('/countries', 'CountriesController');

    Route::any('/regions/modification', 'RegionsController@modification');
    Route::resource('/regions', 'RegionsController');

    Route::any('/towns/modification', 'TownsController@modification');
    Route::resource('/towns', 'TownsController');

    Route::any('/reviews/modification', 'ReviewsController@modification');
    Route::resource('/reviews', 'ReviewsController');

    Route::any('/reviews_product/modification', 'ReviewsProductController@modification');
    Route::resource('/reviews_product', 'ReviewsProductController');

    Route::any('/status/modification', 'StatusController@modification');
    Route::resource('status', 'StatusController');

    Route::any('/currency/modification', 'CurrencyController@modification');
    Route::resource('currency', 'CurrencyController');

    Route::any('/condition_order/modification', 'ConditionOrderController@modification');
    Route::resource('condition_order', 'ConditionOrderController');

    Route::any('/status_storage/modification', 'StatusStorageController@modification');
    Route::resource('status_storage', 'StatusStorageController');

    Route::any('/weight/modification', 'WeightController@modification');
    Route::resource('weight', 'WeightController');

    Route::any('/size/modification', 'SizeController@modification');
    Route::resource('size', 'SizeController');

    Route::any('/payments/modification', 'PaymentsController@modification');
    Route::resource('payments', 'PaymentsController');

    Route::any('/delivery/modification', 'DeliveryController@modification');
    Route::resource('delivery', 'DeliveryController');

    Route::any('/options/modification', 'OptionController@modification');
    Route::resource('options', 'OptionController');

    Route::any('/order/modification{query?}', 'OrderController@modification');
    Route::resource('/order', 'OrderController');

    Route::any('/news_category/modification', 'NewsCategoryController@modification');
    Route::any('/news_category/filter_name', 'NewsCategoryController@autoComplete');
    Route::resource('news_category', 'NewsCategoryController');

    Route::any('/news/modification', 'NewsController@modification');
    Route::resource('news', 'NewsController');

	Route::any('/home-review/modification', 'HomeReviews@modification');
	Route::resource('home-review', 'HomeReviews');

	Route::any('/success-history/modification', 'AdminSuccessHistory@modification');
	Route::resource('success-history', 'AdminSuccessHistory');

    Route::any('/user_groups/modification', 'UserGroupsController@modification');
    Route::resource('/user_groups', 'UserGroupsController');

    Route::any('/customer_groups/modification', 'CustomerGroupsController@modification');
    Route::resource('/customer_groups', 'CustomerGroupsController');

    Route::any('/customers/modification', 'CustomersController@modification');
    Route::resource('/customers', 'CustomersController');

    Route::any('/news_latter/modification', 'NewsLatterController@modification');
    Route::resource('/news_latter', 'NewsLatterController');

    Route::any('/deleting-reason/modification', 'AdminDeletingReasonController@modification');
    Route::resource('/deleting-reason', 'AdminDeletingReasonController');

    Route::get('/user-deleting', 'AdminUserDeletingController@index');
    Route::post('/user-deleting/restore/{id}', 'AdminUserDeletingController@restore');

    Route::any('/customer_fields/modification', 'CustomerFieldsController@modification');
    Route::resource('/customer_fields', 'CustomerFieldsController');
    Route::any('/customer_fields/modification', 'CustomerFieldsController@modification');

    Route::resource('/banners', 'BannersController');
    Route::resource('/layouts', 'LayoutsController');
    Route::resource('/filters', 'FiltersController');

    Route::resource('/social', 'SocialController');
    Route::resource('/stopwords', 'StopWordsController');
	Route::resource('/admins', 'AdminsController');
	Route::resource('/statistic', 'StatisticController');
    Route::post('/statistic/get-regions', 'StatisticController@getAllRegions');

});

Route::get('/back-to-admin', 'Client\HomeController@backToAdmin');
Route::post(
    '/send-request-ammount',
    [
        'middleware' => 'auth',
        'uses' => 'Client\HomeController@sendRequestAmmount'
    ]
);

Route::get('/admin/image_manager', 'Admin\PhotoController@index');
Route::get('/admin/filemanager', 'Admin\PhotoController@filemanager');
Route::any('/admin/filemanager/upload', 'Admin\PhotoController@upload');
Route::any('/admin/filemanager/folder', 'Admin\PhotoController@folder');
Route::any('/admin/filemanager/delete', 'Admin\PhotoController@delete');

Route::any('/loadmore', 'Client\HomeController@loadmore');

Route::get('/admin/filemanager1', 'Admin\PhotoController@index');

Route::post(
    '/check-user-required-field',
    'Client\HomeController@checkUserRequiredField'
);

Route::post(
    '/get-languages-kinds',
    'Client\HomeController@getLanguagesKinds'
);

Route::get('/logout', function() {

    if(auth()->check()){
        auth()->logout();
        return redirect()->back();
    }

    return redirect()->back();
});

Route::post('/file-add', function(){

	if(!auth()->check())
		return report('404');

	$filePath = 'files/users/'.auth()->user()->id;

	$savedName = request('file')->store($filePath);

    return response()
        ->json(array(
            'fileName' => $savedName
		));
});

Route::post('/image-add', function(){

	if(!auth()->check())
		return report('404');

	$imagePath = 'img/users/' . auth()->user()->id;

	if(request('crop_image')){
		$image = base64_decode(preg_replace(
			'#^data:image/\w+;base64,#i',
			'',
			request('crop_image')
		));

		$imageName = $imagePath . "/" . substr(md5(mt_rand()), 0, 32) . ".png";

        if(request('name'))
            $imageName = request('name');

		if(!is_dir(public_path('image/') . $imagePath))
			mkdir(public_path('image/') . $imagePath);

		file_put_contents(
			public_path('image/') . $imageName,
			$image
		);

		return response()->json(array(
			'imageName' => $imageName
		));
	}

	$savedName = request('image')->store($imagePath);

    $savedResizeName = resizeImg($savedName, 495, 335);
	$savedResizeName = $savedResizeName;

    return response()
        ->json(array(
            'imageName' => $savedName,
            'imageResizeName' => $savedResizeName
		));
});

Route::post('/image-delete', function(){

	if(!auth()->check())
		return report('404');

	$imageName = request('imageDelete');

	unlink(public_path('image/'.$imageName));

    return response()
        ->json(array(
            'imageName' => $imageName
		));
});

Route::post('/file-delete', function(){

	if(!auth()->check())
		return report('404');

	$fileName = request('fileDelete');

	unlink(public_path('image/'.$fileName));

    return response()
        ->json(array(
            'fileName' => $fileName
		));
});

Route::group(['namespace' => 'Client', 'middleware' => 'client'], function(){

	Route::get('/google/autocomplete', function(){

		$autocomplete = json_decode(@file_get_contents(
			"https://maps.googleapis.com/maps/api/place/autocomplete/json?"
			.request()->getQueryString()
		), true);

		return response()->json($autocomplete);

	});

	Route::get('/test', 'TestController@test');

    Route::get('/{seo}', 'UrlAliasesController@index');

});

Route::post('send-code-sms', function(){

	$textCode = substr(str_shuffle("0123456789"), 0, 4);
	$message = "Dilavr.com.ua code: " . $textCode;

	session()->flash('confirm_code', encodeToStr($textCode));

	App\API\TurboSMS::send(auth()->user()->getPhoneNumber(), $message);

});

Route::post('confirm-code-sms', function(){

	if(request('code') == decodeFromStr(session('confirm_code'))){

		auth()->user()->update(array(
			'phone_checked' => '1'
		));

		return response('Ok', 200);

	}

	return response('Error', 412);

});

Route::get('orders/file/{hash}', function($hash){

    return response()
        ->download(
            base64_decode($hash)
        );

});

Route::get('file/{hash}', function($hash){

    return response()
        ->download(
            'image/'.base64_decode($hash)
        );

});

Route::get('/adminpanel/test', function(){
    return response()
        ->json(
            request()->all()
        );
});
