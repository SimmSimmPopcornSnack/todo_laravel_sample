<?php

namespace Tests\Feature;

use App\Http\Requests\CreateTask;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    // Refresh database and re-do migration for each test case
    use RefreshDatabase;

    /**
     * called before running a test method
     */
    public function sestUp() {
        parent::setUp();
        // generate folder data before running a test case
        $this->seed("FoldersTableSeeder");
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    /**
     * 期限日が日付でない場合はvalidation error
     * @test
     */
    public function due_date_should_be_date() {
        $response = $this->post("/folders/1/tasks/create", [
            "title" => "Sample task",
            "due_date" => 123, // invalid data (int)
        ]);

        $response->assertSessionHasErrors([
            'due_date' => '期限日 には日付を入力してください',
            "due_date" => "期限日 には今日以降の日付を入力してください。",
        ]);
    }
    /**
     * 期限日が過去日付の場合はvalidation error
     * @test
     */
    public function due_date_should_not_be_past() {
        $response = $this->post("/folders/1/tasks/create", [
            "title" => "Sample task",
            "due_date" => Carbon::yesterday()->format("Y/m/d"),
        ]);
        $response->assertSessionHasErrors([
            "due_date" => "期限日 には今日以降の日付を入力してください。",
        ]);
    }
}
