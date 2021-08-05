<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\NewUserRegistered;
use App\Mail\EmailUpdated;
use Illuminate\Http\Request;

class UserManagementController extends Controller {
	private const PW_LENGTH = 8;
	private const ALPHABET = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';

	public function validateUserDataRequest(Request $request) {
		$request->validate([
			'name' => ['required', 'string'],
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
		Mail::to($request->email)->send(new NewUserRegistered($user,$password));
	}

	private function randomPassword() {
		$password = "";
		$alphabetLength = strlen(self::ALPHABET) - 1;
		for ($i = 0; $i < self::PW_LENGTH; $i++)
			$password .= self::ALPHABET[rand(0, $alphabetLength)];
		return $password;
	}

	public function editUserEmail(Request $request, $user) {
		$request->validate([
			'email' => ['string', 'email', 'max:255', \Illuminate\Validation\Rule::unique('users')->ignore($user->id)]
		]);
		$user->update(['email' => $request->email]);
		Mail::to($request->email)->send(new EmailUpdated($user));
	}

	public function deleteUser(User $user) {
		$user->delete();
	}
}