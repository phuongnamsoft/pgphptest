<?php

namespace App\Console\Commands;

use App\Models\UserModel;
use Illuminate\Console\Command;

class AppendComments extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'append:comments {id} {comments}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Append comment for given user ID';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    /**
     * User model instance.
     *
     * @var UserModel
     */

    protected $userModel;

    public function __construct(UserModel $userModel) {
        parent::__construct();
        $this->userModel = $userModel;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle() {
        $arguments = $this->arguments();
        $userId = intval($arguments['id']);
        $userDetail = $this->userModel->getById($userId);
        if (empty($userDetail)) {
            $this->warn('User not found!');
            return 0;
        }
        $this->userModel->updateById(['comments' => $userDetail['comments'] . "\n" . (string)$arguments['comments']], $userId);
        $this->info('User comments is updated successfully!');
        return 0;
    }
}
