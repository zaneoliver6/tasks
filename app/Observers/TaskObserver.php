<?php

namespace App\Observers;

use App\Task;

class TaskObserver
{

    /**
     * Handle the category "creating" event.
     *
     * @param  \App\Category  $category
     * @return void
     */
    public function creating(Task $task)
    {
        if(is_null($task->priority)) {
            $task->priority = Task::where('project_id','=',$task->project_id)->max('priority') + 1;
            return;
        }

        $lowerPriorityTasks = Task::where([
                                            ['priority', '>=', $task->priority],
                                            ['project_id', '=',$task->project_id],
                                        ])->get();
        foreach($lowerPriorityTasks as $lowPriorityTask) {
            $lowPriorityTask->priority++;
            $lowPriorityTask->saveQuietly();
        }
    }

    /**
     * Handle the meal "updating" event.
     *
     * @param  \App\Meal  $meal
     * @return void
     */
    public function updating(Task $task)
    {
        if($task->isClean('priority')) {
            return;
        }

        if(is_null($task->priority)) {
            $task->priority = Task::where('project_id','=',$task->project_id)->max('priority');
            return;
        }

        if($task->getOriginal('priority') > $task->priority) {
            $range = [$task->priority, $task->getOriginal('priority')];
        } else {
            $range = [$task->getOriginal('priority'), $task->priority];
        }

        $tasks = Task::where('project_id', '=',$task->project_id)->whereBetween('priority', $range)->where('id','!=', $task->id)->get();

        foreach($tasks as $task) {
            if($task->getOriginal('priority') < $task->priority) {
                $task->priority--;
            } else {
                $task->priority++;
            }
        }
        $task->saveQuietly();

    }
    /**
     * Handle the task "created" event.
     *
     * @param  \App\Task  $task
     * @return void
     */
    public function created(Task $task)
    {
        //
    }

    /**
     * Handle the task "updated" event.
     *
     * @param  \App\Task  $task
     * @return void
     */
    public function updated(Task $task)
    {
        //
    }

    /**
     * Handle the task "deleted" event.
     *
     * @param  \App\Task  $task
     * @return void
     */
    public function deleted(Task $task)
    {
        //
        $tasks = Task::where('project_id', '=',$task->project_id)->where('priority', '>' ,$task->priority)->get();

        foreach($tasks as $task) {
            $task->priority--;
            $task->saveQuietly();
        }
    }

    /**
     * Handle the task "restored" event.
     *
     * @param  \App\Task  $task
     * @return void
     */
    public function restored(Task $task)
    {
        //
    }

    /**
     * Handle the task "force deleted" event.
     *
     * @param  \App\Task  $task
     * @return void
     */
    public function forceDeleted(Task $task)
    {
        //
    }
}
