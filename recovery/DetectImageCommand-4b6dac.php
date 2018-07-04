<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Profiles;
use App\Models\ProfilesInfo;

class DetectImageCommand extends Command{

    // @var string
    protected $signature = 'detect:models';

    // @var string
    protected $description = 'Detect images all profile models';

    // @return void
    public function __construct(){
        parent::__construct();
    }

    // @return mixed
    public function handle(){

        // ---------------------------------------------------------------------
        // implode profiles gateway on keys
        // this is keys as id profile
        // get all profiles and save in Fallback
        // ---------------------------------------------------------------------

        $image_path = public_path().'/images/profiles/';
        $result = app('gateway')->query('getNumberOnlineCams');
        $total = $result ? app('gateway')->getResponse()['total_online'] : 0;

        $result = app('gateway')->query('getCams', array(
            'status' => 'ONLINE',
            'cams_per_page' => $total,
        ));
        $cams = $result ? app('gateway')->getResponse()['cams'] : null;

        $image_all = scandir($image_path);
        $cams = $cams ? implode('-', array_keys($cams)) : null;

        // get all online profiles
        $result = app('gateway')->query('getProfile', ['account' => $cams]);
        $cams = $result ? app('gateway')->getResponse()['cams'] : null;

        foreach($cams ?: [] as $key => $value){

            $imageUrlAccount =
                'http://cams.images-dnxlive.com/snapshots/'.
                $key.
                '_webcam_260x195.jpg';

            // save main image in our fallback mysql
            saveProfileImage($image_path, $imageUrlAccount, $image_all);

        }

    }

}
