<?php

namespace App\Http\Controllers\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Base\Controller;
use App\Http\Controllers\Base\MainController;
use App\Models\Profiles;

// -----------------------------------------------------------------------------
// controller ProfileController
// controller handle profile model page
// @params $id model
// @return html content
// -----------------------------------------------------------------------------

class ProfileController extends MainController{

	public function __construct(){ parent::__construct(); }

	public function index($id){

		// ---------------------------------------------------------------------
		// set account as query id
		// get data profile of search params
		// ---------------------------------------------------------------------

		$argsProfile = array(
			'account' => $id,
			'ip' => request()->ip()
		);

		if(!env('FALLBACK')){

			$result = app('gateway')->query('getProfile', $argsProfile);
			$cam = @app('gateway')->getResponse()['cams'][$id] ?: [];

			// set and get image cache
			if($cam){

				$cam['pictures_cache'] = imageCache(
					$cam['pictures'],
					$this->picturePath,
					$this->cacheTime
				);

			}

		}

		// ---------------------------------------------------------------------
		// if api return null or a mistake
		// switch fallback our mysql server data
		// ---------------------------------------------------------------------

		if(env('FALLBACK')){

			if($cam = Profiles::getProfile($argsProfile)){

				$cam = array_merge(
					$cam->toArray(),
					$cam->info()
				);

				if(@$cam['pictures'])
					$cam['pictures'] = json_decode($cam['pictures'], true);
				else
					$cam['pictures'] = [];

				$cam['profiles'] = json_decode(@$cam['profiles'], true);

				$cam['fallback'] = true;

				// set and get image cache
				$cam['pictures_cache'] = imageCache(
					$cam['pictures'],
					$this->picturePath,
					$this->cacheTime
				);

			}
		}

		$cam['also_profile'] = $this->alsoProfile();

		// ---------------------------------------------------------------------
		// if api fail then redirect to home
		// if api success then make view temlate of data
		// ---------------------------------------------------------------------

		if(!$cam) return redirect('/');

		return view('general.profile.profile', compact('cam'));

	}

	public function alsoProfile(){

		// ---------------------------------------------------------------------
		// get also data profiles for profile
		// ---------------------------------------------------------------------
		$countPage = 5;
		$search = $this->implodeOptionGateway();
		$data['cams_per_page'] = $countPage;
		$data['count'] = $countPage;
		$data['search'] = $search;

		if(!env('FALLBACK')){

			$result = app('gateway')->query('getCams', $data);

			$data['cams'] = $result ? app('gateway')->getResponse()['cams'] : [];

			// set or get image cache
			foreach($data['cams'] as &$cam){

				$result = app('gateway')->query(
					'getProfile',
					array('account' => $cam['account'])
				);

				$cam = @app('gateway')->getResponse()['cams'][$cam['account']] ?: [];

			}

		}

		// ---------------------------------------------------------------------
		// if api return null or a mistake
		// switch fallback our mysql server data
		// ---------------------------------------------------------------------

		if(env('FALLBACK')){

			$data['links'] = Profiles::getProfiles($data);
			$data['cams'] = $data['links']->toArray();
			$data['cams'] = $data['cams']['data'];
			$data['fallback'] = true;

		}

		return @$data['cams'];

	}

}
