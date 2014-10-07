<?php

class DashboardController extends BaseController
{
	public function home()
	{
		$data["person"]=Session::get('person');
		$data["user"]=Session::get('user');
		$data["staff"]=Session::get('staff');
		$data["inside_url"] = Config::get('app.inside_url');
		$data["config"] = GeneralConfiguration::first();
		return View::make('dashboard/dashboard',$data);
	}
}