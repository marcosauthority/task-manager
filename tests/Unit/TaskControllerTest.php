<?php
namespace Tests\Unit;
use App\Http\Controllers\TaskController;
use App\Http\Utils\Constants;
use App\Models\Task;
use Illuminate\Http\Request;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;
class TaskControllerTest extends TestCase
{
    public function testIndex()
    {
                $taskMock = \Mockery::mock('overload:' . Task::class);

        $taskMock->shouldReceive('all')->andReturn(new Collection([
            new Task,
            new Task,
            new Task,
        ]));

        $controller = new TaskController;

        $response = $controller->index();

        $this->assertEquals(Constants::$statusSuccess, $response->getData()->status);

        $this->assertCount(3, $response->getData()->tasks);
    }
    public function testStore()
    {
                $taskMock = \Mockery::mock('overload:' . Task::class);

        $taskMock->shouldReceive('create')->andReturn(new Task);

        $controller = new TaskController;

        $request = new Request();
        $request->replace([
            'name' => 'Test task',
            'description' => 'This is a test task',
            'priority' => 'High'
        ]);

        $response = $controller->store($request);

        $this->assertEquals(Constants::$statusSuccess, $response->getData()->status);
    }
}
