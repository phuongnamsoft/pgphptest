<?php

namespace Tests\Feature;

use Tests\TestCase;

class UserTest extends TestCase {
    /**
     * test get user info with right user ID
     *
     * @return void
     */
    public function test_case_1() {
        $response = $this->get('/?id=1');
        $response->assertStatus(200);
    }

    /**
     * test get user info with wrong user ID
     *
     * @return void
     */
    public function test_case_2() {
        $response = $this->get('/?id=100');
        $response->assertStatus(404);
    }

    /**
     * test update user comments with invalid data
     *
     * @return void
     */
    public function test_case_3() {
        $response = $this->post('/user', ['id' => 1, 'passwordtestt' => '', 'comments' => 'PictureWorks']);
        $response->assertStatus(302);
    }

    /**
     * test case #4
     * test update user comments with invalid password
     *
     * @return void
     */
    public function test_case_4() {
        $response = $this->post('/user', ['id' => 1, 'password' => 'Invalid password', 'comments' => 'PictureWorks']);
        $response->assertStatus(403);
    }

    /**
     * test case #5
     * test update user comments with valid data
     *
     * @return void
     */
    public function test_case_5() {
        $response = $this->post('/user', ['id' => 1, 'password' => 'PictureWorks', 'comments' => 'PictureWorks']);
        $response->assertStatus(200);
    }

}
