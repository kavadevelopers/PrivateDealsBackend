<?php

namespace App\Http\Controllers\Web\Front;

use App\Enums\StartupPrimaryRoundStatusEnum;
use App\Enums\StartupStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\MasterBlogModel;
use App\Models\StartupModel;
use App\Models\StartupRoundModel;
use Illuminate\Support\Facades\Auth;
use App\Models\PrimaryTransactionMgt14Model;
use App\Models\StartupPitchModel;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{

    function dashboard()
    {
        echo "s dashboard";
    }

    function startupHome(): View
    {
        setPageTitle('Raise Home');
        return view('front.home-startup');
    }


    function index(): View
    {
        setPageTitle('Home');
        $data['livedeals'] = StartupRoundModel::where('round_status', StartupPrimaryRoundStatusEnum::raisingnow)
        ->with(['startup'])
        ->get();
        $data['completed'] = StartupRoundModel::where('round_status', StartupPrimaryRoundStatusEnum::completed)
        ->with(['startup'])
        ->get();
        $data['comingsoon'] = StartupRoundModel::where('round_status', StartupPrimaryRoundStatusEnum::comingsoon)
        ->with(['startup'])
        ->get();
        
        return view('front.home',$data);
    }

    function partnerHome(): View
    {
        setPageTitle('Home');
        return view('front.home');
    }

    function deal($slug): View
    {
        // dd('deals');
        $startup = StartupModel::where('url_slug',$slug)->where('is_deleted','0')->with('details')->with('StartupOther')->with('faqs')->first();
        if($startup){
            $data['_title'] = $startup->brand;
            $data['startup'] = $startup;
            $data['startup_details'] =  $startup->details;
            $data['other'] =  $startup->other;
            $data['startup_social'] = $startup->social_media;
            // $data['team']   = $startup->team;
            $data['pitch']  = StartupPitchModel::where('startup_id',$startup->id)->where('scheduled_date','>=',date('Y-m-d H:i:s'))->orderby('id','asc')->get();
            $data['faqs']   =   $startup->faqs;
            // dd($data);
            // $data['updates']   = StartupUpdates::orderby('id','desc')->where('status','1')->where('startup',$id)->get();
            return view('front.common.detailed_view',$data);
        }else{
            abort(404);
        }
    }
    
}
