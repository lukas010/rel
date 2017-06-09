<?php
class Task
{
    private $_db;
    private $_tasks;

    public function __construct()
    {
        $this->_db = DB::getInstance();
    }

    public function addTask($user, $task)
    {
        $this->_db->insert('tasks', array(
            'task' => $task,
            'assigned' => $d = date('Y-m-d H:i:s')
        ));

        if ($this->_db->insert('tasks_relationship', array(
            'user_id' => $user,
            'task_id' => $this->_db->get('tasks', array('assigned', '=', $d))->first()->id
            ))) {
        }

        return true;
    }

    public function editTask($user_id, $task, $task_id)
    {
        $this->_db->update('tasks', $task_id, array(
            'task' => $task
        ));

        $rel_id = $this->_db->get('tasks_relationship', array('task_id', '=', $task_id))->first()->id;

        if ($this->_db->update('tasks_relationship', $rel_id, array(
            'user_id' => $user_id,
            'task_id' => $task_id
            ))) {
        }

        return true;
    }

    public function deleteTask($id)
    {
        if ($this->_db->delete('tasks', array('id', '=', $id))
            &&
            $this->_db->delete('tasks_relationship', array('task_id', '=', $id))) {
            return true;
        }
    }

    public function markAsDoneTask($user, $task)
    {
        if ($this->_db->update('tasks', $task, array('done' => date('Y-m-d H:i:s')))) {
            return true;
        }
    }

    public function getTask($id)
    {
        return $this->_db->get('tasks', array('id', '=', $id))->first()->task;
    }

    public function getTasks($user = false)
    {
        if (!$user) {
            $sql = "SELECT * FROM tasks";
            if (!$this->_db->query($sql)->error()) {
                if (!empty($this->_tasks = $this->_db->results())) {
                    foreach ($this->_tasks as $task) {
                        $tasks[] = array(
                            'task_id' => $task->id,
                            'task' => $task->task,
                            'user_id' => $this->_db->get('users', array('id', '=', $this->_db->get('tasks_relationship', array('task_id', '=', $task->id))->first()->user_id))->first()->id,
                            'user' => $this->_db->get('users', array('id', '=', $this->_db->get('tasks_relationship', array('task_id', '=', $task->id))->first()->user_id))->first()->name,
                            'assigned' => $task->assigned,
                            'done' => $task->done,
                        );
                    }

                    return $tasks;
                }
            }
        } else {
            // Duomenys gaunami pasitelkiant tasks_relationship lentele
            $this->_tasks = $this->_db->get('tasks_relationship', array('user_id', '=', $user))->results();

            if (empty($this->_tasks)) {
                return false;
            } else {
                foreach ($this->_tasks as $task) {
                    $tasks[] = array(
                        'id' => $this->_db->get('tasks', array('id', '=', $task->task_id))->first()->id,
                        'task' => $this->_db->get('tasks', array('id', '=', $task->task_id))->first()->task,
                        'done' =>$this->_db->get('tasks', array('id', '=', $task->task_id))->first()->done,
                    );
                }

                return $tasks;
            }
        }
    }
}
