<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;

class UserController extends BaseController {

    protected $moduleName = 'user';
    protected $userModel;

    public function __construct(UserModel $userModel) {
        parent::__construct();
        $this->userModel = $userModel;
    }

    /**
     * Show the info for a given user (get parameter).
     *
     * @param Request $request
     * @return \Illuminate\View\View|string
     */
    public function index(Request $request) {
        if ($request->has('id')) {
            $id = intval($request->get('id'));
            $user = $this->userModel->getById($id);
            if (empty($user)) {
                return response('404', 404);
            }
            $this->viewData['user'] = (object) $user;
            return $this->getSView('detail');
        }
        return response('404', 404);
    }

    /**
     * Show the info for a given user.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\View\View|string
     */
    public function view(Request $request, $id) {
        $id = intval($id);
        $user = $this->userModel->getById($id);
        if (empty($user)) {
            return response('404', 404);
        }
        $this->viewData['user'] = (object)$user;
        return $this->getSView('detail');
    }

    /**
     * Update the info for a given user.
     *
     * @param Request $request
     * @return \Illuminate\View\View|string
     */
    public function update(Request $request) {
        $request->validate([
            'id' => 'required|numeric',
            'password' => 'required',
            'comments' => 'required'
        ]);
        $postData = $request->all();
        $userId = intval($postData['id']);
        $userDetail = $this->userModel->getById($userId);

        if (empty($userDetail)) {
            return response(['status' => 0, 'message' => 'User not found!'], 404);
        }

        if ($this->userModel->getDefaultPassword() !== $postData['password']) {
            return response(['status' => 0, 'message' => 'Wrong password!'], 403);
        }

        $this->userModel->updateById(['comments' => $userDetail['comments'] . "\n" . (string)$postData['comments']], $postData['id']);
        return response(['status' => 0, 'message' => 'User comments is updated successfully!'], 200);
    }


}
