<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\SettingsRequest;
use App\GeneralSettings;

class GeneralSettingsController extends AdminController
{
    public function index()
    {
        $settings = GeneralSettings::all()->first();

        return view('manage.admin.settings.index', [
            'settings' => $settings,
        ]);
    }

  public function store(SettingsRequest $request)
{
    GeneralSettings::find(1)->update([
        'hostname'      => $request->hostname,
        'hostname_port' => $request->hostname_port,
        'rcon_port'     => $request->rcon_port,
        'rcon_password' => $request->rcon_password,
        'websender_port'     => $request->websender_port,
        'websender_password' => $request->websender_password,

        'website_name'  => $request->website_name,
        'website_desc'  => $request->website_desc,

  
        'site_tagline'       => $request->site_tagline,
        'contact_email'      => $request->contact_email,
        'homepage_highlight' => $request->homepage_highlight,

        'navbar_color'       => $request->navbar_color,
        'background_image'   => $request->background_image,
        'background_color'   => $request->background_color,
        'primary_color'      => $request->primary_color,
        'nav_text_color'     => $request->nav_text_color,

        'custom_css'         => $request->custom_css,
    ]);

    session()->flash('successfullyUpdateData');
    return redirect()->back();
}


}
