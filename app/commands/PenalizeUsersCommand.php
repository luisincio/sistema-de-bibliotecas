<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class PenalizeUsersCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'users:penalize';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Penalize users.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$today = Date("Y-m-d");
		$expired_loans = Loan::where('expire_at','<',$today)->get();
		foreach($expired_loans as $expired_loan){
			$material = Material::find($expired_loan->material_id);
			$penalty_period = PenaltyPeriod::getPenaltyPeriodByDate($today)->first();
			if($penalty_period){
				$penalty_days = $penalty_period->penalty_days;
			}else{
				$material_type = MaterialType::find($material->material_type);
				$penalty_days = $material_type->day_penalty;
			}
			$edit_user = User::find($expired_loan->user_id);
			if($edit_user->restricted_until){
				$restricted_until = date('Y-m-d', strtotime($edit_user->restricted_until."+ ".$penalty_days." days"));
			}else{
				$restricted_until = date('Y-m-d', strtotime($today."+ ".$penalty_days." days"));
			}
			$edit_user->restricted_until = $restricted_until;
			$edit_user->save();
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array();
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
