<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class CleanReservationsCommand extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'reservations:clean';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Cleans all the expired material reservations.';

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
		/* Select all reservations to be cleaned*/
		$clean_reservations = MaterialReservation::where('expire_at','<',$today)->get();
		foreach($clean_reservations as $clean_reservation){
			/* For each reservation we have to update the user and material status */
			$material_reservation = MaterialReservation::find($clean_reservation->id);
			/* First I get the material to be modified */
			$material = Material::find($material_reservation->material_id);
			/* Update the user's current reservations value */
			$user = User::find($material_reservation->user_id);
			$user->current_reservations = $user->current_reservations - 1;
			$user->save();
			$material_reservation->delete();
			/* If the material has another reservation on the queue we have to assign it to the next reservation */
			$next_reservation = MaterialReservation::getReservationByMaterial($material->mid)->first();
			
			if($next_reservation){
				/* Set the "available" flag on material to 2 */
				$material->available = 2;
				/* There's another reservation on the queue */
				$expire_at = date("Y-m-d", strtotime("tomorrow"));
				$next_reservation = MaterialReservation::find($next_reservation->id);
				$next_reservation->expire_at = $expire_at;
				$next_reservation->save();

				$next_user = User::find($next_reservation->user_id);
				$next_person = Person::find($next_user->person_id);
				Mail::send('emails.available_material', array('title'=>$material->title), function($message) use ($next_person)
				{
					$message->to($next_person->mail, $next_person->name)
							->subject('Libro disponible para préstamo');
				});
			}else{
				/* If there's no other reservation, then the material is fully available */
				$material->available = 1;
			}
			$material->save();
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
