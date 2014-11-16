<?php

class DashboardController extends BaseController
{
	public function home()
	{
		$id = Auth::id();
		$data["person"] = Auth::user();
		$data["user"]= Person::find($id)->user;
		$data["staff"] = Person::find($id)->staff;
		$data["inside_url"] = Config::get('app.inside_url');
		$data["config"] = GeneralConfiguration::first();
		return View::make('dashboard/dashboard',$data);
	}
}