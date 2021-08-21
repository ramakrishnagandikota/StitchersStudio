<?php
namespace App\Traits;
use Auth;
use App\User;
use Carbon\Carbon;
use Jenssegers\Agent\Agent;

trait UserAgentTrait{

  function myBrowser(){
  	    $agent = new Agent();
        $user['browser'] = $agent->browser();
        $user['platform'] = $agent->platform();
        $user['version'] = $agent->version($user['browser']);
        $user['isDesktop'] = $agent->isDesktop();
        $user['isPhone'] = $agent->isPhone();
        $user['isRobot'] = $agent->isRobot();
        if($agent->isRobot() == true){
          $user['robot'] = $agent->robot();
        }
        return $user;
  }


}