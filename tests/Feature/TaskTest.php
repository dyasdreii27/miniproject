<?php

namespace Tests\Feature;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_task_can_be_created_updated_completed_and_deleted(): void
    {
        $this->post(route('tasks.store'), [
            'task_name' => 'Prepare presentation',
            'description' => 'Finish the slides for Friday.',
            'status' => 'Pending',
            'due_date' => '2026-09-30',
        ])->assertRedirect(route('tasks.index'));

        $task = Task::firstOrFail();
        $this->assertDatabaseHas('tasks', [
            'task_name' => 'Prepare presentation',
            'status' => 'Pending',
        ]);

        $this->put(route('tasks.update', $task), [
            'task_name' => 'Prepare final presentation',
            'description' => 'Finish and review the slides.',
            'status' => 'Pending',
            'due_date' => '2026-10-01',
        ])->assertRedirect(route('tasks.index'));

        $this->patch(route('tasks.status', $task), ['status' => 'Completed'])
            ->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'status' => 'Completed']);

        $this->delete(route('tasks.destroy', $task))
            ->assertRedirect(route('tasks.index'));
        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
    }
}
