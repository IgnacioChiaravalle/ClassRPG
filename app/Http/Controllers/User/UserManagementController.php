<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;
use App\Models\User;
use App\Notifications\NewUserRegistered;
use App\Notifications\EmailUpdated;
use App\Notifications\AccountDeleted;
use Illuminate\Http\Request;

class UserManagementController extends Controller {
	private const PW_LENGTH = 8;
	private const ALPHABET = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';

	public function getUserByName($name) {
		return User::where('name', $name)->first();
	}
	
	public function validateNewUserDataRequest(Request $request) {
		$request->validate([
			'name' => ['required', 'string', 'unique:users'],
			'real_name' => ['required', 'string'],
			'email' => ['required', 'string', 'email', 'max:255', 'unique:users']
		]);
	}

	public function createUser(Request $request, $type) {
		$password = $this->randomPassword();
		$user = User::create([
			'name' => $request->name,
			'real_name' => $request->real_name,
			'email' => $request->email,
			'password' => Hash::make($password),
			'type' => $type
		]);
		$user->notify(new NewUserRegistered($user, $password));
	}
		private function randomPassword() {
			$password = "";
			$alphabetLength = strlen(self::ALPHABET) - 1;
			for ($i = 0; $i < self::PW_LENGTH; $i++)
				$password .= self::ALPHABET[rand(0, $alphabetLength)];
			return $password;
		}

	public function editUserNames(Request $request, $user) {
		$request->validate([
			'name' => ['string', \Illuminate\Validation\Rule::unique('users')->ignore($user->id)],
			'real_name' => ['string']
		]);
		if ($user->name != $request->name || $user->real_name != $request->real_name)
			$user->update([
				'name' => $request->name,
				'real_name' => $request->real_name
			]);
	}
	
	public function editUserEmail(Request $request, $user) {
		$request->validate([
			'email' => ['string', 'email', 'max:255', \Illuminate\Validation\Rule::unique('users')->ignore($user->id)]
		]);
		if ($user->email != $request->email) {
			$user->update(['email' => $request->email]);
			$user->notify(new EmailUpdated($user));
		}
	}

	public function editUserPassword(Request $request, $user) {
		$request->validate([
			'password' => [
				'required',
				'confirmed',
				Password::min(8)
					->mixedCase()
					->letters()
					->numbers()
					->uncompromised(),
			]
		]);
		$user->update(['password' => Hash::make($request->password)]);
	}

	public function deleteUser(User $user) {
		$user->notify(new AccountDeleted($user));
		$user->delete();
	}
}
