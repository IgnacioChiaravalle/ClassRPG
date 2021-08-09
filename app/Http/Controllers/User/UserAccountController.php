<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Controllers\User\UserManagementController;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserAccountController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	protected function createUserDataView() {
		return View::make('user.my_account')->with('user', $this->getUser());
	}

	protected function editUserData(Request $request) {
		$uMC = new UserManagementController;
		$user = $this->getUser();
		$uMC->editUserNames($request, $user);
		$uMC->editUserEmail($request, $user);
		return redirect()->route('/')->with('message', "Información actualizada con éxito.");
	}

	protected function createChangePasswordView(Request $request) {
		return View::make('user.change_password')->with('user', $this->getUser());
	}

	protected function changeUserPassword(Request $request) {
		(new UserManagementController)->editUserPassword($request, $this->getUser());
		return redirect()->route('/')->with('message', "Contraseña actualizada con éxito.");
	}

	private function getUser() {
		return Auth::user();
	}
}
